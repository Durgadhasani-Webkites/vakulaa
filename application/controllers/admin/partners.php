<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Partners extends Admin_Controller {

	public function __construct() {
		parent::__construct();
	   $this->load->model('admin/partners_m');

		$privileges=explode(",", $this->session->userdata('privileges'));
		if(!in_array(32, $privileges)) {
			redirect('admin/index/logout');
		}
		
	}
	public function index(){
		$data['admin_results']=$this->partners_m->contact_view();
		$this->template('admin/partners/contact_view',$data);
	}
	public function overseas(){
		$data['admin_results']=$this->partners_m->overseas();
		$this->template('admin/partners/overseas_view',$data);
	}

	public function contact_readmore(){
		$data['admin_results']=$this->partners_m->contact_readmore($this->uri->segment(4));
		$this->template('admin/partners/contact_readmore',$data);
	}

	public function overseas_readmore(){
		$data['admin_results']=$this->partners_m->overseas_readmore($this->uri->segment(4));
		$this->template('admin/partners/overseas_readmore',$data);
	}

	public function contact_delete() {
		$id = $this->uri->segment(4);
		$results=$this->partners_m->contact_delete($id);
		if($results){
           $this->session->set_flashdata('notify_success',"Record Deleted Successfully!");
       } else{
           $this->session->set_flashdata('notify_error',"There is a problem to delete record!");
       }
       Redirect('admin/partners');
	}

	public function overseas_delete() {
		$id = $this->uri->segment(4);
		$results=$this->partners_m->overseas_delete($id);
		if($results){
           $this->session->set_flashdata('notify_success',"Record Deleted Successfully!");
       } else{
           $this->session->set_flashdata('notify_error',"There is a problem to delete record!");
       }
       Redirect('admin/partners/overseas');
	   }

}