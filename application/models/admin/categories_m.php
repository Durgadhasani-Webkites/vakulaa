<?php
Class Categories_M extends CI_Model {
	
	public function __construct() {
		parent::__construct();
        $this->table_name="admin_category";
	}

    public function filterview() {

        $this->db->select("*");
        $this->db->from('admin_filter_group a');
        $this->db->join('admin_filter b', 'a.id=b.filter_group_id');
        $this->db->order_by('b.filter_group_id','ASC');
        $query = $this->db->get();
        return $query->result_array();

    }

    public function get_category_filters($cid){

        $this->db->select('a.filter_group_id,a.filter_id,b.filter_group_name,c.filter_name');
        $this->db->from('admin_category_filter a');
        $this->db->join('admin_filter_group b','a.filter_group_id=b.id','left');
        $this->db->join('admin_filter c','a.filter_id=c.id','left');
        if(is_array($cid)){
            $this->db->where_in('a.category_id', $cid);
        }else{
            $this->db->where('a.category_id', $cid);
        }
        $query = $this->db->get();
        if($query->num_rows()>=1) {
            return $query->result_array();
        }else{
            return false;
        }

    }

    // public function get_brands($id){
    //     $this->db->select('brands');
    //     if(is_array($id)){
    //         $this->db->where_in('id', $id);
    //     }else{
    //         $this->db->where('id', $id);
    //     }
    //     $query = $this->db->get('admin_category');
    //     if($query->num_rows()>=1){
    //         return $query->result_array();
    //     }else{
    //         return false;
    //     }

    // }

    public function get_filters_for_category($cat_id) {
        if(is_array($cat_id)){
            $this->db->where_in('category_id', $cat_id);
        }else{
            $this->db->where('category_id', $cat_id);
        }
        $query = $this->db->get('admin_category_filter');
        return $query->result_array();

    }

	public function view($current_cat_id, $count) {
			
		static $option_results;
	
		if (!isset($current_cat_id)) {
			$current_cat_id = 0;
		}
	
		$count++;
	
		$this->db->where('parent_id', $current_cat_id);
        $this->db->order_by('sort_order', 'ASC');
		$query = $this->db->get($this->table_name);
		$get_options=$query->result_array();
		if ($query->num_rows() > 0) {
		
			foreach ($get_options as $rows) { 
				$cat_id=$rows['id'];
				$cat_name=$rows['category_name'];
				$category_image=$rows['category_image'];
				$sort_order=$rows['sort_order'];
				$created=$rows['created'];
				$status=$rows['status'];
				$indent_flag = '';
				if ($current_cat_id != 0) {
					for ($x = 2; $x <= $count; $x++) {
						$indent_flag .=  '&nbsp;&nbsp;&rarr;&nbsp;&nbsp;';
					}
					$indent_flag .=  '';
				}
	
				$option_results[$cat_id]['category_name'] = $indent_flag . $cat_name;
				$option_results[$cat_id]['parent_id'] = $rows['parent_id'];
				$option_results[$cat_id]['category_image'] = $category_image;
				$option_results[$cat_id]['sort_order'] = $sort_order;
				$option_results[$cat_id]['created'] = $created;
				$option_results[$cat_id]['status'] = $status;
	
				$this->view($cat_id, $count);
			}
			
		}
	
		return $option_results;
	}

	
	public function categoryview($current_cat_id, $count) {
			
		static $option_results;
	
		if (!isset($current_cat_id)) {
			$current_cat_id = 0;
		}
	
		$count++;
	
		$this->db->where('parent_id', $current_cat_id);
		$this->db->order_by('sort_order', 'ASC');
		$query = $this->db->get($this->table_name);
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

    public function editview($id) {
        if(is_array($id)){
            $this->db->where_in('id', $id);
        }else{
            $this->db->where('id', $id);
        }
        $query = $this->db->get('admin_category');
        if ($query->num_rows() > 0) {
            if(is_array($id)){
                return $query->result_array();
            }else{
                return $query->row_array();
            }
        }

    }

    // public function get_filters_brands($id){

    //     $category_results= $this->editview($id);
    //     if(isset($category_results[0])){
    //         $brands_arr=array();
    //         foreach($category_results as $k=>$v){
    //             if(!empty($v['brands'])) {
    //                 $category_brands = array();
    //                 $category_brands = explode(",", $v['brands']);
    //                 foreach ($category_brands as $brands_id) {
    //                     if (!in_array($brands_id, $brands_arr)) {
    //                         array_push($brands_arr, $brands_id);
    //                     }
    //                 }
    //             }
    //         }
    //     }else{
    //         if(!empty($category_results['brands'])){
    //             $brands_arr=explode(",",$category_results['brands']);
    //         }
    //     }

    //     if(!empty($brands_arr)){

    //         $this->load->model('admin/brands_m');
    //         $brand_details=$this->brands_m->get($brands_arr);

    //         foreach($brand_details as $k=>$v){
    //             $brands[$k]['label']=$v['brand_name'];
    //             $brands[$k]['value']=$v['id'];
    //         }
    //         if(!empty($brands)){
    //             $brands_filters['brands']=$brands;
    //         }
    //     }
    //     $this->db->select('a.filter_group_id,a.filter_id,b.filter_group_name,c.filter_name');
    //     $this->db->from('admin_category_filter a');
    //     $this->db->join('admin_filter_group b','a.filter_group_id=b.id','left');
    //     $this->db->join('admin_filter c','a.filter_id=c.id','left');
    //     if(is_array($id)){
    //         $this->db->where_in('a.category_id', $id);
    //     }else{
    //         $this->db->where('a.category_id', $id);
    //     }
    //     $query = $this->db->get();
    //     if($query->num_rows()>=1){
    //         $filter_results=$query->result_array();
    //         if(!empty($filter_results)){
    //             foreach($filter_results as $k=>$v){
    //                 $filters[$k]['label']=$v['filter_group_name'].'_'.$v['filter_name'];
    //                 $filters[$k]['value']=$v['filter_group_id']. '_'.$v['filter_id'];
    //             }
    //             if(!empty($filters)){
    //                 $brands_filters['filters']=$filters;
    //             }
    //         }
    //     }

    //     if(!empty($brands_filters)){
    //         echo json_encode($brands_filters);
    //     }
    // }

    public function get($id) {
        if(is_array($id)){
            $this->db->where_in('id', $id);
        }else{
            $this->db->where('id', $id);
        }
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            if(is_array($id)){
                return $query->result_array();
            }else{
                return $query->row_array();
            }
        }
        return false;
    }
	
	public function add() {
        $slug=url_title(strtolower($_POST['category_name']));
        $num_rows = $this->db->get_where($this->table_name,array('slug'=>$slug))->num_rows();
        if($num_rows==0) {

            $date = date("Y-m-d H:i:s");
            $option['parent_id'] = 0;
            if (isset($_POST['parent']) && !empty($_POST['parent'])) {
                $option['parent_id'] = $_POST['parent'];
            }
            $option['category_name'] = $_POST['category_name'];
            $option['slug'] = $slug;
            // if (!empty($_POST['brands'])) {
            //     $option['brands'] = implode(",", $_POST['brands']);
            // }
            if (!empty($_POST['category_image'])) {
                $option['category_image'] = $_POST['category_image'];
            }
            if (!empty($_POST['category_image_other'])) {
                $option['category_slider_image'] = $_POST['category_image_other'];
            }

            $option['category_image_name'] = $_POST['category_image_name'];

            $option['description'] = $_POST['category_description'];

            $option['meta_title'] = $_POST['meta_title'];
            $option['meta_description'] = $_POST['meta_description'];
            $option['meta_keywords'] = $_POST['meta_keywords'];

            $option['sort_order'] = $_POST['sort_order'];

            $option['created'] = $date;
            $option['status'] = $_POST['status'];
            $this->db->insert($this->table_name, $option);

            $categoryid = $this->db->insert_id();

            if (isset($_POST['filters'])) {
                $filters = $_POST['filters'];
                $i = 0;
                foreach ($filters as $value) {
                    $optionarray[$i]['category_id'] = $categoryid;
                    $filtersexp = explode("_", $value);
                    $optionarray[$i]['filter_group_id'] = $filtersexp[0];
                    $optionarray[$i]['filter_id'] = $filtersexp[1];
                    $i++;
                }

                $this->db->insert_batch('admin_category_filter', $optionarray);
            }

            return true;
        }
        return false;

		
	}
	

	public function update() {
        $id=$_POST['id'];
        $slug=url_title(strtolower($_POST['category_name']));
        $num_rows = $this->db->get_where($this->table_name,array('slug'=>$slug,'id !='=>$id))->num_rows();
        if($num_rows==0) {
           
            $date=date("Y-m-d H:i:s");
            $option['parent_id']=$_POST['parent'];
            $option['category_name']=$_POST['category_name'];
            $option['slug']=url_title(strtolower($_POST['category_name']));
            if(!empty($_POST['category_image'])){
                $option['category_image']=$_POST['category_image'];
            }
            $option['category_image_name'] = $_POST['category_image_name'];
            $option['category_slider_image']=$_POST['category_image_other'];
            $option['description']=$_POST['category_description'];

            $option['meta_title'] = $_POST['meta_title'];
            $option['meta_description'] = $_POST['meta_description'];
            $option['meta_keywords'] = $_POST['meta_keywords'];

            $option['sort_order']=$_POST['sort_order'];

            $option['updated']=$date;
            $option['status']=$_POST['status'];
            $this->db->where('id',$id);
            $this->db->update($this->table_name, $option);

            if(isset($_POST['filters'])) {
                $this->db->from('admin_category_filter');
                $this->db->where('category_id', $id);
                $query = $this->db->delete();

                $filters=$_POST['filters'];
                $i=0;
                foreach($filters as $value) {
                    $optionarray[$i]['category_id']=$id;
                    $filtersexp=explode("_", $value);
                    $optionarray[$i]['filter_group_id']=$filtersexp[0];
                    $optionarray[$i]['filter_id']=$filtersexp[1];
                    $i++;
                }

                $this->db->insert_batch('admin_category_filter', $optionarray);
            }

            return true;
        }
        return false;

    }


	
	public function delete($id) {
		$this->db->from($this->table_name);
		$this->db->where('id', $id);
		$query = $this->db->delete();
		return true;
	}
	
	public function deactivate($id) {
		$this->db->set('status', 0);
		$this->db->where('id', $id);
		$query=$this->db->update($this->table_name);
		return true;
		
	}
	
	public function activate($id) {
		$this->db->set('status', 1);
		$this->db->where('id', $id);
		$query=$this->db->update($this->table_name);
		return true;
		
	}

	
}
?>