<?php
Class Profile_M extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name='admin_registration';
    }
	
	public function get_profile($id){
        $this->db->where('id',$id);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            redirect('admin/index/dashboard');
        }
    }
	
	public function update_profile($data) {
		$this->db->from($this->table_name);
        $this->db->where('username', $data['user_name']);
        $this->db->where('id !=', $data['id']);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == "") {
			$date=date('Y-m-d H:i:s');
			$dataup['email']= $data['user_email'];
            if(!empty($data['user_name'])){
                $dataup['username']= $data['user_name'];
            }
			$dataup['first_name']= $data['first_name'];
			$dataup['last_name']= $data['last_name'];
			$dataup['mobile_no']= $data['mobile_no'];
			$dataup['fulladdress']= $data['fulladdress'];
			if ($data['repeat_password'] != "") {
				$dataup['password']= base64_encode($data['repeat_password']);
			}
			$dataup['updated']= $date;
			$this->db->where('id',$data['id']);
			$update_res = $this->db->update($this->table_name,$dataup);
			if ($update_res) {
				$this->notify_success("Updated successfully!");
				return true;
			} else {
				$this->notify_error("Problem while updating data!");
				return false;
			}
		} else {
			$this->notify_error("Problem while updating data!");
			return false;
		}
    }
	
	public function check_old_pass($oldpassword) {
        $email = $this->session->userdata('email');
        $username = $this->session->userdata('username');
        $this->db->where('email', $email);
        $this->db->where('username', $username);
        $this->db->where('password', base64_encode($oldpassword));
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() >= 1) {
            echo 'true';
            die;
        }
        echo 'false';
        die;
    }
	
}
?>