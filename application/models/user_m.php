<?php

Class User_M extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_user_details($id){
        $this->db->where('id', $id);
        $query_res = $this->db->get('user_registration');
        if ($query_res->num_rows() == 1) {
            return $query_res->row_array();
        } else {
            return false;
        }
    }

    public function get_user_by_phone($phone){
        $this->db->where('user_phone', $phone);
        $query_res = $this->db->get('user_registration');
        if ($query_res->num_rows() == 1) {
            return $query_res->row_array();
        } else {
            return false;
        }
    }

    public function email_exists($email)
    {
        $this->db->select('user_email');
        $this->db->from('user_registration');
        $this->db->where('user_email', $email);
        $this->db->limit(1);
        $query_res = $this->db->get();
        if ($query_res->num_rows() == 1) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    public function phone_exists($phone)
    {
        $this->db->select('user_phone');
        $this->db->from('user_registration');
        $this->db->where('user_phone', $phone);
        $this->db->limit(1);
        $query_res = $this->db->get();
        if ($query_res->num_rows() == 1) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    public function phone_exists_forgot($phone){
        $this->db->select('user_phone');
        $this->db->from('user_registration');
        $this->db->where('user_phone', $phone);
        $this->db->limit(1);
        $query_res = $this->db->get();
        if ($query_res->num_rows() == 1) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    public function register_user($data){

        $insert['user_name'] =$data['name'];
        $insert['user_phone'] =$data['user_phone'];
        $insert['user_email'] =$data['user_email'];
        $insert['password'] = base64_encode(trim($data['password']));

        $insert['ip_address']= $this->input->ip_address();
        $insert['created'] = date('Y-m-d H:i:s');
        $insert['updated'] = date('Y-m-d H:i:s');
        $insert['logged_datetime'] = date('Y-m-d H:i:s');
        $insert['otp_verified'] = 1;
        $insert['status'] = 2;
        $this->db->insert('user_registration', $insert);
        if ($this->db->insert_id()) {
         $this->login(array('user_email'=>$data['user_email'],'password'=>$data['password']));
         return true;
     }
     return false;

 }

 public function login($data){
    $this->db->where('user_email', $data['user_email']);
    $this->db->where('password', base64_encode($data['password']));
    $this->db->limit(1);
    $query = $this->db->get('user_registration');
    if ($query->num_rows() == 1) {
        $query_res=$query->row_array();
        $user_details=array(
            'name'=>$query_res['user_name'],
            'email'=>$query_res['user_email'],
            'id'=>$query_res['id']
        );
        $this->session->set_userdata('login_details',$user_details);
        return true;
    } else {
        $this->session->set_flashdata('error',"Invalid login credentials");
    }
    return false;
}

public function add_shipping_addr($data){
    if (!empty($this->session->userdata('login_details')['id'])) {
        $user_id=$this->session->userdata('login_details')['id'];
        $this->db->set('user_id',$user_id);
    }
    $this->db->set('title',$data['title']);
    $this->db->set('contact_name',$data['contact_name']);
    $this->db->set('address',$data['address']);
    $this->db->set('landmark',$data['landmark']);
    $this->db->set('pincode',$data['pincode']);
    $this->db->set('city',$data['city']);
    $this->db->set('state',$data['state']);
    $this->db->set('country',$data['country']);
    $this->db->set('contact_number',$data['contact_number']);
    $this->db->set('email_address',$data['email_address']);
    $make_default=0;
    if(isset($data['make_default'])){
        $make_default = $data['make_default'];
    }
    $this->db->set('make_default',$make_default);
    $this->db->set('created',date("Y-m-d H:i:s"));
    $this->db->set('updated',date("Y-m-d H:i:s"));
    $this->db->set('status',1);
    $this->db->insert('user_shipping_address');
    return $this->db->insert_id();
}

public function update_shipping_addr($data){
    $this->db->set('title',$data['title']);
    $this->db->set('contact_name',$data['contact_name']);
    $this->db->set('address',$data['address']);
    $this->db->set('landmark',$data['landmark']);
    $this->db->set('pincode',$data['pincode']);
    $this->db->set('city',$data['city']);
    $this->db->set('state',$data['state']);
    $this->db->set('country',$data['country']);
    $this->db->set('contact_number',$data['contact_number']);
    $this->db->set('email_address',$data['email_address']);
    $make_default=0;
    if(isset($data['make_default'])){
        $make_default = $data['make_default'];
    }
    $this->db->set('make_default',$make_default);
    $this->db->set('updated',date("Y-m-d H:i:s"));
    $this->db->where('id',$data['id']);
    $this->db->update('user_shipping_address');
    return true;
}

public function set_default_shipping_addr($id){
    $update['make_default']=0;
    $this->db->update('user_shipping_address', $update);

    $update['make_default']=1;
    $this->db->where('id', $id);
    $this->db->update('user_shipping_address', $update);

}

public function get_order_detail_by_order_id($order_id){
    $this->db->from('user_order');
    $this->db->where('order_id', $order_id);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
        return $query->row_array();
    } else {
        return false;
    }
}

public function get_shippingexist($id){
    $this->db->where('pincode',$id);
    $this->db->where('cod_serviceability','COD & Prepaid both');
    $this->db->select('*');
    $query=$this->db->get('shipping');
    return $query->num_rows();
    return true;
}

public function update_user_phone($data){
    $this->db->set('otp_verified',1);
    $this->db->set('user_phone',$data['user_phone']);
    $this->db->where('id', $data['id']);
    $this->db->update('user_registration');
}


public function get_shipping_addr($id){
    if ($this->session->userdata('login_details')) {
       $user_id=$this->session->userdata('login_details')['id'];
       $this->db->where('user_id', $user_id);
   }
   $this->db->where('id', $id);
   $query = $this->db->get('user_shipping_address');
   if ($query->num_rows() >= 1) {
    return $query_res=$query->row_array();
}
return false;
}

public function get_all_shipping_address(){
    $user_id=$this->session->userdata('login_details')['id'];
    $this->db->where('user_id', $user_id);
    $query = $this->db->get('user_shipping_address');
    if ($query->num_rows() >= 1) {
        return $query_res=$query->result_array();
    }
    return false;
}

public function delete_shipping_addr($id){
    $this->db->where('id',$id);
    $this->db->delete('user_shipping_address');
    return true;
}


public function get_order_history($limit='',$offset=''){
    if(!$this->session->userdata('login_details')){
        redirect(base_url());
    }
    $user_id=$this->session->userdata('login_details')['id'];
    $this->db->select('a.*,SUM(b.coupon_discount) as coupon_discount');
    $this->db->from('user_order a');
    $this->db->join('user_cart b','b.order_id = a.order_id','left');
    $this->db->where('(a.payment_status = 2 OR a.payment_mode="cod")');
    $this->db->where('a.user_id', $user_id);
    $this->db->where('a.status',2);
    $this->db->where('a.order_type','online');
    $this->db->group_by('a.id');
    $this->db->order_by('a.id', 'DESC');
    if(!empty($limit)){
        $this->db->limit($limit, $offset);
    }
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
        $result = $query->result_array();
        foreach($result as $k=>$v){
            $this->db->select('a.*,b.coupon_code,c.slug');
            $this->db->from('user_cart a');
            $this->db->join('admin_coupon_applied b','a.coupon_applied_id = b.id','left');
            $this->db->join('admin_product c','a.product_id = c.id','left');
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

public function get_total_order_history(){
    $user_id=$this->session->userdata('login_details')['id'];
    $this->db->select('*',false);
    $this->db->from('user_order a');
    $this->db->where('a.user_id',$user_id);
    $this->db->where('(a.payment_status = 2 OR a.payment_mode="cod")');
    $this->db->where('a.status',2);
    $this->db->where('a.order_type','online');
    $query = $this->db->get();
    return $query->num_rows();
}

public function get_order_detail($id)
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

public function get_all_states($filter_data=array(),$offset='',$limit=''){
    if(!empty($filter_data['search'])){
        $this->db->like('state',$filter_data['search']);
    }
    if(!empty($limit)){
        $this->db->limit($limit,$offset);
    }
    $query = $this->db->get('user_states');
    if($query->num_rows()>=1){
        return $query->result_array();
    }
    return false;
}

public function get_total_states($filter_data){
    if(!empty($filter_data['search'])){
        $this->db->like('state',$filter_data['search']);
    }
    $query = $this->db->get('user_states');
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


public function update_account($data){
    $login_details = $this->session->userdata('login_details');
    $update['user_name'] = $data['user_name'];
    $update['user_email'] = $data['user_email'];
    $update['user_phone'] = $data['user_phone'];
    $update['updated'] = date('Y-m-d H:i:s');
    $this->db->where('id',$data['id']);
    $this->db->update('user_registration', $update);
    return true;
}

public function check_old_pass($old_password){
    $encoded_pass=base64_encode($old_password);
    $this->db->where('password', $encoded_pass);
    $query=$this->db->get('user_registration');
    if($query->num_rows()>=1){
        echo 'true';
    }else{
        echo 'false';
    }
}

public function change_password($data){
    $id=$this->session->userdata('login_details')['id'];
    if($data['confirm_pass']!=$data['new_password']){
        return false;
    }
    $update['password']=base64_encode($data['confirm_pass']);
    $this->db->where('id', $id);
    $this->db->update('user_registration', $update);
    if ($this->db->affected_rows()>=0) {
        return true;
    } else {
        return false;
    }
}
}