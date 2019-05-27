<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homepage_order extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/homepageorder_m');
        $privileges=explode(",", $this->session->userdata('privileges'));
        if(!in_array(28, $privileges)) {
            redirect('admin/index/logout');
        }
    }

    public function index() {
      //  $data['admin_results']=$this->headings_m->get();
        //$this->template('admin/headings/view',$data);
        $data['admin_results']=$this->homepageorder_m->get();
        $this->template('admin/hompageorder',$data);
    }

    public function process(){
        //print_r($_POST);
        $this->homepageorder_m->update();
    }
    
}
?>