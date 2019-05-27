<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fixed_Banner extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('admin/fixed_banner_m');

        $privileges=explode(",", $this->session->userdata('privileges'));
        if(!in_array(9, $privileges)) {
            redirect('admin/index/logout');
        }
		
	} 

	public function index() {
		$data['admin_results']=$this->fixed_banner_m->get_all();
		$this->template('admin/fixed_banner/view',$data);
	}

	public function add() {
		$this->template('admin/fixed_banner/add');
	}
	
	public function process_add()
    {
        if (isset($_FILES['banner_image']) && !empty($_FILES['banner_image']['name'])) {
            if($this->upload_banner()) {
                $getresult = $this->fixed_banner_m->add($_POST);
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
        redirect('admin/fixed_banner');
    }

	
	public function edit() {
		$id = $this->uri->segment(4);
		$data['admin_result']=$this->fixed_banner_m->editview($id);
		$this->template('admin/fixed_banner/edit', $data);
	}
	
	public function process_edit() {
        if (isset($_FILES['banner_image']) && !empty($_FILES['banner_image']['name'])) {
            if(!$this->upload_banner()) {
                $this->session->set_flashdata('notify_error', "Problem while inserting banner!");
                redirect('admin/fixed_banner');
            }
        }
        $getresult=$this->fixed_banner_m->edit($_POST);

        if($getresult) {
            $this->session->set_flashdata('notify_success', "Successfully updated!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while updating details!");
        }
        redirect('admin/fixed_banner');

	}
    public function upload_banner(){

            $upload_path   = 'images/upload/';
            if(!file_exists($upload_path)){
                mkdir($upload_path);
            }
            $upload_path  .= 'fixed_banner/';
            if(!file_exists($upload_path)){
                mkdir($upload_path);
            }

            if(isset($_POST['ban_id'])){
                $results=$this->fixed_banner_m->get($_POST['ban_id']);
                $image_path =realpath('images/upload/fixed_banner'). '/'.$results['image'];
                if(file_exists($image_path)){
                    unlink($image_path);
                }
            }

        $new_name = time().$_FILES["banner_image"]['name'];
        $config1['file_name'] = $new_name;
        $config1['upload_path'] = $upload_path;
        $config1['allowed_types'] = 'gif|jpg|png|jpeg';
        $this->load->library('upload', $config1);
        $this->upload->initialize($config1);
        if ($this->upload->do_upload('banner_image')) {
            $upload_data = $this->upload->data();
            $_POST['banner_image'] = $upload_data['file_name'];
            return true;
        }

        return false;

    }

	public function delete() {
	
		$id = $this->uri->segment(4);
		$getresult=$this->fixed_banner_m->delete($id);

        if($getresult) {
            $this->session->set_flashdata('notify_success', "Successfully removed!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while deleting details!");
        }
        redirect('admin/fixed_banner');

	}
	
	public function deactivate() {
	
		$id = $this->uri->segment(4);
		$getresult=$this->fixed_banner_m->deactivate($id);

        if($getresult) {
            $this->session->set_flashdata('notify_success', "Successfully deactivated!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while deactivate!");
        }
        redirect('admin/fixed_banner');
		
	}
	
	public function activate() {
	
		$id = $this->uri->segment(4);
		$getresult=$this->fixed_banner_m->activate($id);

        if($getresult) {
            $this->session->set_flashdata('notify_success', "Successfully activated!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while activate!");
        }
        redirect('admin/fixed_banner');
	}
	
}
?>