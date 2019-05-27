<?php 
Class Login_M extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_table_count() {
        $this->db->select('table_name');
        $this->db->from('INFORMATION_SCHEMA.TABLES');
        $this->db->where('TABLE_SCHEMA', $this->db->database);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            foreach($result as $k=>$v){
                $query_st = "SELECT * FROM ".$v['table_name'];
                if($v['table_name']=='manage_task' && ($this->session->userdata('resource_id')>0)){
                    $query_st.= ' WHERE FIND_IN_SET('.$this->session->userdata('resource_id').', accessed_by) > 0 AND status = 1';
                }
                $query = $this->db->query($query_st);
                $result[$k]['table_rows'] = $query->num_rows();
            }
            return $result;
        }else{
            return false;
        }
    }

    public function adminlogin($username, $password) {
        $this->db->select('id, username, password, email, privileges');
        $this->db->from('admin_registration');
        $this->db->where('username', $username);
        $this->db->where('password', base64_encode($password));
        $this->db->where('status', 1);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            foreach ($query->result() as $rows) {
                $logdata = array('id'=> $rows->id,'username' => $rows->username, 'email' => $rows->email, 'privileges' => $rows->privileges,'resource_id'=>$rows->resource_id,'logged_in_adm' => TRUE,);
            }
            if (isset($_POST['remember']) && $_POST['remember'] == 'yes') {
                $year = time() + (86400 * 30);
                $user_cookie = array('name' => 'username', 'value' => $username, 'expire' => $year);
                $password_cookie = array('name' => 'password', 'value' => $password, 'expire' => $year);
                $remember_cookie = array('name' => 'remember', 'value' => 1, 'expire' => $year);
                $this->input->set_cookie($user_cookie);
                $this->input->set_cookie($password_cookie);
                $this->input->set_cookie($remember_cookie);
            } else {
                if (isset($_COOKIE['remember'])) {
                    $this->load->helper('cookie');
                    delete_cookie('username');
                    delete_cookie('password');
                    delete_cookie('remember');
                }
            }
            $this->session->set_userdata($logdata);
            return true;
        } else {
            $this->session->set_userdata('loginerror', "Please enter valid username and password");
            if (isset($_COOKIE['remember'])) {
                $this->load->helper('cookie');
                delete_cookie('username');
                delete_cookie('password');
                delete_cookie('remember');
            }
            return false;
        }
    }
	
	public function email_exists() {
        $email = $this->input->post('email');
        $this->db->select('id, email, username, password');
        $this->db->from('admin_registration');
        $this->db->where('email', $email);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            foreach ($query->result_array() as $rows) {
                return $rows;
            }
        } else {
            return false;
        }
    }

    public function get_user_details($id){
        $this->db->select('*');
        $this->db->from('admin_registration');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }
}
?>