<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends User_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('index_m');
        $this->_limit=2;
    }

    public function index($seg1='',$seg2='',$seg3='')
    {
        if(empty($seg1) && empty($seg2) && empty($seg3)){
            $filter['status']=true;
            $filters['status']=true;
            $filters['bannertype']='1';
            $this->load->model('admin/banner_m');
            $data['banners']=$this->banner_m->get_all($filters);
            $this->load->model('admin/settings_m');
            $data['home_page_products'] = $this->settings_m->get_home_page_products();
            $data['how_to_prepare'] = $this->settings_m->get_how_to_prepare();

            $data['meta_title']='vakulla';
            $data['meta_description']='vakulla';
            $data['meta_keywords']='vakulla';
            $this->template('index',$data);
        }else{
            if(!empty($seg1) && empty($seg2) && empty($seg3)){
                $category_details = $this->index_m->get_category_by_slug($seg1);
                if(!empty($category_details)){
                    $filter=array();
                    $filter['category_id']=$category_details['id'];
                    $data['category_details']=$category_details;
                    $data['filters'] = $this->index_m->get_filter_by_category($category_details['id']);
                    $data['products'] = $this->index_m->get_products_by_filter($filter,$start=0);
                    $data['total_products'] = $this->index_m->get_total_products_by_filter($filter);

                    if(!empty($data['products'])){
                        $this->load->model('product_m');
                        foreach($data['products'] as $k=>$v){
                            $data['products'][$k]['product_options'] = $this->product_m->get_product_options($v['product_id']);
                        }
                    }

                    $meta_title = "{$category_details['category_name']} | vakulla.com";
                    $meta_description = '';
                    $meta_keywords = '';


                    if(!empty($category_details['meta_title'])) {
                        $meta_title = $category_details['meta_title'];
                        $meta_description = $category_details['meta_description'];
                        $meta_keywords = $category_details['meta_keywords'];
                    }

                    $data['meta_title']=$meta_title;
                    $data['meta_description']=$meta_description;
                    $data['meta_keywords']=$meta_keywords;
                    $this->template('product-listing',$data);
                }else{
                    $data['page_details'] = $this->index_m->get_page_details($seg1);
                    $this->template('page',$data);
                }

            }
            if(!empty($seg1) && !empty($seg2) && empty($seg3)){
                $category1_details = $this->index_m->get_category_by_slug($seg1);
                $category_details = $this->index_m->get_category_by_slug($seg2);
                if(!empty($category_details)){
                    $filter=array();
                    $filter['category_id']=$category_details['id'];
                    $data['category_details']=$category_details;
                    $data['child_categories'] = $this->index_m->get_child_categories_listing(array('category_id'=>$category1_details['id']));
                    $data['filters'] = $this->index_m->get_filter_by_category($category_details['id']);
                    $data['products'] = $this->index_m->get_products_by_filter($filter,$start=0);
                    if(!empty($data['products'])){
                        $this->load->model('product_m');
                        foreach($data['products'] as $k=>$v){
                            $data['products'][$k]['product_options'] = $this->product_m->get_product_options($v['product_id']);
                        }
                    }
                    $data['total_products'] = $this->index_m->get_total_products_by_filter($filter);


                    $meta_title = "{$category_details['category_name']} | vakulla.com";
                    $meta_description = '';
                    $meta_keywords = '';
                    if(!empty($category_details['meta_title'])){
                        $meta_title =$category_details['meta_title'];
                        $meta_description = $category_details['meta_description'];
                        $meta_keywords = $category_details['meta_keywords'];
                    }
                    $data['meta_title']=$meta_title;
                    $data['meta_description']=$meta_description;
                    $data['meta_keywords']=$meta_keywords;

                    $this->template('product-listing',$data);
                }
            }
            if(!empty($seg1) && !empty($seg2) && !empty($seg3)){
                $category_details = $this->index_m->get_category_by_slug($seg3);
                if(!empty($category_details)){
                    $filter=array();
                    $filter['category_id']=$category_details['id'];
                    $data['category_details']=$category_details;
                    $data['child_categories'] = $this->index_m->get_child_categories($category_details['id'],2);
                    $data['filters'] = $this->index_m->get_filter_by_category($category_details['id']);
                    $data['products'] = $this->index_m->get_products_by_filter($filter,$start=0);
                    if(!empty($data['products'])){
                        $this->load->model('product_m');
                        foreach($data['products'] as $k=>$v){
                            $data['products'][$k]['product_options'] = $this->product_m->get_product_options($v['product_id']);
                        }
                    }
                    $data['total_products'] = $this->index_m->get_total_products_by_filter($filter);

                    $meta_title = "{$category_details['category_name']} | vakulla.com";
                    $meta_description = '';
                    $meta_keywords = '';

                    if(!empty($category_details['meta_title'])){
                        $meta_title =$category_details['meta_title'];
                        $meta_description = $category_details['meta_description'];
                        $meta_keywords = $category_details['meta_keywords'];
                    }
                    $data['meta_title']=$meta_title;
                    $data['meta_description']=$meta_description;
                    $data['meta_keywords']=$meta_keywords;
                    $this->template('product-listing',$data);
                }
            }
        }

    }

    public function listing(){

        $data = array();

        $this->template('product-listing',$data);
    }

    public function detailpage(){

        $data = array();

        $this->template('productdetail',$data);
    }

    public function clients(){

        $data = array();

        $this->template('clients',$data);
    }

    public function subscribe_to_newsletter(){
        $res = $this->index_m->get_newsletter($_POST);
        if(!$res){
            $insert_res = $this->index_m->add_newsletter($_POST);
            if($insert_res){
                $response['success']='Successfully subscribed to newsletter';
            }else{
                $response['error']='Error in subscribing to newsletter';
            }
        }else{
            $response['error']='Already subscribed to newsletter';
        }
        echo json_encode($response);
    }

    public function affiliate_process(){
        $this->index_m->add_affiliate($_POST);
        redirect('affiliate');
    }

}
?>