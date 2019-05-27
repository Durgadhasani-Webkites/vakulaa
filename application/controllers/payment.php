<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payment extends User_Controller
{
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $this->load->model('user_m');
        $order_id = $this->session->userdata('order_id');


        $order_details = $this->user_m->get_order_detail_by_order_id($order_id);
 
        $order_details['codavailable'] = $this->user_m->get_shippingexist($order_details['shipping_user_pincode']);
        //  print_r($_POST);

       
        $this->load->helper('file');

        $orderData = [
            'receipt'         => $order_details['id'],
            'amount'          => $order_details['net_total']*100, // 2000 rupees in paise
            'currency'        => 'INR',
            'payment_capture' => 1 // auto capture
        ];

        $userData = [
            "name"              => $order_details['shipping_user_name'],
            "description"       => '',
            "image"             => '',
            "prefill"           => [
                "name"              => $order_details['shipping_user_name'],
                "email"             => $order_details['shipping_user_email'],
                "contact"           => $order_details['shipping_user_contact_no'],
            ],
            "notes"             => [
                "address"           => "",
                "merchant_order_id" => $order_details['id'],
            ],
            "theme"             => [
                "color"             => "#2F63A3"
            ]
        ];
        if($order_details['codavailable']!=0)
        {

            if(isset($_POST['payment']))
            {
                if($_POST['payment']==1)
                {
                    require('razorpay2/pay.php');
                }
                else
                {
                    redirect('payment/cod_success');
                }
            }
            else
            {
                $this->load->model('cart_m');
                $order_details['cart_details']=$this->cart_m->view_cart_details();
                $total_price=0;
                $total_grams=0;
                if(!empty($order_details['cart_details'])){
                    foreach($order_details['cart_details'] as $k=>$v){
                        $grams = $v['weightingrams'];
                        $price=$v['option_price'];
                        if($v['option_id']==0){
                            $price=$v['product_price'];
                            $grams = $v['weight_shipping_single'];
                        }
                        $quantity=$v['quantity'];
                        $subtotal_price=$quantity*$price;
                        $gms=$quantity*$grams;
                        if($v['coupon_applied_id']!=0){
                            $subtotal_price = $subtotal_price - $v['coupon_discount'];
                        }
                        $total_price+=$subtotal_price;
                        $total_grams+=$gms;
                    }
                }
                $order_details['net_total'] = $total_price;
                $order_details['total_grams'] = $total_grams;
                $order_details['delivery_cost'] = $this->cart_m->get_delivery_cost();
                $this->template('payment', $order_details);

            }
        }
        else{
            require('razorpay2/pay.php');
        }
    }

    public function cod_success()
    {
        $this->load->model('user_m');
        $order_id = $this->session->userdata('order_id');

        $data['order_details'] = $this->user_m->get_order_detail_by_order_id($order_id);
        $order_id = $data['order_details']['order_id'];
        $data['cart_items'] = $this->user_m->get_cart_items($order_id);
        $this->load->model('admin/settings_m');
        $data['supermarket_results'] = $this->settings_m->get_supermarket_results();
        //  print_r($data);die;
        if(!empty($data['cart_items'])){
            foreach($data['cart_items'] as $k=>$v){
                $insert_status['cart_id']=$v['id'];
                $insert_status['order_id']=$data['order_details']['id'];
                $insert_status['status_text']='Ordered';
                $insert_status['comments']='Your Order has been placed.';
                $insert_status['created']=date('Y-m-d H:i:s');
                $this->db->insert('user_order_status',$insert_status);

                $this->load->model('cart_m');
                 $cart_offer_prod = $this->cart_m->get_cart_offer_products($v['id']);
                    if(!empty($cart_offer_prod)){
                        foreach($cart_offer_prod as $k1=>$v1){
                            $option_res = $this->product_m->get_option_details(array('product_id'=>$v1['offer_product_id'],'option_id'=>$v1['offer_option_id']));
                            $prod_quantity = $option_res['option_qty'];
                            $product_stock=$prod_quantity-$v1['offer_product_qty'];
                            if($product_stock<0){
                                $product_stock=0;
                            }
                            $this->db->set('option_qty', $product_stock);
                            $this->db->where('product_id', $v1['offer_product_id']);
                            $this->db->where('option_id', $v1['offer_option_id']);
                            $this->db->update('admin_product_option_value');

                        }
                    }

                    if($v['option_id']==0){
                        $this->load->model('checkout_m');
                        $p_res = $this->checkout_m->get_product_details($v['product_id']);
                        $product_stock = $p_res['quantity']-$v['quantity'];
                        if($product_stock<0){
                            $product_stock=0;
                        }
                        $this->db->set('quantity', $product_stock);
                        $this->db->where('id', $v['product_id']);
                        $this->db->update('admin_product');
                    }else{
                        $this->load->model('checkout_m');
                        $p_res = $this->checkout_m->get_product_opt_details($v['product_id'],$v['option_id']);
                        $product_stock = $p_res['option_qty']-$v['quantity'];
                        if($product_stock<0){
                            $product_stock=0;
                        }
                        $this->db->set('option_qty', $product_stock);
                        $this->db->where('product_id', $v['product_id']);
                        $this->db->where('option_id', $v['option_id']);
                        $this->db->update('admin_product_option_value');
                    }

                    $data['cart_details'][$k]['cart_offer_prod']=$cart_offer_prod;

            }
        }

        $this->load->model('admin/settings_m');
        $data['company_details'] = $this->settings_m->get();
        $data['payment_mode']='COD';
        $mobile=$data['order_details']['shipping_user_contact_no'];
        $msg = "Your order(".$order_id.") has been placed successfully.Payment mode is COD.  - message by vakulaa.com";
        // smshorizon($mobile,$msg);

        $this->load->config('email');
        $this->load->library('My_PHPMailer');
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = $this->config->item('smtp_host');
        $mail->SMTPAuth = true;
        // $mail->SMTPSecure = 'tls';
        //$mail->SMTPDebug = 2;
        $mail->Username = $this->config->item('smtp_user');
        $mail->Password = $this->config->item('smtp_pass');
        $mail->Port = $this->config->item('smtp_port');
        $mail->SetFrom($this->config->item('from_email'), $this->config->item('from_name'));
        $mail->AddAddress($data['order_details']['shipping_user_email']);
        $mail->AddCC($this->config->item('admin_email'));


        $mail->Subject = "Your Order with vakulaa.com [Order No: ".$order_id."]";
        $data['order_details']['payment_mode']='COD';
        $message = '<p>Hi ' . $data['order_details']['shipping_user_name'] . ',</p>';
        $message .= '<p>Thank you for your order at vakulaa.com!</p>';
        $invoice = $this->load->view("invoice", $data, true);
        $message .= $invoice;

        
        $invoice_path = FCPATH . "invoices/INVOICE_" . $data['order_details']['order_id'] . ".pdf";
        if (file_exists($invoice_path) == FALSE) {
            ini_set('memory_limit', '32M');

            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}|' . date(DATE_RFC822));
            $pdf->WriteHTML($invoice);
            $pdf->Output($invoice_path, 'F');
        }

        $mail->Body = $message;
        $mail->AddAttachment($invoice_path);
        $mail->isHTML(true);
        if( $mail->Send()){
           $mail->ClearAllRecipients();
           $mail->clearAttachments();
           $payment['invoice_sent']=1;
       }
       $payment['payment_status']=2;
       $payment['payment_date']=date('Y-m-d H:i:s');
       $payment['payment_mode']='COD';
       $payment['net_total']= $data['order_details']['net_total']+60;
       $this->load->model('checkout_m');
       $this->checkout_m->update_payment_response($order_id,$payment);
       redirect('payment/success');
   }


   public function verify_pay(){

    require('razorpay2/verify.php');

    if(isset($success) && $success){
        if(!empty($payment_data) && $payment_data->status=='captured'){
            $this->load->model('user_m');
            $order_id = $this->session->userdata('order_id');

            $data['order_details'] = $this->user_m->get_order_detail_by_order_id($order_id);
            $order_id = $data['order_details']['order_id'];
            $data['cart_items'] = $this->user_m->get_cart_items($order_id);
            $this->load->model('admin/settings_m');
            $data['supermarket_results'] = $this->settings_m->get_supermarket_results();
                //  print_r($data);die;
            if(!empty($data['cart_items'])){
                foreach($data['cart_items'] as $k=>$v){
                    $insert_status['cart_id']=$v['id'];
                    $insert_status['order_id']=$data['order_details']['id'];
                    $insert_status['status_text']='Ordered';
                    $insert_status['comments']='Your Order has been placed.';
                    $insert_status['created']=date('Y-m-d H:i:s');
                    $this->db->insert('user_order_status',$insert_status);

                    $this->load->model('cart_m');
                 $cart_offer_prod = $this->cart_m->get_cart_offer_products($v['id']);
                    if(!empty($cart_offer_prod)){
                        foreach($cart_offer_prod as $k1=>$v1){
                            $option_res = $this->product_m->get_option_details(array('product_id'=>$v1['offer_product_id'],'option_id'=>$v1['offer_option_id']));
                            $prod_quantity = $option_res['option_qty'];
                            $product_stock=$prod_quantity-$v1['offer_product_qty'];
                            if($product_stock<0){
                                $product_stock=0;
                            }
                            $this->db->set('option_qty', $product_stock);
                            $this->db->where('product_id', $v1['offer_product_id']);
                            $this->db->where('option_id', $v1['offer_option_id']);
                            $this->db->update('admin_product_option_value');

                        }
                    }

                    if($v['option_id']==0){
                        $this->load->model('checkout_m');
                        $p_res = $this->checkout_m->get_product_details($v['product_id']);
                        $product_stock = $p_res['quantity']-$v['quantity'];
                        if($product_stock<0){
                            $product_stock=0;
                        }
                        $this->db->set('quantity', $product_stock);
                        $this->db->where('id', $v['product_id']);
                        $this->db->update('admin_product');
                    }else{
                        $this->load->model('checkout_m');
                        $p_res = $this->checkout_m->get_product_opt_details($v['product_id'],$v['option_id']);
                        $product_stock = $p_res['option_qty']-$v['quantity'];
                        if($product_stock<0){
                            $product_stock=0;
                        }
                        $this->db->set('option_qty', $product_stock);
                        $this->db->where('product_id', $v['product_id']);
                        $this->db->where('option_id', $v['option_id']);
                        $this->db->update('admin_product_option_value');
                    }

                    $data['cart_details'][$k]['cart_offer_prod']=$cart_offer_prod;

                }
            }

            $this->load->model('admin/settings_m');
            $data['company_details'] = $this->settings_m->get();

            $mobile=$data['order_details']['shipping_user_contact_no'];
            $msg = "Your order(".$order_id.") has been placed successfully - message by vakulaa.com";
            // smshorizon($mobile,$msg);

            $this->load->config('email');
            $this->load->library('My_PHPMailer');
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->Host = $this->config->item('smtp_host');
            $mail->SMTPAuth = true;
                // $mail->SMTPSecure = 'tls';
                //$mail->SMTPDebug = 2;
            $mail->Username = $this->config->item('smtp_user');
            $mail->Password = $this->config->item('smtp_pass');
            $mail->Port = $this->config->item('smtp_port');
            $mail->SetFrom($this->config->item('from_email'), $this->config->item('from_name'));
            $mail->AddAddress($data['order_details']['shipping_user_email']);
            $mail->AddCC($this->config->item('admin_email'));


            $mail->Subject = "Your Order with vakulaa.com [Order No: ".$order_id."]";

            $message = '<p>Hi ' . $data['order_details']['shipping_user_name'] . ',</p>';
            $message .= '<p>Thank you for your order at vakulaa.com!</p>';
            $invoice = $this->load->view("invoice", $data, true);
            $message .= $invoice;


            $invoice_path = FCPATH . "invoices/INVOICE_" . $data['order_details']['order_id'] . ".pdf";
            if (file_exists($invoice_path) == FALSE) {
                ini_set('memory_limit', '32M');

                $this->load->library('pdf');
                $pdf = $this->pdf->load();
                $pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}|' . date(DATE_RFC822));
                $pdf->WriteHTML($invoice);
                $pdf->Output($invoice_path, 'F');
            }

            $mail->Body = $message;
            $mail->AddAttachment($invoice_path);
            $mail->isHTML(true);
            if( $mail->Send()){
               $mail->ClearAllRecipients();
               $mail->clearAttachments();
               $payment['invoice_sent']=1;
           }
           $payment['payment_status']=2;
           $payment['payment_date']=date('Y-m-d H:i:s');
           $this->load->model('checkout_m');
           $this->checkout_m->update_payment_response($order_id,$payment);
           redirect('payment/success');
       }else{
        $this->load->model('checkout_m');
        $order_id = $this->session->userdata('order_id');
        $payment['payment_status']=3;
        $payment['payment_details']='Failed';
        $this->checkout_m->update_payment_response($order_id,$payment);
        redirect('payment/failure');
    }

}else{
    redirect('payment/failure');
}
}
public function success(){
    if($this->session->userdata('order_id')) {
        $data['order_id'] = $this->session->userdata('order_id');
        $this->load->model('checkout_m');
        $data['net_total']= $this->checkout_m->net_amt($this->session->userdata('order_id'));
        $this->session->unset_userdata('order_id');
        $this->template('payment_success',$data);
    }else{
        redirect(base_url());
    }
}

public function cancel_order(){
    if($this->session->userdata('order_id')){
        $order_id = $this->session->userdata('order_id');
        $this->load->model('checkout_m');
        $pay_det['payment_status']=3;
        $this->checkout_m->update_payment_response($order_id,$pay_det);
        redirect(base_url().'payment/failure');
    }else{
        redirect(base_url());
    }
}

public function failure(){
    if($this->session->userdata('order_id')) {
        $data['order_id'] = $this->session->userdata('order_id');
        $this->template('payment_failure',$data);
    }else{
        redirect(base_url());
    }
}
}
