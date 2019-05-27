<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Filters extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('admin/filters_m');

		$privileges=explode(",", $this->session->userdata('privileges'));
		if(!in_array(11, $privileges)) {
			redirect('admin/index/logout');
		}
		
	}
	
	public function index() {
		$data['admin_results']=$this->filters_m->view();
		$this->template('admin/filters/view',$data);
	}

	public function add() {
		$this->template('admin/filters/add');
	}
	
	public function process_add() {

        $getresult=$this->filters_m->add($_POST);

        if($getresult) {
            $this->session->set_flashdata('notify_success', "Successfully added!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while inserting!");

        }
        redirect('admin/filters');
		
	}

	public function edit($id) {
		$id = $this->uri->segment(4);
		$data['filter_group']=$this->filters_m->editview($id);
		$data['filter_option']=$this->filters_m->filtereditview($id);
		$this->template('admin/filters/edit', $data);
	}
	
	public function process_edit() {

        $getresult=$this->filters_m->edit($_POST);

        if($getresult) {
            $this->session->set_flashdata('notify_success', "Successfully updated!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while updating!");
        }
        redirect('admin/filters');
		
	}
	public function editsuccess($postdetails) {
	

	}
	public function delete() {
	
		$id = $this->uri->segment(4);
		$getresult=$this->filters_m->delete($id);
			
		if($getresult) {
			$this->session->set_flashdata('notify_success', "Successfully removed!");
		} else {
			$this->session->set_flashdata('notify_error', "Problem while deleting!");
		}
        redirect('admin/filters');
	}
	public function deactivate() {
	
		$id = $this->uri->segment(4);
		$getresult=$this->filters_m->deactivate($id);
			
		if($getresult) {
            $this->session->set_flashdata('notify_success', "Successfully deactivated!");
		} else {
			$this->session->set_flashdata('notify_error', "Problem while deactivate!");
		}
        redirect('admin/filters');
	}
	
	public function activate() {
	
		$id = $this->uri->segment(4);
		$getresult=$this->filters_m->activate($id);
			
		if($getresult) {
			$this->session->set_flashdata('notify_success', "Successfully activated!");
		} else {
			$this->session->set_flashdata('notify_error', "Problem while activate!");
		}
        redirect('admin/filters');
		
	}

	public function remove_filter($id) {
		$filter_group_id=$this->filters_m->remove_filter($id);
		if($filter_group_id) {
            $this->session->set_flashdata('notify_success', "Successfully deleted!");
		} else {
            $this->session->set_flashdata('notify_error', "Problem while deleting!");
		}
        redirect('admin/filters/edit/'.$filter_group_id);
	}
	
}
?>