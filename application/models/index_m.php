<?php
Class Index_M extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_breadcrumb($cid){
        $this->db->select('id,slug,parent_id,category_name');
        $this->db->where('id', $cid);
        $query = $this->db->get('admin_category');
        $breadcrumb_ids=array();
        if ($query->num_rows() > 0) {
            $cat_results = $query->row_array();
            $breadcrumb_ids[]=$cat_results['slug'].'|'.$cat_results['category_name'];
            $breadcrumb_ids=array_merge($this->get_breadcrumb($cat_results['parent_id']),$breadcrumb_ids);
        }
        return $breadcrumb_ids;
    }

    public function get_homepage_order()
    { 
        $this->db->where('status','2');
        $this->db->order_by('sortorder','ASC');
        $query= $this->db->get('admin_homepage');
        return $query->result_array();
    }

    public function get_child_categories_listing($filter=array(),$limit='',$level=''){
        $this->db->select('a.id,a.category_name,a.slug,b.id as p_id,c.product_id,b.category_name as p_catname,b.slug as p_slug,COUNT(c.product_id) as cat_prod_count,IF(e.option_id IS NULL,d.quantity,e.option_qty) as stock_quantity',false);
        $this->db->from('admin_category a');
        $this->db->join('admin_category b','a.parent_id = b.id','left');
        $this->db->join('admin_product_category c','a.id = c.category_id','left');
        $this->db->join('admin_product d','d.id = c.product_id','left');
        $this->db->join('admin_product_option_value e', 'e.product_id = d.id AND default_option=1', 'left');
        $this->db->where('a.status', 1);
        if(!empty($filter['category_id']) && !is_array($filter['category_id'])) {
            $this->db->where('a.id', $filter['category_id']);
        }
        // if(!empty($filter['brands'])) {
        //     $this->db->_protect_identifiers=false;
        //     $this->db->where('FIND_IN_SET('.$filter['brands'].',a.brands) > 0');
        //     $this->db->_protect_identifiers=true;
        // }
        if(!empty($filter['category_id']) && is_array($filter['category_id'])) {
            $this->db->where_in('a.id', $filter['category_id']);
        }
        $this->db->_protect_identifiers=false;
        $this->db->group_by('IF(stock_quantity > 0, a.id, 0)');
        $this->db->_protect_identifiers=true;
        $this->db->where('a.parent_id',0);
        $this->db->having('stock_quantity > 0');
        if(!empty($limit)){
            $this->db->limit($limit);
        }
        $query = $this->db->get();
      //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            if($level==''){
                foreach($result as $k=>$v){
                    $this->db->select('a.id as id,a.category_name,a.slug,COUNT(c.product_id) as cat_prod_count,IF(e.option_id IS NULL,d.quantity,e.option_qty) as stock_quantity',false);
                    $this->db->from('admin_category a');
                    $this->db->join('admin_product_category c','a.id = c.category_id','left');
                    $this->db->join('admin_product d','d.id = c.product_id','left');
                    $this->db->join('admin_product_option_value e', 'e.product_id = d.id AND default_option=1', 'left');
                    $this->db->where('a.parent_id', $v['id']);
                    $this->db->where('a.status', 1);
                    $this->db->having('stock_quantity > 0');
                    $this->db->_protect_identifiers=false;
                    $this->db->group_by('IF(stock_quantity > 0, a.id, 0)');
                    $this->db->_protect_identifiers=true;
                    $query = $this->db->get();
                    if ($query->num_rows() > 0) {
                        $result[$k]['level1_cat'] = $query->result_array();
                    }
                }
            }
            return $result;
        }
    }

    public function get_child_categories($category_id,$level=''){
        $this->db->select('a.id,a.category_name,a.slug,b.id as p_id,b.category_name as p_catname,b.slug as p_slug');
        $this->db->from('admin_category a');
        $this->db->join('admin_category b','a.parent_id = b.id','left');
        $this->db->where('a.status', 1);
        if(($level=='') || ($level==1)){
            $this->db->where('a.id', $category_id);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row= $query->row_array();
            //print_r($row);die;
            $this->db->select('a.id as id,a.category_name,a.slug,COUNT(b.product_id) as nop');
            $this->db->from('admin_category a');
            $this->db->join('admin_product_category b','b.category_id = a.id','left');
            if(($level==1)) {
                $this->db->where('a.id', $category_id);
            }
            $this->db->where('a.parent_id', $row['id']);
            $this->db->where('a.status', 1);
            $this->db->group_by('b.category_id');
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $result1 = $query->result_array();
                //print_r($result1);die;
                if($level>=1){
                    foreach ($result1 as $k1 => $v1) {
                        $this->db->select('a.id as id,a.category_name,a.slug,COUNT(b.product_id) as nop');
                        $this->db->from('admin_category a');
                        $this->db->join('admin_product_category b','b.category_id = a.id','left');
                        $this->db->where('a.parent_id', $v1['id']);
                        $this->db->where('a.status', 1);
                        $this->db->group_by('b.category_id');
                        $query = $this->db->get();
                        if ($query->num_rows() > 0) {
                            $result2 = $query->result_array();
                            $result1[$k1]['level2_cat'] = $result2;
                        }
                    }
                }
                $row['level1_cat']=$result1;
            }
            return $row;
        }
        return false;
    }

    public function get_all_categories(){
        $this->db->select('id,parent_id,category_name,slug,sort_order');
        $this->db->where('parent_id', 0);
        $this->db->where('status', 1);
        $this->db->order_by('sort_order > 0 DESC , sort_order ASC');
        $query = $this->db->get('admin_category');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            foreach($result as $k=>$v){
                $this->db->select('id,parent_id,category_name,slug,sort_order');
                $this->db->where('parent_id', $v['id']);
                $this->db->where('status', 1);
                $this->db->order_by('sort_order > 0 DESC , sort_order ASC');
                $query = $this->db->get('admin_category');
                if ($query->num_rows() > 0) {
                    $result1 = $query->result_array();

                    foreach ($result1 as $k1 => $v1) {
                        $this->db->select('id,parent_id,category_name,slug,sort_order');
                        $this->db->where('parent_id', $v1['id']);
                        $this->db->where('status', 1);
                        $this->db->order_by('sort_order > 0 DESC , sort_order ASC');
                        $this->db->limit(15);
                        $query = $this->db->get('admin_category');
                        if ($query->num_rows() > 0) {
                            $result2 = $query->result_array();
                            $result1[$k1]['level2_cat'] = $result2;
                        }
                    }
                    $result[$k]['level1_cat'] = $result1;
                }
            }
            return $result;
        }
        return false;
    }

    public function get_page_details($slug){
        $this->db->where('slug',$slug);
        $query = $this->db->get('admin_contents');
        if($query->num_rows()>=1) {
            return  $query->row_array();
        }
        return false;
    }

    public function get_newsletter($data){
        $this->db->where('newsletter_email',$data['newsletter_email']);
        $query = $this->db->get('newsletter');
        return $query->num_rows();
    }

    public function add_newsletter($data){
        $date=date("Y-m-d H:i:s");
        $insert['newsletter_email']=$data['newsletter_email'];
        $insert['created']=$date;
        $insert['status']=1;
        $this->db->insert('newsletter', $insert);
        return $this->db->insert_id();
    }

    public function add_affiliate($data){
        $date=date("Y-m-d H:i:s");
        $data['created']=$date;
        $data['status']=2;
        $this->db->insert('affiliate', $data);

        $this->load->config('email');
        $this->load->library('My_PHPMailer');
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = $this->config->item('smtp_host');
        $mail->SMTPAuth = true;
        // $mail->SMTPSecure = 'tls';
        //$mail->SMTPDebug = 2;
        $mail->Username = $this->config->item('smtp_user');
        $mail->Password = $this->config->item('smtp_pass');
        $mail->Port = $this->config->item('smtp_port');
        $mail->SetFrom($this->config->item('from_email'), $this->config->item('from_name'));
        $mail->AddAddress($this->config->item('team_email3'));
        //$mail->AddAddress('saravanan@webkites.in');
        //$mail->AddCC($data['cc']);


        $mail->Subject = "Received new affiliate from vakullaa.com";

        $message = '<p>Hi,</p>';
        $message .= '<p>The following is the affiliate submitted from vakullaa.com</p>';
        $message .= '<p>&nbsp;</p>';
        $message .= '<p>Name: '.$data['user_name'].'</p>';
        $message .= '<p>Mobile: '.$data['user_mobile'].'</p>';
        $message .= '<p>Email: '.$data['user_email'].'</p>';
        $message .= '<p>Business Type: '.$data['business_type'].'</p>';
        $message .= '<p>Business Name: '.$data['business_name'].'</p>';
        $message .= '<p>Describe about products: '.$data['describe_products'].'</p>';
        $message .= '<p>&nbsp;</p>';
        $message .= '<p>Thanks,</p>';
        $message .= '<p>vakullaa team.</p>';

        $mail->Body = $message;
        $mail->isHTML(true);
        $mail->Send();
        $mail->ClearAllRecipients();

        $this->session->set_flashdata('success', 'Thanks for your submission. We will get back to you shortly.');
        return $this->db->insert_id();
    }

    public function get_filter_by_category($category_id){
        $this->db->select('a.filter_group_id,a.filter_id,c.filter_group_name,d.filter_name');
        $this->db->from('admin_category_filter a');
        $this->db->join('admin_category b','a.category_id = b.id','left');
        $this->db->join('admin_filter_group c','a.filter_group_id = c.id','left');
        $this->db->join('admin_filter d','a.filter_id = d.id','left');
        $this->db->where('a.category_id',$category_id);
        $this->db->order_by('d.sort_order','asc');
        $query = $this->db->get('');
        if($query->num_rows()>=1){
            $result =  $query->result_array();
            foreach($result as $k=>$v){
                $new_result[$v['filter_group_name']][]=$v;
            }
          return $new_result;
        }
        return false;
    }

    public function get_category_by_id($id){
        $this->db->where('id',$id);
        $query = $this->db->get('admin_category');
        if($query->num_rows()>=1){
            return $query->row_array();
        }else{
            return false;
        }
    }

    // public function get_brand_by_slug($slug){
    //   $this->db->where('slug',$slug);
    //     $query = $this->db->get('admin_brands');
    //     if($query->num_rows()>=1){
    //         return $query->row_array();
    //     }else{
    //         return false;
    //     }  
    // }


    public function get_category_by_slug($slug){
        $this->db->where('slug',$slug);
        $query = $this->db->get('admin_category');
        if($query->num_rows()>=1){
            return $query->row_array();
        }else{
            return false;
        }
    }

    public function get_all_product_names(){
        $this->db->select('id,product_name');
        $query = $this->db->get('admin_product');
        if($query->num_rows()>=1){
            return $query->result_array();
        }
        return false;
    }

    public function _similar_word_search($term,$product_arr){
        if(!empty($product_arr)){
            $exact_matched_prod_words=[];
            $similar_matched_prod_words=[];
            $unique_words=array();
            foreach ($product_arr as $k=>$v) {
                $v_arr = explode(' ',$v);

                foreach($v_arr as $k1=>$v1){
                    $v1=preg_replace("/[^a-zA-Z0-9]/", "", $v1);
                    $term_arr = explode(' ',$term);
                    foreach($term_arr as $term_val){
                        similar_text(strtolower($term_val), strtolower($v1), $perc);
                        if($perc==100){
                            if(!in_array($term_val,$unique_words)){
                                $unique_words[]=$term_val;
                                $exact_matched_prod_words[]=$v1;
                            }
                        }else{
                            if($perc>75){
                                if(!in_array($v1,$similar_matched_prod_words)){
                                    $similar_matched_prod_words[]=$v1;
                                }
                            }
                        }
                    }
                }
            }
            if(!empty($exact_matched_prod_words)){
                $matched_prod_words['extract']= $exact_matched_prod_words;
            }else{
                $matched_prod_words['similar']= $similar_matched_prod_words;
            }
            return $matched_prod_words;
        }
        return false;
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

    public function get_products_by_filter($filter, $limit='',$start=''){
       
        $this->db->select('a.id as product_id,a.slug,a.price as product_price,a.actual_price_single,a.product_code,a.product_name,a.product_image,a.product_thumb_image,a.product_medium_image,d.discount_type,d.discount_price,d.start_date,d.end_date,f.tax_value as state_tax_value,g.tax_value as central_tax_value,h.selling_price as option_price,IF(h.option_id IS NULL,a.price,h.selling_price) as prod_price,IF(h.option_id IS NULL,a.quantity,h.option_qty) as stock_quantity',false);
        $this->db->from('admin_product a');
        $this->db->join('admin_product_category b', 'a.id = b.product_id', 'left');
        $this->db->join('admin_product_filter c', 'a.id = c.product_id', 'left');
        $this->db->join('admin_product_discount d', 'a.id = d.product_id', 'left');
        $this->db->join('admin_category e', 'e.id = b.category_id', 'left');
        $this->db->join('tax_settings f', 'f.id = a.sgst', 'left');
        $this->db->join('tax_settings g', 'g.id = a.cgst', 'left');
        $this->db->join('admin_product_option_value h', 'h.product_id = a.id AND default_option=1', 'left');
        $this->db->where('a.status', 2);
        if(isset($filter['category_id'])){
            if(is_array($filter['category_id'])){
                $this->db->where_in('b.category_id', $filter['category_id']);
            }else{
                $this->db->where('b.category_id', $filter['category_id']);
            }
        }
        if(isset($filter) && !empty($filter['filter'])) {
            $this->db->where_in('c.filter_group_id_filter_id',$filter['filter']);
        }
        if(!empty($filter['search_term'])){
            $term = trim($filter['search_term']);
            $product_arr=array();
            if(!empty($filter['product_names'])){
                foreach($filter['product_names'] as $k=>$v){
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

        $this->db->group_by('b.product_id');
       
        if(isset($filter['sort_by']) && ($filter['sort_by']=='newest_first')){
            $this->db->order_by('a.id', 'DESC');
        }elseif(isset($filter['sort_by']) && ($filter['sort_by']=='low_to_high')){
            $this->db->order_by('prod_price', 'ASC');
            //$this->db->order_by('option_price', 'ASC');
        }elseif(isset($filter['sort_by']) && ($filter['sort_by']=='high_to_low')){
            $this->db->order_by('prod_price', 'DESC');
            //$this->db->order_by('option_price', 'DESC');
        } else{
            $this->db->_protect_identifiers=false;
            $this->db->order_by('IF(a.sort_order!=0,a.sort_order,a.id)','ASC');
            $this->db->_protect_identifiers=true;
        }

        $this->db->having('stock_quantity > 0');

        if(!empty($limit)){
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get();
       //echo $this->db->last_query();die;
        if($query->num_rows()>=1){
            $results=$query->result_array();
            return $results;
        }
        return false;
    }

    public function get_total_products_by_filter($filter){
        $this->db->select('a.id,IF(f.option_id IS NULL,a.quantity,f.option_qty) as stock_quantity',false);
        $this->db->from('admin_product a');
        $this->db->join('admin_product_category b', 'a.id = b.product_id', 'left');
        $this->db->join('admin_product_filter c', 'a.id = c.product_id', 'left');
        $this->db->join('admin_product_discount d', 'a.id = d.product_id', 'left');
        $this->db->join('admin_category e', 'e.id = b.category_id', 'left');
        $this->db->join('admin_product_option_value f', 'f.product_id = a.id AND default_option=1', 'left');
        if(isset($filter['category_id'])){
            if(is_array($filter['category_id'])){
                $this->db->where_in('b.category_id', $filter['category_id']);
            }else{
                $this->db->where('b.category_id', $filter['category_id']);
            }
        }

        if(isset($filter) && !empty($filter['filter'])) {
            $this->db->where_in('c.filter_group_id_filter_id',$filter['filter']);
        }
        
        if (!empty($amountwhere)) {
            $this->db->where($amountwhere);
        }

        if(!empty($filter['search_term'])){
            $term = trim($filter['search_term']);
            $product_arr=array();
            if(!empty($filter['product_names'])){
                foreach($filter['product_names'] as $k=>$v){
                    $product_arr[$v['id']]=$v['product_name'];
                }
            }

            $like ='(FIND_IN_SET("'.$term.'",a.product_tags )> 0';
            // $like .= ' OR a.product_name LIKE "%'.$term.'%"';

            $matched_prod_words = $this->similar_word_search($term,$product_arr);
            // print_r($matched_prod_ids);
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

        if (!empty($filteroptionwhere)) {
            $this->db->where($filteroptionwhere);
        }

        $this->db->where('a.status', 2);
        $this->db->having('stock_quantity > 0');
        $this->db->order_by('a.id', 'DESC');
        $this->db->group_by('b.product_id');

        $query = $this->db->get();

        return $query->num_rows();
    }

}