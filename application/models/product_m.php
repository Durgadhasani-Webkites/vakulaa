<?php
Class Product_M extends CI_Model
{
    public function __construct(){
        parent::__construct();
    }

    public function pincode_check_db($pincode)
    {
        $this->db->where('pincode',$pincode);
        $query = $this->db->get('shipping');
        
        if ($query->num_rows() > 0){
            return true;
        }
        else{
            return false;
        }
    } 

    public function get_searched_products($filter,$cat){
        $this->db->select('a.id as product_id,a.slug,a.price as product_price,a.product_code,a.product_name,a.product_image,a.product_thumb_image,a.product_medium_image,d.discount_type,d.discount_price,d.start_date,d.end_date,f.tax_value as state_tax_value,g.tax_value as central_tax_value,h.selling_price as option_price,IF(h.option_id IS NULL,a.price,h.selling_price) as prod_price,IF(h.option_id IS NULL,a.quantity,h.option_qty) as stock_quantity',false);
        $this->db->from('admin_product a');
        $this->db->join('admin_product_category b', 'a.id = b.product_id', 'left');
        $this->db->join('admin_product_filter c', 'a.id = c.product_id', 'left');
        $this->db->join('admin_product_discount d', 'a.id = d.product_id', 'left');
        $this->db->join('admin_category e', 'e.id = b.category_id', 'left');
        $this->db->join('tax_settings f', 'f.id = a.sgst', 'left');
        $this->db->join('tax_settings g', 'g.id = a.cgst', 'left');
        $this->db->join('admin_product_option_value h', 'h.product_id = a.id AND default_option=1', 'left');
        $this->db->where('a.status',2);

        if(!empty($filter['search_term'])){
            $term = trim($filter['search_term']);
            $product_arr=array();
            if(!empty($filter['product_names'])){
                foreach($filter['product_names'] as $k=>$v){
                    $product_arr[$v['id']]=$v['product_name'];
                }
            }

            $like ='(FIND_IN_SET("'.$term.'",a.product_tags )> 0';
            //$like .= ' OR a.product_name LIKE "%'.$term.'%"';
            $this->load->model('index_m');
            $matched_prod_words = $this->index_m->similar_word_search($term,$product_arr);
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
        if(!empty($cat) && $cat!='all'){
            $this->db->where('c.category_id',$cat);
        }
        $this->db->group_by('b.product_id');
        $this->db->order_by('a.sort_order','ASC');
        $this->db->having('stock_quantity > 0');
        $this->db->limit(10);
        //$this->db->where('MATCH (a.product_name) AGAINST ("'.$term.'" IN BOOLEAN MODE)',false);

        $query= $this->db->get();
       // echo $this->db->last_query();die;
        if($query->num_rows()>=1){
            return $query->result_array();
        }
        return false;
    }

    public function get_product_images($product_id){
        $this->db->where_in('product_id',$product_id);
        $query= $this->db->get('admin_product_image');
        if($query->num_rows()>=1){
            return $query->result_array();
        }
        return false;
    }

    public function get_related_images($category_id){
        $this->db->select('');
        $this->db->where('parent_id','0');
        $this->db->where('id !=',$category_id);
        $this->db->where('category_slider_image !=','');
        $this->db->limit(8);
        $query= $this->db->get('admin_category');
        return $query->result_array();
    }

    public function get_product_detail($slug){
        $this->db->from('admin_product a');
        $this->db->join('admin_product_category b', 'b.product_id = a.id');
        $this->db->where('a.slug',$slug);
        $query = $this->db->get();
       // echo $this->db->last_query();
        if($query->num_rows()>=1){
            $row =$query->row_array();
            $this->db->select('h.id as attr_gr_id,h.attribute_group_name,i.id as attr_id,i.attribute_name,g.attribute_text');
            $this->db->from('admin_product_attribute g');
            $this->db->join('admin_attribute_group h', 'h.id = g.attribute_group_id', 'left');
            $this->db->join('admin_attribute i', 'i.id = g.attribute_id', 'left');
            $this->db->where('g.product_id', $row['id']);
            $query = $this->db->get();
            if($query->num_rows()>=1){
                $results=$query->result_array();
                $specifications_arr=array();
                foreach($results as $k=>$v){
                    $specifications_arr[$v['attribute_group_name']][]=$v['attribute_name'].'-&-'.$v['attribute_text'];
                }
                if(!empty($specifications_arr)){
                    $row['specification']=$specifications_arr;
                }

            }
            return $row;
        }
        return false;
    }

    // public function getbrandimage($id) {
    //     if(is_array($id)){
    //         $this->db->where_in('id', $id);
    //     }else{
    //         $this->db->where('id', $id);
    //     }
    //     $query = $this->db->get('admin_brands');
    //     if ($query->num_rows() > 0) {
    //         if(is_array($id)){
    //             return $query->result_array();
    //         }else{
    //             return $query->row_array();
    //         }
    //     }
    //     return false;
    // }

    public function get_product_by_option($product_id,$option_id){
        $this->db->select("a.*");
        $this->db->from('admin_product_option_value a');
        $this->db->where('a.product_id', $product_id);
        $this->db->where('a.option_id', $option_id);
        $query = $this->db->get();
        if($query->num_rows()>=1){
            return $query->row_array();
        }else{
            return false;
        }
    }

    public function get_product_by_id($id){
        $this->db->select("a.*,b.category_id,c.tax_name as sgst_tax_name,c.tax_value as sgst_tax_value,d.tax_name as cgst_tax_name,d.tax_value as cgst_tax_value");
        $this->db->from('admin_product a');
        $this->db->join('admin_product_category b', 'b.product_id = a.id');
        $this->db->join('tax_settings c', 'c.id = a.sgst', 'left');
        $this->db->join('tax_settings d', 'd.id = a.cgst', 'left');
        $this->db->where('a.id',$id);
        $this->db->order_by('b.category_id','desc');
        $query = $this->db->get('');
        if($query->num_rows()>=1){
            return $query->row_array();
        }else{
            return false;
        }
    }

    public function get_related_products($product_id,$category_id){
        $this->db->select("a.category_id,b.*,c.tax_value as state_tax_value,d.tax_value as central_tax_value");
        $this->db->from('admin_product_category a');
        $this->db->join('admin_product b', 'a.product_id = b.id');
        $this->db->join('tax_settings c', 'c.id = b.sgst', 'left');
        $this->db->join('tax_settings d', 'd.id = b.cgst', 'left');
        $this->db->where('a.product_id != ', $product_id);
        $this->db->where('a.category_id', $category_id);
        $this->db->where('b.status', 2);
        $this->db->limit(8);
        $query = $this->db->get();
        if($query->num_rows()> 0){
            $result =  $query->result_array();
            return $result;
        }
        return false;
    }

    public function get_latest_offer_products($product_id,$category_id){
        $this->db->select("a.category_id,b.*,c.tax_value as state_tax_value,d.tax_value as central_tax_value");
        $this->db->from('admin_product_category a');
        $this->db->join('admin_product b', 'a.product_id = b.id');
        $this->db->join('tax_settings c', 'c.id = b.sgst', 'left');
        $this->db->join('tax_settings d', 'd.id = b.cgst', 'left');
        $this->db->where('a.product_id != ', $product_id);
        $this->db->where('a.category_id', $category_id);
        // $this->db->where('b.latest_offers', 1);
        $this->db->limit(8);
        $query = $this->db->get();
        if($query->num_rows()> 0){
            $result =  $query->result_array();
            return $result;
        }
        return false;
    }

    public function get_offer_products($filter){
        $this->db->select("d.product_name,e1.option_value_name,a.offer_quantity");
        $this->db->from('admin_offer_products a');
        $this->db->join('admin_product_option_value b', 'a.product_option_id = b.option_id AND a.product_id = b.product_id AND b.availability = "Yes"','left');
        $this->db->join('admin_product d', 'a.offer_product_id=d.id','left');
        $this->db->join('admin_product_option_value e', 'a.offer_option_id = e.option_id AND a.offer_product_id = e.product_id AND e.availability = "Yes"','left');
        $this->db->join('admin_option_value e1', 'e.option_id = e1.id','left');
        $this->db->where('a.product_id', $filter['product_id']);
        if(isset($filter['option_id'])){
            $this->db->where('a.product_option_id', $filter['option_id']);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_product_options($product_id){
        $this->db->select("a.*,b.option_value_name");
        $this->db->from('admin_product_option_value a');
        $this->db->join('admin_option_value b', 'a.option_id=b.id');
        $this->db->where('a.availability', 'Yes');
        $this->db->where('a.product_id', $product_id);
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result_array();
    }

    public function get_option_details($data){
        $this->db->select("a.*,b.option_value_name,c.product_medium_image,c.product_image");
        $this->db->from('admin_product_option_value a');
        $this->db->join('admin_option_value b', 'a.option_id=b.id');
        $this->db->join('admin_product c', 'a.product_id=c.id');
        $this->db->where('a.availability', 'Yes');
        $this->db->where('a.product_id', $data['product_id']);
        $this->db->where('a.option_id', $data['option_id']);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_coupon_detail($coupon_id){
        $this->db->select("a.id as coupon_id,a.coupon_code,a.discount_type,a.discount,a.valid_from,a.valid_to");
        $this->db->from('admin_coupon a');
        $this->db->where('a.coupon_type', 'special');
        $this->db->where('a.status', '2');
        if(is_array($coupon_id)){
            $this->db->where_in('a.id', $coupon_id);
        }else{
            $this->db->where('a.id', $coupon_id);
        }
        $query = $this->db->get();
        if($query->num_rows()>0) {
            $result =  $query->result_array();
            $todaydate=date('Y-m-d');
            foreach($result as $k=>$v){
                if(($v['valid_from']!='0000-00-00') && ($v['valid_to']!='0000-00-00') && !($v['valid_from'] <= $todaydate && $v['valid_to'] >= $todaydate)) {
                    unset($result[$k]);
                }
            }
            return $result;
        }
        return false;
    }

    public function get_product_coupons($product_id){
        $this->db->select("a.product_id,b.id as coupon_id,b.coupon_code,b.discount_type,b.discount,b.valid_from,b.valid_to");
        $this->db->from('admin_product_category a');
        $this->db->_protect_identifiers=false;
        $this->db->join('admin_coupon b', 'FIND_IN_SET(a.category_id,b.categories) > 0 AND status =2');
        $this->db->_protect_identifiers=true;
        $this->db->where_in('a.product_id', $product_id);
        $query = $this->db->get();
        if($query->num_rows()>0){
            $result =  $query->result_array();
            $todaydate=date('Y-m-d');
            foreach($result as $k=>$v){
                if(($v['valid_from']!='0000-00-00') && ($v['valid_to']!='0000-00-00') && !($v['valid_from'] <= $todaydate && $v['valid_to'] >= $todaydate)) {
                    unset($result[$k]);
                }
            }
            return $result;
        }
        return false;
    }


}