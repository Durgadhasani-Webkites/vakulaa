<?php
Class Options_M extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	//Select Options
	
	public function view() {
	
		$query = $this->db->get('admin_option');
		return $query->result_array();
		
	}
	
	public function add($postdetails) {

		$groupname=$postdetails['option_name'];
		$this->db->from('admin_option');
		$this->db->where('option_name', $groupname);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if($query -> num_rows() == "") {
		
			$date=date("Y-m-d H:i:s");
			
			$option['option_name']=$groupname;
			$option['type']=$postdetails['option_type'];
			$option['sort_order']=$postdetails['option_order'];
			$option['created']=$date;
			$option['status']=2;
			$this->db->insert('admin_option', $option);
			$filterid=$this->db->insert_id();

            if(isset($postdetails['option_value']) & !empty($postdetails['option_value'])){
                $i=0;
                foreach($postdetails['option_value'] as $key=>$value) {
                    if(!empty($value)){
                        $optionarray[$i]['option_id']=$filterid;
                        $optionarray[$i]['option_value_name']=$value;
                        $optionarray[$i]['sort_order']=$postdetails['option_value_order'][$key];
                        $optionarray[$i]['created']=$date;
                        $optionarray[$i]['status']=2;
                        $i++;
                    }
                }

                if($optionarray!="") {
                    $this->db->insert_batch('admin_option_value', $optionarray);
                }
            }

			return true;
			
		} else {
		
			return false;
			
		}
		
	}
	
	public function editview($id) {
	
		$this->db->where('id', $id);
		$query = $this->db->get('admin_option');
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			redirect('admin/index/dashboard');
		}
		
	}
	
	public function filtereditview($id) {
	
		$this->db->where('option_id', $id);
		$query = $this->db->get('admin_option_value');
		return $query->result_array();
		
	}
	
	public function edit($postdetails) {
		
		$id=$postdetails['group_id'];
		$groupname=$postdetails['option_name'];
		$this->db->from('admin_option');
		$this->db->where('option_name', $groupname);
		$this->db->where('id !=', $id);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if($query -> num_rows() == "") {
	
			$date=date("Y-m-d H:i:s");
			$this->db->set('option_name', $groupname);
			$this->db->set('type', $postdetails['option_type']);
			$this->db->set('sort_order', $postdetails['option_order']);
			$this->db->set('updated', $date);
			$this->db->where('id', $id);
			$this->db->update('admin_option');

            $i=0;$j=0;
            foreach($postdetails['option_value'] as $key=>$value) {
                if(!empty($value)){
                    if(isset($postdetails['option_id']) && array_key_exists($key,$postdetails['option_id'])){
                        $optionarrayup[$i]['id'] = $postdetails['option_id'][$key];
                        $optionarrayup[$i]['option_value_name'] = $value;
                        $optionarrayup[$i]['sort_order'] = $postdetails['option_value_order'][$key];
                        $optionarrayup[$i]['updated'] = $date;
                        $i++;
                    }else{
                        $optionarrayin[$j]['option_id'] = $id;
                        $optionarrayin[$j]['option_value_name'] = $value;
                        $optionarrayin[$j]['sort_order'] = $postdetails['option_value_order'][$key];
                        $optionarrayin[$j]['created'] = $date;
                        $j++;
                    }
                }
            }
			
			if(isset($optionarrayup) && $optionarrayup!="") {
				$this->db->update_batch('admin_option_value', $optionarrayup, 'id');
			}
			
			if(isset($optionarrayin) && $optionarrayin!="") {
				$this->db->insert_batch('admin_option_value', $optionarrayin);
			}
			
			return true;
		
		} else {
		
			return false;
			
		}

	}
	
	public function delete($id) {
	
		$this->db->from('admin_option');
		$this->db->where('id', $id);
		$query = $this->db->delete();
		if($query) {
			$this->db->from('admin_option_value');
			$this->db->where('option_id', $id);
			$querybtm = $this->db->delete();
		}
		
		return true;
		
	}
	
	public function deactivate($id) {
	
		$status=1;
		$this->db->set('status', $status);
		$this->db->where('id', $id);
		$query=$this->db->update('admin_option');
		return true;
		
	}
	
	public function activate($id) {
	
		$status=2;
		$this->db->set('status', $status);
		$this->db->where('id', $id);
		$query=$this->db->update('admin_option');
		return true;
		
	}
	
	public function remove_option($id) {
        $this->db->where('id', $id);
        $query=$this->db->get('admin_option_value');
        if($query->num_rows()>=1){
            $res=$query->row_array();
            $this->db->from('admin_option_value');
            $this->db->where('id', $id);
            $this->db->delete();
            return $res['option_id'];
        }else{
            return false;
        }
		
	}
	
}
?>