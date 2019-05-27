<?php

Class Failed_Orders_M extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table_name = 'user_order';
    }

    public function get_all($filter_data = array(), $offset = '', $limit = '')
    {
        $this->db->select('a.*,SUM(b.coupon_discount) as coupon_discount', false);
        $this->db->from($this->table_name . ' a');
        $this->db->join('user_cart b','b.order_id = a.order_id','left');
        if (!empty($filter_data)) {
            if (isset($filter_data['search'])) {
                $search = '(a.order_id LIKE "%' . $filter_data['search'] . '%")';
                $this->db->where($search);
            }

            if (!empty($filter_data['payment_mode'])) {
                $this->db->where('a.payment_mode', $filter_data['payment_mode']);
            }

            if (isset($filter_data['seen_status'])) {
                $this->db->where('a.seen_status', $filter_data['seen_status']);
                $this->db->where('(a.payment_status =2 OR a.payment_mode ="cod")');
            }

            if (!empty($filter_data['order_no'])) {
                $this->db->where('a.order_id', $filter_data['order_no']);
            }

            if (!empty($filter_data['user_name'])) {
                $this->db->where('a.shipping_user_name', $filter_data['user_name']);
            }

            if (!empty($filter_data['user_mobile'])) {
                $this->db->where('a.shipping_user_contact_no', $filter_data['user_mobile']);
            }

            if(!empty($filter_data['order_from'])){
                $order_from_date = date('Y-m-d',strtotime(str_replace('/','-',$filter_data['order_from'])));
                $where[]= 'DATE_FORMAT(a.created,"%Y-%m-%d") >= "'.$order_from_date.'"';
            }
            if(!empty($filter_data['order_to'])){
                $order_to_date = date('Y-m-d',strtotime(str_replace('/','-',$filter_data['order_to'])));
                $where[]= 'DATE_FORMAT(a.created,"%Y-%m-%d") <= "'.$order_to_date.'"';
            }

            if(!empty($where)){
                $where = '('.implode(' AND ',$where).')';
                $this->db->where($where);
            }

            if (!empty($filter_data['paid_status'])) {
                $this->db->where('a.payment_status', $filter_data['paid_status']);
            }

            if(!empty($filter_data['list']) && ($filter_data['list']=='today')){
                $this->db->where('DATE_FORMAT(a.created,"%Y-%m-%d") = CURDATE()');
            }
            if(!empty($filter_data['list']) && ($filter_data['list']=='week')) {
                $this->db->where('WEEKOFYEAR(a.created) = WEEKOFYEAR(CURDATE())');
            }
            if(!empty($filter_data['list']) && ($filter_data['list']=='month')) {
                $this->db->where('YEAR(a.created) = YEAR(CURDATE()) AND MONTH(a.created)= MONTH(CURDATE())');
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
                    $this->db->order_by('a.shipping_user_contact_no', $dir);
                }
                if ($filter_data['order']['column'] == '4') {
                    $this->db->order_by('a.net_total', $dir);
                }
                if ($filter_data['order']['column'] == '5') {
                    $this->db->order_by('a.payment_mode', $dir);
                }
                if ($filter_data['order']['column'] == '6') {
                    $this->db->order_by('TIMESTAMP(a.payment_date)', $dir);
                }
                if ($filter_data['order']['column'] == '7') {
                    $this->db->order_by('a.payment_status', $dir);
                }
            }
        }
        $this->db->where('a.order_type','online');
        $this->db->where('a.payment_status = 3');
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
        if (!empty($filter_data)) {
            if (isset($filter_data['search'])) {
                $search = '(order_id LIKE "%' . $filter_data['search'] . '%")';
                $this->db->where($search);
            }
            if (!empty($filter_data['order_no'])) {
                $this->db->where('order_id', $filter_data['order_no']);
            }

            if (isset($filter_data['seen_status'])) {
                $this->db->where('seen_status', $filter_data['seen_status']);
                $this->db->where('(payment_status =2 OR payment_mode ="cod")');
            }

            if (!empty($filter_data['payment_mode'])) {
                $this->db->where('payment_mode', $filter_data['payment_mode']);
            }

            if (!empty($filter_data['user_name'])) {
                $this->db->where('shipping_user_name', $filter_data['user_name']);
            }

            if (!empty($filter_data['user_mobile'])) {
                $this->db->where('shipping_user_contact_no', $filter_data['user_mobile']);
            }

            if(!empty($filter_data['order_from'])){
                $order_from_date = date('Y-m-d',strtotime(str_replace('/','-',$filter_data['order_from'])));
                $where[]= 'DATE_FORMAT(created,"%Y-%m-%d") >= "'.$order_from_date.'"';
            }
            if(!empty($filter_data['order_to'])){
                $order_to_date = date('Y-m-d',strtotime(str_replace('/','-',$filter_data['order_to'])));
                $where[]= 'DATE_FORMAT(created,"%Y-%m-%d") <= "'.$order_to_date.'"';
            }

            if(!empty($where)){
                $where = '('.implode(' AND ',$where).')';
                $this->db->where($where);
            }

            if (!empty($filter_data['paid_status'])) {
                $this->db->where('payment_status', $filter_data['paid_status']);
            }

            if(!empty($filter_data['list']) && ($filter_data['list']=='today')){
                $this->db->where('DATE_FORMAT(payment_date,"%Y-%m-%d") = CURDATE()');
            }
            if(!empty($filter_data['list']) && ($filter_data['list']=='week')) {
                $this->db->where('WEEKOFYEAR(created) = WEEKOFYEAR(CURDATE())');
            }
            if(!empty($filter_data['list']) && ($filter_data['list']=='month')) {
                $this->db->where('YEAR(created) = YEAR(CURDATE()) AND MONTH(created)= MONTH(CURDATE())');
            }
        }
        $this->db->where('order_type','online');
        $this->db->where('(payment_status = 3)');
        $this->db->where('status',2);
        $query = $this->db->get($this->table_name);
        return $query->num_rows();
    }

}