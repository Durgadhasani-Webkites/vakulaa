<?php

Class Stock_Report_M extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_category($filter_data = array(), $offset = '', $limit = ''){
        $this->db->select('a.*');
        $this->db->from('admin_category a');
        if (isset($filter_data['search'])) {
            $search = '(a.category_name LIKE "%' . $filter_data['search'] . '%")';
            $this->db->where($search);
        }
        $this->db->where('a.status', 1);
        if (!empty($limit)) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
       // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_total_category($filter_data)
    {
        $this->db->select('a.id');
        $this->db->from('admin_category a');
        if (!empty($filter_data)) {
            if (isset($filter_data['search'])) {
                $search = '(a.category_name LIKE "%' . $filter_data['search'] . '%")';
                $this->db->where($search);
            }
        }
        $this->db->where('a.status', 1);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_stock_report($filter_data){
        $this->db->select('IF(c.option_id IS NULL,b.quantity,c.option_qty) as stock,IF(c.option_id IS NULL,b.price,c.selling_price) as price,IF(c.option_id IS NULL,b.product_name,CONCAT(b.product_name,"-",d.option_value_name)) as product_name',false);

        $this->db->from('admin_product_category a');
        $this->db->join('admin_product b', 'b.id = a.product_id','left');
        $this->db->join('admin_product_option_value c', 'b.id = c.product_id','left');
        $this->db->join('admin_option_value d', 'd.id = c.option_id','left');
        if(!empty($filter_data)){

            if(!empty($filter_data['category']) && ($filter_data['category'][0]!='all')){
                $this->db->where_in('a.category_id',$filter_data['category']);
            }
            if(!empty($filter_data['status'])){
                $this->db->where('a.status',$filter_data['status']);
            }
        }

        $this->db->group_by('c.id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
}
