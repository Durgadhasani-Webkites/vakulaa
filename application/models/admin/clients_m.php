<?php
Class Clients_M extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
    public function get($id){

        $this->db->where('id', $id);
        $query=$this->db->get('admin_blog');
        if($query->num_rows() >=1){
            return $query->row_array();
        }
        return false;
    }
	
	public function get_all($filter=array()) {
		 if(isset($filter['status'])){
			$this->db->order_by('sort_order','asc');
			$this->db->where('status',2);
        }
		$query = $this->db->get('admin_blog');
		return $query->result_array();
	}
	
	public function add($postdetails) {
		
		$date=date("Y-m-d H:i:s");

		$option['title']=$postdetails['title'];
        if(!empty($postdetails['blog_image'])){
            $option['image']=$postdetails['blog_image'];
        }
        if(!empty($postdetails['image_link'])){
            $option['image_link']=$postdetails['image_link'];
        }
		$option['sort_order']=$postdetails['sort_order'];
		$option['created']=$date;
		$option['status']=$postdetails['status'];

		$this->db->insert('admin_blog', $option);
		
		return true;	
			
	}
	
	public function editview($id) {
	
		$this->db->where('id', $id);
		$query = $this->db->get('admin_blog');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			redirect('estoreadmin/index/dashboard');
		}
		
	}
	
	public function edit($postdetails) {

		$date=date("Y-m-d H:i:s");
		$id=$postdetails['blog_id'];
		$option['title']=$postdetails['title'];
		
        if(!empty($postdetails['blog_image'])){
            $option['image']=$postdetails['blog_image'];
        }
        if(!empty($postdetails['image_link'])){
            $option['image_link']=$postdetails['image_link'];
        }
		$option['sort_order']=$postdetails['sort_order'];
		$option['updated']=$date;
		$option['status']=$postdetails['status'];
		$this->db->where('id', $id);
		$this->db->update('admin_blog', $option);
		
		return true;

	}
	
	public function delete($id) {

        if($results=$this->get($id)){
            $image_path =realpath('images/upload/blogs'). '/'.$results['image'];
        }

        if(isset($image_path) && file_exists($image_path)){
            unlink($image_path);
        }

		$this->db->from('admin_blog');
		$this->db->where('id', $id);
		$this->db->delete();
		return true;
		
	}
	
	public function deactivate($id) {
	
		$status=1;
		$this->db->set('status', $status);
		$this->db->where('id', $id);
		$this->db->update('admin_blog');
		return true;
		
	}
	
	public function activate($id) {
	
		$status=2;
		$this->db->set('status', $status);
		$this->db->where('id', $id);
		$this->db->update('admin_blog');
		return true;
		
	}
	
}
?>