<?php
Class Contact_details_m extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function get_country(){
		return $this->db->get('admin_create_country')->result_array();
	}

    public function add_process(){
    	$insert['country']=$_POST['country'];
    	$insert['designation']=$_POST['designation'];
    	$insert['name']=$_POST['name'];
    	$insert['mobile']=$_POST['mobile'];
    	$insert['email']=$_POST['email'];
    	$insert['google']=$_POST['google'];
        $insert['status']=$_POST['status'];
    	$insert['created']=date('Y-m-d H:i:s');
        if($this->db->insert('admin_contact_details',$insert)){
        	return true;
        }else{
        	return false;
        }
        }

        public function view(){
            return $this->db->get('admin_contact_details')->result_array();
            //select admin_create_country.country from admin_create_country INNER JOIN admin_contact_details on admin_contact_details.country=admin_create_country.country
        }

        public function editview($id){
            $this->db->where('id', $id);
            $query = $this->db->get('admin_contact_details');
            return $query->row_array();
        }

        public function process_edit(){
            $id=$this->input->post('id');
            $update['country']=$_POST['country'];
            $update['designation']=$_POST['designation'];
            $update['name']=$_POST['name'];
            $update['mobile']=$_POST['mobile'];
            $update['email']=$_POST['email'];
            $update['google']=$_POST['google'];
            $update['status']=$_POST['status'];
            $update['updated']=date('Y-m-d H:i:s');
            $this->db->where('id',$id);
            $query=$this->db->update('admin_contact_details',$update);
            if($query){
                return true;
            }else{
                return false;
            }
        }

        public function delete($id) {
            $this->db->from('admin_contact_details');
            $this->db->where('id', $id);
            $query = $this->db->delete();
            if($query) {
               return true;
            }else{
                return false;
            }
        }
    }