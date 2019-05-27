<?php
Class Delivery_Rates_M extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get() {
        $query = $this->db->get('admin_delivery_grams_rate');
        return $query->row_array();
    }
	
    public function edit($data) {
        $date=date('Y-m-d H:i:s');
        if(isset($data['id'])){

            $update['rate']=$data['rate'];
            $update['grams']=$data['grams'];
            $this->db->where('id', $data['id']);
            $this->db->update('admin_delivery_grams_rate', $update);

        }else{
            $insert['rate']=$data['rate'];
            $insert['grams']=$data['grams'];
            $this->db->insert('admin_delivery_grams_rate', $insert);
        }
        return true;
    }

} 
?>