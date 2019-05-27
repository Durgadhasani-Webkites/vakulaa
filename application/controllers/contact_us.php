<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Contact_us extends User_Controller{


    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->load->model('admin/settings_m');
        $data['contact_address'] = $this->settings_m->get_contact_address();
        $data['position_details'] = $this->settings_m->get_position_details();
         $this->load->model('admin/settings_m');
        $data['country'] = $this->settings_m->get_country();
        $data['contact_details'] = $this->settings_m->get_contact_details();

        $data['meta_title']='Contact Us | vakulaa.com';
        $data['meta_description']='';
        $data['meta_keywords']='';

        $this->template('contact_us',$data);
    }

    public function get_details(){
        $this->load->model('admin/settings_m');
        $result = $this->settings_m->get_details($this->input->post('country'));
        if($result){
         echo json_encode($result);
        } else {
           return TRUE;
        }
    }
}