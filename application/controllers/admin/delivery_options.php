<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Delivery_Options extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/delivery_options_m');
        $privileges=explode(",", $this->session->userdata('privileges'));
        if(!in_array(15, $privileges)) {
            redirect('admin/index/logout');
        }
    }

    public function index() {
        $data['admin_results']=$this->delivery_options_m->get();
        $this->template('admin/delivery_options/view',$data);
    }

    public function process_delivery_options() {
        $getresult=$this->delivery_options_m->edit($_POST);
        if($getresult) {
            $this->session->set_flashdata('notify_success', "Successfully updated!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while updating!");
        }
        redirect('admin/delivery_options');
    }

}
?>