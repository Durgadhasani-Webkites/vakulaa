<?php
Class Partners_m extends CI_Model{
    public function __construct(){
        parent::__construct();
    }

    public function contact_view() {
	    $query = $this->db->get('user_partner_details');
		return $query->result_array();		
	}
	 public function overseas() {
	    $query = $this->db->get('user_overseas_details');
		return $query->result_array();		
	}

	public function contact_readmore($uri){
		$this->db->where('id',$uri);
	    $query = $this->db->get('user_partner_details');
		return $query->result_array();		
	}

	public function overseas_readmore($uri){
		$this->db->where('id',$uri);
	    $query = $this->db->get('user_overseas_details');
		return $query->result_array();		
	}

	public function contact_delete($id) {
		$this->db->where('id',$id);
		$query=$this->db->delete('user_partner_details');
		if($query){
			return true;
		}else{
			return false;
		}
	}

	public function overseas_delete($id) {
		$this->db->where('id',$id);
		$query=$this->db->delete('user_overseas_details');
		if($query){
			return true;
		}else{
			return false;
		}
	}
}