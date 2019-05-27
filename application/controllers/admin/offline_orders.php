<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Offline_Orders extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/offline_orders_m');
    }

    public function index(){
        $this->template('admin/offline_orders/view');
    }

    public function ajax_index(){

        $offset=$_GET['start'];

        $limit=$_GET['length'];

        $filter_data=array();


        if(!empty($_GET['search']['value'])){
            $filter_data['search']=$_GET['search']['value'];
        }

        if(!empty($_GET['formValues'])){
            parse_str($_GET['formValues'],$filter_data);
        }

        if(!empty($_GET['order'][0]['column'])){
            $filter_data['order']['column']=$_GET['order'][0]['column'];
            $filter_data['order']['dir']= $_GET['order'][0]['dir'];
        }

        $admin_results=$this->offline_orders_m->get_all($filter_data,$offset,$limit);

        $total_results=$this->offline_orders_m->get_total($filter_data);

        $dataTableData=array();

        $dataTableData['draw']=$_GET['draw'];

        $dataTableData['recordsTotal']=$total_results;

        $dataTableData['recordsFiltered']=$total_results;

        $dataTableData['data']=[];

        if(!empty($admin_results)){

            foreach($admin_results as $k=>$v){

                $dataTableData['data'][$k][0]=$v['order_id'];

                $dataTableData['data'][$k][1]=$v['shipping_user_name'];

                $dataTableData['data'][$k][2]=$v['shipping_user_contact_no'];

                $net_total = $v['net_total']-$v['coupon_discount'];

                $dataTableData['data'][$k][3]=$net_total;

                $dataTableData['data'][$k][4]=$v['payment_mode'];

                $dataTableData['data'][$k][5]=date('d/m/Y h:i:s A',strtotime($v['created']));

                if($v['payment_status']==2){
                    $status_text='<span class="label label-success">Paid</span>';
                }else{
                    $status_text='<span class="label label-danger">Not Paid</span>';
                }

                $dataTableData['data'][$k][6]=$status_text;


                $dataTableData['data'][$k][7] = '<a class="btn btn-primary btn-sm mb5" target="_blank" title="click to view bill" href="' . base_url('admin/offline_orders/view_bill/' . $v['order_id']) . '">Bill</a>';
                $dataTableData['data'][$k][7] .= '<a class="btn btn-primary btn-sm mb5" target="_blank" title="click to view invoice" href="' . base_url('admin/offline_orders/view_invoice/' . $v['id']) . '">Invoice</a>';
                if($v['payment_status']==1){
                    $dataTableData['data'][$k][7] .= '<a class="btn btn-warning btn-sm mb5" data-target="#globalModal" data-toggle="modal" title="click to mark as paid" href="' . base_url('admin/offline_orders/mark_as_paid/' . $v['id']) . '">Mark as paid</a>';
                }else{
                    $dataTableData['data'][$k][7] .= '<a class="btn btn-warning btn-sm mb5" data-target="#globalModal" data-toggle="modal" title="click to mark as unpaid" href="' . base_url('admin/offline_orders/mark_as_unpaid/' . $v['id']) . '">Mark as unpaid</a>';
                }
                $dataTableData['data'][$k][7] .= '<a class="btn btn-danger btn-sm mb5 confirm" target="_blank" title="click to delete" href="' . base_url('admin/offline_orders/delete_bill/' . $v['id']) . '">Trash</a>';
            }

        }
        echo json_encode($dataTableData);

    }

    public function view_bill($order_id){
        $this->load->model('admin/bill_m');
        $data['bill_results'] = $this->bill_m->get_bill($order_id);
        $this->load->model('admin/settings_m');
        $data['supermarket_results'] = $this->settings_m->get_supermarket_results();
        if(!empty($data['bill_results'])){
            foreach($data['bill_results'] as $k=>$v){
                $data['bill_id'] = $v['bill_id'];
                $data['bill_date'] = $v['bill_date'];
                $data['total_amount'] = $v['total_amount'];
                $data['delivery_cost'] = $v['delivery_cost'];
                $data['discount_percent'] = $v['discount_percent'];
                $data['net_total'] = $v['net_total'];
                $data['cash_received'] = $v['cash_received'];
                $data['balance_paid'] = $v['balance_paid'];
                $data['payment_status'] = $v['payment_status'];
                $data['remarks'] = $v['comments'];
            }
        }

        $this->template('admin/offline_orders/view_bill',$data);
    }

    public function view_invoice($id){
        $this->load->model('admin/orders_m');
        $data['order_details'] = $this->orders_m->get($id);
        $order_id = $data['order_details']['order_id'];
        $data['cart_items'] = $this->orders_m->get_cart_items($order_id);
        if(!empty($data['cart_items'])){
            foreach($data['cart_items'] as $k=>$v){
                $filter['cart_id']=$v['id'];
                $order_status = $this->orders_m->get_order_status($filter);
                $status_text='';
                if(!empty($order_status)){
                    $status_text = $order_status['status_text'];
                }
                $data['cart_items'][$k]['status_text'] = $status_text;
                $cart_offer_prod = $this->orders_m->get_cart_offer_products($v['id']);
                $data['cart_items'][$k]['cart_offer_prod']=$cart_offer_prod;
            }
        }

        $this->load->model('admin/settings_m');
        $data['supermarket_results'] = $this->settings_m->get_supermarket_results();


        $this->template('admin/offline_orders/view_invoice',$data);
    }

    public function print_invoice($id){
        $this->load->model('admin/orders_m');
        $data['order_details'] = $this->orders_m->get($id);
        $order_id = $data['order_details']['order_id'];
        $data['cart_details'] = $this->orders_m->get_cart_items($order_id);
        if(!empty($data['cart_details'])){
            foreach($data['cart_details'] as $k=>$v){
                $filter['cart_id']=$v['id'];
                $order_status = $this->orders_m->get_order_status($filter);
                $status_text='';
                if(!empty($order_status)){
                    $status_text = $order_status['status_text'];
                }
                $data['cart_details'][$k]['status_text'] = $status_text;
                $cart_offer_prod = $this->orders_m->get_cart_offer_products($v['id']);
                $data['cart_details'][$k]['cart_offer_prod']=$cart_offer_prod;
            }
        }

        $this->load->model('admin/settings_m');
        $data['supermarket_results'] = $this->settings_m->get_supermarket_results();
        $this->load->view('invoice',$data);
    }



    public function print_bill($id){
        $data['order_details'] = $this->offline_orders_m->get($id);
        $order_id = $data['order_details']['order_id'];
        $this->load->model('admin/bill_m');
        $data['bill_results'] = $this->bill_m->get_bill($order_id);
        $this->load->model('admin/settings_m');
        $data['supermarket_results'] = $this->settings_m->get_supermarket_results();
        if(!empty($data['bill_results'])){
            foreach($data['bill_results'] as $k=>$v){
                $data['bill_id'] = $v['bill_id'];
                $data['bill_date'] = $v['bill_date'];
                $data['total_amount'] = $v['total_amount'];
                $data['discount_percent'] = $v['discount_percent'];
                $data['delivery_cost'] = $v['delivery_cost'];
                $data['net_total'] = $v['net_total'];
                $data['cash_received'] = $v['cash_received'];
                $data['balance_paid'] = $v['balance_paid'];
            }
        }
        $this->load->view('admin/bill/print_bill',$data);
    }

    public function edit_bill($id){
        $this->load->model('admin/bill_m');
        $data['bill_results'] = $this->bill_m->get_order_details($id);
        $order_id = $data['bill_results']['order_id'];
        if($data['bill_results']['shipping_user_name']!='guest'){
            $user_id = $data['bill_results']['user_id'];
            $data['user_shipping_results'] = $this->db->get_where('user_shipping_address',array('user_id'=>$user_id))->row_array();
        }
        $data['bill_items'] = $this->bill_m->get_bill($order_id);
      //  print_r($data);die;
        $this->template('admin/bill/view',$data);
    }

    public function mark_as_paid($order_id){
        $data['order_id'] = $order_id;
        $this->load->view('admin/offline_orders/mark_as_paid',$data);
    }

    public function mark_as_unpaid($order_id){
        $data['order_id'] = $order_id;
        $this->load->view('admin/offline_orders/mark_as_unpaid',$data);
    }

    public function process_mark_as_paid(){
        $this->offline_orders_m->mark_as_paid($_POST);
        $this->session->set_flashdata('notify_success',"updated successfully");
        redirect('admin/offline_orders');
    }

    public function process_mark_as_unpaid(){
        $this->offline_orders_m->mark_as_unpaid($_POST);
        $this->session->set_flashdata('notify_success',"updated successfully");
        redirect('admin/offline_orders');
    }

    public function change_order_status() {
        $getres=$this->offline_orders_m->change_order_status($_POST);
        $this->session->set_flashdata('notify_success', "Successfully updated!");
        if($_POST['submit']=='save_and_mail'){
            if($getres) {
                $data['order_details'] = $this->offline_orders_m->get($_POST['order_id']);
                $order_id = $data['order_details']['order_id'];
                $data['cart_items'] = $this->offline_orders_m->get_cart_items($order_id);
                if(!empty($data['cart_items'])){
                    foreach($data['cart_items'] as $k=>$v){
                        $cart_offer_prod = $this->offline_orders_m->get_cart_offer_products($v['id']);
                        $data['cart_items'][$k]['cart_offer_prod']=$cart_offer_prod;
                    }
                    $shipping_name = $data['order_details']['shipping_user_name'];
                    $shipping_email = $data['order_details']['shipping_user_email'];

                    $message_subject='Your order -'.$_POST['order_id'];
                    $message='';
                    if($_POST['delivery_status']=='Shipped'){
                        $message_subject='Shipment of items in order '.$_POST['order_id'].' by vakullaa.com';
                        $message.='<p>Hi '.$shipping_name.',</p>';
                        $message.='<p>Greeting from vakullaa!</p>';
                        $message.='<p>Your order '.$_POST['order_id'].' has been shipped by vakullaa.com</p>';

                    }

                    if($_POST['delivery_status']=='Delivered'){
                        $message_subject='Delivery confirmation of vakullaa.com order '.$_POST['order_id'].'. Please share your feedback.';
                        $message.='<p>Hi '.$shipping_name.',</p>';
                        $message.='<p>Greeting from vakullaa!</p>';
                        $message.='<p> We are pleased to inform that the following items in your order '.$_POST['order_id'].' have been delivered. This completes your order. Thank you for shopping!</p>';

                    }

                    if($_POST['delivery_status']=='Initiate Return'){
                        $message_subject='Return of your order '.$_POST['order_id'].' has been initiated by vakullaa.com';
                        $message.='<p>Hi '.$shipping_name.',</p>';
                        $message.='<p>Greeting from vakullaa!</p>';
                        $message.='<p> We would like to inform you that we are processing your return of the Order '.$_POST['order_id'].' has been initiated.</p>';
                    }

                    if($_POST['delivery_status']=='Returned'){
                        $message_subject='Confirmation for return of your order '.$_POST['order_id'].' by vakullaa.com';
                        $message.='<p>Hi '.$shipping_name.',</p>';
                        $message.='<p>Greeting from vakullaa!</p>';
                        $message.='<p> Your has order for '.$_POST['order_id'].' has been returned.</p>';
                    }
                    if($_POST['delivery_status']=='Canceled'){
                        $message_subject='Cancellation of your order '.$_POST['order_id'].' with vakullaa.com';
                        $message.='<p>Hi '.$shipping_name.',</p>';
                        $message.='<p>Greeting from vakullaa!</p>';
                        $message.='<p> We would like to inform you that we are processing your cancellation request for  the Order '.$_POST['order_id'].'.</p>';
                    }

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
                    $mail->AddAddress($shipping_email);

                    $mail->Subject = $message_subject;

                    $mail->Body = $message;
                    $mail->isHTML(true);
                    $mail->Send();
                    $mail->ClearAllRecipients();
                    $mail->clearAttachments();


                    $this->session->set_flashdata('notify_success', "Successfully updated!");
                    redirect('admin/offline_orders/view_invoice/'.$_POST['order_id']);
                    return true;

                }

            } else {

                $this->session->set_flashdata('notify_error', "Problem while inserting!");
                redirect('admin/offline_orders/view_invoice/'.$_POST['order_id']);
                return true;

            }
        }else{
            $this->session->set_flashdata('notify_success', "Successfully updated!");
            redirect('admin/offline_orders/view_invoice/'.$_POST['order_id']);
        }
        return true;
    }

    public function get_export_form(){
        $this->load->view('admin/offline_orders/export_frm');
    }

    public function process_export_order(){
        $order_date=array();
        if(!empty($_POST['order_from_date'])) {
            $order_from_date = str_replace('/', '-', $_POST['order_from_date']);
            $_POST['order_from_date'] = date('Y-m-d', strtotime($order_from_date));
            $order_date[] = date('d-m-Y', strtotime($order_from_date));
        }
        if(!empty($_POST['order_to_date'])){
            $order_to_date = str_replace('/', '-', $_POST['order_to_date']);
            $_POST['order_to_date'] = date('Y-m-d',strtotime($order_to_date));
            $order_date[] = date('d-m-Y', strtotime($order_to_date));
        }

        $order_results=$this->offline_orders_m->get_order_list($_POST);
        if(!empty($order_results)){
            $table_columns = array('Order ID','Order Date','Name','Mobile','Products','Amount','Payment Mode','Payment Status');

            $this->load->library("excel");
            $object = new PHPExcel();

            $object->setActiveSheetIndex(0);
            $column = 0;
            foreach($table_columns as $field)
            {
                $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
                $column++;
            }

            $excel_row = 2;
            foreach($order_results as $k=>$v) {
                $order_id = $v['order_id'];
                $product_names = $this->offline_orders_m->get_products_by_oid($order_id);
                $product_name_str = '';
                if (!empty($product_names)) {
                    $product_name_str = implode(',', $product_names);
                }
                $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $v['order_id']);
                $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, date('d-m-Y', strtotime($v['created'])));
                $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $v['shipping_user_name']);
                $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $v['shipping_user_contact_no']);
                $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $product_name_str);

                $net_total = $v['net_total'] - $v['coupon_discount'];
                $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $net_total);
                $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $v['payment_mode']);
                $payment_status = 'not paid';
                if ($v['payment_status'] == 2) {
                    $payment_status = 'paid';
                }
                $excel_row++;
            }

            $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="offline_orders_'.date("ymdhis").'.xls"');
            $object_writer->save('php://output');

        }else{
            $this->session->set_flashdata('notify_error',"No order found");
            redirect('admin/offline_orders');
        }
    }

    public function delete_bill($id){
        $this->offline_orders_m->delete_bill($id);
        redirect('admin/offline_orders');
    }


}