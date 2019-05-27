<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Modules extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/modules_m');
    }

    public function index() {
        $data['admin_results']=$this->modules_m->get_all();
        $this->template("admin/modules/view",$data);
    }

    public function add() {
        $this->template("admin/modules/add");
    }

    public function process_add() {
        $this->modules_m->add($_POST);
        Redirect('admin/modules');
    }

    public function edit($id) {
        $data['admin_results']=$this->modules_m->get($id);
        $this->template("admin/modules/edit",$data);
    }

    public function process_edit() {
        $update_results=$this->modules_m->update($_POST);
        if($update_results){
            $this->session->set_flashdata('notify_success', "Successfully updated.");
        } else{
            $this->session->set_flashdata('notify_error', "Error in updating content.Try again later.");
        }
        Redirect('admin/modules');

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
        $this->modules_m->approve($id);
        redirect('admin/modules');
    }

    public function disapprove() {
        $id = $this->uri->segment(4);
        $this->modules_m->disapprove($id);
        redirect('admin/modules');
    }

    public function delete() {
        $id = $this->uri->segment(4);
        $this->modules_m->delete($id);
        redirect('admin/modules');
    }

    public function multi_approve(){
        $this->modules_m->multi_approve();
        redirect('admin/modules');
    }
	
    public function multi_disapprove(){
        $this->modules_m->multi_disapprove();
        redirect('admin/modules');
    }
	
    public function multi_delete(){
        $this->modules_m->multi_delete();
        redirect('admin/modules');
    }
	
}
?>