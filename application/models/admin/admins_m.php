<?php
Class Admins_M extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name='admin_registration';
    }
	
	public function get_all(){
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
	
    public function get($id){
        $this->db->where('id',$id);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            redirect('admin/index/dashboard');
        }
    }
	
    public function add($data) {
		$this->db->from($this->table_name);
        $this->db->where('username', $data['user_name']);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == "") {
			$date=date('Y-m-d H:i:s');
			$datain['email']= $data['user_email'];
			$datain['username']= $data['user_name'];
			$datain['password']= base64_encode($data['user_password']);
			if ($data['privileges'] != "") {
                $privileges=implode(",", $data['privileges']);
            } else {
                $privileges="";
            }
			$datain['privileges']= $privileges;
			$datain['created']= $date;
			$datain['updated']= $date;
			$insert_res = $this->db->insert($this->table_name,$datain);
			if ($insert_res) {
				$this->notify_success("Added successfully!");
				return true;
			} else {
				$this->notify_error("Problem while adding data!");
				return false;
			}
		} else {
			$this->notify_error("Problem while adding data!");
			return false;
		}
    }
	
    public function update($data) {
		$this->db->from($this->table_name);
        $this->db->where('username', $data['user_name']);
        $this->db->where('id !=', $data['id']);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == "") {
			$date=date('Y-m-d H:i:s');
			$dataup['email']= $data['user_email'];
			$dataup['username']= $data['user_name'];
			if ($data['privileges'] != "") {
				$privileges=implode(",", $data['privileges']);
			} else {
				$privileges="";
			}
			$dataup['privileges']= $privileges;
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
			$dataup['username']= $data['user_name'];
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

    public function approve($id) {
        $this->db->set('status', 1);
        $this->db->where('id', $id);
        $query = $this->db->update($this->table_name);
        if($query){
            $this->notify_success("Approved successfully!");
            return true;
        }
        $this->notify_error("Problem while approving!");
        return false;
    }

    public function disapprove($id) {
        $this->db->set('status', 2);
        $this->db->where('id', $id);
        $res=$this->db->update($this->table_name);
        if($res){
            $this->notify_success("Disapproved successfully!");
            return true;
        }else{
            $this->notify_error( "Problem while disapproving!");
            return false;
        }
    }

    public function delete($id) {
        $this->db->from($this->table_name);
        $this->db->where('id', $id);
        $this->db->delete();
        $this->notify_success("Deleted successfully!");
        return true;
    }

    public function multi_approve() {
        if(empty($_POST['id'])){
            return false;
        }
        $this->db->set('status', 1);
        $this->db->where_in('id', $_POST['id']);
        $query = $this->db->update($this->table_name);
        if($query){
            $this->notify_success("Approving successfully!");
            return true;
        }
        $this->notify_error("Error in approving data!");
        return false;
    }

    public function multi_disapprove() {
        if(empty($_POST['id'])){
            return false;
        }
        $this->db->set('status', 2);
        $this->db->where_in('id', $_POST['id']);
        $query = $this->db->update($this->table_name);
        if($query){
            $this->notify_success("Disapproved successfully!");
            return true;
        }
        $this->notify_error("Error in disapproving data!");
        return false;
    }

    public function multi_delete() {
        if(empty($_POST['id'])){
            $this->notify_error("Error in deleting data!");
            return false;
        }
        $id=$_POST['id'];
        $this->db->from($this->table_name);
        $this->db->where_in('id', $id);
        $this->db->delete();
        $this->notify_success("Deleted successfully!");
        return true;
    }
	
}
?>