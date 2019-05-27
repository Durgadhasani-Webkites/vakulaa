<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Headings extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/headings_m');
        $privileges=explode(",", $this->session->userdata('privileges'));
        if(!in_array(3, $privileges)) {
            redirect('admin/index/logout');
        }
    }

    public function index() {
        $data['admin_results']=$this->headings_m->get();
        $this->template('admin/headings/view',$data);
    }

    public function process() {
        $getresult=$this->headings_m->edit($_POST);
        if($getresult) {
            $this->session->set_flashdata('notify_success', "Successfully updated!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while updating!");
        }
        redirect('admin/headings');
    }


}
?>