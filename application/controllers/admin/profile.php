<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Profile extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/profile_m');
    }
	
    public function index() {
        $id=$this->session->userdata('id');
        $data['admin_results']=$this->profile_m->get_profile($id);
        $this->template("admin/admins/profile",$data);
    }
	
	public function process_profile() {
        $update_results=$this->profile_m->update_profile($_POST);
        if($update_results){
            $this->session->set_flashdata('notify_success', "Successfully updated.");
        } else{
            $this->session->set_flashdata('notify_error', "Error in updating content. Try again later.");
        }
        redirect('admin/profile');
    }
	
	public function check_old_pass() {
        $old_password = $_GET['old_password'];	
        $this->profile_m->check_old_pass($old_password);
    }
	
}
?>