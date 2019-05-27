<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attributes extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('admin/attributes_m');

		$privileges=explode(",", $this->session->userdata('privileges'));
		if(!in_array(9, $privileges)) {
			redirect('admin/index/logout');
		}
	}
	
	public function index() {
		$data['admin_results']=$this->attributes_m->view();
		$this->template('admin/attributes/view',$data);
	}
	
	public function add() {
		$this->template('admin/attributes/add');
	}
	
	public function process_add() {

		$this->form_validation->set_rules('attribute_group_name','group name','required|trim|xss_clean');
		if($this->form_validation->run() == FALSE) {
			$this->template('admin/attributes/add');
		} else {
			$this->addsuccess($_POST);
		}
		
	}
	
	public function addsuccess($postdetails) {
	
		$getresult=$this->attributes_m->add($postdetails);
			
		if($getresult) {
			$this->session->set_flashdata('notify_success', "Successfully added!");
		} else {
			$this->session->set_flashdata('notify_error', "Problem while inserting!");
		}
        redirect('admin/attributes');
	}

	public function edit() {
		$id = $this->uri->segment(4);
		$data['filter_group']=$this->attributes_m->editview($id);
		$data['filter_option']=$this->attributes_m->filtereditview($id);
		$this->template('admin/attributes/edit', $data);
	}
	
	public function process_edit() {

		$id=$this->input->post('group_id');
		$this->form_validation->set_rules('attribute_group_name','group name','required|trim|xss_clean');
	
		if($this->form_validation->run() == FALSE) {
			$data['filter_group']=$this->attributes_m->editview($id);
			$data['filter_option']=$this->attributes_m->filtereditview($id);
			$this->template('admin/attributes/edit', $data);
		} else {
			$this->editsuccess($_POST);
		}
		
	}
	
	public function editsuccess($postdetails) {
	
		$getresult=$this->attributes_m->edit($postdetails);
			
		if($getresult) {
            $this->session->set_flashdata('notify_success',"Successfully updated!");
		} else {
			$this->session->set_flashdata('notify_error', "Problem while updating!");
		}
        redirect('admin/attributes');
	}
	
	//-------------------
	
	public function delete() {
	
		$id = $this->uri->segment(4);
		$getresult=$this->attributes_m->delete($id);
			
		if($getresult) {
			$this->session->set_flashdata('notify_success', "Successfully removed!");
		} else {
			$this->session->set_flashdata('notify_error', "Problem while deleting!");
		}
        redirect('admin/attributes');
	}
	
	public function deactivate() {
	
		$id = $this->uri->segment(4);
		$getresult=$this->attributes_m->deactivate($id);
			
		if($getresult) {
			$this->session->set_flashdata('notify_success', "Successfully deactivated!");
		} else {
			$this->session->set_flashdata('notify_error', "Problem while deactivate!");
		}
        redirect('admin/attributes');
	}
	
	public function activate() {
	
		$id = $this->uri->segment(4);
		$getresult=$this->attributes_m->activate($id);

		if($getresult) {
			$this->session->set_flashdata('notify_success', "Successfully activated!");
		} else {
			$this->session->set_flashdata('notify_error', "Problem while activate!");
		}
        redirect('admin/attributes');
	}
	
	//-------------------
	
	public function remove_attribute($id) {
		$group_id=$this->attributes_m->remove_attribute($id);
		if($group_id) {
            $this->session->set_flashdata('notify_success', "Successfully deleted!");
		} else {
            $this->session->set_flashdata('notify_error', "Problem while deleting!");
		}
        redirect('admin/attributes/edit/'.$group_id);
	}
	
}
?>