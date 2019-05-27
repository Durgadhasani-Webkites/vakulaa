<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Contact_details extends Admin_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model('admin/contact_details_m');
            $privileges=explode(",", $this->session->userdata('privileges'));
            if(!in_array(33, $privileges)) {
            redirect('admin/index/logout');
            }
        }

        public function index(){
            $view['admin_results']=$this->contact_details_m->view();
            $this->template('admin/contact_details/view',$view);
        }

        public function add(){
            $country['results']=$this->contact_details_m->get_country();
            $this->template('admin/contact_details/add_contact',$country);
        }
        
        public function add_process(){
           if($this->contact_details_m->add_process()){
           $this->session->set_flashdata('notify_success', "Record inserted successfully!");
            } else {
            $this->session->set_flashdata('notify_error', "There is problem to insert record!");
            }
            redirect('admin/contact_details');
        }

        public function edit() {
            $id = $this->uri->segment(4);
            $data['results']=$this->contact_details_m->get_country();
            $data['contact_details']=$this->contact_details_m->editview($id);
            $this->template('admin/contact_details/edit', $data);
        }

        public function process_edit() {
           $result=$this->contact_details_m->process_edit($_POST);
           if($result){
              $this->session->set_flashdata('notify_success', "Updated Successfully successfully!");
           }else {
            $this->session->set_flashdata('notify_error', "There is problem to Update record!");
            }
            redirect('admin/contact_details');
        }

        public function delete() {
            $id = $this->uri->segment(4);
            $getresult=$this->contact_details_m->delete($id);
            if($getresult) {
                $this->session->set_flashdata('notify_success', "Successfully removed!");
            } else {
                $this->session->set_flashdata('notify_error', "Problem while deleting!");
            }
        redirect('admin/contact_details');
    }
    }
