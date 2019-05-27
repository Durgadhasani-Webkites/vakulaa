<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Options extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('admin/options_m');

		$privileges=explode(",", $this->session->userdata('privileges'));
		if(!in_array(8, $privileges)) {
			redirect('admin/index/logout');
		}

	}

	public function index() {
		$data['admin_results']=$this->options_m->view();
		$this->template('admin/options/view',$data);
	}

	public function add() {
		$this->template('admin/options/add');
	}

	public function process_add() {

		$this->form_validation->set_rules('option_name','option name','required|trim|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->template('admin/options/add');
		} else {
			$this->addsuccess($_POST);
		}

	}

	public function addsuccess($postdetails) {

		$getresult=$this->options_m->add($postdetails);

		if($getresult) {
			$this->session->set_flashdata('notify_success', "Successfully added!");
		} else {
			$this->session->set_flashdata('notify_error', "Problem while inserting!");
		}
        redirect('admin/options');

	}

	public function edit() {
		$id = $this->uri->segment(4);
		$data['filter_group']=$this->options_m->editview($id);
		$data['filter_option']=$this->options_m->filtereditview($id);

		$this->template('admin/options/edit', $data);
	}

	public function process_edit() {

		$id=$this->input->post('group_id');

		$this->form_validation->set_rules('option_name','option name','required|trim|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$data['filter_group']=$this->options_m->editview($id);
			$data['filter_option']=$this->options_m->filtereditview($id);
			$this->template('admin/options/edit', $data);
		} else {
			$this->editsuccess($_POST);
		}

	}

	public function editsuccess($postdetails) {

		$getresult=$this->options_m->edit($postdetails);

		if($getresult) {
			$this->session->set_flashdata('notify_success', "Successfully updated!");
		} else {
			$this->session->set_flashdata('notify_error', "Problem while updating!");
		}
        redirect('admin/options');
	}

	//-------------------

	public function delete() {

		$id = $this->uri->segment(4);
		$getresult=$this->options_m->delete($id);

		if($getresult) {
			$this->session->set_flashdata('notify_success', "Successfully removed!");

		} else {
			$this->session->set_flashdata('notify_error', "Problem while deleting!");
		}
        redirect('admin/options');
	}

	public function deactivate() {

		$id = $this->uri->segment(4);
		$getresult=$this->options_m->deactivate($id);

		if($getresult) {
			$this->session->set_flashdata('notify_success', "Successfully deactivated!");
		} else {
			$this->session->set_flashdata('notify_error', "Problem while deactivate!");
		}
        redirect('admin/options');
	}

	public function activate() {

		$id = $this->uri->segment(4);
		$getresult=$this->options_m->activate($id);

		if($getresult) {
			$this->session->set_flashdata('notify_success', "Successfully activated!");
		} else {
			$this->session->set_flashdata('notify_error', "Problem while activate!");
		}
        redirect('admin/options');
	}

	//-------------------

	public function remove_option($id) {

        $group_id=$this->options_m->remove_option($id);
        if($group_id) {
            $this->session->set_flashdata('notify_success', "Successfully deleted!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while deleting!");
        }
        redirect('admin/options/edit/'.$group_id);

	}

}
?>