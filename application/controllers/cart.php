<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends User_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('cart_m');
    }

    public function index() {

        if($this->input->post('product_id') && $this->input->post('product_id')!='') {

            $product_id = $this->input->post('product_id');
            $quantity = $this->input->post('quantity');

            $this->load->model('products_m');
            $product_details = $this->products_m->get_by_id($product_id);
            $existing_quantity = $product_details['quantity'];

            $product_name = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', $product_details['product_name']));

            if ($existing_quantity > 0 && $quantity > 0) {

                $this->cart_m->add_cart();
                redirect('cart/view');

            } else {
                $this->session->set_flashdata('pro_message', "<div class='notify notify-red'><span class='symbol icon-error'></span> Please add minimum quantity!</div>");
                redirect('product/' . $product_id . '/' . $product_name);
            }
        }

    }

    public function add_to_cart(){
        if($this->input->post('pid')!='' && $this->input->post('qty')>0) {
            $this->cart_m->add_to_cart($_POST);
        }
    }

    public function view() {
       $data=array();
       $data['cart_details']=$this->cart_m->view_cart();
        if(!empty($data['cart_details'])){
            foreach($data['cart_details'] as $k=>$v){
                $cart_offer_prod = $this->cart_m->get_cart_offer_products($v['id']);
                $data['cart_details'][$k]['cart_offer_prod']=$cart_offer_prod;
            }
        }
       /* if(isset($this->session->userdata('login_details')['user_id'])) {
            $this->load->model('rewards_m');
            $data['reward_points']=$this->rewards_m->apply_reward_points();
        }*/
        //print_r($data);die;
        $data['meta_title']='Cart | vakulla.com';
        $data['meta_description']='';
        $data['meta_keywords']='';

        $this->template('cart', $data);

    }

       public function view_cart() {
        $data=array();
       $data['cart_details']=$this->cart_m->view_cart();
        if(!empty($data['cart_details'])){
            foreach($data['cart_details'] as $k=>$v){
                $cart_offer_prod = $this->cart_m->get_cart_offer_products($v['id']);
                $data['cart_details'][$k]['cart_offer_prod']=$cart_offer_prod;
            }
        }
        $data['meta_title']='Cart | vakulla.com';
        $data['meta_description']='';
        $data['meta_keywords']='';

        $this->template('checkout', $data);

    }
  
    function cart_details(){
        $result = $this->cart_m->view_cart_details();
        if($result){
            echo json_encode($result);
        } else { 
            return TRUE;
        }
    }
 
    public function apply_coupon(){
        $this->cart_m->apply_coupon($_POST);
    }

    public function remove_coupon($id){
        $this->cart_m->remove_coupon($id);
        redirect('cart/view');
    }

    public function remove_coupon_code(){
         $this->cart_m->remove_coupon($this->input->post('id'));
         echo json_encode(array('coupon_success'=>'Coupon removed successfully'));
    }

    public function update() {
        $cart_id=$_POST['cartid'];
        $qty=$_POST['cartqty'];
        $product_id=$_POST['proid'];
        $option_id=$_POST['option_id'];
        $this->load->model('product_m');
        if($option_id==0){
            $prod_res=$this->product_m->get_product_by_id($product_id);
            $quantity = $prod_res['quantity'];
        }else{
            $prod_res=$this->product_m->get_product_by_option($product_id,$option_id);
            $quantity = $prod_res['option_qty'];
        }

        if(($quantity>=$qty) && ($qty>0)) {
            $this->cart_m->update_cart_item($cart_id,$qty);
            $this->cart_m->update_cart_offer_qty($cart_id,$qty);
            $response['success']='Quantity successfully updated';
        } else {
            $response['error']='Out of stock';
        }
        echo json_encode($response);
        return true;
    }

    public function delete() {

        $id = $this->uri->segment(3);
        $getresult=$this->cart_m->delete($id);

        /*if($getresult) {
            $this->session->set_flashdata('cart_message', '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Successfully removed!</div>');
        } else {
            $this->session->set_flashdata('cart_message', '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Problem while deleting!</div>');
        }*/
        redirect('cart/view');
    }

     public function delete_cart_item() {
        $result=$this->cart_m->delete_cart_item($this->input->post('id'));
        if($result){
            $response['success']='Successfully removed!';
            if($this->session->userdata('order_id')){
            $order_id=$this->session->userdata('order_id');
           }
        $response['cart_total'] = $this->cart_m->get_cart_total($order_id);
        } else { 
            $response['error']='Problem while deleting!';
        }
        echo json_encode($response);
        return true;
    }

    public function apply_promo() {

        $promocode=$this->input->post('promocode');
        if($promocode!="") {
            $this->cart_m->apply_promo($promocode);
            redirect('payment');
        } else {
            redirect('cart/view');
        }

    }
}