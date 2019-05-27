        <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

        class Country extends Admin_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('admin/country_m');

            $privileges=explode(",", $this->session->userdata('privileges'));
            if(!in_array(33, $privileges)) {
                redirect('admin/index/logout');
            }
            } 

        public function index(){
            $data['admin_results']=$this->country_m->view();
            $this->template('admin/country/view',$data);
        }

         public function add_country(){
            $this->template('admin/country/add_country');
        }

        public function process_add(){
            $query=$this->country_m->process_add($_POST);
            if($query) {
            $this->session->set_flashdata('notify_success', "Record inserted successfully!");
            } else {
            $this->session->set_flashdata('notify_error', "There is problem to insert record!");
            }
            redirect('admin/country');
        }

        public function edit() {
            $id = $this->uri->segment(4);
            $data['country']=$this->country_m->editview($id);

            $this->template('admin/country/edit', $data);
        }

        public function process_edit() {
           $result=$this->country_m->process_edit($_POST);
           if($result){
              $this->session->set_flashdata('notify_success', "Updated Successfully successfully!");
           }else {
            $this->session->set_flashdata('notify_error', "There is problem to Update record!");
            }
            redirect('admin/country');
        }

        public function delete() {
            $id = $this->uri->segment(4);
            $getresult=$this->country_m->delete($id);
    
            if($getresult) {
                $this->session->set_flashdata('notify_success', "Successfully removed!");
    
            } else {
                $this->session->set_flashdata('notify_error', "Problem while deleting!");
            }
        redirect('admin/country');
    }
    }
