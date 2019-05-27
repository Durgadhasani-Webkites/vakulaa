<?php
Class Tax_Settings_M extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name='tax_settings';
    }

    public function get($id) {
        $this->db->from($this->table_name);
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return false;
        }
    }
	
    public function get_in($id) {
        $this->db->from($this->table_name);
        $this->db->where_in('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_all($filter=array()) {
        if(!empty($filter['status'])){
            $this->db->where('status',1);
        }
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function add() {
        $date=date('Y-m-d H:i:s');
        $insert['tax_type']=$_POST['tax_type'];
		$insert['tax_name']=$_POST['tax_name'];
		$insert['tax_value']=$_POST['tax_value'];
        $insert['created']= $date;
        $insert['status']= $_POST['status'];
        $res=$this->db->insert($this->table_name,$insert);
        if($res){
            $this->notify_success("Added successfully!");
            return true;
        } else {
            $this->notify_error("Problem while adding data!");
            return false;
        }
    }

    public function update() {
        $date=date('Y-m-d H:i:s');
        $id=$_POST['id'];
        $update['tax_type']=$_POST['tax_type'];
        $update['tax_name']=$_POST['tax_name'];
        $update['tax_value']=$_POST['tax_value'];
        $update['updated']= $date;
        $update['status']= $_POST['status'];
        $this->db->where('id',$id);
        $update_res = $this->db->update($this->table_name,$update);
        if ($update_res) {
            $this->notify_success("Updated successfully!");
            return true;
        } else {
            $this->notify_error("Problem while updating data!");
            return false;
        }
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
        $this->db->set('status', 0);
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
        $details=$this->get($id);
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
        $this->db->set('status', 0);
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
        $this->db->from($this->table_name);
        $this->db->where_in('id', $_POST['id']);
        $this->db->delete();
        $this->notify_success("Deleted successfully!");
        return true;
    }

} 
?>