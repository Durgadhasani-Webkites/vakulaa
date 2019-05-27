<?php
Class Bill_M extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_total_customer_list($filter_data){
        $this->db->select('a.id');
        $this->db->from('user_registration a');
        $this->db->join('user_shipping_address b','a.id = b.user_id AND b.default_address = 1','left');
        if(!empty($filter_data)){
            if(isset($filter_data['search'])){
                $this->db->where('(b.contact_number LIKE "%'.trim($filter_data['search']).'%" OR b.first_name LIKE  "%'.trim($filter_data['search']).'%")');
            }
        }
        $this->db->where('a.status',2);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_customer_list($filter_data=array(),$offset='',$limit=''){
        $this->db->select('a.id,b.first_name,b.last_name,b.contact_number,b.email_address,b.house_no,b.apartment_name,b.street_name,b.landmark,b.city_name,b.state,b.area_name,b.pincode');
        $this->db->from('user_registration a');
        $this->db->join('user_shipping_address b','a.id = b.user_id','left');
        if(!empty($filter_data)){
            if(isset($filter_data['search'])){
                $this->db->where('(a.user_phone LIKE "%'.trim($filter_data['search']).'%" OR a.user_name LIKE  "%'.trim($filter_data['search']).'%")');
            }
        }
        $this->db->where('a.status',2);
        if(!empty($limit)){
            $this->db->limit($limit,$offset);
        }
        $query = $this->db->get();
       // echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_option_code_details($code){
        $this->db->select('a.product_id,a.option_id,a.option_code as product_code,CONCAT(c.product_name,"-",b.option_value_name) as  product_desc,a.option_qty as product_qty,a.selling_price as product_price',false);
        $this->db->from('admin_product_option_value a');
        $this->db->join('admin_option_value b','a.option_id = b.id','left');
        $this->db->join('admin_product c','a.product_id = c.id','left');
        $this->db->where('a.option_code', $code);
        $query = $this->db->get();
        if($query->num_rows()>=1){
            $row = $query->row_array();
            $row['product_option_id']=$row['product_id'].'_'.$row['option_id'];
            return $row;
        }
        return false;
    }

    public function get_product_code_details($code){
        $this->db->select('a.id,a.product_code,a.product_name as  product_desc,a.quantity as product_qty,a.price as product_price,a.is_product_variable,a.weight as weightage,a.weight_class,a.weight_price',false);
        $this->db->from('admin_product a');
        $this->db->where('a.product_code', $code);
        $query = $this->db->get();
        if($query->num_rows()>=1){
            $row = $query->row_array();
            $row['product_option_id']=$row['id'].'_0';
            return $row;
        }
        return false;
    }

    public function get_product_details($id){
        $this->db->select('a.id as product_id,a.product_code,a.hsn_number,a.product_thumb_image as product_image,a.product_name as prod_name,a.product_name as  product_desc,a.is_product_variable,a.weight as weightage,a.weight_class,a.weight_price,a.quantity as product_qty,a.price as product_price,b.tax_name as sgst_name,b.tax_value as sgst_value,c.tax_name as cgst_name,c.tax_value as cgst_value',false);
        $this->db->from('admin_product a');
        $this->db->join('tax_settings b','a.sgst = b.id','left');
        $this->db->join('tax_settings c','a.cgst = c.id','left');
        $this->db->where('a.id', $id);
        $query = $this->db->get();
        if($query->num_rows()>=1){
            $row = $query->row_array();
            $sgst_rate = $row['product_price']*($row['sgst_value']/100);
            $cgst_rate = $row['product_price']*($row['cgst_value']/100);
            $row['product_option_id']=$id.'_0';
            $row['total_amt_with_tax']=$row['product_price']+$sgst_rate+$cgst_rate;
            return $row;
        }
        return false;
    }

    public function get_product_opt_details($product_option_id){
        $this->db->select('a.product_id,a.hsn_number,b.option_value_name as option_name,a.product_option_thumb_images as option_image,a.option_code,a.option_code as product_code,CONCAT(c.product_name,"-",b.option_value_name) as  product_desc,c.product_thumb_image as product_image,c.product_code as prod_code,c.product_name,c.is_product_variable,c.weight as weightage,c.weight_class,c.weight_price,c.price as prod_price,a.option_qty as product_qty,a.selling_price,a.selling_price as product_price,d.tax_name as sgst_name,d.tax_value as sgst_value,e.tax_name as cgst_name,e.tax_value as cgst_value',false);
        $this->db->from('admin_product_option_value a');
        $this->db->join('admin_option_value b','a.option_id = b.id','left');
        $this->db->join('admin_product c','a.product_id = c.id','left');
        $this->db->join('tax_settings d','c.sgst = d.id','left');
        $this->db->join('tax_settings e','c.cgst = e.id','left');
        $product_option_arr = explode('_',$product_option_id);
        $this->db->where('a.product_id', $product_option_arr[0]);
        $this->db->where('a.option_id', $product_option_arr[1]);
        $query = $this->db->get();
        if($query->num_rows()>=1){
            $row = $query->row_array();
            $sgst_rate = $row['product_price']*($row['sgst_value']/100);
            $cgst_rate = $row['product_price']*($row['cgst_value']/100);
            $row['product_option_id']=$product_option_id;
            $row['tax_rate']=$sgst_rate+$cgst_rate;
            $row['total_amt_with_tax']=$row['product_price']+$sgst_rate+$cgst_rate;
            return $row;
        }
        return false;
    }

    public function get_total_product_code_list($filter_data){
        $where1='b.product_id is NULL';
        $where2='1';
        if(!empty($filter_data['search'])){
            $where1.= ' AND a.product_code LIKE "%'.$filter_data['search'].'%"';
            $where2.= ' AND  a.option_code LIKE "%'.$filter_data['search'].'%"';
        }

        $query= $this->db->query('(SELECT CONCAT(a.id, "_", 0) AS product_id, a.product_code FROM admin_product AS a
    LEFT JOIN admin_product_option_value  AS b ON a.id = b.product_id
    WHERE '.$where1.')
    UNION
    (SELECT CONCAT(a.product_id, "_", a.option_id) AS product_id, a.option_code AS product_code FROM admin_product_option_value AS a
    LEFT JOIN admin_product AS b ON a.product_id = b.id
    LEFT JOIN admin_option_value  AS c ON a.option_id = c.id
    WHERE '.$where2.'
    )
    ORDER BY product_code ASC ');
        return $query->num_rows();
    }



    public function get_product_code_list($filter_data=array(),$offset='',$limit=''){

        $where1='b.product_id IS NULL';
        $where2='1';
        if(!empty($filter_data['search'])){
            $where1.= ' AND a.product_code LIKE "%'.$filter_data['search'].'%"';
            $where2.= ' AND a.option_code LIKE "%'.$filter_data['search'].'%"';
        }
        $limit_con='';
        if(!empty($limit)){
            $limit_con = 'LIMIT '.$offset.','.$limit;
        }
        $query= $this->db->query('(SELECT CONCAT(a.id, "_", 0) AS product_id, a.product_code FROM admin_product AS a
    LEFT JOIN admin_product_option_value  AS b ON a.id = b.product_id
    WHERE '.$where1.')
    UNION
    (SELECT CONCAT(a.product_id, "_", a.option_id) AS product_id, a.option_code AS product_code FROM admin_product_option_value AS a
    LEFT JOIN admin_product AS b ON a.product_id = b.id
    LEFT JOIN admin_option_value  AS c ON a.option_id = c.id
    WHERE '.$where2.'
    )
    ORDER BY product_code ASC '.$limit_con);
        if($query->num_rows()>=1) {
            return $query->result_array();
        }
        return false;
    }

    public function get_total_product_desc_list($filter_data){
        $where1='b.product_id IS NULL';
        $where2='1';
        if(!empty($filter_data['search'])){
            $where1.= ' AND a.product_name LIKE "%'.$filter_data['search'].'%"';
            $where2.= ' AND b.product_name LIKE "%'.$filter_data['search'].'%"';
        }
        $query= $this->db->query('(SELECT CONCAT(a.id, "_", 0) AS product_id, a.product_name FROM admin_product AS a
    LEFT JOIN admin_product_option_value  AS b ON a.id = b.product_id
    WHERE '.$where1.')
    UNION
    (SELECT CONCAT(a.product_id, "_", a.option_id) AS product_id,CONCAT(b.product_name, "-", c.option_value_name) AS product_name FROM admin_product_option_value AS a
    LEFT JOIN admin_product AS b ON a.product_id = b.id
    LEFT JOIN admin_option_value AS c ON a.option_id = c.id
    WHERE '.$where2.'
    )
    ORDER BY product_name ASC ');
        return $query->num_rows();
    }



    public function get_product_desc_list($filter_data=array(),$offset='',$limit=''){
        $where1='b.product_id IS NULL';
        $where2='1';
        if(!empty($filter_data['search'])){
            $where1.= ' AND a.product_name LIKE "%'.$filter_data['search'].'%"';
            $where2.= ' AND b.product_name LIKE "%'.$filter_data['search'].'%"';
        }
        $limit_con='';
        if(!empty($limit)){
            $limit_con = 'LIMIT '.$offset.','.$limit;
        }
            $query= $this->db->query('(SELECT CONCAT(a.id ,"_", 0) AS product_id, a.product_name FROM admin_product AS a
    LEFT JOIN admin_product_option_value  AS b ON a.id = b.product_id
    WHERE '.$where1.')
    UNION
    (SELECT CONCAT(a.product_id, "_", a.option_id) AS product_id, CONCAT(b.product_name, "-", c.option_value_name) AS product_name FROM admin_product_option_value AS a
    LEFT JOIN admin_product  AS b ON a.product_id = b.id
    LEFT JOIN admin_option_value  AS c ON a.option_id = c.id
    WHERE '.$where2.'
    )
    ORDER BY product_name ASC '.$limit_con);
        if($query->num_rows()>=1) {
            return $query->result_array();
        }
        return false;
    }

    public function update_customer($data){

        $update['user_name'] = $data['customer_name'];
        $update['user_email'] = $data['customer_email'];
        $update['user_phone'] = $data['customer_phone_no'];
        $update['updated'] = date('Y-m-d H:i:s');
        $this->db->where('id',$data['id']);
        $this->db->update('user_registration', $update);

        $update = array();
        $customer_name_arr = explode(' ', $data['customer_name']);
        $update['first_name'] = $customer_name_arr[0];
        if (isset($customer_name_arr[1])) {
            $update['last_name'] = $customer_name_arr[1];
        }
        $update['contact_number'] = $data['customer_phone_no'];
        $update['email_address'] = $data['customer_email'];
        $update['house_no'] = $data['house_no'];
        $update['apartment_name'] = $data['apartment_name'];
        $update['street_name'] = $data['street_name'];
        $update['landmark'] = $data['landmark'];
        $update['city_name'] = $data['city_name'];
        $update['area_name'] = $data['area_name'];
        $update['pincode'] = $data['pincode'];
        $update['updated'] = date('Y-m-d H:i:s');
        $this->db->where('user_id',$data['id']);
        $this->db->where('default_address',1);
        $this->db->update('user_shipping_address', $update);
        return $data['id'];
    }

    public function add_customer($data){
        $num_rows = $this->db->get_where('user_registration',array('user_phone'=>$data['customer_phone_no']))->num_rows();
        if($num_rows==0) {
            $insert['user_name'] = $data['customer_name'];
            $insert['user_email'] = $data['customer_email'];
            $insert['user_phone'] = $data['customer_phone_no'];
            $insert['password'] = base64_encode('123456');
            $insert['otp_verified'] = 1;
            $insert['created'] = date('Y-m-d H:i:s');
            $insert['ip_address'] = $this->input->ip_address();
            $insert['status'] = 2;

            $this->db->insert('user_registration', $insert);
            $id = $this->db->insert_id();
            $insert = array();
            $insert['user_id'] = $id;
            $customer_name_arr = explode(' ', $data['customer_name']);
            $insert['first_name'] = $customer_name_arr[0];
            if (isset($customer_name_arr[1])) {
                $insert['last_name'] = $customer_name_arr[1];
            }
            $insert['contact_number'] = $data['customer_phone_no'];
            $insert['email_address'] = $data['customer_email'];
            $insert['house_no'] = $data['house_no'];
            $insert['apartment_name'] = $data['apartment_name'];
            $insert['street_name'] = $data['street_name'];
            $insert['landmark'] = $data['landmark'];
            $insert['city_name'] = $data['city_name'];
            $insert['area_name'] = $data['area_name'];
            $insert['pincode'] = $data['pincode'];
            $insert['default_address'] = 1;
            $insert['created'] = date('Y-m-d H:i:s');
            $insert['status'] = 2;
            $this->db->insert('user_shipping_address', $insert);
            return $id;
        }
    }

    public function save_bill($data){
        $num_rows = $this->db->get_where('user_order',array('order_id'=>$data['order_no']))->num_rows();
        if($num_rows==0){
            
            if(empty($data['shipping_fee'])){
                $data['shipping_fee']=0;
            }
            $insert_order['total_amount'] = $data['total_cost'];
            $insert_order['net_total'] = round($data['net_total']);
            $insert_order['delivery_cost']=$data['shipping_fee'];
            $insert_order['discount_percent']=$data['discount_percent'];
            $insert_order['cash_received']=$data['cash_received'];
            $insert_order['balance_paid']=abs($data['balance_paid']);
            $insert_order['payment_mode']=$data['payment_by'];
            $insert_order['payment_id']=$data['reference_no'];
            $insert_order['comments']=$data['remarks'];
            $insert_order['payment_id']=$data['reference_no'];

            $insert_order['order_type']='offline';

            $insert_order['payment_status']=1;
            if($data['payment_status']=='paid'){
                $insert_order['payment_status']=2;
                $insert_order['payment_date']=date('Y-m-d H:i:s');
            }

            $insert_order['created']=date('Y-m-d H:i:s');
            $insert_order['status']=2;
            
            if($data['customer_no']=='guest'){
                $insert_order['user_id']=0;
                $insert_order['shipping_user_name']='guest';
                $insert_order['shipping_user_contact_no']=$data['phone_no'];
            }else{
                $user_shipping_results = $this->db->get_where('user_shipping_address',array('user_id'=>$data['customer_no']))->row_array();
                $insert_order['user_id']=$data['customer_no'];
                $insert_order['shipping_user_name']=$user_shipping_results['first_name'].' '.$user_shipping_results['last_name'];
                $insert_order['shipping_user_contact_no']=$user_shipping_results['contact_number'];
                $insert_order['shipping_user_email']=$user_shipping_results['email_address'];
                $insert_order['shipping_user_house_no']=$user_shipping_results['house_no'];
                $insert_order['shipping_user_apt_name']=$user_shipping_results['apartment_name'];
                $insert_order['shipping_user_street_addr']=$user_shipping_results['street_name'];
                $insert_order['shipping_user_landmark']=$user_shipping_results['landmark'];
                $insert_order['shipping_user_city_name']=$user_shipping_results['city_name'];
                $insert_order['shipping_user_state']=$user_shipping_results['state'];
                $insert_order['shipping_user_area_name']=$user_shipping_results['area_name'];
                $insert_order['shipping_user_pincode']=$user_shipping_results['pincode'];
            }
            $insert_order['order_id']=$data['order_no'];
            $this->db->insert('user_order', $insert_order);

            $this->insert_cart_items($data);

        }else{
            $this->update_bill($data);
        }
       return true;

    }

    public function delete_cart_items($order_id){
        $this->db->from('user_cart');
        $this->db->where('order_id', $order_id);
        $this->db->delete();

        $this->db->from('user_cart_offer_products');
        $this->db->where('order_id', $order_id);
        $this->db->delete();
    }

    public function insert_cart_items($data){
       // print_r($data);die;
        if(!empty($data['product_option_id'])){
            $this->load->model('cart_m');
            foreach($data['product_option_id'] as $k=>$v){
                if(!empty($v)){
                    $v_arr = explode('_',$v);
                    if(!empty($data['product_weight'][$k]) && !empty($data['product_weight_class'][$k])){

                        if($v_arr[1]==0) {
                            $product_details = $this->get_product_details($v_arr[0]);
                            $product_id = $product_details['product_id'];
                            $insert_cart=array();
                            $insert_cart['order_id']=$data['order_no'];
                            $insert_cart['user_id']=$data['customer_no'];
                            if($data['customer_no']=='guest'){
                                $insert_cart['user_id']=0;
                            }
                            $insert_cart['product_id']=$product_id;
                            $insert_cart['product_name']=$product_details['prod_name'].'-'.$data['product_weight'][$k].$data['product_weight_class'][$k];
                            
                            $insert_cart['product_thumb_image']=$product_details['product_image'];
                            $insert_cart['product_price']=$data['product_rate'][$k];
                            $insert_cart['quantity']=$data['product_qty'][$k];

                            $insert_cart['product_weight']=$data['product_weight'][$k];
                            $insert_cart['product_weight_class']=$data['product_weight_class'][$k];
                            $insert_cart['is_variable_product']=1;

                            $insert_cart['option_id']=0;
                            $insert_cart['hsn_number']=$product_details['hsn_number'];
                            if(!empty($product_details['sgst_value'])){
                                $insert_cart['sgst_name']=$product_details['sgst_name'];
                                $insert_cart['sgst_value']=$product_details['sgst_value'];
                            }
                            if(!empty($product_details['cgst_value'])){
                                $insert_cart['cgst_name']=$product_details['cgst_name'];
                                $insert_cart['cgst_value']=$product_details['cgst_value'];
                            }
                            $product_qty = $product_details['product_qty'];

                            $this->db->insert('user_cart', $insert_cart);
                            $cart_id = $this->db->insert_id();

                            /*$existing_product_qty = $data['existing_product_qty'][$k];
                            if($existing_product_qty==''){
                                $existing_product_qty=0;
                            }
                            $product_stock = ($existing_product_qty+$product_qty)-$data['product_qty'][$k];
                            if($product_stock<0){
                                $product_stock=0;
                            }
                            $this->db->set('quantity', $product_stock);
                            $this->db->where('id', $product_id);
                            $this->db->update('admin_product');*/

                        }

                        if($v_arr[1]!=0) {
                            $option_details = $this->get_product_opt_details($v);
                            $insert_cart=array();
                            $insert_cart['order_id']=$data['order_no'];
                            $insert_cart['user_id']=$data['customer_no'];
                            if($data['customer_no']=='guest'){
                                $insert_cart['user_id']=0;
                            }
                            $insert_cart['product_id']=$option_details['product_id'];
                            $insert_cart['product_name']=$option_details['product_name'];
                            $insert_cart['product_description']=$option_details['product_description'];
                            $insert_cart['product_thumb_image']=$option_details['product_image'];

                            $insert_cart['product_price']=$option_details['prod_price'];
                            $insert_cart['quantity']=$data['product_qty'][$k];

                            $insert_cart['product_weight']=$data['product_weight'][$k];
                            $insert_cart['product_weight_class']=$data['product_weight_class'][$k];
                            $insert_cart['is_variable_product']=1;

                            $insert_cart['option_id']=$v_arr[1];
                            $insert_cart['option_code']=$option_details['option_code'];
                            $insert_cart['option_name']=$data['product_weight'][$k].$data['product_weight_class'][$k];
                            $insert_cart['option_image']=$option_details['option_image'];
                            $insert_cart['option_price']=$data['product_rate'][$k];
                            $insert_cart['hsn_number']=$option_details['hsn_number'];
                            if(!empty($option_details['sgst_value'])){
                                $insert_cart['sgst_name']=$option_details['sgst_name'];
                                $insert_cart['sgst_value']=$option_details['sgst_value'];
                            }
                            if(!empty($option_details['cgst_value'])){
                                $insert_cart['cgst_name']=$option_details['cgst_name'];
                                $insert_cart['cgst_value']=$option_details['cgst_value'];
                            }

                            $this->db->insert('user_cart', $insert_cart);
                            $cart_id = $this->db->insert_id();

                            /*$existing_product_qty = $data['existing_product_qty'][$k];
                            if($existing_product_qty==''){
                                $existing_product_qty=0;
                            }
                            $product_stock = ($existing_product_qty+$option_details['product_qty'])-$data['product_qty'][$k];
                            if($product_stock<0){
                                $product_stock=0;
                            }
                            $this->db->set('option_qty', $product_stock);
                            $this->db->where('product_id', $option_details['product_id']);
                            $this->db->where('option_id', $v_arr[1]);
                            $this->db->update('admin_product_option_value');*/
                        }

                    }else{

                        if($v_arr[1]==0){
                            $product_details = $this->get_product_details($v_arr[0]);
                            $insert_cart=array();
                            $insert_cart['order_id']=$data['order_no'];
                            $insert_cart['user_id']=$data['customer_no'];
                            if($data['customer_no']=='guest'){
                                $insert_cart['user_id']=0;
                            }
                            $insert_cart['product_id']=$product_details['product_id'];
                            $insert_cart['product_code']=$product_details['product_code'];
                            $insert_cart['product_name']=$product_details['prod_name'];
                            $insert_cart['product_thumb_image']=$product_details['product_image'];
                            $insert_cart['product_price']=$product_details['product_price'];
                            $insert_cart['quantity']=$data['product_qty'][$k];
                            $insert_cart['option_id']=0;
                            $insert_cart['hsn_number']=$product_details['hsn_number'];
                            if(!empty($product_details['sgst_value'])){
                                $insert_cart['sgst_name']=$product_details['sgst_name'];
                                $insert_cart['sgst_value']=$product_details['sgst_value'];
                            }
                            if(!empty($product_details['cgst_value'])){
                                $insert_cart['cgst_name']=$product_details['cgst_name'];
                                $insert_cart['cgst_value']=$product_details['cgst_value'];
                            }

                            $this->db->insert('user_cart', $insert_cart);
                            $cart_id = $this->db->insert_id();
                            $existing_product_qty = $data['existing_product_qty'][$k];
                            if($existing_product_qty==''){
                                $existing_product_qty=0;
                            }
                            $product_stock = ($existing_product_qty+$product_details['product_qty'])-$data['product_qty'][$k];
                            if($product_stock<0){
                                $product_stock=0;
                            }
                            $this->db->set('quantity', $product_stock);
                            $this->db->where('id', $product_details['product_id']);
                            $this->db->update('admin_product');

                        }else{
                            if(!empty($data['product_qty'][$k])){
                                $option_details = $this->get_product_opt_details($v);
                                //print_r($option_details);
                                $insert_cart['order_id']=$data['order_no'];
                                $insert_cart['user_id']=$data['customer_no'];
                                if($data['customer_no']=='guest'){
                                    $insert_cart['user_id']=0;
                                }
                                $insert_cart['product_id']=$option_details['product_id'];
                                $insert_cart['product_code']=$option_details['prod_code'];
                                $insert_cart['product_name']=$option_details['product_name'];
                                $insert_cart['product_description']=$option_details['product_description'];
                                $insert_cart['product_thumb_image']=$option_details['product_image'];
                                $insert_cart['product_price']=$option_details['prod_price'];
                                $insert_cart['quantity']=$data['product_qty'][$k];
                                $insert_cart['option_id']=$v_arr[1];
                                $insert_cart['option_code']=$option_details['option_code'];
                                $insert_cart['option_name']=$option_details['option_name'];
                                $insert_cart['option_image']=$option_details['option_image'];
                                $insert_cart['option_price']=$option_details['selling_price'];
                                $insert_cart['hsn_number']=$option_details['hsn_number'];
                                if(!empty($option_details['sgst_value'])){
                                    $insert_cart['sgst_name']=$option_details['sgst_name'];
                                    $insert_cart['sgst_value']=$option_details['sgst_value'];
                                }
                                if(!empty($option_details['cgst_value'])){
                                    $insert_cart['cgst_name']=$option_details['cgst_name'];
                                    $insert_cart['cgst_value']=$option_details['cgst_value'];
                                }
                                $this->db->insert('user_cart', $insert_cart);
                                $cart_id = $this->db->insert_id();
                                $existing_product_qty = $data['existing_product_qty'][$k];
                                if($existing_product_qty==''){
                                    $existing_product_qty=0;
                                }
                                $product_stock = ($existing_product_qty+$option_details['product_qty'])-$data['product_qty'][$k];
                                if($product_stock<0){
                                    $product_stock=0;
                                }
                                $this->db->set('option_qty', $product_stock);
                                $this->db->where('product_id', $option_details['product_id']);
                                $this->db->where('option_id', $v_arr[1]);
                                $this->db->update('admin_product_option_value');
                            }

                            $offer_products = $this->cart_m->get_offer_products($v_arr[0],$v_arr[1]);
                            //print_r($offer_products);die;
                            if(!empty($offer_products) && !empty($cart_id)){
                                $this->load->model('product_m');
                                foreach($offer_products as $k1=>$v1){
                                    $insert_offer_prod[$k1]['cart_id'] = $cart_id;
                                    $insert_offer_prod[$k1]['order_id'] = $data['order_no'];
                                    $insert_offer_prod[$k1]['offer_product_id'] = $v1['offer_product_id'];
                                    $insert_offer_prod[$k1]['offer_option_id'] = $v1['offer_option_id'];
                                    if($v1['offer_option_id']==0){
                                        $product_code = $v1['product_code'];
                                        $product_name = $v1['product_name'];
                                        $option_name='';
                                    }else{
                                        $product_code = $v1['offer_option_code'];
                                        $product_name = $v1['product_name'];
                                        $option_name = $v1['offer_option_name'];
                                    }
                                    $insert_offer_prod[$k1]['offer_product_code'] = $product_code;
                                    $insert_offer_prod[$k1]['offer_option_name'] = $option_name;
                                    $insert_offer_prod[$k1]['offer_product_name'] = $product_name;
                                    $insert_offer_prod[$k1]['offer_product_qty'] = $v1['offer_quantity'];

                                    if($v1['offer_option_id']!=0){
                                        $option_res = $this->product_m->get_option_details(array('product_id'=>$v1['offer_product_id'],'option_id'=>$v1['offer_option_id']));


                                        $prod_quantity = $option_res['option_qty'];
                                    }else{
                                        $product_details = $this->get_product_details($v1['offer_product_id']);
                                        $prod_quantity = $product_details['product_qty'];
                                    }

                                    $product_stock=$prod_quantity-$v1['offer_quantity'];
                                    if($product_stock<0){
                                        $product_stock=0;
                                    }
                                    $this->db->set('option_qty', $product_stock);
                                    $this->db->where('product_id', $v1['offer_product_id']);
                                    $this->db->where('option_id', $v1['offer_option_id']);
                                    $this->db->update('admin_product_option_value');

                                }
                                if(!empty($insert_offer_prod)){
                                    $this->db->insert_batch('user_cart_offer_products',$insert_offer_prod);
                                }
                            }
                        }



                    }


                }
            }
        }
    }

    public function update_bill($data){
       //print_r($data);die;
        $update['total_amount']=$data['total_cost'];
        if(empty($data['shipping_fee'])){
            $data['shipping_fee']=0;
        }
        $update['delivery_cost']=$data['shipping_fee'];
        $update['discount_percent']=$data['discount_percent'];
        $update['cash_received']=$data['cash_received'];
        $update['balance_paid']=abs($data['balance_paid']);
        $update['payment_mode']=$data['payment_by'];
        $update['payment_id']=$data['reference_no'];
        $update['comments']=$data['remarks'];
        $update['payment_id']=$data['reference_no'];

        $update['order_type']='offline';

        $update['payment_status']=1;
        if($data['payment_status']=='paid'){
            $update['payment_status']=2;
            $update['payment_date']=date('Y-m-d H:i:s');
        }

        $update['updated']=date('Y-m-d H:i:s');
        $update['net_total']=round($data['net_total']);

        if($data['customer_no']=='guest'){
            $update['user_id']=0;
            $update['shipping_user_name']='guest';
            $update['shipping_user_contact_no']=$data['phone_no'];
        }else{
            $user_results = $this->db->get_where('user_registration',array('id'=>$data['customer_no']))->row_array();
            $update['user_id']=$data['customer_no'];
            $update['shipping_user_name']=$user_results['user_name'];
            $update['shipping_user_contact_no']=$user_results['user_phone'];
        }
        if(isset($data['bill_id'])){
            $this->db->where('id',$data['bill_id']);
        }else{
            $this->db->where('order_id',$data['order_no']);
        }
        $this->db->update('user_order', $update);

        $this->delete_cart_items($data['order_no']);

        $this->insert_cart_items($data);
    }

    public function get_order_details($id)
    {
        $this->db->select('a.*', false);
        $this->db->from('user_order a');
        $this->db->where('a.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }


    public function get_bill($order_id='') {
        $this->db->select('a.*,b.total_amount,b.net_total,b.created as bill_date,b.id as bill_id,b.delivery_cost,b.discount_percent,b.cash_received,b.balance_paid,b.payment_status,b.payment_date,b.comments,c.weight,c.weight_class,c.weight_price',false);
        $this->db->from('user_cart a');
        $this->db->join('user_order b','a.order_id = b.order_id','left');
        $this->db->join('admin_product c','c.id = a.product_id','left');
        $this->db->where('a.order_id', $order_id);
        $query = $this->db->get();
        if($query->num_rows()>=1){
            return $query->result_array();
        }
        return false;
    }
}