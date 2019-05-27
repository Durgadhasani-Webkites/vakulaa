<?php

Class Customers_M extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table_name = 'user_registration';
    }

    public function get_all_customers(){
        $this->db->select('id,user_name,user_email,user_phone,DATE_FORMAT(created,"%d/%m/%Y %h:%i:%s %p") as created,IF(status=2,"Active","Not Active") as status',false);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }


    public function get_all_shipping_address($filter_data = array(), $offset = '', $limit = '')
    {
        $this->db->select('a.*', false);
        $this->db->from('user_shipping_address a');
        if (!empty($filter_data)) {
            if (isset($filter_data['search'])) {
                $search = '(a.first_name LIKE "%' . $filter_data['search'] . '%" OR a.email_address LIKE "%' . $filter_data['search'] . '%" OR a.contact_number LIKE "%' . $filter_data['search'] . '%")';
                $this->db->where($search);
            }

            if (isset($filter_data['order'])) {
                $dir = $filter_data['order']['dir'];
                if ($filter_data['order']['column'] == '0') {
                    $this->db->order_by('a.first_name', $dir);
                }
                if ($filter_data['order']['column'] == '1') {
                    $this->db->order_by('a.email_address', $dir);
                }
                if ($filter_data['order']['column'] == '2') {
                    $this->db->order_by('a.contact_number', $dir);
                }
                if ($filter_data['order']['column'] == '3') {
                    $this->db->order_by('a.city_name', $dir);
                }
                if ($filter_data['order']['column'] == '4') {
                    $this->db->order_by('a.pincode', $dir);
                }
                if ($filter_data['order']['column'] == '6') {
                    $this->db->order_by('TIMESTAMP(a.created)', $dir);
                }
            }
            if (!empty($filter_data['customer_id'])) {
                $this->db->where('a.user_id', $filter_data['customer_id']);
            }
        }

        $this->db->order_by('a.id', 'desc');
        if (!empty($limit)) {
            $this->db->limit($limit, $offset);
        }
        $this->db->where('status',2);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_total_shipping_address($filter_data)
    {
        if (!empty($filter_data)) {
            if (isset($filter_data['search'])) {
                $search = '(first_name LIKE "%' . $filter_data['search'] . '%" OR email_address LIKE "%' . $filter_data['search'] . '%" OR contact_number LIKE "%' . $filter_data['search'] . '%")';
                $this->db->where($search);
            }
            if (!empty($filter_data['customer_id'])) {
                $this->db->where('user_id', $filter_data['customer_id']);
            }
        }

        $this->db->where('status',2);
        $query = $this->db->get('user_shipping_address');
        return $query->num_rows();
    }

    public function get_all($filter_data = array(), $offset = '', $limit = '')
    {
        $this->db->select('a.*', false);
        $this->db->from($this->table_name . ' a');
        if (!empty($filter_data)) {
            if (isset($filter_data['search'])) {
                $search = '(a.user_name LIKE "%' . $filter_data['search'] . '%" OR a.user_email LIKE "%' . $filter_data['search'] . '%" OR a.user_phone LIKE "%' . $filter_data['search'] . '%")';
                $this->db->where($search);
            }
            if (!empty($filter_data['user_name'])) {
                $this->db->like('a.user_name', $filter_data['user_name']);
            }

            if (!empty($filter_data['user_email'])) {
                $this->db->like('a.user_email', $filter_data['user_email']);
            }

            if (!empty($filter_data['user_phone'])) {
                $this->db->like('a.user_phone', $filter_data['user_phone']);
            }

            if (isset($filter_data['order'])) {
                $dir = $filter_data['order']['dir'];
                if ($filter_data['order']['column'] == '1') {
                    $this->db->order_by('a.user_name', $dir);
                }
                if ($filter_data['order']['column'] == '2') {
                    $this->db->order_by('a.user_email', $dir);
                }
                if ($filter_data['order']['column'] == '3') {
                    $this->db->order_by('a.user_phone', $dir);
                }
                if ($filter_data['order']['column'] == '4') {
                    $this->db->order_by('TIMESTAMP(a.created)', $dir);
                }
            }
        }

        $this->db->order_by('a.id', 'desc');
        if (!empty($limit)) {
            $this->db->limit($limit, $offset);
        }
        $this->db->where('status',2);
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
                $search = '(user_name LIKE "%' . $filter_data['search'] . '%" OR user_email LIKE "%' . $filter_data['search'] . '%" OR user_phone LIKE "%' . $filter_data['search'] . '%")';
                $this->db->where($search);
            }

            if (!empty($filter_data['user_name'])) {
                $this->db->like('user_name', $filter_data['user_name']);
            }

            if (!empty($filter_data['user_email'])) {
                $this->db->like('user_email', $filter_data['user_email']);
            }

            if (!empty($filter_data['user_phone'])) {
                $this->db->like('user_phone', $filter_data['user_phone']);
            }


        }
        $this->db->where('status',2);
        $query = $this->db->get($this->table_name);
        return $query->num_rows();
    }

    public function get_order_history($filter=array(),$limit='',$offset=''){
        $this->db->select('a.*,SUM(b.coupon_discount) as coupon_discount');
        $this->db->from('user_order a');
        $this->db->join('user_cart b','b.order_id = a.order_id','left');

        $this->db->where('(a.payment_status = 2 OR a.payment_mode = "cod")');

        if(!empty($filter['customer_id'])) {
            $this->db->where('a.user_id', $filter['customer_id']);
        }
        $this->db->group_by('a.id');
        $this->db->order_by('a.id', 'DESC');
        if(!empty($limit)){
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            foreach($result as $k=>$v){
                $this->db->select('a.*,b.coupon_code');
                $this->db->from('user_cart a');
                $this->db->join('admin_coupon_applied b','a.coupon_applied_id = b.id','left');
                $this->db->where('a.order_id', $v['order_id']);
                $query_res = $this->db->get();
                if ($query_res->num_rows() >= 1) {
                    $result1 = $query_res->result_array();
                    foreach($result1 as $k1=>$v1){
                        $result1[$k1]['cart_offer_prod'] = $this->get_cart_offer_products($v1['id']);
                    }
                    $result[$k]['cart_items']=$result1;
                }
            }
            return $result;
        }
        return false;
    }

    public function get_total_order_history($filter){

        $this->db->select('*',false);
        $this->db->from('user_order a');
        if(!empty($filter['customer_id'])) {
            $this->db->where('a.user_id', $filter['customer_id']);
        }
        $this->db->where('(a.payment_status = 2 OR a.payment_mode = "cod")');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_cart_offer_products($cart_id){
        $this->db->where('cart_id', $cart_id);
        $query = $this->db->get('user_cart_offer_products');
        if($query->num_rows()>=1){
            return $query->result_array();
        }
        return false;
    }

    public function get_order($order_id){
        $this->db->where('order_id', $order_id);
        $query = $this->db->get('user_order');
        if($query->num_rows()>=1){
            return $query->row_array();
        }
        return false;
    }

    public function get_order_status($order_id,$cart_id){
        $this->db->select('max(status_text) as status_text,max(created) as created,max(comments) as comments,max(id) as id',false);
        $this->db->where('order_id', $order_id);
        $this->db->where('cart_id', $cart_id);
        $this->db->group_by('status_text');
        $this->db->order_by('id','asc');
        $query = $this->db->get('user_order_status');
        if($query->num_rows()>=1){
            return $query->result_array();
        }
        return false;
    }

    public function get_shipping_address($id){
        $this->db->select('a.*', false);
        $this->db->from('user_shipping_address a');
        $this->db->where('status',2);
        $this->db->where('id',$id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function add_shipping_address($data){
        $date=date("Y-m-d H:i:s");
        if(empty($data['default_address'])){
            $data['default_address']=0;
        }else{
            $this->db->set('default_address',0);
            $this->db->where('user_id',$data['customer_id']);
            $this->db->update('user_shipping_address');
        }
        $data['created']=$date;
        $data['status']=2;

        $this->db->insert('user_shipping_address', $data);
        return $this->db->insert_id();
    }

    public function edit_shipping_address($data){
        $date=date("Y-m-d H:i:s");
        if(empty($data['default_address'])){
            $data['default_address']=0;
        }else{
            $this->db->set('default_address',0);
            $this->db->where('id !=',$data['id']);
            $this->db->update('user_shipping_address');
        }
        $data['updated']=$date;
        $data['status']=2;
        $this->db->where('id',$data['id']);
        $this->db->update('user_shipping_address', $data);
        return $this->get_shipping_address($data['id']);
    }

    public function delete_shipping_address($id) {

        $result = $this->get_shipping_address($id);

        $this->db->from('user_shipping_address');
        $this->db->where('id', $id);
        $this->db->delete();

        return $result;
    }

    public function get_cart_by_uid($uid) {
        $this->db->select('a.*',false);
        $this->db->from('user_cart a');
        $this->db->join('user_order b','a.order_id = b.order_id','left');
        $this->db->where_in('b.user_id', $uid);
        $query = $this->db->get();
        if($query->num_rows()>=1){
            return $query->result_array();
        }
        return false;
    }

    public function delete($id){

        $this->load->model('admin/orders_m');
        $data['cart_details']=$this->get_cart_by_uid($id);
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
                    $p_res = $this->orders_m->get_product_details($v['product_id']);
                    $product_stock = $p_res['quantity']+$v['quantity'];
                    if($product_stock<0){
                        $product_stock=0;
                    }
                    $this->db->set('quantity', $product_stock);
                    $this->db->where('id', $v['product_id']);
                    $this->db->update('admin_product');
                }else{
                    $p_res = $this->orders_m->get_product_opt_details($v['product_id'],$v['option_id']);
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

        $query = "DELETE a, b, c, d, e, f FROM user_registration as a
                LEFT JOIN user_order b ON a.id = b.user_id
                LEFT JOIN user_cart c ON b.order_id = c.order_id
                LEFT JOIN user_cart_offer_products d ON b.order_id = d.order_id
                LEFT JOIN user_order_status e ON b.id = e.order_id
                LEFT JOIN user_shipping_address f ON a.id = f.user_id
                WHERE a.id = $id
                ";
        $this->db->query($query);
        return true;
    }

    public function multi_delete(){
        if(empty($_POST['id'])){
            $this->notify_error("Error in deleting data!");
            return false;
        }
        foreach($_POST['id'] as $id){
            $this->delete($id);
        }
        return true;
    }

}

