<?php
class User_Controller extends MY_Controller {

    function __construct() {
        parent::__construct();
        ini_set('display_errors', 1);
        ini_set('allow_url_fopen', 1);
        $this->config->load('facebook');
        $this->config->load('googleplus');
    }

    function google_AuthUrl(){
        if (!$this->session->userdata('log_details')['id']) {
            require_once APPPATH . 'libraries/Google/autoload.php';

            $client = new Google_Client();
            $client->setClientId($this->config->item('client_id', 'googleplus'));
            $client->setClientSecret($this->config->item('client_secret', 'googleplus'));
            $client->setRedirectUri($this->config->item('redirect_uri', 'googleplus'));
            $client->addScope("email");
            $client->addScope("profile");

            $client->addScope(Google_Service_Drive::DRIVE_READONLY);
            return $client->createAuthUrl();
        }
        return false;
    }

	function template($view='', $data=array()) {

        $data['authUrl'] =$this->google_AuthUrl();
        

        $this->load->model('index_m');
        $data['header_cat'] = $this->index_m->get_all_categories();
        $this->load->model('admin/contents_m');
        $filter['status']=true;
        $data['contents']=$this->contents_m->get_all($filter);
        $this->load->model('admin/settings_m');
        $data['web_settings'] = $this->settings_m->get();
        $data['supermarket_results'] = $this->settings_m->get_supermarket_results();

        if($this->session->userdata('order_id')){
            $order_id=$this->session->userdata('order_id');
            $this->load->model('cart_m');
            $data['cart_total']=$this->cart_m->get_cart_total($order_id);
        }

        $filter=array();
        $filter['last_minute_buy']=1;
        $filter['status']=true;
        $data['last_minute_buy_products'] = $this->index_m->get_products_by_filter($filter,6);

        $current_url = current_url(); 
        
        if ($current_url == base_url()) {
          $this->load->view('common/home_header',$data);
        }else{
          $this->load->view('common/header',$data);
        }

        
        $this->load->view($view, $data);
        $this->load->view('common/footer',$data);
    }
	
}
?>