<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clients extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('admin/blog_m');

        $privileges=explode(",", $this->session->userdata('privileges'));
        if(!in_array(9, $privileges)) {
            redirect('admin/index/logout');
        }
		
	} 

	public function index() {
		$data['admin_results']=$this->blog_m->get_all();
		$this->template('admin/blog/view',$data);
	}

	public function add() {
		$this->template('admin/blog/add');
	}
	
	public function process_add()
    {
        if (isset($_FILES['blog_image']) && !empty($_FILES['blog_image']['name'])) {
            if($this->upload_blog()) {
                $getresult = $this->blog_m->add($_POST);
                if($getresult) {
                    $this->session->set_flashdata('notify_success', "Successfully added!");
                } else {
                    $this->session->set_flashdata('notify_error', "Problem while inserting!");
                }
            } else{
                $this->session->set_flashdata('notify_error', "Problem while inserting blog!");
            }
        } else{
            $this->session->set_flashdata('notify_error', "Please upload blog image");
        }
        redirect('admin/blog');
    }

	
	public function edit() {
		$id = $this->uri->segment(4);
		$data['admin_result']=$this->blog_m->editview($id);
		$this->template('admin/blog/edit', $data);
	}
	
	public function process_edit() {
        if (isset($_FILES['blog_image']) && !empty($_FILES['blog_image']['name'])) {
            if(!$this->upload_blog()) {
                $this->session->set_flashdata('notify_error', "Problem while inserting blog!");
                redirect('admin/blog');
            }
        }
        $getresult=$this->blog_m->edit($_POST);

        if($getresult) {
            $this->session->set_flashdata('notify_success', "Successfully updated!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while updating details!");
        }
        redirect('admin/blog');

	}
    public function upload_blog(){

            $upload_path   = 'images/upload/';
            if(!file_exists($upload_path)){
                mkdir($upload_path);
            }
            $upload_path  .= 'blogs/';
            if(!file_exists($upload_path)){
                mkdir($upload_path);
            }

            if(isset($_POST['blog_id'])){
                $results=$this->blog_m->get($_POST['blog_id']);
                $image_path =realpath('images/upload/blogs'). '/'.$results['image'];
                if(file_exists($image_path)){
                    unlink($image_path);
                }
            }

            $path=$_FILES['blog_image']['name'];
            $base_name = pathinfo($path, PATHINFO_FILENAME);
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $file_name=$base_name.date('yhis').'.'.$ext;

            //---------------------
            $config['image_library'] = 'gd2';
            $config['source_image'] = $_FILES['blog_image']['tmp_name'];
            $config['new_image'] = $upload_path.$file_name;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 906;
            $config['height'] = 325;
            $config['master_dim'] = 'height';
            $this->load->library('image_lib', $config);
            $this->image_lib->initialize($config);
            if($this->image_lib->resize()){
                $_POST['blog_image'] = $file_name;
                $this->image_lib->clear();
                return true;
            }
            return false;

    }

	public function delete() {
	
		$id = $this->uri->segment(4);
		$getresult=$this->blog_m->delete($id);

        if($getresult) {
            $this->session->set_flashdata('notify_success', "Successfully removed!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while deleting details!");
        }
        redirect('admin/blog');

	}
	
	public function deactivate() {
	
		$id = $this->uri->segment(4);
		$getresult=$this->blog_m->deactivate($id);

        if($getresult) {
            $this->session->set_flashdata('notify_success', "Successfully deactivated!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while deactivate!");
        }
        redirect('admin/blog');
		
	}
	
	public function activate() {
	
		$id = $this->uri->segment(4);
		$getresult=$this->blog_m->activate($id);

        if($getresult) {
            $this->session->set_flashdata('notify_success', "Successfully activated!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while activate!");
        }
        redirect('admin/blog');
	}
	
}
?>