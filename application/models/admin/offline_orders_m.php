<?php

Class Offline_Orders_M extends MY_Model
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


    public function get_cart_items($order_id){
        $this->db->select('a.*,b.coupon_code',false);
        $this->db->from('user_cart a');
        $this->db->join('admin_coupon_applied b','a.coupon_applied_id = b.id','left');
        $this->db->where('a.order_id', $order_id);
        $query = $this->db->get();
        if($query->num_rows()>=1){
            return $query->result_array();
        }
        return false;
    }

    public function get_cart_offer_products($cart_id){
        $this->db->where('cart_id', $cart_id);
        $query = $this->db->get('user_cart_offer_products');
        if($query->num_rows()>=1){
            return $query->result_array();
        }
        return false;
    }

    public function get_order_history($order_id){
        $this->db->select('a.*,IF(b.option_id=0,b.product_name,CONCAT(b.product_name,"-",b.option_name)) as prod_name', false);
        $this->db->from('user_order_status a');
        $this->db->join('user_cart b','a.cart_id = b.id','left');
        $this->db->where('a.order_id',$order_id);
        $this->db->order_by('a.id','DESC');
        $query = $this->db->get();
        if($query->num_rows()>=1){
            return $query->result_array();
        }
        return false;
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
        $this->db->where('a.order_type','offline');
        $this->db->where('a.status',2);
        $this->db->group_by('a.id');
        $this->db->order_by('a.id', 'desc');
        if (!empty($limit)) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
       // echo $this->db->last_query();die;
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

            if (!empty($filter_data['user_mobile'])) {
                $this->db->where('a.shipping_user_contact_no', $filter_data['user_mobile']);
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

        }
        $this->db->where('order_type','offline');
        $this->db->where('status',2);
        $this->db->group_by('id');
        $query = $this->db->get($this->table_name);
        return $query->num_rows();
    }

    public function get_order_status($data){
        $this->db->where('cart_id', $data['cart_id']);
        $this->db->limit(1);
        $this->db->order_by('id','desc');
        $query = $this->db->get('user_order_status');
        if($query->num_rows()>=1){
            return $query->row_array();
        }
        return false;
    }

    public function change_order_status($postdetails) {
        if(!empty($postdetails['cart_id'])){
            $date=date("Y-m-d H:i:s");
            foreach($postdetails['cart_id'] as $k=>$v){
                $insert[$k]['cart_id']=$v;
                $insert[$k]['order_id']=$postdetails['order_id'];
                $insert[$k]['status_text']=$postdetails['delivery_status'];
                $insert[$k]['comments']=$postdetails['tracking_comments'];
                $insert[$k]['created']=$date;
            }
            if(!empty($insert)){
                $this->db->insert_batch('user_order_status',$insert);
            }
        }
        return true;
    }

    public function get_order_list($filter_data){
        $this->db->select('a.order_id,a.created,a.shipping_user_name,a.shipping_user_contact_no,a.net_total,a.coupon_discount,a.payment_mode,a.payment_status,a.delivery_date,a.delivery_time_slot',false);
        $this->db->from($this->table_name.' a');
        if(!empty($filter_data)){
            if(!empty($filter_data['order_from_date'])){
                $order_from_date = date('Y-m-d',strtotime(str_replace('/','-',$filter_data['order_from_date'])));
                $where[]= 'DATE_FORMAT(a.created,"%Y-%m-%d") >= "'.$order_from_date.'"';
            }
            if(!empty($filter_data['order_to_date'])){
                $order_to_date = date('Y-m-d',strtotime(str_replace('/','-',$filter_data['order_to_date'])));
                $where[]= 'DATE_FORMAT(a.created,"%Y-%m-%d") <= "'.$order_to_date.'"';
            }
        }
        if(!empty($where)){
            $where = '('.implode(' AND ',$where).')';
            $this->db->where($where);
        }
        $this->db->where('order_type','offline');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_products_by_oid($order_id){
        $this->db->select('a.product_name,a.option_id,a.option_name',false);
        $this->db->from('user_cart a');
        $this->db->where('a.order_id', $order_id);
        $query = $this->db->get();
        if($query->num_rows()>=1){
            $result = $query->result_array();
            $products=array();
            foreach($result as $k=>$v){
                $product_name=$v['product_name'];
                if($v['option_id']!=0){
                    $product_name=$v['product_name'].'-'.$v['option_name'];
                }
                $products[]=$product_name;
            }
            return $products;
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


    public function mark_as_paid($data){
      //
        $this->db->set('payment_date',date('Y-m-d H:i:s'));
        $this->db->set('payment_status',2);
        $this->db->set('comments',$data['comments']);
        $this->db->where('id', $data['order_id']);
        $query = $this->db->update('user_order');

        $this->load->model('cart_m');
        $this->load->model('product_m');
        $data['cart_details']=$this->get_cart($data['order_id']);
        if(!empty($data['cart_details'])){
            $this->load->model('product_m');
            foreach($data['cart_details'] as $k=>$v){
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

        return false;
    }

    public function mark_as_unpaid($data){
        $this->db->set('payment_date',date('Y-m-d H:i:s'));
        $this->db->set('payment_status',1);
        $this->db->set('comments',$data['comments']);
        $this->db->where('id', $data['order_id']);
        $query = $this->db->update('user_order');

        $this->load->model('cart_m');
        $this->load->model('product_m');
        $data['cart_details']=$this->get_cart($data['order_id']);
        if(!empty($data['cart_details'])){
            $this->load->model('product_m');
            foreach($data['cart_details'] as $k=>$v){
                $cart_offer_prod = $this->cart_m->get_cart_offer_products($v['id']);
                if(!empty($cart_offer_prod)){
                    foreach($cart_offer_prod as $k1=>$v1){
                        $option_res = $this->product_m->get_option_details(array('product_id'=>$v1['offer_product_id'],'option_id'=>$v1['offer_option_id']));
                        $prod_quantity = $option_res['option_qty'];
                        $product_stock=$prod_quantity+$v1['offer_product_qty'];
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
                    $product_stock = $p_res['quantity']+$v['quantity'];
                    if($product_stock<0){
                        $product_stock=0;
                    }
                    $this->db->set('quantity', $product_stock);
                    $this->db->where('id', $v['product_id']);
                    $this->db->update('admin_product');
                }else{
                    $p_res = $this->get_product_opt_details($v['product_id'],$v['option_id']);
                    $product_stock = $p_res['option_qty']+$v['quantity'];
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

        return false;
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

    public function delete_bill($id){
        $result = $this->get($id);
        if(!empty($result)){
            $this->db->set('status', 3);
            $this->db->where('id', $id);
            $query = $this->db->update('user_order');
            $data['cart_details']=$this->get_cart($result['order_id']);
            if(!empty($data['cart_details'])){
                $this->load->model('cart_m');
                $this->load->model('product_m');
                foreach($data['cart_details'] as $k=>$v){
                    $cart_offer_prod = $this->cart_m->get_cart_offer_products($v['id']);
                    if(!empty($cart_offer_prod)){
                        foreach($cart_offer_prod as $k1=>$v1){
                            $option_res = $this->product_m->get_option_details(array('product_id'=>$v1['offer_product_id'],'option_id'=>$v1['offer_option_id']));
                            $prod_quantity = $option_res['option_qty'];
                            $product_stock=$prod_quantity+$v1['offer_product_qty'];
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
                        $product_stock = $p_res['quantity']+$v['quantity'];
                        if($product_stock<0){
                            $product_stock=0;
                        }
                        $this->db->set('quantity', $product_stock);
                        $this->db->where('id', $v['product_id']);
                        $this->db->update('admin_product');
                    }else{
                        $p_res = $this->get_product_opt_details($v['product_id'],$v['option_id']);
                        $product_stock = $p_res['option_qty']+$v['quantity'];
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