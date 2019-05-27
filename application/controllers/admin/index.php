<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Index extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/login_m');
        $exception_uris = array('admin/index/login', 'admin/index/process_login', 'admin/index/forgot', 'admin/index/process_forgot');
        if (in_array(uri_string(), $exception_uris)) {
            if ($this->session->userdata('logged_in_adm')) {
                $this->index();
            }
        }
    }

    public function index() {
        if ($this->session->userdata('logged_in_adm')) {
            redirect('admin/index/dashboard');
        } else {
            $this->login();
        }
    }

    public function login() {
        $this->load->helper('cookie');
        $data['meta_title'] = 'Admin Login';
        $data['meta_description'] = 'Admin Login';
        $data['meta_keywords'] = 'Admin login page';
        $this->load->view('admin/login', $data);
    }

    public function process_login() {
        if (!$this->session->userdata('logged_in_adm')) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $this->form_validation->set_rules('username', 'username', 'trim|required|strip_tags');
            $this->form_validation->set_rules('password', 'password', 'trim|required|strip_tags');
            if ($this->form_validation->run() == FALSE) {
                $this->login();
            } else {
                $this->login_success($username, $password);
            }
        } else {
            redirect('admin/index/dashboard');
        }
    }

    public function login_success($username, $password) {
        $this->load->helper('cookie');
        $result = $this->login_m->adminlogin($username, $password);
        if ($result) {
            redirect('admin/index/dashboard');
        } else {
            redirect('admin');
        }
    }

    public function forgot() {
        $data['meta_title'] = 'Admin Forgot';
        $data['meta_description'] = 'Admin forgot';
        $data['meta_keywords'] = 'Admin forgot page';
        $this->load->view('admin/forgot', $data);
    }

    public function process_forgot() {
        $this->form_validation->set_rules('email', 'email', 'required|trim|xss_clean|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $this->forgot();
        } else {
            $getpassword = $this->login_m->email_exists();
            if (!empty($getpassword)) {
                $email = $getpassword['email'];
                $username = $getpassword['username'];
                $password = base64_decode($getpassword['password']);
                $data['username'] = $username;
                $data['password'] = $password;
                $message = $this->load->view('admin/email_templates/forgot', $data, true);
				$this->load->library('My_PHPMailer');
				$this->load->config('email');
				$mail = new PHPMailer();
				$mail->IsSMTP();
				$mail->Host = $this->config->item('smtp_host');
				$mail->SMTPAuth = true;
				$mail->Username = $this->config->item('smtp_user');
				$mail->Password = $this->config->item('smtp_pass');
				$mail->Port = $this->config->item('smtp_port');
				$mail->SetFrom($this->config->item('from_email'), $this->config->item('from_name'));
				$mail->Subject = "Admin Password";
				$mail->Body = $message;
				$mail->AddAddress($email,$username);
				$mail->isHTML(true);
                if($mail->Send()) {
                    $this->session->set_flashdata('forgot_success', 'Your password successfully sent to ' . $email . '</span>');
                } else {
                    $this->session->set_flashdata('forgot_error', "Email was not sent, please contact your administrator");
                }
            } else {
                $this->session->set_flashdata('forgot_error', "Your email is not in our database");
            }
            redirect('admin/index/forgot');
        }
    }

    public function dashboard() {
        if ($this->session->userdata('logged_in_adm') == FALSE) {
            redirect('admin/index/login');
        } else {
            $data = array();
            $data['meta_title'] = 'Admin Login';
            $data['meta_description'] = 'Admin Login';
            $data['meta_keywords'] = 'Admin login page';

            $table_count=$this->login_m->get_table_count();
            $this->load->model('admin/modules_m');
            $data['dashboard_modules']=$this->modules_m->get_dashboard_modules();
            if($table_count){
                foreach($table_count as $k=>$v){
                    $data[$v['table_name'].'_count']=$v['table_rows'];
                }
            }
            $this->load->model('admin/orders_m');
            $data['orders_today'] = $this->orders_m->get_orders_today(7);

            $this->load->model('admin/products_m');
            $data['out_of_stock_products'] = $this->products_m->get_out_of_stock_products(7);

            $data['nearing_out_of__products'] = $this->products_m->get_nearing_out_of_products(7);


            $data['total_value_today'] = $this->orders_m->get_total_value_today();
            $data['total_value_thisweek'] = $this->orders_m->get_total_value_thisweek();
            $data['total_value_thismonth'] = $this->orders_m->get_total_value_thismonth();

            $this->template('admin/dashboard', $data);
        }
    }


    public function logout() {
        $newdata = array('username' => '', 'password' => '', 'logged_in_adm' => FALSE,);
        $this->session->unset_userdata($newdata);
        $this->session->sess_destroy();
        redirect('admin');
    }
	
}
?>