<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->model('admin/categories_m');
		$this->load->library('form_validation');

		$privileges=explode(",", $this->session->userdata('privileges'));
		if(!in_array(5, $privileges)) {
			redirect('admin/index/logout');
		}
		
	} 

	public function index() {
		$data['admin_results']=$this->categories_m->view(0, 0);
		$this->template('admin/categories/view',$data);
	}

	public function add() {
		$data['category_view']=$this->categories_m->categoryview(0, 0);
        $data['filter_view']=$this->categories_m->filterview();
		$this->template('admin/categories/add',$data);
	}
	
	public function process_add() {
		$this->category_image();
		$this->category_image_other();

        $result=$this->categories_m->add();
        if($result) {
            $this->session->set_flashdata('notify_success', "Successfully added!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while inserting!");
        }
        redirect('admin/categories');
	}


	public function edit() {
		$id = $this->uri->segment(4);
		$data['category_view']=$this->categories_m->categoryview(0, 0);
		$data['admin_results']=$this->categories_m->get($id);

        $data['filter_view']=$this->categories_m->filterview();
        $data['filters_for_category']=$this->categories_m->get_filters_for_category($id);
		$this->template('admin/categories/edit', $data);
	}
	
	public function process_edit() {
		$this->category_image();
		$this->category_image_other();
		
        $result=$this->categories_m->update();

        if($result) {
            $this->session->set_flashdata('notify_success', "Successfully updated!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while updating!");
        }
        redirect('admin/categories');
	}

	public function category_image() {

        if (isset($_FILES['category_image']) && !empty($_FILES['category_image']['name'])) {

            $upload_path   = 'images/category/';
            if(!file_exists($upload_path)){
                mkdir($upload_path);
            }

            $new_name = time().$_FILES["category_image"]['name'];
            $config1['file_name'] = $new_name;
            $config1['upload_path'] = $upload_path;
            $config1['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config1);
            $this->upload->initialize($config1);
            if ($this->upload->do_upload('category_image')) {
                $upload_data = $this->upload->data();
                $_POST['category_image'] = $upload_data['file_name'];
            }
        }
    }

    public function category_image_other() {

        if (isset($_FILES['category_image_other']) && !empty($_FILES['category_image_other']['name'])) {

            $upload_path   = 'images/category/';
            if(!file_exists($upload_path)){
                mkdir($upload_path);
            }

            $new_name = time().$_FILES["category_image_other"]['name'];
            $config1['file_name'] = $new_name;
            $config1['upload_path'] = $upload_path;
            $config1['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config1);
            $this->upload->initialize($config1);
            if ($this->upload->do_upload('category_image_other')) {
                $upload_data = $this->upload->data();
                $_POST['category_image_other'] = $upload_data['file_name'];
            }
        }
    }


	public function delete($id) {
        $result=$this->categories_m->delete($id);
			
		if($result) {
			$this->session->set_flashdata('notify_success', "Successfully removed!");
		} else {
			$this->session->set_flashdata('notify_error', "Problem while deleting!");
		}
        redirect('admin/categories');
		
	}
	
	public function deactivate($id) {
        $result=$this->categories_m->deactivate($id);
			
		if($result) {
			$this->session->set_flashdata('notify_success', "Successfully deactivated!");
		} else {
			$this->session->set_flashdata('notify_error', "Problem while deactivate!");
		}
        redirect('admin/categories');
		
	}
	
	public function activate($id) {

        $result=$this->categories_m->activate($id);
			
		if($result) {
			$this->session->set_flashdata('notify_success', "Successfully activated!");
		} else {
			$this->session->set_flashdata('notify_error', "Problem while activate!");
		}
        redirect('admin/categories');
		
	}
	
}
?>