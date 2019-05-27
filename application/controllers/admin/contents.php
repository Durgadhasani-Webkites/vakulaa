<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Contents extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/contents_m');
        $privileges=explode(",", $this->session->userdata('privileges'));
        if(!in_array(4, $privileges)) {
            redirect('admin/index/logout');
        }
    }
	
    public function index() {
        $data['admin_results']=$this->contents_m->get_all();
        $this->template("admin/contents/view",$data);
    }

    public function add() {
        $this->template("admin/contents/add");
    }
	
    public function process_add() {
        $this->contents_m->add($_POST);
        Redirect('admin/contents');
    }

    public function edit($id) {
        $data['admin_results']=$this->contents_m->get($id);
        $this->template("admin/contents/edit",$data);
    }

    public function process_edit() {
        $update_results=$this->contents_m->update($_POST);
        if($update_results){
            $this->session->set_flashdata('notify_success', "Successfully updated.");
        } else{
            $this->session->set_flashdata('notify_error', "Error in updating content. Try again later.");
        }
        Redirect('admin/contents');
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
        $this->contents_m->approve($id);
        redirect('admin/contents');
    }

    public function disapprove() {
        $id = $this->uri->segment(4);
        $this->contents_m->disapprove($id);
        redirect('admin/contents');
    }

    public function delete() {
        $id = $this->uri->segment(4);
        $this->contents_m->delete($id);
        redirect('admin/contents');
    }

    public function multi_approve(){
        $this->contents_m->multi_approve();
        redirect('admin/contents');
    }
	
    public function multi_disapprove(){
        $this->contents_m->multi_disapprove();
        redirect('admin/contents');
    }
	
    public function multi_delete(){
        $this->contents_m->multi_delete();
        redirect('admin/contents');
    }
	
}
?>