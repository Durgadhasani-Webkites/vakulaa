<?php

Class Trash_Orders_M extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table_name = 'user_order';
    }

    public function get($id)
    {
        $this->db->select('a.*', false);
        $this->db->from($this->table_name . ' a');
        $this->db->where('a.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
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
            if (!empty($filter_data['order_no'])) {
                $this->db->where('a.order_id', $filter_data['order_no']);
            }

            if (!empty($filter_data['user_name'])) {
                $this->db->where('a.shipping_user_name', $filter_data['user_name']);
            }

            if (!empty($filter_data['user_mobile'])) {
                $this->db->where('a.shipping_user_contact_no', $filter_data['user_mobile']);
            }

            if (!empty($filter_data['paid_status'])) {
                $this->db->where('a.payment_status', $filter_data['paid_status']);
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
        $this->db->where('(a.status = 3 OR a.status = 4)');
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

            if (!empty($filter_data['user_name'])) {
                $this->db->where('shipping_user_name', $filter_data['user_name']);
            }

            if (!empty($filter_data['user_mobile'])) {
                $this->db->where('shipping_user_contact_no', $filter_data['user_mobile']);
            }

            if (!empty($filter_data['paid_status'])) {
                $this->db->where('payment_status', $filter_data['paid_status']);
            }

        }
        $this->db->where('(status = 3 OR status =4)');

        $query = $this->db->get($this->table_name);
        return $query->num_rows();
    }



    public function get_product_details($id){
        $this->db->select('a.quantity',false);
        $this->db->from('admin_product a');
        $this->db->where('a.id', $id);
        $query = $this->db->get();
        if($query->num_rows()>=1){
            return $query->row_array();
        }
        return false;
    }

    public function get_product_opt_details($product_id,$option_id){
        $this->db->select('a.option_qty',false);
        $this->db->from('admin_product_option_value a');
        $this->db->where('a.product_id', $product_id);
        $this->db->where('a.option_id', $option_id);
        $query = $this->db->get();
        if($query->num_rows()>=1){
            return $query->row_array();
        }
        return false;
    }

    public function get_cart($order_id='') {
        $this->db->select('a.*',false);
        $this->db->from('user_cart a');
        $this->db->join('user_order b','a.order_id = b.order_id','left');
        $this->db->where('b.order_id', $order_id);
        $query = $this->db->get();
        if($query->num_rows()>=1){
            return $query->result_array();
        }
        return false;
    }


    public function restore_bill($id){
        $result = $this->get($id);
        if(!empty($result)){
            $this->db->set('status', 2);
            $this->db->where('id', $id);
            $query = $this->db->update('user_order');
            $data['cart_details']=$this->get_cart($result['order_id']);
            if(!empty($data['cart_details'])){
                $this->load->model('cart_m');
                $this->load->model('product_m');
                foreach($data['cart_details'] as $k=>$v){

                    $this->db->set('status', 2);
                    $this->db->where('id', $v['id']);
                    $this->db->update('user_cart');

                    $cart_offer_prod = $this->cart_m->get_cart_offer_products($v['id']);
                    if(!empty($cart_offer_prod)){
                        foreach($cart_offer_prod as $k1=>$v1){
                            $option_res = $this->product_m->get_option_details(array('product_id'=>$v1['offer_product_id'],'option_id'=>$v1['offer_option_id']));
                            $prod_quantity = $option_res['option_qty'];
                            $product_stock=$prod_quantity-$v1['offer_product_qty'];
                            if($product_stock<0){
                                $product_stock=0;
                            }
                            $this->db->set('option_qty', $product_stock);
                            $this->db->where('product_id', $v1['offer_product_id']);
                            $this->db->where('option_id', $v1['offer_option_id']);
                            $this->db->update('admin_product_option_value');

                        }
                    }

                    if($v['option_id']==0){
                        $p_res = $this->get_product_details($v['product_id']);
                        $product_stock = $p_res['quantity']-$v['quantity'];
                        if($product_stock<0){
                            $product_stock=0;
                        }
                        $this->db->set('quantity', $product_stock);
                        $this->db->where('id', $v['product_id']);
                        $this->db->update('admin_product');
                    }else{
                        $p_res = $this->get_product_opt_details($v['product_id'],$v['option_id']);
                        $product_stock = $p_res['option_qty']-$v['quantity'];
                        if($product_stock<0){
                            $product_stock=0;
                        }
                        $this->db->set('option_qty', $product_stock);
                        $this->db->where('product_id', $v['product_id']);
                        $this->db->where('option_id', $v['option_id']);
                        $this->db->update('admin_product_option_value');
                    }
                }
            }
        }
        return false;
    }

}