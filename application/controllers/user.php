<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends User_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_m');
    }


    public function signin(){
        if(!$this->session->userdata('login_details')) {
            $data = array();
            $data['meta_title']='SignIn | vakullaa.com';
            $data['meta_description']='';
            $data['meta_keywords']='';
            $this->template('signin',$data);
        }else{
            redirect('checkout');
        }
    }

    public function signin_process(){
        $res = $this->user_m->login($_POST);
        if($res){
           if($this->session->userdata('login_details')){
            redirect(base_url().'checkout');
        }else{
            redirect(base_url());
        }
        }else{
                $this->session->set_flashdata('login_error',"Invalid login credentials.");
                redirect('user/signin');
        }
    }

    public function signup(){
        if(!$this->session->userdata('login_details')){
            $data['meta_title']='SignUp | Vakulla.com';
            $data['meta_description']='';
            $data['meta_keywords']='';
            $this->template('signup',$data);
        }else{
            redirect('user/myaccount');
        }

    }

      public function forgot(){
        $data['meta_title']='Forgot password | Vakulla.com';
        $data['meta_description']='';
        $data['meta_keywords']='';
        $this->template('forgot_password',$data);
    }

    // public function forgot(){
    //     $data['meta_title']='Forgot password | Vakulla.com';
    //     $data['meta_description']='';
    //     $data['meta_keywords']='';
    //     $this->template('forgot',$data);
    // }

    public function signup_process(){
        $this->user_m->register_user($_POST);
        if($this->session->userdata('login_details')){
            redirect(base_url().'checkout');
        }else{
            redirect(base_url());
        }
    }

    public function myaccount(){
        $id=$this->session->userdata('login_details')['id'];
        $data['user_details']=$this->user_m->get_user_details($id);
        $data['meta_title']='My account | Vakulla.com';
        $data['meta_description']='';
        $data['meta_keywords']='';
        $this->template('my_account/index',$data);
    }

    public function process_account(){
        $results=$this->user_m->update_account($_POST);
        if($results){
            $this->session->set_flashdata('success',"Account information updated!");
        } else{
            $this->session->set_flashdata('error',"Error in updating account information!");

        }
        Redirect('user/myaccount');
    }

     public function process_shipping_address(){
        $results=$this->user_m->add_shipping_addr($_POST);
        if($results){
            $this->session->set_flashdata('success',"Address has been added successfully!");
        } else{
            $this->session->set_flashdata('error',"Error in adding address!");

        }
        Redirect('user/shipping_address');
    }

    public function change_password(){
        $this->template('my_account/change_pass');
    }

    public function process_change_password(){

        $results=$this->user_m->change_password($_POST);
        if($results){
            $this->session->set_flashdata('success',"Password has been changed successfully!");
        } else{
            $this->session->set_flashdata('error',"Error in updating password!");

        }
        Redirect('user/change_password');
    }

    public function check_old_pass(){
        $this->user_m->check_old_pass($_GET['old_password']);
    }

    public function shipping_address(){

        $id=$this->session->userdata('login_details')['id'];
        $data['user_details']=$this->user_m->get_user_details($id);
        $data['shipping_address']=$this->user_m->get_all_shipping_address($id);
        // $data['pincode']=$this->user_m->getpincodelist();
        $this->template('my_account/shipping_address',$data);
    }

    public function delete_address($id){
         if(!$this->session->userdata('login_details')){
            redirect(base_url());
        }
        $this->user_m->delete_shipping_addr($id);
        $this->session->set_flashdata('success',"Address has been deleted successfully!");
        Redirect('user/shipping_address');
    }

    public function order_history(){
        $offset =0;
        $limit =5;
        $order_results=$this->user_m->get_order_history($limit,$offset);
        $total_orders=$this->user_m->get_total_order_history();

        $data['order_history'] = $order_results;

        $this->load->library('pagination');
        $base_url = base_url() . 'user/order_history_ajax/';
        $config['base_url'] = $base_url;
        $config['total_rows'] = $total_orders;
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tag_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tag_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tag_close'] = "</li>";
        $this->pagination->initialize($config);
        $jsFunction['name'] = 'ajax_paginate';
        $jsFunction['params'] = array();
        $this->pagination->initialize_js_function($jsFunction);
        $data['page_link'] = $this->pagination->create_js_links();
        $data['base_url'] = $base_url;
        $this->template('my_account/order_history',$data);

    }

    public function order_history_ajax($offset=0){
        $limit =5;
        $order_results=$this->user_m->get_order_history($limit,$offset);
        $total_orders=$this->user_m->get_total_order_history();
        $data['order_history'] = $order_results;
        $this->load->library('pagination');
        $base_url = base_url() . 'user/order_history_ajax/';
        $config['base_url'] = $base_url;
        $config['total_rows'] = $total_orders;
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tag_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tag_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tag_close'] = "</li>";
        $this->pagination->initialize($config);
        $jsFunction['name'] = 'ajax_paginate';
        $jsFunction['params'] = array();
        $this->pagination->initialize_js_function($jsFunction);
        $response['page_link'] = $this->pagination->create_js_links();
        $data['base_url'] = $base_url;
        $response['html'] = $this->load->view('my_account/order_history_ajax', $data, true);


        echo json_encode($response);
    }

    public function view_invoice($id){
        $data['order_details'] = $this->user_m->get_order_detail($id);
        $order_id = $data['order_details']['order_id'];
        $data['cart_items'] = $this->user_m->get_cart_items($order_id);
      //  print_r($data);die;
        if(!empty($data['cart_items'])){
            foreach($data['cart_items'] as $k=>$v){
                $cart_offer_prod = $this->user_m->get_cart_offer_products($v['id']);
                $data['cart_items'][$k]['cart_offer_prod']=$cart_offer_prod;
            }
        }
        $this->load->model('admin/settings_m');
        $data['supermarket_results'] = $this->settings_m->get_supermarket_results();
        $this->template('my_account/view_invoice',$data);
    }

    public function track_invoice($order_id){

        $this->load->model('admin/customers_m');
        $data['order_details'] = $this->customers_m->get_order($order_id);

        $data['cart_items'] = $this->user_m->get_cart_items($order_id);
        if(!empty($data['cart_items'])){
            foreach($data['cart_items'] as $k=>$v){
                $cart_offer_prod = $this->user_m->get_cart_offer_products($v['id']);
                $status_results  = $this->customers_m->get_order_status($data['order_details']['id'],$v['id']);
                $new_status=array();
                if(!empty($status_results)){
                    foreach($status_results as $k1=>$v1){
                        $new_status[$v1['status_text']]=$v1;
                    }
                }
                $data['cart_items'][$k]['status_results']  = $new_status;
                $data['cart_items'][$k]['cart_offer_prod']=$cart_offer_prod;
            }
        }
        // print_r($data);die;
        $this->template('my_account/track_invoice',$data);
    }

    public function email_exists(){
        $this->user_m->email_exists($_POST['user_email']);
    }

    public function phone_exists(){
        $this->user_m->phone_exists($_POST['user_phone']);
    }

    public function phone_exists_forgot(){
        $this->user_m->phone_exists_forgot($_POST['user_phone']);
    }

    public function edit_shipping_address(){
        $data['shipping_address'] = $this->user_m->get_shipping_address($_POST['id']);
        // $data['pincode'] = $this->user_m->getpincodelist();

        $this->load->view('shipping_address_edit',$data);
    }
    
    public function set_default_shipping_addr(){
        $id=$_POST['id'];
        $this->user_m->set_default_shipping_addr($id);
    }

 

    public function send_otp(){
        if(!empty($_POST['user_phone'])){
            $otp_no=mt_rand(1000,10000);
            $user_phone = $_POST['user_phone'];
            $message="Your Verification code is $otp_no - Message By vakulla.com";
            $result = smshorizon($user_phone,$message);
           /* $result['error']='';
            $response['opt_no']=$otp_no;*/
            if($result['error']==''){
                $response['otp_sent'] = true;
                $this->session->set_userdata('otp_data',array('otp_no'=>$otp_no,'phone_number'=>$user_phone));
            }else{
                $response['otp_sent'] = false;
                $response['error'] = $result['error'];
            }

            echo json_encode($response);die;
        }
    }

    public function verify_otp(){
        $response['otp_verified']=false;
        
        if(!empty($_POST['otp_no'])){
            $otp_number = $_POST['otp_no'][0].$_POST['otp_no'][1].$_POST['otp_no'][2].$_POST['otp_no'][3];
            if($this->session->userdata('otp_data')){
                if(($this->session->userdata('otp_data')['otp_no']==$otp_number) && ($this->session->userdata('otp_data')['phone_number']==$_POST['user_phone'])){
                    $response['otp_verified']=true;
                    $this->session->unset_userdata('otp_data');
                }
            }
        }
        echo json_encode($response);die;
    }

    public function verify_ph_otp(){
        $response['otp_verified']=false;
        if(!empty($_POST['otp_no']) && is_numeric($_POST['otp_no'])) {
            if ($this->session->userdata('otp_data')) {
                if (($this->session->userdata('otp_data')['otp_no'] == $_POST['otp_no']) && ($this->session->userdata('otp_data')['phone_number'] == $_POST['user_phone'])) {

                    $this->user_m->update_user_phone($_POST);
                    $user_details = $this->user_m->get_user_details($_POST['id']);
                    $login_details = array(
                        'name' => $user_details['user_name'],
                        'id' => $user_details['id']
                    );
                    $this->session->set_userdata('login_details', $login_details);

                    $response['otp_verified'] = true;
                    $response['redirect_url'] = base_url();
                    if ($this->session->userdata('referrer_url')) {
                        $response['redirect_url'] = $this->session->userdata('referrer_url');
                    }else{
                        $response['redirect_url'] = base_url();
                    }
                    $this->session->unset_userdata('otp_data');
                }
            }
        }
        echo json_encode($response);die;
    }

    public function verify_otp_forgot(){
        $response['otp_verified']=false;
        if(!empty($_POST['otp_no']) && is_numeric($_POST['otp_no'])){
            if($this->session->userdata('otp_data')){
                if(($this->session->userdata('otp_data')['otp_no']==$_POST['otp_no']) && ($this->session->userdata('otp_data')['phone_number']==$_POST['user_phone'])){

                    $user_details = $this->user_m->get_user_by_phone($_POST['user_phone']);
                    $password = base64_decode($user_details['password']);

                    $user_phone = $_POST['user_phone'];
                    $message="Your password is $password - Message By vakullaa.com";
                    $result = smshorizon($user_phone,$message);

                    $login_details=array(
                        'name'=>$user_details['user_name'],
                        'id'=>$user_details['id']
                    );
                    $this->session->set_userdata('login_details',$login_details);

                    $response['otp_verified']=true;
                    if($this->session->userdata('referrer_url')){
                        $response['redirect_url']=$this->session->userdata('referrer_url');
                        $this->session->unset_userdata('referrer_url');
                    }else{
                        $response['redirect_url'] = base_url();
                    }
                    $this->session->unset_userdata('otp_data');
                }
            }
        }
        echo json_encode($response);die;
    }

    public function logout(){
        $this->session->unset_userdata('login_details');
        $this->session->sess_destroy();
        Redirect(base_url());
    }

    public function logout_and_signin(){
        $this->session->unset_userdata('login_details');
        $this->session->sess_destroy();
        Redirect('user/signin');
    }
}