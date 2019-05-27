<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkout extends User_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('checkout_m');
    }

    public function index(){
        $this->session->unset_userdata('redirect');
        $this->load->model('cart_m');
        $data['cart_details']=$this->cart_m->view_cart();
        if(empty($data['cart_details'])){
            redirect('cart/view');
        }
        $this->load->model('user_m');
        $data['all_shipping_address'] = $this->user_m->get_all_shipping_address();
        if(!empty($data['all_shipping_address'])){
             $this->template('select_shipping_addr',$data);
        }else {
            $this->template('shipping_addr',$data);
        }
    }
    
    public function process_shipping_addr(){
        $this->load->model('user_m');
        if(isset($_POST['id'])){
            $this->user_m->update_shipping_addr($_POST);
        }else{
            $shipping_id = $this->user_m->add_shipping_addr($_POST);
            $this->load->model('checkout_m');
            $this->checkout_m->place_order(array('shipping_address'=>$shipping_id));
        }

        if(isset($_POST['redirect_page'])){
            redirect($_POST['redirect_page']);
        }
        redirect('payment');
    }

    public function place_order(){
         $this->load->model('checkout_m');
        // print_r($_POST);die;
        $order_id = $this->checkout_m->place_order($_POST);
        echo json_encode(array('success'=>true));
    }

    public function new_shipping_addr(){
        $this->load->view('shipping_form');
    }

    public function edit_shipping_addr(){
        $this->load->model('user_m');
        $data['shipping_address'] = $this->user_m->get_shipping_addr($_POST['id']);
        $this->load->view('shipping_form',$data);
    }

     public function delete_shipping_addr($id){
        $this->load->model('user_m');
        $this->user_m->delete_shipping_addr($id);
        redirect('checkout');
    }

    public function get_states(){
        $filter_data['search']=$_GET['q'];
        $offset=0;
        $limit=$_GET['limit'];
        if(isset($_GET['page']) && $_GET['page']>0){
            $offset= ($_GET['page']-1)*$limit;
        }
        $this->load->model('user_m');
        $results=$this->user_m->get_all_states($filter_data,$offset,$limit);
        $data['items']=array();
        if($results){
            foreach($results as $k=>$v){
                $state = ucfirst(strtolower($v['state']));
                $data['items'][$k]['id']=$state;
                $data['items'][$k]['title']=$state;
            }
        }
        $data['total_count']=$this->user_m->get_total_states($filter_data);
        echo json_encode($data);
    }

    public function cashondelivery(){
        $order_id = $this->session->userdata('order_id');
        $this->checkout_m->update_order_stock($order_id);
        redirect(base_url().'checkout/success');
    }

    public function success(){
        if($this->session->userdata('order_id')) {
            $data['order_id'] = $this->session->userdata('order_id');
            $this->session->unset_userdata('order_id');
            $this->template('payment_success',$data);
        }else{
            redirect(base_url());
        }
    }

    public function cancel_order(){
        if($this->session->userdata('order_id')){
            $order_id = $this->session->userdata('order_id');
            $pay_det['payment_status']=3;
            $this->checkout_m->update_payment_response($order_id,$pay_det);
            redirect(base_url().'checkout/failure');
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