<?php

Class Checkout_M extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_cart_item($id){
        $this->db->select('a.*,b.quantity as product_stock');
        $this->db->from('user_cart a');
        $this->db->join('admin_product b','a.product_id = b.id','left');
        $this->db->where('a.id', $id);
        $query = $this->db->get();
        if($query->num_rows()>=1){
            return $query->row_array();
        }
        return false;
    }

     public function place_order($data){
        if($this->session->userdata('order_id')){
            if ($this->session->userdata('login_details')) {
                  $login_details = $this->session->userdata('login_details');
            }
            $order_id=$this->session->userdata('order_id');
            $this->db->where('order_id',$order_id);
            if ($this->session->userdata('login_details')) {
                $this->db->where('user_id',$login_details['id']);
            }
            $query = $this->db->get('user_order');
            if($query->num_rows()==1){
                $this->db->from('user_order');
                $this->db->where('order_id', $order_id);
                $this->db->delete();
            }
            if ($this->session->userdata('login_details')) {
            $insert['user_id'] = $login_details['id'];
            }
            $insert['order_id'] = $order_id;
            $insert['coupon_code'] = '';
            $insert['coupon_discount']=0;
            $insert['payment_id']='';
            $insert['payment_date']='';
            $insert['payment_details']='';
            $insert['tracking_id']='';
            $insert['bank_ref_no']='';
            $insert['invoice_sent']=0;
            $insert['delivery_status']='';
            $insert['comments']='';
            $this->load->model('user_m');
            $shipping_details = $this->user_m->get_shipping_addr($data['shipping_address']);

            $insert['shipping_title'] = $shipping_details['title'];
            $insert['shipping_user_name'] = $shipping_details['contact_name'];
            $insert['shipping_user_email'] = $shipping_details['email_address'];
            $insert['shipping_user_contact_no'] = $shipping_details['contact_number'];
            $insert['shipping_user_address'] = $shipping_details['address'];
            $insert['shipping_user_landmark'] = $shipping_details['landmark'];
            $insert['shipping_user_city'] = $shipping_details['city'];
            $insert['shipping_user_state'] = $shipping_details['state'];
            $insert['shipping_user_country'] = $shipping_details['country'];
            $insert['shipping_user_pincode'] = $shipping_details['pincode'];

            $this->load->model('cart_m');
            $cart_items = $this->cart_m->view_cart_details($order_id);
                $total_amount=0;
                 $total_grams=0;
                if(!empty($cart_items)){
                    foreach($cart_items as $k=>$v){
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
                        $total_amount+=$subtotal_price;
                        $total_grams+=$gms;
                    }
                }

                $delivery_cost = $this->cart_m->get_delivery_cost();
                $grams = $total_grams;
                $rate = $delivery_cost['rate'];
                $grams_count = ceil($grams/500);
                $shipping_cost = $grams_count * $rate;


            $this->load->model('admin/settings_m');
            $web_settings = $this->settings_m->get();
            $order_details['total_grams'] = $total_grams;
            $net_total =  $shipping_cost+$total_amount;
            $insert['total_amount'] = round($total_amount);
            $insert['delivery_cost'] = round($shipping_cost);
            $insert['net_total'] = round ($net_total);
            // print_r($insert);die;
            $insert['payment_mode'] = 'credit/debit payment';

            $insert['created'] = date('Y-m-d H:i:s');
            $insert['updated'] = date('Y-m-d H:i:s');
            $insert['seen_status']=1;
            $insert['status'] = 2;

            $insert['order_type'] = 'online';
            $insert['payment_status'] = 1;
             // print_r($insert);die;
            $this->db->insert('user_order', $insert);
            if ($this->db->insert_id()) {
                return $order_id;
            }
        }
        return false;

    }

       public function net_amt($id){
        $this->db->select('net_total');
        $this->db->where('id',$id);
       $query = $this->db->get('user_order');
        if ($query->num_rows() >= 1) {
           $res = $query->row_array();
          
           return $res['net_total'];
       }
       return false;
    }

    public function get_offer_products($pid,$poid){
        $this->db->where('product_id', $pid);
        $this->db->where('product_option_id', $poid);
        $query = $this->db->get('admin_offer_products');
        if($query->num_rows()>=1){
            return $query->result_array();
        }
        return false;
    }

    public function get_product_details($id){
        $this->db->select('a.quantity',false);
        $this->db->from('admin_product a');
        $this->db->where('a.id', $id);
        $query = $this->db->get();
        if($query->num_rows()>=1){
            return $query->row_array();
        }
        return false;
    }

    public function get_product_opt_details($product_id,$option_id){
        $this->db->select('a.option_qty',false);
        $this->db->from('admin_product_option_value a');
        $this->db->where('a.product_id', $product_id);
        $this->db->where('a.option_id', $option_id);
        $query = $this->db->get();
        if($query->num_rows()>=1){
            return $query->row_array();
        }
        return false;
    }

    public function update_payment_response($order_id,$response){
        $this->db->where('order_id',$order_id);
        $this->db->update('user_order', $response);
        return true;
    }

}