<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Admins extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/admins_m');
    }
	
    public function index() {
        $data['admin_results']=$this->admins_m->get_all();
        $this->template("admin/admins/view",$data);
    }

    public function add() {
        $this->template("admin/admins/add");
    }
	
    public function process_add() {
        $this->admins_m->add($_POST);
        Redirect('admin/admins');
    }

    public function edit($id) {
        $data['admin_results']=$this->admins_m->get($id);
        $this->template("admin/admins/edit",$data);
    }

    public function process_edit() {
        $update_results=$this->admins_m->update($_POST);
        if($update_results){
            $this->session->set_flashdata('notify_success', "Successfully updated.");
        } else{
            $this->session->set_flashdata('notify_error', "Error in updating content. Try again later.");
        }
        redirect('admin/admins');
    }
	
	public function profile() {
		$id=$this->session->userdata('id');
        $data['admin_results']=$this->admins_m->get_profile($id);
        $this->template("admin/admins/profile",$data);
    }
	
	public function process_profile() {
        $update_results=$this->admins_m->update_profile($_POST);
        if($update_results){
            $this->session->set_flashdata('notify_success', "Successfully updated.");
        } else{
            $this->session->set_flashdata('notify_error', "Error in updating content. Try again later.");
        }
        redirect('admin/admins/profile');
    }
	
	public function check_old_pass() {
        $old_password = $_GET['old_password'];
        $this->admins_m->check_old_pass($old_password);
    }

    public function process_action() {
        if($_POST['action']=='approve'){
            $this->multi_approve();
        }
        if($_POST['action']=='disapprove'){
            $this->multi_disapprove();
        }
        if($_POST['action']=='delete'){
            $this->multi_delete();
        }
    }

    public function approve() {
        $id = $this->uri->segment(4);
        $this->admins_m->approve($id);
        redirect('admin/admins');
    }

    public function disapprove() {
        $id = $this->uri->segment(4);
        $this->admins_m->disapprove($id);
        redirect('admin/admins');
    }

    public function delete() {
        $id = $this->uri->segment(4);
        $this->admins_m->delete($id);
        redirect('admin/admins');
    }

    public function multi_approve(){
        $this->admins_m->multi_approve();
        redirect('admin/admins');
    }
	
    public function multi_disapprove(){
        $this->admins_m->multi_disapprove();
        redirect('admin/admins');
    }
	
    public function multi_delete(){
        $this->admins_m->multi_delete();
        redirect('admin/admins');
    }
	
}
?>