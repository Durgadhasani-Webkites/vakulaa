<?php
Class MY_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('custom');
		date_default_timezone_set('Asia/Kolkata');
		session_start();
    }
	
}
?>