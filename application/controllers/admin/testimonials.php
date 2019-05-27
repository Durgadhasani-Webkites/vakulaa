<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Testimonials extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/testimonials_m');
        $privileges=explode(",", $this->session->userdata('privileges'));
        if(!in_array(6, $privileges)) {
            redirect('admin/index/logout');
        }
    }
	
    public function index() {
        $data['admin_results']=$this->testimonials_m->get_all();
        $this->template("admin/testimonials/view",$data);
    }

    public function add() {
        $this->template("admin/testimonials/add");
    }
	
    public function process_add() {
		$this->testimonial_image();
        $this->testimonials_m->add($_POST);
        redirect('admin/testimonials');
    }
	
	public function testimonial_image() {
        if(isset($_FILES['testimonial_image']) && !empty($_FILES['testimonial_image']['name'])) {
            $upload_path   = 'images/upload/';
            if(!file_exists($upload_path)){
                mkdir($upload_path);
            }
            $upload_path  .= 'testimonial_images/';
            if(!file_exists($upload_path)){
                mkdir($upload_path);
            }

            $path=$_FILES['testimonial_image']['name'];
            $base_name = pathinfo($path, PATHINFO_FILENAME);
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $file_name=$base_name.'_thumb.'.$ext;

            //---------------------
            $config['image_library'] = 'gd2';
            $config['source_image'] = $_FILES['testimonial_image']['tmp_name'];
            $config['new_image'] = $upload_path.$file_name;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 200;
            $config['height'] = 200;
            $config['master_dim'] = 'width';
            $this->load->library('image_lib', $config);
            $this->image_lib->initialize($config);
            if($this->image_lib->resize()){
                $_POST['testimonial_image'] = $file_name;
            }
            $this->image_lib->clear();

            return false;
        }
        return false;
    }

    public function edit($id) {
        $data=$this->testimonials_m->get($id);
        $this->template("admin/testimonials/edit",$data);
    }

    public function process_edit() {
		$this->testimonial_image();
        $this->testimonials_m->update($_POST);
        Redirect('admin/testimonials');
    }

    public function process_action() {
        if($_POST['action']=='approve'){
            $this->multi_approve();
        }
        if($_POST['action']=='disapprove'){
            $this->multi_disapprove();
        }
        if($_POST['action']=='delete'){
            $this->multi_delete();
        }
    }

    public function approve() {
        $id = $this->uri->segment(4);
        $this->testimonials_m->approve($id);
        redirect('admin/testimonials');
    }

    public function disapprove() {
        $id = $this->uri->segment(4);
        $this->testimonials_m->disapprove($id);
        redirect('admin/testimonials');
    }

    public function delete() {
        $id = $this->uri->segment(4);
        $this->testimonials_m->delete($id);
        redirect('admin/testimonials');
    }

    public function multi_approve() {
        $this->testimonials_m->multi_approve();
        redirect('admin/testimonials');
    }
	
    public function multi_disapprove() {
        $this->testimonials_m->multi_disapprove();
        redirect('admin/testimonials');
    }
	
    public function multi_delete() {

        $this->testimonials_m->multi_delete();
        redirect('admin/testimonials');
    }

}
?>