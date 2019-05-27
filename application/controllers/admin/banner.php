<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banner extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('admin/banner_m');

        $privileges=explode(",", $this->session->userdata('privileges'));
        if(!in_array(9, $privileges)) {
            redirect('admin/index/logout');
        }
		
	} 

	public function index() {
		$data['admin_results']=$this->banner_m->get_all();
		$this->template('admin/banner/view',$data);
	}

	public function add() {
		$this->template('admin/banner/add');
	}
	
	public function process_add()
    {
        if (isset($_FILES['banner_image']) && !empty($_FILES['banner_image']['name'])) {
            if($this->upload_banner()) {
                $getresult = $this->banner_m->add($_POST);
                if($getresult) {
                    $this->session->set_flashdata('notify_success', "Successfully added!");
                } else {
                    $this->session->set_flashdata('notify_error', "Problem while inserting!");
                }
            } else{
                $this->session->set_flashdata('notify_error', "Problem while inserting banner!");
            }
        } else{
            $this->session->set_flashdata('notify_error', "Please upload banner image");
        }
        redirect('admin/banner');
    }

	
	public function edit() {
		$id = $this->uri->segment(4);
		$data['admin_result']=$this->banner_m->editview($id);
		$this->template('admin/banner/edit', $data);
	}
	
	public function process_edit() {
        if (isset($_FILES['banner_image']) && !empty($_FILES['banner_image']['name'])) {
            if(!$this->upload_banner()) {
                $this->session->set_flashdata('notify_error', "Problem while inserting banner!");
                redirect('admin/banner');
            }
        }
        $getresult=$this->banner_m->edit($_POST);

        if($getresult) {
            $this->session->set_flashdata('notify_success', "Successfully updated!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while updating details!");
        }
        redirect('admin/banner');

	}
    public function upload_banner(){

            $upload_path   = 'images/upload/';
            if(!file_exists($upload_path)){
                mkdir($upload_path);
            }
            $upload_path  .= 'banners/';
            if(!file_exists($upload_path)){
                mkdir($upload_path);
            }

            if(isset($_POST['ban_id'])){
                $results=$this->banner_m->get($_POST['ban_id']);
                $image_path =realpath('images/upload/banners'). '/'.$results['image'];
                if(file_exists($image_path)){
                    unlink($image_path);
                }
            }

            $path=$_FILES['banner_image']['name'];
            $base_name = pathinfo($path, PATHINFO_FILENAME);
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $file_name=$base_name.date('yhis').'.'.$ext;

            //---------------------
            $config['image_library'] = 'gd2';
            $config['source_image'] = $_FILES['banner_image']['tmp_name'];
            $config['new_image'] = $upload_path.$file_name;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 906;
            $config['height'] = 325;
            $config['master_dim'] = 'height';
            $this->load->library('image_lib', $config);
            $this->image_lib->initialize($config);
            if($this->image_lib->resize()){
                $_POST['banner_image'] = $file_name;
                $this->image_lib->clear();
                return true;
            }
            return false;

    }

	public function delete() {
	
		$id = $this->uri->segment(4);
		$getresult=$this->banner_m->delete($id);

        if($getresult) {
            $this->session->set_flashdata('notify_success', "Successfully removed!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while deleting details!");
        }
        redirect('admin/banner');

	}
	
	public function deactivate() {
	
		$id = $this->uri->segment(4);
		$getresult=$this->banner_m->deactivate($id);

        if($getresult) {
            $this->session->set_flashdata('notify_success', "Successfully deactivated!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while deactivate!");
        }
        redirect('admin/banner');
		
	}
	
	public function activate() {
	
		$id = $this->uri->segment(4);
		$getresult=$this->banner_m->activate($id);

        if($getresult) {
            $this->session->set_flashdata('notify_success', "Successfully activated!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while activate!");
        }
        redirect('admin/banner');
	}
	
}
?>