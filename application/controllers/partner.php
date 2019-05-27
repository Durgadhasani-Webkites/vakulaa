<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Partner extends User_Controller{


    public function __construct(){

        parent::__construct();

    }


    public function index(){
        $this->load->model('admin/settings_m');
        $data = array();
        $data['supermarket_results'] = $this->settings_m->get_supermarket_results();

        $data['meta_title']='Contact Us | vakullaa.com';
        $data['meta_description']='';
        $data['meta_keywords']='';

        $this->template('partner',$data);
    }


    public function process(){
        $this->upload_file();
        $this->load->model('contact_us_m');

        $this->contact_us_m->add($_POST);

        redirect('contact-us');

    }

    public function upload_file(){
        if(!empty($_FILES['user_file']) && !empty($_FILES['user_file']['name'])) {
            $upload_path = 'images/upload/';
            if (!file_exists($upload_path)) {
                mkdir($upload_path);
            }
            $upload_path .= 'files/';
            if (!file_exists($upload_path)) {
                mkdir($upload_path);
            }

            $new_name = time() . $_FILES["user_file"]['name'];
            $config['file_name'] = $new_name;
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = '*';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('user_file')) {
                $upload_data = $this->upload->data();
                $_POST['user_file'] =$upload_data['file_name'];
                return true;
            }
        }
        return false;
    }

}