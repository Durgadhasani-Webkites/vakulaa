<?php
Class MY_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('custom');
    }

    public function notify_success($msg) {
        $this->session->set_flashdata('notify_success', $msg);
    }
	
    public function notify_error($msg) {
        $this->session->set_flashdata('notify_error', $msg);
    }
}
?>