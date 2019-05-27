<?php
Class Modules_M extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name='admin_modules';
    }

    public function admin_privileges() {
        $this->db->where('status', '1');
        $query = $this->db->get($this->table_name);
        return $query->result_array();
    }

    public function get_all_modules($parent=0){
        $modules = array();
        $this->db->select('id,parent_id,icon,name,link');
        $this->db->from($this->table_name);
        $this->db->where('parent_id',$parent);
        $this->db->order_by('sort_order','ASC');
        $result = $this->db->get()->result();
        foreach ($result as $row) {
            $data['id'] = $row->id;
            $data['parent_id']= $row->parent_id;
            $data['icon'] = $row->icon;
            $data['name'] = $row->name;
            $data['link'] = $row->link;
            $data['sub_modules'] = $this->get_all_modules($row->id);
            $modules[$row->id]=$data;
        }
        return $modules;
    }

    public function get_dashboard_modules(){
        $privileges=$this->session->userdata('privileges');
        $privileges_arr= explode(",",$privileges);
        $new_privileges_arr=array();
        foreach($privileges_arr as $k=>$v){
            if(strpos($v,'-')){
                $sub_prev_arr=explode("-",$v);
                if(!in_array($sub_prev_arr[0],$new_privileges_arr)){
                    $new_privileges_arr[]=$sub_prev_arr[0];
                }
                $new_privileges_arr[]=$sub_prev_arr[1];
            }else{
                $new_privileges_arr[]=$v;
            }
        }
        $this->db->from($this->table_name);
		$this->db->where('show_in_dashboard', 2);
        $this->db->where('status', 1);
        $this->db->where_in('id', $new_privileges_arr);
        $query = $this->db->get();
        if ($query->num_rows()>0) {
            return $query->result_array();
        }
        return false;
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
	
    public function get_all(){
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function add($data){
        $date=date('Y-m-d H:i:s');
        $data['created']= $date;
        
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