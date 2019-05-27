<?php

Class Sales_Report_M extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_product_sales_report($filter_data,$offset = '', $limit = ''){
        $this->db->select('IF(b.option_id=0,b.product_code,b.option_code) as prod_code, IF(b.option_id=0,b.product_name,CONCAT(b.product_name,"-",b.option_name)) as prod_name, SUM(b.quantity) as quantity, SUM(IF(b.option_id=0,b.product_price,b.option_price)) as order_cost,a.delivery_cost',false);
        $this->db->from('user_order a');
        $this->db->join('user_cart b','a.order_id = b.order_id','left');
        if(!empty($filter_data)){
            if (isset($filter_data['search'])) {
                $search = '(IF(b.option_id=0,b.product_code,b.option_code) LIKE "%' . $filter_data['search'] . '%" OR IF(b.option_id=0,b.product_name,CONCAT(b.product_name,"-",b.option_name)) LIKE "%' . $filter_data['search'] . '%")';
                $this->db->where($search);
            }
            if(!empty($filter_data['order_from_date'])){
                $order_from_date = date('Y-m-d',strtotime(str_replace('/','-',$filter_data['order_from_date'])));
                $where[]= 'DATE_FORMAT(a.created,"%Y-%m-%d") >= "'.$order_from_date.'"';
            }
            if(!empty($filter_data['order_to_date'])){
                $order_to_date = date('Y-m-d',strtotime(str_replace('/','-',$filter_data['order_to_date'])));
                $where[]= 'DATE_FORMAT(a.created,"%Y-%m-%d") <= "'.$order_to_date.'"';
            }

            if(!empty($where)){
                $where = '('.implode(' AND ',$where).')';
                $this->db->where($where);
            }
            if(isset($filter_data['order_type']) && ($filter_data['order_type']!='both')){
                $this->db->where('a.order_type',$filter_data['order_type']);
            }

        }

        $this->db->where('(a.payment_status = 2 OR a.payment_mode = "cod")');
        $this->db->where('b.status != 4');
        $this->db->_protect_identifiers=false;
        $this->db->group_by('CASE WHEN b.option_id=0 THEN b.product_code ELSE b.option_code END',false);
        $this->db->_protect_identifiers=true;
        if (!empty($limit)) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }


    public function get_total_product_sales_report($filter_data)
    {
        $this->db->select('a.id,IF(b.option_id=0,b.product_code,b.option_code) as prod_code,IF(b.option_id=0,b.product_name,CONCAT(b.product_name,"-",b.option_name)) as prod_name,SUM(IF(b.option_id=0,b.product_price,b.option_price)) as order_cost',false);
        $this->db->from('user_order a');
        $this->db->join('user_cart b','a.order_id = b.order_id','left');
        if(!empty($filter_data)){
            if (isset($filter_data['search'])) {
                $search = '(IF(b.option_id=0,b.product_code,b.option_code) LIKE "%' . $filter_data['search'] . '%" OR IF(b.option_id=0,b.product_name,CONCAT(b.product_name,"-",b.option_name)) LIKE "%' . $filter_data['search'] . '%")';
                $this->db->where($search);
            }
            if(!empty($filter_data['order_from_date'])){
                $order_from_date = date('Y-m-d',strtotime(str_replace('/','-',$filter_data['order_from_date'])));
                $where[]= 'DATE_FORMAT(a.created,"%Y-%m-%d") >= "'.$order_from_date.'"';
            }
            if(!empty($filter_data['order_to_date'])){
                $order_to_date = date('Y-m-d',strtotime(str_replace('/','-',$filter_data['order_to_date'])));
                $where[]= 'DATE_FORMAT(a.created,"%Y-%m-%d") <= "'.$order_to_date.'"';
            }

            if(!empty($where)){
                $where = '('.implode(' AND ',$where).')';
                $this->db->where($where);
            }
            if(isset($filter_data['order_type']) && ($filter_data['order_type']!='both')){
                $this->db->where('a.order_type',$filter_data['order_type']);
            }
        }

        $this->db->where('(a.payment_status = 2 OR a.payment_mode = "cod")');
        $this->db->where('b.status != 4');
        $this->db->_protect_identifiers=false;
        $this->db->group_by('CASE WHEN b.option_id=0 THEN b.product_code ELSE b.option_code END',false);
        $this->db->_protect_identifiers=true;
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all($filter_data = array(), $offset = '', $limit = '')
    {
        $this->db->select('a.*', false);
        $this->db->from('user_order a');
        if (!empty($filter_data)) {
            if (isset($filter_data['search'])) {
                $search = '(a.order_id LIKE "%' . $filter_data['search'] . '%")';
                $this->db->where($search);
            }
            if(!empty($filter_data['order_from_date'])){
                $order_from_date = date('Y-m-d',strtotime(str_replace('/','-',$filter_data['order_from_date'])));
                $where[]= 'DATE_FORMAT(a.created,"%Y-%m-%d") >= "'.$order_from_date.'"';
            }
            if(!empty($filter_data['order_to_date'])){
                $order_to_date = date('Y-m-d',strtotime(str_replace('/','-',$filter_data['order_to_date'])));
                $where[]= 'DATE_FORMAT(a.created,"%Y-%m-%d") <= "'.$order_to_date.'"';
            }
            if(!empty($where)){
                $where = '('.implode(' AND ',$where).')';
                $this->db->where($where);
            }
            if(isset($filter_data['order_type']) && ($filter_data['order_type']!='both')){
                $this->db->where('a.order_type',$filter_data['order_type']);
            }
            if (isset($filter_data['order'])) {
                $dir = $filter_data['order']['dir'];
                if ($filter_data['order']['column'] == '1') {
                    $this->db->order_by('a.order_id', $dir);
                }
                if ($filter_data['order']['column'] == '2') {
                    $this->db->order_by('a.shipping_user_name', $dir);
                }
                if ($filter_data['order']['column'] == '3') {
                    $this->db->order_by('a.net_total', $dir);
                }
                if ($filter_data['order']['column'] == '4') {
                    $this->db->order_by('a.order_type', $dir);
                }
                if ($filter_data['order']['column'] == '5') {
                    $this->db->order_by('TIMESTAMP(a.payment_date)', $dir);
                }
            }
        }

        $this->db->where('(a.payment_status = 2)');
        $this->db->where('a.status',2);
        $this->db->group_by('a.id');
        $this->db->order_by('a.id', 'desc');
        if (!empty($limit)) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_total($filter_data)
    {
        $this->db->select('a.net_total', false);
        $this->db->from('user_order a');
        if (!empty($filter_data)) {
            if (isset($filter_data['search'])) {
                $search = '(a.order_id LIKE "%' . $filter_data['search'] . '%")';
                $this->db->where($search);
            }
            if(!empty($filter_data['order_from_date'])){
                $order_from_date = date('Y-m-d',strtotime(str_replace('/','-',$filter_data['order_from_date'])));
                $where[]= 'DATE_FORMAT(a.created,"%Y-%m-%d") >= "'.$order_from_date.'"';
            }
            if(!empty($filter_data['order_to_date'])){
                $order_to_date = date('Y-m-d',strtotime(str_replace('/','-',$filter_data['order_to_date'])));
                $where[]= 'DATE_FORMAT(a.created,"%Y-%m-%d") <= "'.$order_to_date.'"';
            }
            if(!empty($where)){
                $where = '('.implode(' AND ',$where).')';
                $this->db->where($where);
            }
            if(isset($filter_data['order_type']) && ($filter_data['order_type']!='both')){
                $this->db->where('a.order_type',$filter_data['order_type']);
            }
        }

        $this->db->where('(a.payment_status = 2)');
        $this->db->where('a.status',2);
        $this->db->group_by('a.id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
}
