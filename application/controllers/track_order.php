<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Track_Order extends User_Controller
{

    public function __construct()
    {
        parent::__construct();

    }

    public function index(){

        if(!empty($_GET['order_id'])){
            $order_id = $_GET['order_id'];
            $this->load->model('admin/customers_m');
            $data['order_details'] = $this->customers_m->get_order($order_id);

            $this->load->model('user_m');
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
            $data['meta_title']="Track Order($order_id) | vakullaa.com";
            $data['meta_description']='';
            $data['meta_keywords']='';
            $this->template('track_order_results',$data);
        }else{
            $data['meta_title']='Track Order | vakullaa.com';
            $data['meta_description']='';
            $data['meta_keywords']='';
            $this->template('track_order',$data);
        }
    }

}