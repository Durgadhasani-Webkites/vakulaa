<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock_Search extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $privileges=explode(",", $this->session->userdata('privileges'));
        if(!in_array(21, $privileges)) {
            redirect('admin/index/logout');
        }
    }

    public function index() {
        $this->template('admin/stock_search/view');
    }

}
?>