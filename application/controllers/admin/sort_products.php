<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sort_Products extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/sort_products_m');
        $privileges=explode(",", $this->session->userdata('privileges'));
        if(!in_array(15, $privileges)) {
            redirect('admin/index/logout');
        }
    }

    public function index() {
        $this->load->model('admin/products_m');
        $data['categories']=$this->products_m->categoryview(0, 0);
        $this->template('admin/sort_products/view',$data);
    }

    public function update_sorting(){
        $this->sort_products_m->update_sorting();
    }

    public function get_products_by_category(){
        $products = $this->sort_products_m->get_products_by_category($_POST['category_id']);
        if(!empty($products)){
            $li_list = '';
            foreach($products as $k=>$v){
                if($v['product_name']!=''){
                    $li_list .= '<li id="item-'.$v['id'].'" class="list-group-item list-group-item-info">'.$v['product_name'].'</li>';
                }
            }
            echo $li_list;
        }
    }

}
?>