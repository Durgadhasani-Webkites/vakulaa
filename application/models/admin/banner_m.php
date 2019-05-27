<?php
Class Banner_M extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
    public function get($id){

        $this->db->where('id', $id);
        $query=$this->db->get('admin_banner');
        if($query->num_rows() >=1){
            return $query->row_array();
        }
        return false;
    }
	
	public function get_all($filter=array()) {
	    if(isset($filter['status'])){
			$this->db->order_by('sort_order','asc');
			$this->db->where('status',2);
			$this->db->where('bannertype',$filter['bannertype']);
        }
		$query = $this->db->get('admin_banner');
		return $query->result_array();
		
	}
	
	public function add($postdetails) {
	
		$date=date("Y-m-d H:i:s");

		$option['title']=$postdetails['banner_name'];
		$option['image_name']=$postdetails['image_name'];
		$option['bannertype']=$postdetails['bannertype'];
        if(!empty($postdetails['banner_image'])){
            $option['image']=$postdetails['banner_image'];
        }
        if(!empty($postdetails['banner_link'])){
            $option['image_link']=$postdetails['banner_link'];
        }
		$option['sort_order']=$postdetails['sort_order'];
		$option['created']=$date;
		$option['status']=$postdetails['status'];

		$this->db->insert('admin_banner', $option);
		
		return true;	
			
	}
	
	public function editview($id) {
	
		$this->db->where('id', $id);
		$query = $this->db->get('admin_banner');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			redirect('estoreadmin/index/dashboard');
		}
		
	}
	
	public function edit($postdetails) {

		$date=date("Y-m-d H:i:s");
		$id=$postdetails['ban_id'];
		$option['title']=$postdetails['banner_name'];
		$option['image_name']=$postdetails['image_name'];
		$option['bannertype']=$postdetails['bannertype'];
        if(!empty($postdetails['banner_image'])){
			$option['image']=$postdetails['banner_image'];
		}
        if(!empty($postdetails['banner_link'])){
            $option['image_link']=$postdetails['banner_link'];
        }
		$option['sort_order']=$postdetails['sort_order'];
		$option['updated']=$date;
		$option['status']=$postdetails['status'];
		$this->db->where('id', $id);
		$this->db->update('admin_banner', $option);
		
		return true;

	}
	
	public function delete($id) {

        if($results=$this->get($id)){
            $image_path =realpath('images/upload/banners'). '/'.$results['image'];
        }
		$this->db->from('admin_banner');
		$this->db->where('id', $id);
		$this->db->delete();

        if(isset($image_path) && file_exists($image_path)){
            unlink($image_path);
        }

		return true;
		
	}
	
	public function deactivate($id) {
	
		$status=1;
		$this->db->set('status', $status);
		$this->db->where('id', $id);
		$this->db->update('admin_banner');
		return true;
		
	}
	
	public function activate($id) {
	
		$status=2;
		$this->db->set('status', $status);
		$this->db->where('id', $id);
		$this->db->update('admin_banner');
		return true;
		
	}
	
}
?>