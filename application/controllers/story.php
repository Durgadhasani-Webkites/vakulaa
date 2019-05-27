<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Story extends User_Controller{

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

        $this->template('story',$data);
    }
   
}