<?php
Class Attributes_M extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function view() {
	
		$query = $this->db->get('admin_attribute_group');
		return $query->result_array();
		
	}
	
	public function add($postdetails) {
	
		$groupname=$postdetails['attribute_group_name'];
		$this->db->from('admin_attribute_group');
		$this->db->where('attribute_group_name', $groupname);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if($query -> num_rows() == "") {
		
			$date=date("Y-m-d H:i:s");
			
			$option['attribute_group_name']=$groupname;
			$option['sort_order']=$postdetails['attribute_group_order'];
			$option['created']=$date;
			$option['status']=2;
			$this->db->insert('admin_attribute_group', $option);
			$filterid=$this->db->insert_id();

            if(isset($postdetails['attribute_name'])){
                $filteroption=$postdetails['attribute_name'];
                $i=0;
                foreach($filteroption as $key=>$value) {
                    if(!empty($value)) {
                        $optionarray[$i]['attribute_group_id'] = $filterid;
                        $optionarray[$i]['attribute_name'] = $value;
                        $optionarray[$i]['sort_order'] = $postdetails['attribute_order'][$key];
                        $optionarray[$i]['created'] = $date;
                        $i++;
                    }
                }
                if(!empty($optionarray)) {
                    $this->db->insert_batch('admin_attribute', $optionarray);
                }
            }

			return true;
			
		} else {
		
			return false;
			
		}
		
	}
	
	public function editview($id) {
	
		$this->db->where('id', $id);
		$query = $this->db->get('admin_attribute_group');
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			redirect('admin/index/dashboard');
		}
		
	}
	
	public function filtereditview($id) {
	
		$this->db->where('attribute_group_id', $id);
		$query = $this->db->get('admin_attribute');
		return $query->result_array();
		
	}
	
	public function edit($postdetails) {
		
		$id=$postdetails['group_id'];
		$groupname=$postdetails['attribute_group_name'];
		$this->db->from('admin_attribute_group');
		$this->db->where('attribute_group_name', $groupname);
		$this->db->where('id !=', $id);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if($query -> num_rows() == "") {
	
			$date=date("Y-m-d H:i:s");
			$this->db->set('attribute_group_name', $groupname);
			$this->db->set('sort_order', $postdetails['attribute_group_order']);
			$this->db->set('updated', $date);
			$this->db->where('id', $id);
			$query=$this->db->update('admin_attribute_group');

            $i=0;$j=0;
            foreach($postdetails['attribute_name'] as $key=>$value) {
                if(!empty($value)){
                    if(isset($postdetails['option_id']) && array_key_exists($key,$postdetails['option_id'])){
                        $optionarrayup[$i]['id'] = $postdetails['option_id'][$key];
                        $optionarrayup[$i]['attribute_name'] = $value;
                        $optionarrayup[$i]['sort_order'] = $postdetails['attribute_order'][$key];
                        $optionarrayup[$i]['updated'] = $date;
                        $i++;
                    }else{
                        $optionarrayin[$j]['attribute_group_id'] = $id;
                        $optionarrayin[$j]['attribute_name'] = $value;
                        $optionarrayin[$j]['sort_order'] = $postdetails['attribute_order'][$key];
                        $optionarrayin[$j]['created'] = $date;
                        $j++;
                    }
                }
            }

			if(isset($optionarrayup) && $optionarrayup!="") {
				$this->db->update_batch('admin_attribute', $optionarrayup, 'id');
			}
			
			if(isset($optionarrayin) && $optionarrayin!="") {
				$this->db->insert_batch('admin_attribute', $optionarrayin);
			}
			
			return true;
		
		} else {
		
			return false;
			
		}

	}
	
	public function delete($id) {
	
		$this->db->from('admin_attribute_group');
		$this->db->where('id', $id);
		$query = $this->db->delete();
		if($query) {
			$this->db->from('admin_attribute');
			$this->db->where('attribute_group_id', $id);
			$querybtm = $this->db->delete();
		}
		
		return true;
		
	}
	
	public function deactivate($id) {
	
		$status=1;
		$this->db->set('status', $status);
		$this->db->where('id', $id);
		$query=$this->db->update('admin_attribute_group');
		return true;
		
	}
	
	public function activate($id) {
	
		$status=2;
		$this->db->set('status', $status);
		$this->db->where('id', $id);
		$query=$this->db->update('admin_attribute_group');
		return true;
		
	}
	
	public function remove_attribute($id) {

        $this->db->where('id', $id);
        $query=$this->db->get('admin_attribute');
        if($query->num_rows()>=1){
            $res=$query->row_array();
            $this->db->from('admin_attribute');
            $this->db->where('id', $id);
            $this->db->delete();
            return $res['attribute_group_id'];
        }else{
            return false;
        }
	}

}
?>