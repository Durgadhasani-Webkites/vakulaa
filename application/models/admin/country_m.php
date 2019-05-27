	<?php
	Class country_m extends CI_Model {
		
		public function __construct() {
			parent::__construct();
		}

		public function process_add(){
			$insert['country'] = $_POST['country'];
			$insert['created'] = date('Y-m-d H:i:s');
			$query=$this->db->insert('admin_create_country',$insert);
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function view(){
			$query = $this->db->get('admin_create_country');
			return $query->result_array();
		}

		public function editview($id){
			$this->db->where('id', $id);
			$query = $this->db->get('admin_create_country');
			return $query->row_array();
		}

		public function process_edit(){
			$id=$this->input->post('id');
			$update['country']=$_POST['country'];
			$update['updated']=date('Y-m-d H:i:s');
			$this->db->where('id',$id);
			$query=$this->db->update('admin_create_country',$update);
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function delete($id) {
		     $this->db->from('admin_create_country');
		     $this->db->where('id', $id);
		     $query = $this->db->delete();
		     if($query) {
		     	return true;
		     }else{
		         return false;
		     }
	    }
    }