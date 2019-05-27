<?php
Class Filters_M extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function view() {
	
		$query = $this->db->get('admin_filter_group');
		return $query->result_array();
		
	}
	
	public function add($postdetails) {
	
		$groupname=$postdetails['filter_group_name'];
		$this->db->from('admin_filter_group');
		$this->db->where('filter_group_name', $groupname);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if($query -> num_rows() == "") {
		
			$date=date("Y-m-d H:i:s");
			
			$option['filter_group_name']=$groupname;
			$option['sort_order']=$postdetails['filter_group_order'];
			$option['created']=$date;
			$option['status']=2;
			$this->db->insert('admin_filter_group', $option);
			$filterid=$this->db->insert_id();
			
			$filteroption=$postdetails['filter_name'];
			$i=0;
			foreach($filteroption as $key=>$value) {
                if(!empty($value)){
                    $optionarray[$i]['filter_group_id']=$filterid;
                    $optionarray[$i]['filter_name']=$value;
                    $optionarray[$i]['sort_order']=$postdetails['filter_order'][$key];
                    $optionarray[$i]['created']=$date;
                    $i++;
                }
			}
			
			if(!empty($optionarray)) {
				$this->db->insert_batch('admin_filter', $optionarray);
			}
			return true;
			
		} else {
		
			return false;
			
		}
		
	}
	
	public function editview($id) {
	
		$this->db->where('id', $id);
		$query = $this->db->get('admin_filter_group');
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			redirect('admin/index/dashboard');
		}
		
	}
	
	public function filtereditview($id) {
	
		$this->db->where('filter_group_id', $id);
		$query = $this->db->get('admin_filter');
		return $query->result_array();
		
	}
	
	public function edit($postdetails) {
		
		$id=$postdetails['group_id'];
		$groupname=$postdetails['filter_group_name'];
		$this->db->from('admin_filter_group');
		$this->db->where('filter_group_name', $groupname);
		$this->db->where('id !=', $id);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if($query -> num_rows() == "") {
	
			$date=date("Y-m-d H:i:s");
			$this->db->set('filter_group_name', $groupname);
			$this->db->set('sort_order', $postdetails['filter_group_order']);
			$this->db->set('updated', $date);
			$this->db->where('id', $id);
			$this->db->update('admin_filter_group');

            $i=0;$j=0;
            foreach($postdetails['filter_name'] as $key=>$value) {
                if(!empty($value)){
                    if(isset($postdetails['option_id']) && array_key_exists($key,$postdetails['option_id'])){
                        $optionarrayup[$i]['id'] = $postdetails['option_id'][$key];
                        $optionarrayup[$i]['filter_name'] = $value;
                        $optionarrayup[$i]['sort_order'] = $postdetails['filter_order'][$key];
                        $optionarrayup[$i]['updated'] = $date;
                        $i++;
                    }else{
                        $optionarrayin[$j]['filter_group_id'] = $id;
                        $optionarrayin[$j]['filter_name'] = $value;
                        $optionarrayin[$j]['sort_order'] = $postdetails['filter_order'][$key];
                        $optionarrayin[$j]['created'] = $date;
                        $j++;
                    }
                }
            }

			if(isset($optionarrayup) && $optionarrayup!="") {
				$this->db->update_batch('admin_filter', $optionarrayup, 'id');
			}
			
			if(isset($optionarrayin) && $optionarrayin!="") {
				$this->db->insert_batch('admin_filter', $optionarrayin);
			}
			
			return true;
		
		} else {
		
			return false;
			
		}

	}
	
	public function delete($id) {
	
		$this->db->from('admin_filter_group');
		$this->db->where('id', $id);
		$query = $this->db->delete();
		if($query) {
			$this->db->from('admin_filter');
			$this->db->where('filter_group_id', $id);
			$this->db->delete();
		}
		
		return true;
		
	}
	
	public function deactivate($id) {
		$status=1;
		$this->db->set('status', $status);
		$this->db->where('id', $id);
		$this->db->update('admin_filter_group');
		return true;
		
	}
	
	public function activate($id) {
		$status=2;
		$this->db->set('status', $status);
		$this->db->where('id', $id);
		$this->db->update('admin_filter_group');
		return true;
		
	}
	
	public function remove_filter($id) {
		$this->db->where('id', $id);
        $query=$this->db->get('admin_filter');
        if($query->num_rows()>=1){
            $res=$query->row_array();
            $this->db->from('admin_filter');
            $this->db->where('id', $id);
            $this->db->delete();
            return $res['filter_group_id'];
        }else{
            return false;
        }
	}
}
?>