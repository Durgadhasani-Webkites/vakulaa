<?php
Class Headings_M extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get() {
        $query = $this->db->get('admin_settings');
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

} 
?>