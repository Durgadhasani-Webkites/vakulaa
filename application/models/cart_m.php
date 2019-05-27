<?php

Class Cart_M extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_cart_qty($product_id){
        $this->db->select('quantity');
        $this->db->where('product_id', $product_id);
        if($this->session->userdata('order_id')){
            $order_id=$this->session->userdata('order_id');
            $this->db->where('order_id', $order_id);
        }
        $query= $this->db->get('user_cart');
        if($query->num_rows()>=1){
            $result=$query->row_array();
            return $result['quantity'];
        }
        return false;
    }


    public function get_cart_total($order_id){
        $this->db->select('COUNT(product_id)');
        $this->db->where('order_id', $order_id);
        $this->db->group_by('option_id');
        $this->db->group_by('product_id');
        $query= $this->db->get('user_cart');
        return $query->num_rows();
    }

    public function get_offer_products($product_id,$option_id){
        $this->db->select('a.offer_product_id,a.offer_option_id,b.product_name,b.product_code,c.option_code as offer_option_code,d.option_value_name as offer_option_name,a.offer_quantity');
        $this->db->from('admin_offer_products a');
        $this->db->join('admin_product b','a.offer_product_id = b.id','left');
        $this->db->join('admin_product_option_value c','a.offer_option_id = c.option_id AND a.offer_product_id = c.product_id','left');
        $this->db->join('admin_option_value d','a.offer_option_id = d.id','left');
        $this->db->where('a.product_id', $product_id);
        $this->db->where('a.product_option_id', $option_id);
        $query= $this->db->get();
        if($query->num_rows()>=1) {
            return $query->result_array();
        }
        return false;
    }

    public function get_special_coupon_prod($coupon_id){
        $this->db->select('a.id,GROUP_CONCAT(CONCAT(b.product_id,"_",b.option_id) SEPARATOR ",") as product_option_id',false);
        $this->db->from('admin_product a');
        $this->db->join('admin_product_option_value b','a.id = b.product_id','left');
        $this->db->where('FIND_IN_SET('.$coupon_id.',a.coupon) > 0');
        $this->db->group_by('b.product_id');
        $query= $this->db->get();
        if($query->num_rows()>=1) {
            return $query->result_array();
        }
        return false;

    }

    public function get_category_coupon_prod($categories){
        $categories_arr = explode(',',$categories);
        $this->db->select('DISTINCT(a.product_id) as product_id',false);
        $this->db->from('admin_product_category a');
        $this->db->where_in($categories_arr);
        $query= $this->db->get();
        if($query->num_rows()>=1) {
            $result = $query->result_array();
            foreach($result as $k=>$v){
                $product_id[] = $v['product_id'];
            }
            $this->db->select('a.id,GROUP_CONCAT(CONCAT(b.product_id,"_",b.option_id) SEPARATOR "&&") as product_option_id',false);
            $this->db->from('admin_product a');
            $this->db->join('admin_product_option_value b','a.id = b.product_id','left');
            $this->db->where_in($product_id);
            $this->db->group_by('b.product_id');
            $query= $this->db->get();
            if($query->num_rows()>=1) {
                return $query->result_array();
            }
        }
        return false;
    }

    public function check_coupon_applied($coupon_code,$order_id){
        $this->db->select('id');
        $this->db->where('coupon_code', $coupon_code);
        $this->db->where('order_id', $order_id);
        $query= $this->db->get('admin_coupon_applied');
        return $query->num_rows();
    }

    public function get_coupon_applied_count($coupon_code){
        $this->db->select('id');
        $this->db->where('coupon_code', $coupon_code);
        $this->db->where('status', 2);
        $query= $this->db->get('admin_coupon_applied');
        return $query->num_rows();
    }

    public function apply_coupon($data){
        if ($data['coupon'] == 'Choose Your Promo code') {
            echo json_encode(array('coupon_error'=>'Please choose your promo code'));
            die;
        }
        if ($data['coupon'] == '') {
            echo json_encode(array('coupon_error'=>'Please enter your promo code'));
            die;
        }
        $this->db->where('coupon_code', $data['coupon']);
        $query= $this->db->get('admin_coupon');
        if($query->num_rows()>=1) {
            $result = $query->row_array();

            if(($result['valid_from']!='0000-00-00') && ($result['valid_to']!='0000-00-00')){
                if(!((date('Y-m-d') >= $result['valid_from']) && (date('Y-m-d') <= $result['valid_to']))){
                    echo json_encode(array('coupon_error'=>'Coupon code expired'));
                    die;
                }
            }

            $coupon_applied_count =  $this->get_coupon_applied_count($data['coupon']);
            if(($coupon_applied_count!=0) && ($coupon_applied_count==$result['max_usage'])){
                echo json_encode(array('coupon_error'=>'Coupon code not available'));
                die;
            }
            $order_id=$this->session->userdata('order_id');
            $already_applied = $this->check_coupon_applied($data['coupon'],$order_id);
            if($already_applied==1){
                echo json_encode(array('coupon_error'=>'Coupon code already applied'));
                die;
            }

            if($result['coupon_type']=='special' || ($result['coupon_type']=='category')) {
                $coupon_products = $this->get_special_coupon_prod($result['id']);
            }

            if($result['coupon_type']=='category'){
                $coupon_products = $this->get_category_coupon_prod($result['categories']);
            }
            if($result['coupon_type']=='special' || ($result['coupon_type']=='category')) {
                $coupon_prods = [];
                if(!empty($coupon_products)){
                    foreach ($coupon_products as $k => $v) {
                        if($v['product_option_id']==''){
                            array_push($coupon_prods,$v['id'].'_0');
                        }else{
                            $product_option_id_arr = explode('&&',$v['product_option_id']);
                            foreach($product_option_id_arr as $k1=>$v1){
                                foreach(explode(',',$v1) as $k2=>$v2){
                                    array_push($coupon_prods,trim($v2));
                                }
                            }
                        }
                    }
                }
            }
            $cart_res = $this->view_cart();
            if(!empty($cart_res)){
                $subtotal_price=0;
                foreach($cart_res as $k=>$v){
                    $product_option_id = $v['product_id'].'_'.$v['option_id'];
                    if(!empty($coupon_prods)){
                        if(in_array($product_option_id,$coupon_prods)){
                            if($v['option_id']==0){
                                $product_price =$v['product_price'];
                            }else{
                                $product_price =$v['option_price'];
                            }

                            $quantity=$v['quantity'];
                            $subtotal_price+=$quantity*$product_price;
                        }
                    }else{
                        if($result['coupon_type']=='all'){
                            if($v['option_id']==0){
                                $product_price =$v['product_price'];
                            }else{
                                $product_price =$v['option_price'];
                            }

                            $quantity=$v['quantity'];
                            $subtotal_price+=$quantity*$product_price;
                        }
                    }
                }
                if($subtotal_price<$result['minimum_amount']){
                    echo json_encode(array('coupon_error'=>'Your total should be above Rs.'.$result['minimum_amount'].' to apply this coupon'));
                    die;
                }else{
                    $insert['order_id']=$order_id;
                    $insert['coupon_type']=$result['coupon_type'];
                    $insert['coupon_code']=$result['coupon_code'];
                    $insert['discount_type']=$result['discount_type'];
                    $insert['discount']=$result['discount'];
                    $this->db->insert('admin_coupon_applied',$insert);
                    $coupon_applied_id = $this->db->insert_id();
                }

                foreach($cart_res as $k=>$v) {
                    $product_option_id = $v['product_id'] . '_' . $v['option_id'];
                    if (!empty($coupon_prods)) {
                        if(in_array($product_option_id,$coupon_prods)){
                            if($v['option_id']==0){
                                $product_price =$v['product_price'];
                            }else{
                                $product_price =$v['option_price'];
                            }

                            $quantity=$v['quantity'];
                            $product_price = $quantity*$product_price;

                            if($result['discount_type']=='Percentage'){
                                $coupon_discount = $product_price*($result['discount']/100);
                            }else{
                                $coupon_discount = $result['discount'];
                            }

                            $this->db->set('coupon_applied_id',$coupon_applied_id);
                            $this->db->set('coupon_discount',$coupon_discount);
                            $this->db->where('product_id',$v['product_id']);
                            $this->db->where('order_id',$order_id);
                            $this->db->update('user_cart');
                        }

                    }else{
                        if($v['option_id']==0){
                            $product_price =$v['product_price'];
                        }else{
                            $product_price =$v['option_price'];
                        }

                        $quantity=$v['quantity'];
                        $product_price = $quantity*$product_price;

                        if($result['discount_type']=='Percentage'){
                            $coupon_discount = $product_price*($result['discount']/100);
                        }else{
                            $coupon_discount = $result['discount'];
                        }

                        $this->db->set('coupon_applied_id',$coupon_applied_id);
                        $this->db->set('coupon_discount',$coupon_discount);
                        $this->db->where('product_id',$v['product_id']);
                        $this->db->where('order_id',$order_id);
                        $this->db->update('user_cart');
                    }
                }
                echo json_encode(array('coupon_success'=>'Coupon applied successfully'));
                die;
            }

        }else{
            echo json_encode(array('coupon_error'=>'Invalid coupon code'));
            die;
        }
    }

    public function get_last_order_id(){
        $this->db->select('order_id');
        $this->db->order_by('id','desc');
        $this->db->limit(1);
        $query = $this->db->get('user_cart');
        if($query->num_rows()>=1){
            $row=$query->row_array();
            return $row['order_id'];
        }
        return false;
    }

    public function create_new_order_id(){
        $order_id = $this->get_last_order_id();
        if(!empty($order_id)){
            $order_id_last = substr($order_id, -6);
            $order_id_next = (int)$order_id_last + 1;
            $order_id = date("YmdHis") . str_pad($order_id_next, 6, '0', STR_PAD_LEFT);
            $num_rows = $this->db->get_where('user_order', array('order_id' => $order_id))->num_rows();
            if ($num_rows == 0) {
                return $order_id;
            }else{
                return false;
            }
        }
        return false;
    }

    public function add_to_cart($data){
        if(!$this->session->userdata('order_id')) {
            if(!$this->create_new_order_id()){
                $order_id=date("YmdHis").'000001';
                $this->session->set_userdata('order_id', $order_id);
            }else{
                $order_id = $this->create_new_order_id();
                while(!$order_id) {
                    $this->create_new_order_id();
                }
                $this->session->set_userdata('order_id', $order_id);
            }

        } else {
            $order_id=$this->session->userdata('order_id');

            $num_rows = $this->db->get_where('user_order',array('order_id'=>$order_id,'payment_status'=>1))->num_rows();

            if($num_rows==1){
                $response['error']='Previous transaction is already in process you cannot do one at a time';
                echo json_encode($response);
                die;
            }
        }
        if(isset($this->session->userdata('login_details')['user_id'])) {
            $user_id=$this->session->userdata('login_details')['user_id'];
        } else {
            $user_id=0;
        }
        $this->load->model('product_m');
        $p_res = $this->product_m->get_product_by_id($data['pid']);
        $prod_quantity = $p_res['quantity'];
        if($data['selectedOpt']!='') {
            $option_res = $this->product_m->get_option_details(array('product_id'=>$data['pid'],'option_id'=>$data['selectedOpt']));
            $prod_quantity = $option_res['option_qty'];
        }

        if($data['qty'] > $prod_quantity) {
            $response['error']='Out of stock';
            echo json_encode($response);
            die;
        }

        $this->db->where('order_id', $order_id);
        if($data['selectedOpt']!='') {
            $this->db->where('option_id', $data['selectedOpt']);
        }
        $this->db->where('product_id', $data['pid']);
        $cart_query= $this->db->get('user_cart');
        if($cart_query->num_rows()>=1) {
            $result = $cart_query->row_array();
            $quantity = $result['quantity']+$data['qty'];
            if($quantity > $prod_quantity) {
                $response['error']='Out of stock';
                echo json_encode($response);
                die;
            }
            $update['quantity']=$quantity;
            $this->db->where('order_id', $order_id);
            $this->db->where('product_id', $data['pid']);
            $this->db->update('user_cart',$update);

        }else{

            $insert['order_id']=$order_id;
            $insert['user_id']=$user_id;
            $insert['product_id']=$data['pid'];

            $insert['product_code']=$p_res['product_code'];
            $insert['product_name']=$p_res['product_name'];
            $insert['product_description']=$p_res['what_is_it'];
            $insert['product_thumb_image']=$p_res['product_thumb_image'];
            $insert['hsn_number']=$p_res['hsn_number'];
            $insert['sgst_name']=(empty($p_res['sgst_tax_name']))?'':$p_res['sgst_tax_name'];
            $insert['sgst_value']=(empty($p_res['sgst_tax_value']))?0:$p_res['sgst_tax_value'];
            $insert['cgst_name']=(empty($p_res['cgst_tax_name']))?'':$p_res['cgst_tax_name'];
            $insert['cgst_value']=(empty($p_res['cgst_tax_value']))?0:$p_res['cgst_tax_value'];

            $insert['quantity']=$data['qty'];

            if($data['selectedOpt']!='' && isset($option_res)){
                $option_id = $data['selectedOpt'];
                $insert['option_id']=$option_id;
                $insert['option_code']=$option_res['option_code'];
                $insert['option_name']=$option_res['option_value_name'];
                $product_option_thumb_images_arr =explode('__&&__',$option_res['product_option_thumb_images']);
                $insert['option_image']=$product_option_thumb_images_arr[0];
                $insert['option_price']=$option_res['selling_price'];
            }else{
                $option_id = 0;
                $insert['product_price']=$p_res['price'];
            }
            $this->db->insert('user_cart',$insert);
            $cart_id = $this->db->insert_id();
            $offer_products = $this->get_offer_products($data['pid'],$option_id);
            if(!empty($offer_products)){
                $insert_offer_prod=array();
                foreach($offer_products as $k=>$v){
                    $insert_offer_prod[$k]['cart_id'] = $cart_id;
                    $insert_offer_prod[$k]['order_id'] = $order_id;
                    $insert_offer_prod[$k]['offer_product_id'] = $v['offer_product_id'];
                    $insert_offer_prod[$k]['offer_option_id'] = $v['offer_option_id'];
                    if($v['offer_option_id']==0){
                        $product_code = $v['product_code'];
                        $product_name = $v['product_name'];
                        $option_name='';
                    }else{
                        $product_code = $v['offer_option_code'];
                        $product_name = $v['product_name'];
                        $option_name = $v['offer_option_name'];
                    }
                    $insert_offer_prod[$k]['offer_product_code'] = $product_code;
                    $insert_offer_prod[$k]['offer_option_name'] = $option_name;
                    $insert_offer_prod[$k]['offer_product_name'] = $product_name;
                    $insert_offer_prod[$k]['offer_product_qty'] = $v['offer_quantity'];
                }
                if(!empty($insert_offer_prod)){
                    $this->db->insert_batch('user_cart_offer_products',$insert_offer_prod);
                }
            }

        }

        $response['cart_total'] = $this->get_cart_total($order_id);
        $response['success'] = 'Added successfully';
        echo json_encode($response);

    }


    public function update_cart_item($cart_id,$cart_qty){
        $this->db->set('quantity', $cart_qty);
        $this->db->where('id', $cart_id);
        $this->db->update('user_cart');
        return true;
    }

    public function update_cart_offer_qty($cart_id,$cart_qty){
        $offer_prod = $this->get_cart_offer_products($cart_id);
        if(!empty($offer_prod)){
            foreach($offer_prod as $k=>$v){
                $this->db->set('offer_product_qty', $v['offer_product_qty']*$cart_qty);
                $this->db->where('id', $v['id']);
                $this->db->update('user_cart_offer_products');
            }
        }
    }

    public function update_product_quantity($product_id, $quantity) {

        foreach($product_id as $key=>$proid) {
            $this->db->where('id', $proid);
            $query= $this->db->get('admin_product');
            $results=$query->row_array();
            $existing_quantity=$results['quantity'];
            $new_quantity=$existing_quantity-$quantity[$key];

            $this->db->set('quantity', $new_quantity);
            $this->db->where('id', $proid);
            $this->db->update('admin_product');
        }

        return true;

    }

    public function update_max_usage_coupon($discountcode) {

        if(!empty($discountcode)) {
            $this->db->where('coupon_code', $discountcode);
            $querytop = $this->db->get('admin_coupon');
            $existused=$querytop->row_array();
            $timesused=$existused['times_used'];
            $timesusednow=$timesused+1;

            $this->db->set('times_used', $timesusednow);
            $this->db->where('coupon_code', $discountcode);
            $this->db->update('admin_coupon');
        }
        return true;

    }

    public function get_cart_offer_products($cart_id){
        $order_id=$this->session->userdata('order_id');
        $this->db->where('order_id', $order_id);
        $this->db->where('cart_id', $cart_id);
        $query = $this->db->get('user_cart_offer_products');
        if($query->num_rows()>=1){
            return $query->result_array();
        }
        return false;
    }


    public function view_cart($order_id='') {
        $this->db->select('a.*,b.coupon_code,c.slug',false);
        $this->db->from('user_cart a');
        $this->db->join('admin_coupon_applied b','a.coupon_applied_id = b.id','left');
        $this->db->join('admin_product c','a.product_id = c.id','left');
        // print_r($this->session->userdata('order_id'));
        // exit();
        if($this->session->userdata('order_id')){
            $order_id=$this->session->userdata('order_id');
        }else{
            $order_id=0;
        }
        $this->db->where('a.order_id', $order_id);
        $query = $this->db->get();
        // echo $this->db->last_query();
        // exit();
        if($query->num_rows()>=1){
            return $query->result_array();
        }
        return false;
    }

    public function view_cart_details($order_id='') {
        $this->db->select('a.*,b.coupon_code,c.slug,c.weight_shipping_single,d.actual_price,d.selling_price,d.weightingrams',false);
        $this->db->from('user_cart a');
        $this->db->join('admin_coupon_applied b','a.coupon_applied_id = b.id','left');
        $this->db->join('admin_product c','a.product_id = c.id','left');
        $this->db->join('admin_product_option_value d','d.product_id = c.id and a.option_id = d.option_id','left');    
        if($this->session->userdata('order_id')){
            $order_id=$this->session->userdata('order_id');
        }else{
            $order_id=0;
        }
        $this->db->where('a.order_id', $order_id);
        $query = $this->db->get();
        // echo $this->db->last_query();
        // exit();
        
        if($query->num_rows()>=1){
            return $query->result_array();
        }
        return false;
    }

     public function coupon_details(){
    $todaydate=date('Y-m-d');
    $array = array('status' => 2, 'valid_from !=' => '0000-00-00', 'valid_to !=' => '0000-00-00', 'valid_from <=' => $todaydate, 'valid_to >='  => $todaydate);
    $this->db->where($array);
    $query = $this->db->get('admin_coupon');
    // echo $this->db->last_query();
        if($query->num_rows()>=1){
            $result=$query->result_array();
            return $result;
        }
       return false;
    }

    public function get_pincode($user_id) {
        $this->db->select('pincode');
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 2);
        $this->db->where('default_address', 1);
        $query = $this->db->get('user_shipping_address');
        if($query->num_rows()>=1){
            $result = $query->row_array();
            return $result['pincode'];
        }
    }
    
    public function get_delivery_cost() {
        $this->db->select('rate');
        $this->db->from('admin_delivery_grams_rate');
        $query = $this->db->get();
        return $query->row_array();
}

public function view_cart_full() {

    $order_id=$this->session->userdata('order_id');
    $this->db->where('order_id', $order_id);
    $this->db->where('status', 2);
    $query = $this->db->get('user_cart');
    if($query->num_rows()>=1){
        return $query->result_array();
    }
}

public function remove_coupon($id){
    $order_id=$this->session->userdata('order_id');
    $this->db->set('coupon_applied_id', 0);
    $this->db->set('coupon_discount', '');
    $this->db->where('order_id', $order_id);
    $this->db->update('user_cart');

    $this->db->from('admin_coupon_applied');
    $this->db->where('id', $id);
    $this->db->delete();
}

public function apply_promo($promo_code) {

    if(isset($this->session->userdata('login_details')['user_id'])) {
        $user_id=$this->session->userdata('login_details')['user_id'];
    } else {
        $user_id=0;
    }
    $order_id=$this->session->userdata('order_id');
    $totalamount=$this->session->userdata('totalamount');

    $payableamount=$totalamount;


    if($payableamount==0) {

        $this->session->set_flashdata('promo_message', "<div class='notify notify-red'><span class='symbol icon-error'></span> Promo code cannot be applied for this price.</div>");
        $this->discountcoderemove();
        return true;
    }

    $this->db->where('coupon_code like binary "'.$promo_code.'"', NULL, FALSE);
    $query = $this->db->get('admin_coupon');
    $queryvaluecnt=$query->num_rows();

    if($queryvaluecnt==0) {

        $this->session->set_flashdata('promo_message', "<div class='notify notify-red'><span class='symbol icon-error'></span> Promo code is Invalid. Please check for spell error!</div>");
        $this->discountcoderemove();

    } else {

        $queryvalue=$query->row_array();
        $valid_from=$queryvalue['valid_from'];
        $valid_to=$queryvalue['valid_to'];
        $discount_type=$queryvalue['discount_type'];
        $discount=$queryvalue['discount'];
        $max_usage=$queryvalue['max_usage'];
        $times_used=$queryvalue['times_used'];
        $todaydate=date("Y-m-d");
        $date=date("Y-m-d H:i:s");

        if($user_id=0) {

            $this->session->set_flashdata('promo_message', "<div class='notify notify-red'><span class='symbol icon-error'></span> Promo code only registered users!</div>");
            $this->discountcoderemove();

        } else {

            if($max_usage<0 && $max_usage<=$times_used) {

                $this->session->set_flashdata('promo_message', "<div class='notify notify-red'><span class='symbol icon-error'></span> Promo code expired!</div>");
                $this->discountcoderemove();

            } else {

                if(($valid_from=='0000-00-00') || ($valid_from=='0000-00-00') || ($valid_from <= $todaydate && $valid_to >= $todaydate)) {

                    if($discount_type=="Percentage") {
                        $discount=$payableamount*$discount/100;
                        $payableamount=$payableamount-$discount;
                    } else {
                        $payableamount=$payableamount-$discount;
                    }

                    $this->session->set_userdata('discount', $discount);

                    $this->db->set('discount_type', $discount_type);
                    $this->db->set('discount_code', $promo_code);
                    $this->db->set('discount_amount', $discount);
                        //$this->db->set('total_amount', $total_discount_price);
                    $this->db->set('updated', $date);
                    $this->db->where('order_id', $order_id);
                    $this->db->update('user_shipping_order');


                    $this->session->set_flashdata('promo_message', "<div class='notify notify-green'><span class='symbol icon-tick'></span> Successfully applied!</div>");

                } else {

                    $this->session->set_flashdata('promo_message', "<div class='notify notify-red'><span class='symbol icon-error'></span> Promo code expired!</div>");
                    $this->discountcoderemove();

                }

            }


        }

    }

    $this->load->model('admin/web_settings_m');
    $web_settings=$this->web_settings_m->get();
    if($web_settings['shipping_cost_applicable']>0 &&$web_settings['shipping_cost'] >0){
        if($payableamount<=$web_settings['shipping_cost_applicable']) {
            $shipping_cost=$web_settings['shipping_cost'];
            $payableamount+=$shipping_cost;
        }
    }
    if(isset($this->session->userdata('login_details')['user_id'])) {
        $this->load->model('rewards_m');
        $reward_points=$this->rewards_m->apply_reward_points();
    } else {
        $reward_points=0;
    }
    if(isset($reward_points) && $reward_points!=0){
        $remaining_amount=$payableamount-$reward_points;
        if($remaining_amount<0){
            $payableamount=$reward_points-$payableamount;
        }else{
            $payableamount=$remaining_amount;
        }
    }

    $this->session->set_userdata('payableamount',$payableamount);

    $this->db->set('payable_amount', $payableamount);
    $this->db->where('order_id', $order_id);
    $this->db->update('user_shipping_order');

    return true;
}

public function discountcoderemove() {

    $order_id=$this->session->userdata('order_id');
    $payableamount=$this->session->userdata('payableamount');
    $date=date("Y-m-d H:i:s");

    $this->session->unset_userdata('discount');
    $this->session->unset_userdata('totaldiscountprice');
    $this->db->set('total_amount', $payableamount);
    $this->db->set('discount_type', "");
    $this->db->set('discount_code', "");
    $this->db->set('discount_amount', "");
    $this->db->set('updated', $date);
    $this->db->where('order_id', $order_id);
    $query=$this->db->update('user_shipping_order');

}

public function delete($id) {

    $this->db->where('id', $id);
    $query=$this->db->get('user_cart');
    $cart_result=$query->row_array();
    $cart_id=$cart_result['id'];

    $this->db->from('user_cart');
    $this->db->where('id', $id);
    $this->db->delete();

    $this->db->from('user_cart_offer_products');
    $this->db->where('cart_id', $id);
    $this->db->delete();

    return true;

}

public function delete_cart_item($id) {

    $this->db->where('id', $id);
    $query=$this->db->get('user_cart');
    $cart_result=$query->row_array();
    $cart_id=$cart_result['id'];

    $this->db->from('user_cart');
    $this->db->where('id', $id);
    $this->db->delete();

    $this->db->from('user_cart_offer_products');
    $this->db->where('cart_id', $id);
    $this->db->delete();

    return true;

}



}
?>