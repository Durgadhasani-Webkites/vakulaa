<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/settings_m');
        $privileges=explode(",", $this->session->userdata('privileges'));
        if(!in_array(3, $privileges)) {
            redirect('admin/index/logout');
        }
    }

    public function index() {
        $data['admin_results']=$this->settings_m->get();
        $data['supermarket_results']=$this->settings_m->get_supermarket_results();
        $data['home_page_products']=$this->settings_m->get_home_page_products();
        $data['how_to_prepare']=$this->settings_m->get_how_to_prepare();
        $data['contact_address']=$this->settings_m->get_contact_address();
        $data['position_details']=$this->settings_m->get_position_details();
        $this->template('admin/settings/view',$data);
    }

    public function process_settings() {
        $getresult=$this->settings_m->edit($_POST);
        if($getresult) {
            $this->session->set_flashdata('notify_success', "Successfully updated!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while updating!");
        }
        redirect('admin/settings');
    }

    public function process_supermarket_addr(){
        $getresult=$this->settings_m->edit_supermarket_addr($_POST);
        if($getresult) {
            $this->session->set_flashdata('notify_success', "Successfully updated!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while updating!");
        }
        redirect('admin/settings');
    }

     public function process_home_product_add() {
        $this->image1();
        $this->image2();
        $this->image3();
        $this->image4();
        $getresult=$this->settings_m->edit_home_page_products($_POST);
        if($getresult) {
            $this->session->set_flashdata('notify_success', "Successfully updated!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while updating!");
        }
        redirect('admin/settings');
    }

    public function image1() {

        if (isset($_FILES['image1']) && !empty($_FILES['image1']['name'])) {
            if(isset($_POST['image1_name'])){
                 $data = array(
                   'image1'=>$this->input->post('image1_name'),
                );
                $results=$this->settings_m->get_image($data);
                $image_path =realpath('images/home_page_products'). '/'.$results['image1'];
                if(file_exists($image_path)){
                    unlink($image_path);
                }
            }
            $upload_path   = 'images/home_page_products/';
            if(!file_exists($upload_path)){
                mkdir($upload_path);
            }
            $new_name = time().$_FILES["image1"]['name'];
            $config1['file_name'] = $new_name;
            $config1['upload_path'] = $upload_path;
            $config1['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config1);
            $this->upload->initialize($config1);
            if ($this->upload->do_upload('image1')) {
                $upload_data = $this->upload->data();
                $_POST['image1'] = $upload_data['file_name'];
            }
        }
    }

        public function image2() {

        if (isset($_FILES['image2']) && !empty($_FILES['image2']['name'])) {

            if(isset($_POST['image2_name'])){
                $data = array(
                   'image2'=>$this->input->post('image2_name'),
                );
                $results=$this->settings_m->get_image($data);
                $image_path =realpath('images/home_page_products'). '/'.$results['image2'];
                if(file_exists($image_path)){
                    unlink($image_path);
                }
            }
            $upload_path   = 'images/home_page_products/';
            if(!file_exists($upload_path)){
                mkdir($upload_path);
            }
            $new_name = time().$_FILES["image2"]['name'];
            $config1['file_name'] = $new_name;
            $config1['upload_path'] = $upload_path;
            $config1['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config1);
            $this->upload->initialize($config1);
            if ($this->upload->do_upload('image2')) {
                $upload_data = $this->upload->data();
                $_POST['image2'] = $upload_data['file_name'];
            }
        }
    }

     public function image3() {

        if (isset($_FILES['image3']) && !empty($_FILES['image3']['name'])) {
            if(isset($_POST['image3_name'])){
                $data = array(
                   'image3'=>$this->input->post('image3_name'),
                );
                $results=$this->settings_m->get_image($data);
                $image_path =realpath('images/home_page_products'). '/'.$results['image3'];
                if(file_exists($image_path)){
                    unlink($image_path);
                }
            }
            $upload_path   = 'images/home_page_products/';
            if(!file_exists($upload_path)){
                mkdir($upload_path);
            }
            $new_name = time().$_FILES["image3"]['name'];
            $config1['file_name'] = $new_name;
            $config1['upload_path'] = $upload_path;
            $config1['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config1);
            $this->upload->initialize($config1);
            if ($this->upload->do_upload('image3')) {
                $upload_data = $this->upload->data();
                $_POST['image3'] = $upload_data['file_name'];
            }
        }
    }

     public function image4() {

        if (isset($_FILES['image4']) && !empty($_FILES['image4']['name'])) {
             if(isset($_POST['image4_name'])){
                $data = array(
                   'image4'=>$this->input->post('image4_name'),
                );
                $results=$this->settings_m->get_image($data);
                $image_path =realpath('images/home_page_products'). '/'.$results['image4'];
                if(file_exists($image_path)){
                    unlink($image_path);
                }
            }
            $upload_path   = 'images/home_page_products/';
            if(!file_exists($upload_path)){
                mkdir($upload_path);
            }
            $new_name = time().$_FILES["image4"]['name'];
            $config1['file_name'] = $new_name;
            $config1['upload_path'] = $upload_path;
            $config1['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config1);
            $this->upload->initialize($config1);
            if ($this->upload->do_upload('image4')) {
                $upload_data = $this->upload->data();
                $_POST['image4'] = $upload_data['file_name'];
            }
        }
    }
    

     public function process_how_to_prepare_add() {
        $this->prepare_image1();
        $this->prepare_image2();
        $this->prepare_image3();
        $this->prepare_image4();
        $getresult=$this->settings_m->edit_how_to_prepare($_POST);
        if($getresult) {
            $this->session->set_flashdata('notify_success', "Successfully updated!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while updating!");
        }
        redirect('admin/settings');
    }

     public function prepare_image1() {

        if (isset($_FILES['prepare_image1']) && !empty($_FILES['prepare_image1']['name'])) {
            if(isset($_POST['prepare_image1_name'])){
                 $data = array(
                   'prepare_image1'=>$this->input->post('prepare_image1_name'),
                );
                $results=$this->settings_m->get_prepare_image($data);
                $image_path =realpath('images/how_to_prepare'). '/'.$results['prepare_image1'];
                if(file_exists($image_path)){
                    unlink($image_path);
                }
            }
            $upload_path   = 'images/how_to_prepare/';
            if(!file_exists($upload_path)){
                mkdir($upload_path);
            }
            $new_name = time().$_FILES["prepare_image1"]['name'];
            $config1['file_name'] = $new_name;
            $config1['upload_path'] = $upload_path;
            $config1['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config1);
            $this->upload->initialize($config1);
            if ($this->upload->do_upload('prepare_image1')) {
                $upload_data = $this->upload->data();
                $_POST['prepare_image1'] = $upload_data['file_name'];
            }
        }
    }

    public function prepare_image2() {

        if (isset($_FILES['prepare_image2']) && !empty($_FILES['prepare_image2']['name'])) {
            if(isset($_POST['prepare_image2_name'])){
                 $data = array(
                   'prepare_image2'=>$this->input->post('prepare_image2_name'),
                );
                $results=$this->settings_m->get_prepare_image($data);
                $image_path =realpath('images/how_to_prepare'). '/'.$results['prepare_image2'];
                if(file_exists($image_path)){
                    unlink($image_path);
                }
            }
            $upload_path   = 'images/how_to_prepare/';
            if(!file_exists($upload_path)){
                mkdir($upload_path);
            }
            $new_name = time().$_FILES["prepare_image2"]['name'];
            $config1['file_name'] = $new_name;
            $config1['upload_path'] = $upload_path;
            $config1['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config1);
            $this->upload->initialize($config1);
            if ($this->upload->do_upload('prepare_image2')) {
                $upload_data = $this->upload->data();
                $_POST['prepare_image2'] = $upload_data['file_name'];
            }
        }
    }

     public function prepare_image3() {

        if (isset($_FILES['prepare_image3']) && !empty($_FILES['prepare_image3']['name'])) {
            if(isset($_POST['prepare_image3_name'])){
                 $data = array(
                   'prepare_image3'=>$this->input->post('prepare_image3_name'),
                );
                $results=$this->settings_m->get_prepare_image($data);
                $image_path =realpath('images/how_to_prepare'). '/'.$results['prepare_image3'];
                if(file_exists($image_path)){
                    unlink($image_path);
                }
            }
            $upload_path   = 'images/how_to_prepare/';
            if(!file_exists($upload_path)){
                mkdir($upload_path);
            }
            $new_name = time().$_FILES["prepare_image3"]['name'];
            $config1['file_name'] = $new_name;
            $config1['upload_path'] = $upload_path;
            $config1['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config1);
            $this->upload->initialize($config1);
            if ($this->upload->do_upload('prepare_image3')) {
                $upload_data = $this->upload->data();
                $_POST['prepare_image3'] = $upload_data['file_name'];
            }
        }
    }

     public function prepare_image4() {

        if (isset($_FILES['prepare_image4']) && !empty($_FILES['prepare_image4']['name'])) {
            if(isset($_POST['prepare_image4_name'])){
                 $data = array(
                   'prepare_image4'=>$this->input->post('prepare_image4_name'),
                );
                $results=$this->settings_m->get_prepare_image($data);
                $image_path =realpath('images/how_to_prepare'). '/'.$results['prepare_image4'];
                if(file_exists($image_path)){
                    unlink($image_path);
                }
            }
            $upload_path   = 'images/how_to_prepare/';
            if(!file_exists($upload_path)){
                mkdir($upload_path);
            }
            $new_name = time().$_FILES["prepare_image4"]['name'];
            $config1['file_name'] = $new_name;
            $config1['upload_path'] = $upload_path;
            $config1['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config1);
            $this->upload->initialize($config1);
            if ($this->upload->do_upload('prepare_image4')) {
                $upload_data = $this->upload->data();
                $_POST['prepare_image4'] = $upload_data['file_name'];
            }
        }
    }

     public function process_contact_address(){
        $getresult=$this->settings_m->edit_contact_address($_POST);
        if($getresult) {
            $this->session->set_flashdata('notify_success', "Successfully updated!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while updating!");
        }
        redirect('admin/settings');
    }

     public function process_position(){
        $getresult=$this->settings_m->edit_position_details($_POST);
        if($getresult) {
            $this->session->set_flashdata('notify_success', "Successfully updated!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while updating!");
        }
        redirect('admin/settings');
    }


}
?>