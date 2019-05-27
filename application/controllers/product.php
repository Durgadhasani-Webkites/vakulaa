<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends User_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_m');
    }

    public function index($slug){
        $slug = substr($slug,0,(strrpos($slug,'-')));
        $data['product_detail'] = $this->product_m->get_product_detail($slug);

        if(!empty($data['product_detail'])){
            $product_id = $data['product_detail']['id'];
            $coupon = $data['product_detail']['coupon'];
            if(!empty($data['product_detail']['specification']['product information'])){
            $data['specification'] = $data['product_detail']['specification']['product information'];
             }
            // print_r($specification);
            
            if(!empty($coupon)){
                $coupon_arr = explode(',',$coupon);
                $special_coupon=$this->product_m->get_coupon_detail($coupon_arr);
                if(!empty($special_coupon)){
                    $data['product_coupons']=$special_coupon;
                }
            }

            //  if(!empty($specification)){
            //     $nutrition_information_arr = explode('-&-',$specification);
            //     $nutrition_information=$this->product_m->get_coupon_detail($nutrition_information_arr);
            //     if(!empty($nutrition_information)){
            //         $data['nutrition_information']=$nutrition_information;
            //         print_r($data['nutrition_information']);
            //     }
            // }

            $product_options = $this->product_m->get_product_options($product_id);

            $data['product_options'] = $product_options;
            if(!empty($product_options)){
                foreach($product_options as $k=>$v){
                    if($v['default_option']==1){
                        $filter['option_id'] = $v['option_id'];
                    }
                }
            }else{
                $data['product_images']=$this->product_m->get_product_images($product_id);
            }

            $category_coupon = $this->product_m->get_product_coupons($product_id);
            if(!empty($category_coupon)){
                if(!isset($data['product_coupons'])){
                    $data['product_coupons']=array();
                }
                $data['product_coupons']= array_merge($category_coupon,$data['product_coupons']);
            }
            $filter['product_id']=$product_id;
            $offer_prods = $this->product_m->get_offer_products($filter);
            $data['offer_products']=$offer_prods;

            $category_id = $data['product_detail']['category_id'];
            $data['other_catgory'] =$this->product_m->get_related_images($category_id);
            $data['related_products'] = $this->product_m->get_related_products($product_id,$category_id);
            if(!empty($data['related_products'])){
                $this->load->model('product_m');
                foreach($data['related_products'] as $k=>$v){
                    $data['related_products'][$k]['product_options'] = $this->product_m->get_product_options($v['id']);
                }
            }

            $this->load->model('index_m');
            $data['bread_crumb']= $this->index_m->get_breadcrumb($category_id);


            $meta_title = $data['product_detail']['meta_title'];
            $meta_description = $data['product_detail']['meta_description'];
            $meta_keywords = $data['product_detail']['meta_keyword'];
            if(empty($data['product_detail'])){
                $meta_title = "{$data['product_detail']['product_name']} | vakulla.com";
                $meta_description = '';
                $meta_keywords = '';
            }
            $data['meta_title']=$meta_title;
            $data['meta_description']=$meta_description;
            $data['meta_keywords']=$meta_keywords;
            $this->template('productdetail',$data);
        }
    }

    public  function pincode_check() {
        $pincode_check = $this->product_m->pincode_check_db($this->input->post('pincode'));

        if($pincode_check){
            $msg = "Delivery available in your area";
            echo json_encode($msg);

        } else {
            return TRUE;
        }
    }

    public function get_option_details(){

        $product_option = $this->product_m->get_option_details($_POST);
        // print_r($product_option);
        $data['product_options'] =$product_option;
        $data['product_detail']['product_medium_image'] =$product_option['product_medium_image'];
        $data['product_detail']['product_image'] =$product_option['product_image'];
        $response['actual_price']= $product_option['actual_price'];
        $response['selling_price']= $product_option['selling_price'];
        $response['product_images']=$this->load->view('product_option_images',$data,true);
        $filter['product_id']=$_POST['product_id'];
        $filter['option_id']=$_POST['option_id'];
        $offer_prods= $this->product_m->get_offer_products($filter);
        if(!empty($offer_prods)){
            $response['offer_list']='<h3><i class="fa fa-gift"></i> Offers:</h3>
            <ul class="list">';
            foreach($offer_prods as $k=>$v){
                $product_name = $v['product_name'];
                if(!empty($v['option_value_name'])){
                    $product_name .= ' - '.$v['option_value_name'];
                }
                $response['offer_list'].='<li><i class="fa fa-info-circle"></i>  Get '. $v['offer_quantity'].' quantity of '.$product_name.' (free)</li>';
            }
            $response['offer_list'].='</ul>';
        }
        // print_r($response);
        echo json_encode($response);
    }

    public function product_ajax() {
        $filter = $_POST;
        $start=0;
        if(isset($_POST['start'])){
            $start=$_POST['start'];
        }
        if(!empty($_POST['brand_filter'])){
            $filter['brands']=$_POST['brand_filter'];
        }

        $this->load->model('index_m');
        if (!empty($_POST['search_term'])) {
            $filter['product_names'] = $this->index_m->get_all_product_names();
        }
        $data['products']=$this->index_m->get_products_by_filter($filter,6,$start);
        if(!empty($data['products'])){
            $this->load->model('product_m');
            foreach($data['products'] as $k=>$v){
                $data['products'][$k]['product_options'] = $this->product_m->get_product_options($v['product_id']);
            }
        }
        //print_r( $data['products']);die;
        $data['total_products'] = $this->index_m->get_total_products_by_filter($filter);
        $response['html']=$this->load->view('product_listing_ajax', $data,true);
        $response['prod_count']= $data['total_products'];
        echo json_encode($response);

    }


}