<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tax_Settings extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/tax_settings_m');
        $privileges=explode(",", $this->session->userdata('privileges'));
        if(!in_array(3, $privileges)) {
            redirect('admin/index/logout');
        }
    }

    public function index() {
        $data['admin_results']=$this->tax_settings_m->get_all();
        $this->template('admin/tax_settings/view',$data);
    }

    public function add() {
        $this->template("admin/tax_settings/add");
    }

    public function process_add() {
        $this->tax_settings_m->add($_POST);
        redirect('admin/tax_settings');
    }

    public function edit($id) {
        $data['admin_results']=$this->tax_settings_m->get($id);
        $this->template("admin/tax_settings/edit",$data);
    }

    public function process_edit() {
        $this->tax_settings_m->update($_POST);
        Redirect('admin/tax_settings');
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
        $this->tax_settings_m->approve($id);
        redirect('admin/tax_settings');
    }

    public function disapprove() {
        $id = $this->uri->segment(4);
        $this->tax_settings_m->disapprove($id);
        redirect('admin/tax_settings');
    }

    public function delete() {
        $id = $this->uri->segment(4);
        $this->tax_settings_m->delete($id);
        redirect('admin/tax_settings');
    }

    public function multi_approve() {
        $this->tax_settings_m->multi_approve();
        redirect('admin/tax_settings');
    }

    public function multi_disapprove() {
        $this->tax_settings_m->multi_disapprove();
        redirect('admin/tax_settings');
    }

    public function multi_delete() {

        $this->tax_settings_m->multi_delete();
        redirect('admin/tax_settings');
    }


}
?>