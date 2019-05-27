<?php
Class Settings_M extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get() {
        $query = $this->db->get('admin_settings');
        return $query->row_array();
    }

    public function get_supermarket_results(){
        $query = $this->db->get('admin_supermarket_settings');
        return $query->row_array();
    }

     public function get_home_page_products(){
        $query = $this->db->get('admin_home_page_product_settings');
        return $query->row_array();
    }

     public function get_how_to_prepare(){
        $query = $this->db->get('admin_how_to_prepare_settings');
        return $query->row_array();
    }

    public function get_contact_address(){
        $query = $this->db->get('admin_contact_settings');
        return $query->row_array();
    }

     public function get_position_details(){
        $query = $this->db->get('admin_position_settings');
        return $query->row_array();
    }
	
    public function edit($data) {
        $date=date('Y-m-d H:i:s');
        if(isset($data['id'])){
            $id=$data['id'];
            unset($data['id']);
            $data['updated']=$date;
            $this->db->where('id', $id);
            $this->db->update('admin_settings', $data);
        }else{
            $data['created']=$date;
            $data['status']=2;
            $this->db->insert('admin_settings', $data);
        }
        return true;
    }

    public function edit_supermarket_addr($data) {
        $date=date('Y-m-d H:i:s');
        if(isset($data['id'])){
            $id=$data['id'];
            unset($data['id']);
            $data['updated']=$date;
            $this->db->where('id', $id);
            $this->db->update('admin_supermarket_settings', $data);
        }else{
            $data['created']=$date;
            $data['status']=2;
            $this->db->insert('admin_supermarket_settings', $data);
        }
        return true;
    }

     public function edit_home_page_products($data) {
        $date=date('Y-m-d H:i:s');
        if(isset($data['id'])){
            $id=$data['id'];
            unset($data['id']);
            unset($data['image1_name']);
            unset($data['image2_name']);
            unset($data['image3_name']);
            unset($data['image4_name']);
            $data['updated']=$date;
            $this->db->where('id', $id);
            $this->db->update('admin_home_page_product_settings', $data);
        }else{
            $data['created']=$date;
            $data['status']=2;
            $this->db->insert('admin_home_page_product_settings', $data);
        }
        return true;
    }

     public function get_image($data){
       
        if (isset($data['image1'])) {
            $this->db->where('image1', $data['image1']);
        }
        if (isset($data['image2'])) {
            $this->db->where('image2', $data['image2']);
        }
        if (isset($data['image3'])) {
            $this->db->where('image3', $data['image3']);
        }
        if (isset($data['image4'])) {
            $this->db->where('image4', $data['image4']);
        }
        
        $query=$this->db->get('admin_home_page_product_settings');
        if($query->num_rows() >=1){
            return $query->row_array();
        }
        return false;
    }

    public function edit_how_to_prepare($data) {
        $date=date('Y-m-d H:i:s');
        if(isset($data['id'])){
            $id=$data['id'];
            unset($data['id']);
            unset($data['prepare_image1_name']);
            unset($data['prepare_image2_name']);
            unset($data['prepare_image3_name']);
            unset($data['prepare_image4_name']);
            $data['updated']=$date;
            $this->db->where('id', $id);
            $this->db->update('admin_how_to_prepare_settings', $data);
        }else{
            $data['created']=$date;
            $data['status']=2;
            $this->db->insert('admin_how_to_prepare_settings', $data);
        }
        return true;
    }

     public function get_prepare_image($data){
       
        if (isset($data['prepare_image1'])) {
            $this->db->where('prepare_image1', $data['prepare_image1']);
        }
        if (isset($data['prepare_image2'])) {
            $this->db->where('prepare_image2', $data['prepare_image2']);
        }
        if (isset($data['prepare_image3'])) {
            $this->db->where('prepare_image3', $data['prepare_image3']);
        }
        if (isset($data['prepare_image4'])) {
            $this->db->where('prepare_image4', $data['prepare_image4']);
        }
        
        $query=$this->db->get('admin_how_to_prepare_settings');
        if($query->num_rows() >=1){
            return $query->row_array();
        }
        return false;
    }

    public function edit_contact_address($data) {
        $date=date('Y-m-d H:i:s');
        if(isset($data['id'])){
            $id=$data['id'];
            unset($data['id']);
            $data['updated']=$date;
            $this->db->where('id', $id);
            $this->db->update('admin_contact_settings', $data);
        }else{
            $data['created']=$date;
            $data['status']=2;
            $this->db->insert('admin_contact_settings', $data);
        }
        return true;
    }

     public function edit_position_details($data) {
        $date=date('Y-m-d H:i:s');
        if(isset($data['id'])){
            $id=$data['id'];
            unset($data['id']);
            $data['updated']=$date;
            $this->db->where('id', $id);
            $this->db->update('admin_position_settings', $data);
        }else{
            $data['created']=$date;
            $data['status']=2;
            $this->db->insert('admin_position_settings', $data);
        }
        return true;
    }
     public function get_country(){
        return $this->db->get('admin_create_country')->result_array();
    }
     public function get_contact_details(){
        return $this->db->limit(2)->get('admin_contact_details')->result_array();
    }

    public function get_details(){
        $id=$this->input->post('country');
        
       $this->db->where('country',$id);
       $query = $this->db->get('admin_contact_details');
       if ($query->num_rows() >= 1) {
          return $query->result_array();
      }
      return false;

}



} 
?>