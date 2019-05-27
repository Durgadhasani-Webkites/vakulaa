<?php
Class Contents_M extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name='admin_contents';
    }
	
    public function get($id){
        $this->db->where('id',$id);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    public function get_by_slug($slug){
        $this->db->where('slug',$slug);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
	
    public function get_all($filter=array()){
        if(!empty($filter['status'])){
            $this->db->where('status',1);
        }
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
	
    public function add($data){
        $date=date('Y-m-d H:i:s');
        $data['slug']= url_title($_POST['page_title']);
        $data['created']= $date;
        $data['updated']= $date;
        $insert_res = $this->db->insert($this->table_name,$data);
        if ($insert_res) {
            $this->notify_success("Added successfully!");
            return true;
        } else {
            $this->notify_error("Problem while adding data!");
            return false;
        }
    }
	
    public function update($data){
        $date=date('Y-m-d H:i:s');
        $data['slug']= url_title($_POST['page_title']);
        $data['updated']= $date;
        $this->db->where('id',$data['id']);
        $update_res = $this->db->update($this->table_name,$data);
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