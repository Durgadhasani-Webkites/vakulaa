<?php
Class Products_M extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

    public function similar_word_search($term,$product_arr){
        if(!empty($product_arr)){
            $exact_matched_prod_words=[];
            $similar_matched_prod_words=[];
            if(str_word_count($term)==1){
                foreach ($product_arr as $k=>$v) {
                    $v_arr = explode(' ', $v);
                    foreach ($v_arr as $k1 => $v1) {
                        $v1 = preg_replace("/[^a-zA-Z0-9]/", "", $v1);
                        similar_text(strtolower($term), strtolower($v1), $perc);
                        if ($perc == 100) {
                            $exact_matched_prod_words[0] = $v1;
                            break;
                        } else {
                            if ($perc > 75) {
                                if (!in_array($v1, $similar_matched_prod_words)) {
                                    $similar_matched_prod_words[] = $v1;
                                }
                            }
                        }
                    }
                    if(count($exact_matched_prod_words)>0){
                        break;
                    }
                }
            }else{
                $term_arr = explode(' ',$term);
                foreach($term_arr as $term_val){
                    $ex_mat_num = 0;
                    foreach ($product_arr as $k=>$v) {
                        $v_arr = explode(' ', $v);
                        foreach ($v_arr as $k1 => $v1) {
                            if(empty($ex_mat_num)) {
                                $v1 = preg_replace("/[^a-zA-Z0-9]/", "", $v1);
                                $v1 = strtolower($v1);
                                similar_text(strtolower($term_val), $v1, $perc);

                                if ($perc == 100) {
                                    if (!in_array($v1, $exact_matched_prod_words)) {
                                        $exact_matched_prod_words[] = $v1;
                                        $ex_mat_num = 1;
                                    }
                                } else {
                                    if ($perc > 75) {
                                        if (!in_array($v1, $similar_matched_prod_words)) {
                                            $similar_matched_prod_words[] = $v1;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $matched_prod_words=[];
            if(!empty($exact_matched_prod_words)){
                $matched_prod_words['extract']= $exact_matched_prod_words;
                if(count($exact_matched_prod_words)==str_word_count($term)){
                    return $matched_prod_words;
                }
            }
            if(!empty($similar_matched_prod_words)){
                $matched_prod_words['similar']= $similar_matched_prod_words;
            }
            return $matched_prod_words;
        }
        return false;
    }

    public function get_all($filter_data=array(),$offset='',$limit=''){

        $this->db->select('a.*,(c.option_value_name) as option_name,IF(b.option_id IS NULL,a.quantity,b.option_qty) as stock_quantity,IF(b.option_id IS NULL,a.product_code,b.option_code) as product_option_code,GROUP_CONCAT(e.category_name SEPARATOR " --&&-- ") as categories',false);

        $this->db->from('admin_product a');
        $this->db->join('admin_product_option_value b', 'a.id = b.product_id AND default_option = 1','left');
        $this->db->join('admin_option_value c', 'c.id = b.option_id','left');
        $this->db->join('admin_product_category d', 'd.product_id = a.id','left');
        $this->db->join('admin_category e', 'd.category_id = e.id','left');
        if(!empty($filter_data)){

            if(!empty($filter_data['search'])){
                $search = $filter_data['search'];
                $search='(a.product_name LIKE "%'.$search.'%" OR b.option_code LIKE "%'.$search.'%" OR e.category_name LIKE "%'.$search.'%")';
                $this->db->where($search);

            }

            if(!empty($filter_data['product_name'])){
                $term = trim($filter_data['product_name']);
                $product_arr=array();
                if(!empty($filter_data['product_names'])){
                    foreach($filter_data['product_names'] as $k=>$v){
                        $product_arr[$v['id']]=$v['product_name'];
                    }
                }

                $like ='(FIND_IN_SET("'.$term.'",a.product_tags )> 0';
                // $like .= ' OR a.product_name LIKE "%'.$term.'%"';

                $matched_prod_words = $this->similar_word_search($term,$product_arr);
                // print_r($matched_prod_words);die;
                if(!empty($matched_prod_words['extract']) && !empty($matched_prod_words['similar'])){
                    $like_arr = [];
                    if(!empty($matched_prod_words['extract'])) {
                        foreach ($matched_prod_words['extract'] as $extract_word) {
                            foreach ($matched_prod_words['similar'] as $similar_word) {
                                $like_arr[] = '(a.product_name REGEXP "(^|[[:<:]])' . trim($extract_word) . '([[:>:]]|$)" AND a.product_name REGEXP "(^|[[:<:]])' . trim($similar_word) . '([[:>:]]|$)")';
                            }
                        }
                    }
                    $like.=' OR ('.implode(' OR ',$like_arr).')';

                }else{
                    if(!empty($matched_prod_words['extract'])){
                        $like_arr=[];
                        foreach($matched_prod_words['extract'] as $matched_word){
                            $like_arr[]=' a.product_name REGEXP "(^|[[:<:]])'.trim($matched_word).'([[:>:]]|$)"';
                        }
                        $like.=' OR ('.implode(' AND ',$like_arr).')';
                    }

                    if(!empty($matched_prod_words['similar'])){
                        $like_arr=[];
                        foreach($matched_prod_words['similar'] as $matched_word){
                            $like_arr[]=' a.product_name REGEXP "(^|[[:<:]])'.trim($matched_word).'([[:>:]]|$)"';
                        }
                        $like.=' OR ('.implode(' OR ',$like_arr).')';
                    }
                }


                $term_arr = explode(' ',$term);
                $like_arr=[];
                foreach($term_arr as $term_val){
                    $like_arr[]=' a.product_name REGEXP "(^|[[:space:]])'.trim($term_val).'([[:space:]]|$)"';
                }
                $like.=' OR ('.implode(' AND ',$like_arr).')';
                $like.=')';
                $this->db->where($like);

            }

            if(!empty($filter_data['product_code'])){
                $search = $filter_data['product_code'];
                $search='(a.product_code LIKE "%'.$search.'%" OR b.option_code LIKE "%'.$search.'%")';
                $this->db->where($search);
            }

            if(!empty($filter_data['status'])){
                $this->db->where('a.status',$filter_data['status']);
            }

            if(isset($filter_data['order'])){

                $dir=$filter_data['order']['dir'];

                if($filter_data['order']['column']=='1'){

                    $this->db->order_by('a.product_name',$dir);

                }

                if($filter_data['order']['column']=='2'){

                    $this->db->order_by('stock_quantity',$dir);

                }

                if($filter_data['order']['column']=='3'){

                    $this->db->order_by('TIMESTAMP(a.created)',$dir);
                }

                if($filter_data['order']['column']=='4'){

                    $this->db->order_by('a.status',$dir);

                }

            }

        }

        $this->db->order_by('a.id','desc');

        if(isset($filter_data['stock']) && ($filter_data['stock']=='0')){
            $this->db->having('stock_quantity',0);
        }

        if(isset($filter_data['stock']) && ($filter_data['stock']=='-1')){
            $this->db->having('stock_quantity > ',0);
            $this->db->having('stock_quantity < ',2);
        }

        if(!empty($limit)){

            $this->db->limit($limit,$offset);

        }
        $this->db->group_by('a.id');
        $query = $this->db->get();
       // echo $this->db->last_query();die;

        if ($query->num_rows() > 0) {

            return $query->result_array();

        } else {

            return false;

        }

    }

    public function get_total($filter_data){

        $this->db->select('a.id,IF(b.option_id IS NULL,a.quantity,b.option_qty) as stock_quantity',false);

        $this->db->from('admin_product a');
        $this->db->join('admin_product_option_value b', 'a.id = b.product_id AND default_option = 1','left');
        $this->db->join('admin_option_value c', 'c.id = b.option_id','left');
        $this->db->join('admin_product_category d', 'd.product_id = a.id','left');
        $this->db->join('admin_category e', 'd.category_id = e.id','left');
        if(!empty($filter_data)){

            if(!empty($filter_data['search'])){
                $search = $filter_data['search'];
                $search='(a.product_name LIKE "%'.$search.'%" OR b.option_code LIKE "%'.$search.'%" OR e.category_name LIKE "%'.$search.'%")';
                $this->db->where($search);

            }
            if(!empty($filter_data['product_name'])){
                $term = trim($filter_data['product_name']);
                $product_arr=array();
                if(!empty($filter_data['product_names'])){
                    foreach($filter_data['product_names'] as $k=>$v){
                        $product_arr[$v['id']]=$v['product_name'];
                    }
                }

                $like ='(FIND_IN_SET("'.$term.'",a.product_tags )> 0';
                // $like .= ' OR a.product_name LIKE "%'.$term.'%"';

                $matched_prod_words = $this->similar_word_search($term,$product_arr);
                // print_r($matched_prod_words);die;
                if(!empty($matched_prod_words['extract']) && !empty($matched_prod_words['similar'])){
                    $like_arr = [];
                    if(!empty($matched_prod_words['extract'])) {
                        foreach ($matched_prod_words['extract'] as $extract_word) {
                            foreach ($matched_prod_words['similar'] as $similar_word) {
                                $like_arr[] = '(a.product_name REGEXP "(^|[[:<:]])' . trim($extract_word) . '([[:>:]]|$)" AND a.product_name REGEXP "(^|[[:<:]])' . trim($similar_word) . '([[:>:]]|$)")';
                            }
                        }
                    }
                    $like.=' OR ('.implode(' OR ',$like_arr).')';

                }else{
                    if(!empty($matched_prod_words['extract'])){
                        $like_arr=[];
                        foreach($matched_prod_words['extract'] as $matched_word){
                            $like_arr[]=' a.product_name REGEXP "(^|[[:<:]])'.trim($matched_word).'([[:>:]]|$)"';
                        }
                        $like.=' OR ('.implode(' AND ',$like_arr).')';
                    }

                    if(!empty($matched_prod_words['similar'])){
                        $like_arr=[];
                        foreach($matched_prod_words['similar'] as $matched_word){
                            $like_arr[]=' a.product_name REGEXP "(^|[[:<:]])'.trim($matched_word).'([[:>:]]|$)"';
                        }
                        $like.=' OR ('.implode(' OR ',$like_arr).')';
                    }
                }


                $term_arr = explode(' ',$term);
                $like_arr=[];
                foreach($term_arr as $term_val){
                    $like_arr[]=' a.product_name REGEXP "(^|[[:space:]])'.trim($term_val).'([[:space:]]|$)"';
                }
                $like.=' OR ('.implode(' AND ',$like_arr).')';
                $like.=')';
                $this->db->where($like);

            }

            if(!empty($filter_data['product_code'])){
                $search = $filter_data['product_code'];
                $search='(a.product_code LIKE "%'.$search.'%" OR b.option_code LIKE "%'.$search.'%")';
                $this->db->where($search);
            }
            if(!empty($filter_data['status'])){
                $this->db->where('a.status',$filter_data['status']);
            }

        }
        if(isset($filter_data['stock']) && ($filter_data['stock']=='0')){
            $this->db->having('stock_quantity',0);
        }

        if(isset($filter_data['stock']) && ($filter_data['stock']=='-1')){
            $this->db->having('stock_quantity > ',0);
            $this->db->having('stock_quantity < ',2);
        }
        $this->db->group_by('a.id');
        $query = $this->db->get();

        return $query->num_rows();

    }

    
    public function view() {
      
      $this->db->select('*, a.id as ids, a.created as created, a.status as status');
      $this->db->from('admin_product a');
      $this->db->order_by('a.id', "desc");
      $query = $this->db->get();
      return $query->result_array();
  }

  public function get_out_of_stock_products($limit){
    $this->db->select('a.id,a.product_name,(c.option_value_name) as option_name,IF(b.option_id IS NULL,a.quantity,b.option_qty) as stock_quantity',false);
    $this->db->from('admin_product a');
    $this->db->join('admin_product_option_value b', 'a.id = b.product_id','left');
    $this->db->join('admin_option_value c', 'c.id = b.option_id','left');
    $this->db->having('stock_quantity',0);
    if (!empty($limit)) {
        $this->db->limit($limit);
    }
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
     return $query->result_array();
 }
}

public function get_nearing_out_of_products($limit){
    $this->db->select('a.id,a.product_name,(c.option_value_name) as option_name,IF(b.option_id IS NULL,a.quantity,b.option_qty) as stock_quantity',false);
    $this->db->from('admin_product a');
    $this->db->join('admin_product_option_value b', 'a.id = b.product_id','left');
    $this->db->join('admin_option_value c', 'c.id = b.option_id','left');
    $this->db->having('stock_quantity <= ',2);
    if (!empty($limit)) {
        $this->db->limit($limit);
    }
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
        return $query->result_array();
    }
}


public function categoryview($current_cat_id, $count) {
 
  static $option_results;
  
  if (!isset($current_cat_id)) {
     $current_cat_id = 0;
 }
 
 $count++;
 
 $this->db->where('parent_id', $current_cat_id);
 $this->db->where('status', 1);
 $this->db->order_by('sort_order', 'ASC');
 $query = $this->db->get('admin_category');
 $get_options=$query->result_array();
 if ($query->num_rows() > 0) {
  
     foreach ($get_options as $rows) { 
        $cat_id=$rows['id'];
        $cat_name=$rows['category_name'];
        
        $indent_flag = '';
        if ($current_cat_id != 0) {
           for ($x = 2; $x <= $count; $x++) {
              $indent_flag .=  '&nbsp;&nbsp;&rarr;&nbsp;&nbsp;';
          }
          $indent_flag .=  '';
      }
      
      $option_results[$cat_id] = $indent_flag . $cat_name;
      
      $this->categoryview($cat_id, $count);
  }
  
}

return $option_results;
}

public function get_all_sgst(){
    $this->db->select("*");
    $this->db->from('tax_settings');
    $this->db->where('tax_type', 'SGST');
    $this->db->where('status', 1);
    $query = $this->db->get();
    return $query->result_array();
}

public function get_all_cgst(){
    $this->db->select("*");
    $this->db->from('tax_settings');
    $this->db->where('tax_type', 'CGST');
    $this->db->where('status', 1);
    $query = $this->db->get();
    return $query->result_array();
}

public function filterview() {
	
  $this->db->select("*");
  $this->db->from('admin_filter_group a');
  $this->db->join('admin_filter b', 'a.id=b.filter_group_id');
  $this->db->where('a.status', 2);
  $query = $this->db->get();
  return $query->result_array();
  
}

public function attributeview() {
	
  $this->db->select("*");
  $this->db->from('admin_attribute_group a');
  $this->db->join('admin_attribute b', 'a.id=b.attribute_group_id');
  $this->db->where('a.status', 2);
  $query = $this->db->get();
  return $query->result_array();
  
}

public function optionview() {
	
  $this->db->from('admin_option');
  $this->db->where('status', 2);
  $query = $this->db->get();
  return $query->result_array();
  
}

public function vendorsview() {
	
  $this->db->from('admin_vendor');
  $this->db->where('status', 2);
  $query = $this->db->get();
  return $query->result_array();
}

public function get_product_options(){
    $this->db->from('admin_option_value');
    $this->db->where('option_id', 1);
    $this->db->where('status', 2);
    $query = $this->db->get();
    return $query->result_array();
}

public function get_offer_products($product_id){
    $this->db->select('a.product_option_id,b.option_value_name,a.offer_product_id,c.product_name as offer_product_name,a.offer_option_id,d.option_value_name as offer_option_name,a.offer_quantity');
    $this->db->from('admin_offer_products a');
    $this->db->join('admin_option_value b','a.product_option_id = b.id','left');
    $this->db->join('admin_product c','a.offer_product_id = c.id','left');
    $this->db->join('admin_option_value d','a.offer_option_id = d.id','left');
    $this->db->where('a.product_id', $product_id);
    $query = $this->db->get();
    return $query->result_array();
}

public function open_options($id) {
	
  $this->db->from('admin_option_value');
  $this->db->where('option_id', $id);
  $this->db->where('status', 2);
  $query = $this->db->get();
  return $query->result_array();
  
}

public function get_all_products($filter_data = array(), $offset = '', $limit = ''){
    $this->db->select('a.id,a.product_name');
    $this->db->from('admin_product a');
    if (isset($filter_data['search'])) {
        $search = '(a.product_name LIKE "%' . $filter_data['search'] . '%")';
        $this->db->where($search);
    }
    if(!empty($filter_data['product_id'])){
        $this->db->where('a.id', $filter_data['product_id']);
    }
    $this->db->where('a.status', 2);
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

public function get_total_products($filter_data)
{
    $this->db->select('a.id');
    $this->db->from('admin_product a');
    if (!empty($filter_data)) {
        if (isset($filter_data['search'])) {
            $search = '(a.product_name LIKE "%' . $filter_data['search'] . '%")';
            $this->db->where($search);
        }
    }
    if(!empty($filter_data['product_id'])){
        $this->db->where('a.id', $filter_data['product_id']);
    }
    $this->db->where('a.status', 2);
    $query = $this->db->get();
    return $query->num_rows();
}

public function get_all_options($filter_data = array(), $offset = '', $limit = ''){
    $this->db->select('a.id,a.option_value_name');
    $this->db->from('admin_option_value a');
    if (isset($filter_data['search'])) {
        $search = '(a.option_value_name LIKE "%' . $filter_data['search'] . '%")';
        $this->db->where($search);
    }
    if(!empty($filter_data['option_id'])){
        $this->db->where('a.option_id', $filter_data['option_id']);
    }
    $this->db->where('a.status', 2);
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

public function get_total_options($filter_data)
{
    $this->db->select('a.id');
    $this->db->from('admin_option_value a');
    if (!empty($filter_data)) {
        if (isset($filter_data['search'])) {
            $search = '(a.option_value_name LIKE "%' . $filter_data['search'] . '%")';
            $this->db->where($search);
        }
    }
    if(!empty($filter_data['option_id'])){
        $this->db->where('a.option_id', $filter_data['option_id']);
    }
    $this->db->where('a.status', 2);
    $query = $this->db->get();
    return $query->num_rows();
}


public function get_all_product_options($filter_data = array(), $offset = '', $limit = ''){
    $this->db->select('b.id,b.option_value_name');
    $this->db->from('admin_product_option_value a');
    $this->db->join('admin_option_value b','a.option_id = b.id','left');
    if (isset($filter_data['search'])) {
        $search = '(b.option_value_name LIKE "%' . $filter_data['search'] . '%")';
        $this->db->where($search);
    }
    if(!empty($filter_data['product_id'])){
        $this->db->where('a.product_id', $filter_data['product_id']);
    }
    if(!empty($filter_data['option_id'])){
        $this->db->where('a.option_id', $filter_data['option_id']);
    }
    $this->db->where('b.status', 2);
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

public function get_total_product_options($filter_data)
{
    $this->db->select('b.id');
    $this->db->from('admin_product_option_value a');
    $this->db->join('admin_option_value b','a.option_id = b.id','left');
    if (!empty($filter_data)) {
        if (isset($filter_data['search'])) {
            $search = '(b.option_value_name LIKE "%' . $filter_data['search'] . '%")';
            $this->db->where($search);
        }
    }
    if(!empty($filter_data['product_id'])){
        $this->db->where('a.product_id', $filter_data['product_id']);
    }
    if(!empty($filter_data['option_id'])){
        $this->db->where('a.option_id', $filter_data['option_id']);
    }
    $this->db->where('b.status', 2);
    $query = $this->db->get();
    return $query->num_rows();
}


public function add($postdetails) {
  if($postdetails['product_name']!="") {
   
      $date=date("Y-m-d H:i:s");
      $option['product_name']=$postdetails['product_name'];
      $option['slug']=url_title(strtolower($_POST['product_name']));
      $option['product_code']=$postdetails['product_code'];
      $option['detailpage_heading1']='What is it?';
      if(!empty($postdetails['detailpage_heading1'])){
        $option['detailpage_heading1']=$postdetails['detailpage_heading1'];
    }
    $option['what_is_it']=$postdetails['what_is_it'];
    $option['detailpage_heading2']='What is contains?';
    if(!empty($postdetails['detailpage_heading2'])){
        $option['detailpage_heading2']=$postdetails['detailpage_heading2'];
    }
    $option['what_is_contains']=$postdetails['what_is_contains'];
    $option['detailpage_heading3']='How to prepare?';
    if(!empty($postdetails['detailpage_heading3'])){
        $option['detailpage_heading3']=$postdetails['detailpage_heading3'];
    }
    $option['how_to_prepare']=$postdetails['how_to_prepare'];
        // $option['meetthecurator']=$postdetails['meetcurator'];
    $option['meta_title']=$postdetails['meta_title'];
    $option['meta_description']=$postdetails['meta_description'];
    $option['meta_keyword']=$postdetails['meta_keywords'];
    if(!empty($postdetails['hidden-tags'])){
        $option['product_tags']=$postdetails['hidden-tags'];
        $option['seo_keyword']=$postdetails['hidden-tags'];
    }
    if(!empty($postdetails['tags'])){
        $option['product_tags']=$postdetails['tags'];
        $option['seo_keyword']=$postdetails['tags'];
    }

    if(isset($postdetails['product_image'])) {
     $option['product_image']=$postdetails['product_image'];
 }
 if(isset($postdetails['product_thumb_image'])) {
    $option['product_thumb_image']=$postdetails['product_thumb_image'];
}

if(isset($postdetails['product_medium_image'])) {
    $option['product_medium_image']=$postdetails['product_medium_image'];
}

$option['hsn_number']=$postdetails['hsn_number'];

$option['sgst']=$postdetails['sgst'];
if (empty($data['sgst'])) {
    $option['sgst'] = 0;
}
$option['cgst']=$postdetails['cgst'];
if (empty($data['cgst'])) {
    $option['cgst'] = 0;
}
$option['price']=$postdetails['price'];
$option['actual_price_single']=$postdetails['actual_price_single'];
if(isset($postdetails['is_product_variable'])) {
    $option['is_product_variable']=$postdetails['is_product_variable'];
}
        // $option['weight']=$postdetails['weight'];
        // $option['weight_class']=$postdetails['weight_class'];
        // $option['weight_price']=$postdetails['weight_price'];
$option['quantity']=$postdetails['quantity'];
$option['weight_shipping_single']=$postdetails['weight_shipping_single'];
$option['stock']=$postdetails['stock'];
 
$option['sort_order']=$postdetails['sort_order'];

if(!empty($postdetails['coupon'])) {
    $option['coupon']=implode(',',$postdetails['coupon']);
}
$option['created']=$date;
$option['status']=$postdetails['status'];

$this->db->insert('admin_product', $option);
$productid=$this->db->insert_id();

if(!empty($postdetails['categories'])) {
    $category=$postdetails['categories'];
    $i=0;
    foreach($category as $value) {
       $optionarray1[$i]['product_id']=$productid;
       $optionarray1[$i]['category_id']=$value;
       $i++;
   }
   if(!empty($optionarray1)) {
       $this->db->insert_batch('admin_product_category', $optionarray1);
   }
}

if(!empty($postdetails['filters'])) {
    $filters=$postdetails['filters'];
    $j=0;
    foreach($filters as $value) {
       $optionarray2[$j]['product_id']=$productid;
       $filtersexp=explode("_", $value);
       $optionarray2[$j]['filter_group_id']=$filtersexp[0];
       $optionarray2[$j]['filter_id']=$filtersexp[1];
       $optionarray2[$j]['filter_group_id_filter_id']=$value;
       $j++;
   }
   if(!empty($optionarray2)) {
       $this->db->insert_batch('admin_product_filter', $optionarray2);
   }
}


if(!empty($postdetails['attribute_label'])) {
    $filteroption=$postdetails['attribute_label'];
    $k=0;
    foreach($filteroption as $key=>$value) {
        if($value!='' && $postdetails['attribute_desc'][$key]){
            $optionarray3[$k]['product_id']=$productid;
            $filtersexp=explode("_", $value);
            $optionarray3[$k]['attribute_group_id']=$filtersexp[0];
            $optionarray3[$k]['attribute_id']=$filtersexp[1];
            $optionarray3[$k]['attribute_text']=$postdetails['attribute_desc'][$key];
            $k++;
        }
    }
    if(!empty($optionarray3)) {
       $this->db->insert_batch('admin_product_attribute', $optionarray3);
   }
}


if(!empty($postdetails['option'])) {

    $option1['option_id']=$postdetails['option'];
    $option1['product_id']=$productid;
    $this->db->insert('admin_product_option', $option1);
    $optionidtop=$this->db->insert_id();

    if(!empty($postdetails['product_option'])){
        foreach($postdetails['product_option'] as $k=>$v){
            $product_option_arr[$k]['product_id']=$productid;
            $product_option_arr[$k]['product_option_id']=$optionidtop;
            $product_option_arr[$k]['availability']=$v['availability'];
            $product_option_arr[$k]['option_code']=$v['option_code'];
            $product_option_arr[$k]['hsn_number']=$v['hsn_number'];
            $product_option_arr[$k]['option_qty']=$v['option_qty'];
            $product_option_arr[$k]['weightingrams']=$v['weightingrams'];
            $product_option_arr[$k]['default_option']=$v['default_option'];
            $product_option_arr[$k]['option_id']=$v['option_id'];
            $product_option_arr[$k]['product_option_images']=$v['product_option_images'];
            $product_option_arr[$k]['product_option_thumb_images']=$v['product_option_thumb_images'];
            $product_option_arr[$k]['product_option_medium_images']=$v['product_option_medium_images'];
            $product_option_arr[$k]['actual_price']=$v['actual_price'];
            $product_option_arr[$k]['selling_price']=$v['selling_price'];

        }
        if(!empty($product_option_arr)){
            $this->db->from('admin_product_option_value');
            $this->db->where('product_id', $productid);
            $this->db->delete();

            $this->db->insert_batch('admin_product_option_value', $product_option_arr);
        }
    }
}

if(!($postdetails['orig_image']) and $postdetails['orig_image']!="") {
    $orig_image=$postdetails['orig_image'];
    $medium_image=$postdetails['medium_image'];
    $small_image=$postdetails['small_image'];
    $image_order=$postdetails['product_image_order'];
    $orig_imagecnt=count($orig_image);
    for($m=0; $m<$orig_imagecnt; $m++) {
        $imgarray[$m]['product_id']=$productid;
        $imgarray[$m]['image']=$orig_image[$m];
        $imgarray[$m]['medium_image']=$medium_image[$m];
        $imgarray[$m]['small_image']=$small_image[$m];
        $imgarray[$m]['sort_order']=$image_order[$m];
    }
    if(!empty($imgarray)){
        $this->db->insert_batch('admin_product_image', $imgarray);
    }

}

if(!empty($postdetails['offer_option_id'])){
    $insert_batch=array();
    foreach($postdetails['offer_option_id'] as $k=>$v) {
        if(!empty($v) && !empty($postdetails['offer_product_id'][$k]) && !empty($postdetails['offer_quantity'][$k]))
            $insert_batch[$k]['product_id'] = $productid;
        $insert_batch[$k]['product_option_id'] = $postdetails['product_option_id'][$k];
        $insert_batch[$k]['offer_product_id'] = $postdetails['offer_product_id'][$k];
        $insert_batch[$k]['offer_option_id'] = $postdetails['offer_option_id'][$k];
        $insert_batch[$k]['offer_quantity'] = $postdetails['offer_quantity'][$k];
    }
    if(!empty($insert_batch)){
        $this->db->insert_batch('admin_offer_products', $insert_batch);
    }
}

return true;
}

}

	//-----------------------------

public function editview($id) {
	
  $this->db->where('id', $id);
  $query = $this->db->get('admin_product');
  if ($query->num_rows() > 0) {
     return $query->result_array();
 } else {
     redirect('adminadmin/index/dashboard');
 }
 
}

public function categoryview_exists($id) {
	
  $this->db->where('product_id', $id);
  $query = $this->db->get('admin_product_category');
  return $query->result_array();
  
}

public function filterview_exists($id) {
	
  $this->db->where('product_id', $id);
  $query = $this->db->get('admin_product_filter');
  return $query->result_array();
  
}

public function attributeview_exists($id) {
	
  $this->db->where('product_id', $id);
  $query = $this->db->get('admin_product_attribute');
  return $query->result_array();
  
}

public function optionview_exists($id) {
	
  $this->db->where('product_id', $id);
  $query = $this->db->get('admin_product_option');
  return $query->result_array();
  
}

public function open_optionsedit($id) {
	
  $this->db->from('admin_option_value');
  $this->db->where('option_id', $id);
  $this->db->where('status', 2);
  $query = $this->db->get();
  return $query->result_array();
  
}

public function get_offer_options($product_id){
    $this->db->select('b.id,b.option_value_name');
    $this->db->from('admin_product_option_value a');
    $this->db->join('admin_option_value b','a.option_id = b.id','left');
    $this->db->where('a.product_id', $product_id);
    $query = $this->db->get();
    return $query->result_array();
}

public function open_optionsedit_exists($optid) {
  $this->db->from('admin_product_option_value');
  $this->db->where('product_option_id', $optid);
  $query = $this->db->get();
  return $query->result_array();
  
}

public function discount_view_exists($id) {
	
  $this->db->where('product_id', $id);
  $query = $this->db->get('admin_product_discount');
  return $query->result_array();
  
}

public function image_view_exists($id) {
	
  $this->db->where('product_id', $id);
  $query = $this->db->get('admin_product_image');
  return $query->result_array();
  
}

public function edit($postdetails) {
  if($postdetails['proid']!="") {
      
     $productid=$postdetails['proid'];
     $date=date("Y-m-d H:i:s");
     
     $option['product_name']=$postdetails['product_name'];
     $option['slug']=url_title(strtolower($_POST['product_name']));
     $option['product_code']=$postdetails['product_code'];
     $option['detailpage_heading1']='What is it?';
     if(!empty($postdetails['detailpage_heading1'])){
        $option['detailpage_heading1']=$postdetails['detailpage_heading1'];
    }
    $option['what_is_it']=$postdetails['what_is_it'];
    $option['detailpage_heading2']='What is contains?';
    if(!empty($postdetails['detailpage_heading2'])){
        $option['detailpage_heading2']=$postdetails['detailpage_heading2'];
    }
    $option['what_is_contains']=$postdetails['what_is_contains'];
    $option['detailpage_heading3']='How to prepare?';
    if(!empty($postdetails['detailpage_heading3'])){
        $option['detailpage_heading3']=$postdetails['detailpage_heading3'];
    }
    $option['how_to_prepare']=$postdetails['how_to_prepare'];
    $option['meta_title']=$postdetails['meta_title'];
    $option['meta_description']=$postdetails['meta_description'];
    $option['meta_keyword']=$postdetails['meta_keywords'];
    $option['weight_shipping_single']=$postdetails['weight_shipping_single']; 
    $option['hsn_number']=$postdetails['hsn_number'];
    $option['sgst']=$postdetails['sgst'];
    if (empty($postdetails['sgst'])) {
        $option['sgst'] = 0;
    }
    $option['cgst']=$postdetails['cgst'];
    if (empty($postdetails['cgst'])) {
        $option['cgst'] = 0;
    }
    $option['price']=$postdetails['price'];
    $option['actual_price_single']=$postdetails['actual_price_single'];
    $option['is_product_variable']=0;
    if(isset($postdetails['is_product_variable'])) {
        $option['is_product_variable']=$postdetails['is_product_variable'];
    }
            // $option['weight']=$postdetails['weight'];
            // $option['weight_class']=$postdetails['weight_class'];
            // $option['weight_price']=$postdetails['weight_price'];
    $option['quantity']=$postdetails['quantity'];
    $option['stock']=$postdetails['stock'];
    $option['sort_order']=$postdetails['sort_order'];
    $option['updated']=$date;
    $option['status']=$postdetails['status'];

    if(isset($postdetails['product_image'])) {
        $option['product_image']=$postdetails['product_image'];
    }

    if(isset($postdetails['product_thumb_image'])) {
        $option['product_thumb_image']=$postdetails['product_thumb_image'];
    }

    if(isset($postdetails['product_medium_image'])) {
        $option['product_medium_image']=$postdetails['product_medium_image'];
    }

    if(isset($postdetails['product_brand'])){
        $option['product_brand']=$postdetails['product_brand'];
    }

    if(!empty($postdetails['hidden-tags'])){
        $option['product_tags']=$postdetails['hidden-tags'];
        $option['seo_keyword']=$postdetails['hidden-tags'];
    }

    if(!empty($postdetails['tags'])) {
        $option['product_tags'] = $postdetails['tags'];
        $option['seo_keyword'] = $postdetails['tags'];
    }

    if(!empty($postdetails['coupon'])) {
        $option['coupon']=implode(',',$postdetails['coupon']);
    }

    $this->db->where('id', $productid);
    $this->db->update('admin_product', $option);
    
    if(isset($postdetails['categories'])) {
       $this->db->where('product_id', $productid);
       $this->db->delete('admin_product_category');
       $category=$postdetails['categories'];
       $i=0;
       foreach($category as $value) {
          $optionarray1[$i]['product_id']=$productid;
          $optionarray1[$i]['category_id']=$value;
          $i++;
      }
      if(!empty($optionarray1)) {
          $this->db->insert_batch('admin_product_category', $optionarray1);
      }
  }
  
  if(isset($postdetails['filters'])) {
   $this->db->where('product_id', $productid);
   $this->db->delete('admin_product_filter');
   $filters=$postdetails['filters'];
   $j=0;
   foreach($filters as $value) {
      $optionarray2[$j]['product_id']=$productid;
      $filtersexp=explode("_", $value);
      $optionarray2[$j]['filter_group_id']=$filtersexp[0];
      $optionarray2[$j]['filter_id']=$filtersexp[1];
      $optionarray2[$j]['filter_group_id_filter_id']=$value;
      $j++;
  }
  if(!empty($optionarray2)) {
      $this->db->insert_batch('admin_product_filter', $optionarray2);
  }
}

if(isset($postdetails['attribute_label'])) {
    $this->db->where('product_id', $productid);
    $this->db->delete('admin_product_attribute');

    $filteroption=$postdetails['attribute_label'];

    $k=0;
    foreach($filteroption as $key=>$value) {
        if($value!='' && $postdetails['attribute_desc'][$key]){
            $optionarray3[$k]['product_id']=$productid;
            $filtersexp=explode("_", $value);
            $optionarray3[$k]['attribute_group_id']=$filtersexp[0];
            $optionarray3[$k]['attribute_id']=$filtersexp[1];
            $optionarray3[$k]['attribute_text']=$postdetails['attribute_desc'][$key];
            $k++;
        }

    }
    if(!empty($optionarray3)) {
        $this->db->insert_batch('admin_product_attribute', $optionarray3);
    }
}

if(!empty($postdetails['option'])) {
    
   $this->db->where('product_id', $productid);
   $querysel = $this->db->get('admin_product_option');
   $queryselcnt=$querysel->num_rows();
   
   if($queryselcnt==0 or $queryselcnt=="") {
      $option1['option_id']=$postdetails['option'];
      $option1['product_id']=$productid;
      $this->db->insert('admin_product_option', $option1);
      $optionidtop=$this->db->insert_id();
  } else {
      $option1['option_id']=$postdetails['option'];
      $this->db->where('product_id', $productid);
      $this->db->update('admin_product_option', $option1);
      $optionidtop=$postdetails['idopt'];
  }

  if(!empty($postdetails['product_option'])){
    foreach($postdetails['product_option'] as $k=>$v){
        $product_option_arr[$k]['product_id']=$productid;
        $product_option_arr[$k]['product_option_id']=$optionidtop;
        $product_option_arr[$k]['availability']=$v['availability'];
        $product_option_arr[$k]['option_code']=$v['option_code'];
        $product_option_arr[$k]['hsn_number']=$v['hsn_number'];
        $product_option_arr[$k]['option_qty']=$v['option_qty'];
        $product_option_arr[$k]['weightingrams']=$v['weightingrams'];
        $product_option_arr[$k]['default_option']=$v['default_option'];
        $product_option_arr[$k]['option_id']=$v['option_id'];
        $product_option_arr[$k]['product_option_images']=$v['product_option_images'];
        $product_option_arr[$k]['product_option_thumb_images']=$v['product_option_thumb_images'];
        $product_option_arr[$k]['product_option_medium_images']=$v['product_option_medium_images'];
        $product_option_arr[$k]['actual_price']=$v['actual_price'];
        $product_option_arr[$k]['selling_price']=$v['selling_price'];

    }
    if(!empty($product_option_arr)){
        $this->db->from('admin_product_option_value');
        $this->db->where('product_id', $productid);
        $this->db->delete();

        $this->db->insert_batch('admin_product_option_value', $product_option_arr);
    }
}
} else {
   
   $this->db->from('admin_product_option');
   $this->db->where('product_id', $productid);
   $this->db->delete();
   
   $this->db->from('admin_product_option_value');
   $this->db->where('product_id', $productid);
   $this->db->delete();
   
}


if(isset($postdetails['orig_image']) and $postdetails['orig_image']!="") {
   $orig_image=$postdetails['orig_image'];
   $medium_image=$postdetails['medium_image'];
   $thumb_image=$postdetails['thumb_image'];
   $image_order=$postdetails['product_image_order'];
   $orig_imagecnt=count($orig_image);
   for($m=0; $m<$orig_imagecnt; $m++) {
      $imgarray[$m]['product_id']=$productid;
      $imgarray[$m]['image']=$orig_image[$m];
      $imgarray[$m]['medium_image']=$medium_image[$m];
      $imgarray[$m]['thumb_image']=$thumb_image[$m];
      $imgarray[$m]['sort_order']=$image_order[$m];
  }
  if(!empty($imgarray)){
    $this->db->insert_batch('admin_product_image', $imgarray);
}

}

if(!empty($postdetails['offer_product_id'])){
    $insert_batch=array();
    foreach($postdetails['offer_product_id'] as $k=>$v) {
        if(!empty($v) &&!empty($postdetails['offer_quantity'][$k])){
            $insert_batch[$k]['product_id'] = $productid;
            $insert_batch[$k]['product_option_id'] = $postdetails['product_option_id'][$k];
            $insert_batch[$k]['offer_product_id'] = $v;
            $insert_batch[$k]['offer_option_id'] = $postdetails['offer_option_id'][$k];
            $insert_batch[$k]['offer_quantity'] = $postdetails['offer_quantity'][$k];
        }
    }
    if(!empty($insert_batch)){
        $this->db->from('admin_offer_products');
        $this->db->where('product_id', $productid);
        $this->db->delete();
        $this->db->insert_batch('admin_offer_products', $insert_batch);
    }
}

return true;

} else {
  
 return false;
 
}
}

public function delete($id) {
	
  $this->db->from('admin_product');
  $this->db->where('id', $id);
  $this->db->delete();
  
  $tablesdelete = array('admin_product_attribute', 'admin_product_category', 'admin_product_discount', 'admin_product_filter', 'admin_product_image', 'admin_product_option', 'admin_product_option_value');
  $this->db->where('product_id', $id);
  $this->db->delete($tablesdelete);

  return true;
  
}

public function deactivate($id) {
	
  $status=1;
  $this->db->set('status', $status);
  $this->db->where('id', $id);
  $this->db->update('admin_product');
  return true;
  
}

public function activate($id) {
	
  $status=2;
  $this->db->set('status', $status);
  $this->db->where('id', $id);
  $this->db->update('admin_product');
  return true;
}


public function remove_attribute($id) {
	
  $this->db->from('admin_product_attribute');
  $this->db->where('id', $id);
  $this->db->delete();
  return true;
  
}

public function remove_image($id) {
	
  $this->db->from('admin_product_image');
  $this->db->where('id', $id);
  $this->db->delete();
  echo 'true';
  
}


public function multi_activate() {

    if(empty($_POST['id'])){
        return false;
    }
    $this->db->set('status', 2);
    $this->db->where_in('id', $_POST['id']);
    $query = $this->db->update('admin_product');
    if($query){
        $this->session->set_flashdata('notify_success',"Activated successfully!");
        return true;
    }
    $this->session->set_flashdata('notify_error',"Error in activating data!");
    return false;
}

public function multi_deactivate() {

    if(empty($_POST['id'])){
        return false;
    }
    $this->db->set('status', 1);
    $this->db->where_in('id', $_POST['id']);
    $query = $this->db->update('admin_product');
    if($query){
        $this->session->set_flashdata('notify_success',"Deactivated successfully!");
        return true;
    }
    $this->session->set_flashdata('notify_error',"Error in deactivating data!");
    return false;
}

public function multi_delete() {
    if(empty($_POST['id'])){
        $this->session->set_flashdata('notify_error',"Error in deleting data!");
        return false;
    }
    $id=$_POST['id'];

    $this->db->from('admin_product');
    $this->db->where_in('id', $id);
    $this->db->delete();

    $this->session->set_flashdata('notify_success',"Successfully deleted!");
    return true;
}

}
?>