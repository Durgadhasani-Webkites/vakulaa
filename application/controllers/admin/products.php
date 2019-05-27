<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('admin/products_m');

		$privileges=explode(",", $this->session->userdata('privileges'));
		if(!in_array(7, $privileges)) {
			redirect('admin/index/logout');
		}
		
	} 

	public function index() {

		$this->template('admin/products/view');
	}

    public function ajax_index(){

        $offset=$_GET['start'];

        $limit=$_GET['length'];

        $filter_data=array();

        if(!empty($_GET['formValues'])){

            parse_str($_GET['formValues'],$filter_data);

        }

        if(!empty($_GET['search']['value'])){

            $filter_data['search']=$_GET['search']['value'];

        }



        if(!empty($_GET['order'][0]['column'])){

            $filter_data['order']['column']=$_GET['order'][0]['column'];

            $filter_data['order']['dir']= $_GET['order'][0]['dir'];

        }

        if (!empty($filter_data['product_name'])) {
            $this->load->model('index_m');
            $filter_data['product_names'] = $this->index_m->get_all_product_names();

        }
        $admin_results=$this->products_m->get_all($filter_data,$offset,$limit);

        $total_results=$this->products_m->get_total($filter_data);

        $dataTableData=array();

        $dataTableData['draw']=$_GET['draw'];

        $dataTableData['recordsTotal']=$total_results;

        $dataTableData['recordsFiltered']=$total_results;

        $dataTableData['data']=[];

        if(!empty($admin_results)){

            $this->load->model('admin/settings_m');
            $web_settings = $this->settings_m->get();

            // $home_heading_1 = (!empty($web_settings['home_heading_1']))?$web_settings['home_heading_1']:'Latest Offers';
            // $home_heading_4 = (!empty($web_settings['home_heading_4']))?$web_settings['home_heading_4']:'New Arrivals';
            // $home_heading_2 = (!empty($web_settings['home_heading_2']))?$web_settings['home_heading_2']:'Top Selling';


            foreach($admin_results as $k=>$v){

                $edit_url = base_url('admin/products/edit/'.$v['id'].'?offset='.$offset);
                $delete_url = base_url('admin/products/delete/'.$v['id'].'?offset='.$offset);
                if(isset($filter_data['stock'])){
                    $edit_url.="&stock={$filter_data['stock']}";
                    $delete_url.="&stock={$filter_data['stock']}";
                }
                // $displayed_in='';
                // if($v['latest_offers']==1){
                //     $displayed_in.=', '.$home_heading_1;
                // }
                // if($v['new_arrivals']==1){
                //     $displayed_in.=', '.$home_heading_4;
                // }
                // if($v['top_selling']==1){
                //     $displayed_in.=', '.$home_heading_2;
                // }

                $dataTableData['data'][$k][0]='<label class="option block mn">
                                            <input type="checkbox" name="id[]" class="mul_ch" value="'.$v['id'].'">
                                            <span class="checkbox mn"></span>
                                        </label>';

                $dataTableData['data'][$k][1]=$v['product_name'];
                if(!empty($v['option_name'])){
                    $dataTableData['data'][$k][1].=' - '.$v['option_name'];
                }
                if(!empty($v['product_option_code'])){
                    $dataTableData['data'][$k][1].='<br/><b>Product Code: </b>'.$v['product_option_code'];
                }
                if(!empty($displayed_in)){
                    $dataTableData['data'][$k][1].='<br/>(<span style="font-size:12px;">'.trim($displayed_in,", ").'</span>)';
                }
                if(!empty($v['categories'])){
                    $dataTableData['data'][$k][1].='<br/><b>Categories: </b><a  data-content="'.$v['categories'].'"  class="categoryModal" href="javascript:">View</a>';
                }

                $dataTableData['data'][$k][2]=$v['stock_quantity'];

                $dataTableData['data'][$k][3]=date('d-m-Y h:i:s',strtotime($v['created']));

                $status ='<i class="fa fa-times"></i>';
                if($v['status']==2){
                  $status ='<i class="fa fa-check"></i>';
                }

                $dataTableData['data'][$k][4]=$status;

                $dataTableData['data'][$k][5] = '<div class="btn-group text-right">

                                            <button type="button" class="btn btn-success br2 btn-xs fs12 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Change

                                                <span class="caret ml5"></span>

                                            </button>

                                            <ul class="dropdown-menu" role="menu">

                                                <li>
                                                    <a title="click to view" href="'.$edit_url.'">Edit</a>
                                                </li>
                                                 <li>
                                                    <a class="confirm" title="click to delete" href="'.$delete_url.'">Delete</a>
                                                </li>

                                            </ul>

                                        </div>';

            }



        }

        echo json_encode($dataTableData);



    }

	public function add() {
		$data['category_view']=$this->products_m->categoryview(0, 0);
		$data['attribute_view']=$this->products_m->attributeview();
        $this->load->model('admin/coupon_m');
		$data['special_coupons']=$this->coupon_m->get_special_coupons();
		$data['option_view']=$this->products_m->optionview();
		$data['sgst_res']=$this->products_m->get_all_sgst();
		$data['cgst_res']=$this->products_m->get_all_cgst();

        $this->load->model('admin/settings_m');
        $data['web_settings'] = $this->settings_m->get();

		//$data['vendors_view']=$this->products_m->vendorsview();
		$this->template('admin/products/add',$data);
	}
	
	public function open_options() {
		$id=$this->input->post('id');
		$data['options_view']=$this->products_m->open_options($id);
		echo $this->load->view('admin/products/options',$data);
	}

    public function get_all_products(){
        if(isset($_GET['q'])){
            $filter_data['search']=$_GET['q'];
        }
        $offset=0;
        $limit=$_GET['limit'];
        if(isset($_GET['page']) && $_GET['page']>0){
            $offset= ($_GET['page']-1)*$limit;
        }
        $filter_data['active']=true;
        $option_res=$this->products_m->get_all_products($filter_data,$offset,$limit);
        $items=array();
        if(!empty($option_res)){
            $i=0;
            foreach($option_res as $k=>$v){
                $items[$i]['name']=$v['product_name'];
                $items[$i]['id']=$v['id'];
                $i++;
            }
        }
        $data['items']=$items;
        $data['total_count']=$this->products_m->get_total_products($filter_data);
        echo json_encode($data);
    }

    public function get_all_options(){
        if(isset($_GET['q'])){
            $filter_data['search']=$_GET['q'];
        }
        $offset=0;
        $limit=$_GET['limit'];
        if(isset($_GET['page']) && $_GET['page']>0){
            $offset= ($_GET['page']-1)*$limit;
        }
        if(isset($_GET['product_id'])){
            $filter_data['product_id']=$_GET['product_id'];
        }
        $filter_data['active']=true;
        $option_res=$this->products_m->get_all_options($filter_data,$offset,$limit);
        $items=array();
        if(!empty($option_res)){
            $i=0;
            foreach($option_res as $k=>$v){
                $items[$i]['name']=$v['option_value_name'];
                $items[$i]['id']=$v['id'];
                $i++;
            }
        }
        $data['items']=$items;
        $data['total_count']=$this->products_m->get_total_options($filter_data);
        echo json_encode($data);
    }

    public function get_all_product_options(){
        if(isset($_GET['q'])){
            $filter_data['search']=$_GET['q'];
        }
        $offset=0;
        $limit=$_GET['limit'];
        if(isset($_GET['page']) && $_GET['page']>0){
            $offset= ($_GET['page']-1)*$limit;
        }
        if(isset($_GET['product_id'])){
            $filter_data['product_id']=$_GET['product_id'];
        }
        $filter_data['active']=true;
        $option_res=$this->products_m->get_all_product_options($filter_data,$offset,$limit);
        $items=array();
        if(!empty($option_res)){
            $i=0;
            foreach($option_res as $k=>$v){
                $items[$i]['name']=$v['option_value_name'];
                $items[$i]['id']=$v['id'];
                $i++;
            }
        }
        $data['items']=$items;
        $data['total_count']=$this->products_m->get_total_product_options($filter_data);
        echo json_encode($data);
    }


    public function get_product_filters_brands(){
        $cid=$_POST['cid'];
        $this->load->model('admin/categories_m');
        if(strpos($cid,",")!== false){
            $cid=explode(",",$cid);
        }
        $this->categories_m->get_filters_brands($cid);

    }
	
	public function process_add() {
  
		$this->form_validation->set_rules('product_name','product name','required|trim|xss_clean');
		if (!empty($_FILES['thumb_image']['name'])) {
			$this->form_validation->set_rules('thumb_image', 'product image', 'callback_product_image');
		}
		if (!empty($_FILES['product_images']['name'])) {
			$this->form_validation->set_rules('product_images[]','image','callback_product_multi_images');
		}
		
		if($this->form_validation->run() == FALSE) {
			$data['category_view']=$this->products_m->categoryview(0, 0);
			$data['filter_view']=$this->products_m->filterview();
			$data['attribute_view']=$this->products_m->attributeview();
			$data['option_view']=$this->products_m->optionview();
			$this->template('admin/products/add',$data);
		} else {
			$this->addsuccess($_POST);
		}
		
	}
	
	public function addsuccess($postdetails) {
       
        if(!empty($postdetails['availability'])){
            $i=0;
            $j=0;
            $files =$_FILES;
            foreach($postdetails['availability'] as $k=>$v){
                if($v=='Yes'){
                    if(!empty($files['product_option_images']['name'][$k])){
                        $product_option_images_type = $files['product_option_images']['type'][$k];
                        $product_option_images_tmp_name = $files['product_option_images']['tmp_name'][$k];
                        $product_option_images_error = $files['product_option_images']['error'][$k];
                        $product_option_images_size = $files['product_option_images']['size'][$k];

                        $product_option_images_arr[$k]=array();
                        $product_option_thumb_images_arr[$k]=array();
                        $product_option_medium_images_arr[$k]=array();
                        foreach($files['product_option_images']['name'][$k] as $k1=>$v1){
                            if(!empty($v1)){
                                $_FILES['product_option_images']['name']= $v1;
                                $_FILES['product_option_images']['type']= $product_option_images_type[$k1];
                                $_FILES['product_option_images']['tmp_name']= $product_option_images_tmp_name[$k1];
                                $_FILES['product_option_images']['error']= $product_option_images_error[$k1];
                                $_FILES['product_option_images']['size']= $product_option_images_size[$k1];

                                $upload_data = $this->_product_option_image();
                                array_push($product_option_images_arr[$k],$upload_data['file_name']);
                                array_push($product_option_thumb_images_arr[$k],$this->_product_option_thumb_image($upload_data));
                                array_push($product_option_medium_images_arr[$k],$this->_product_option_medium_image($upload_data));
                            }
                        }
                        if(!empty($product_option_images_arr[$k])){
                            $product_option[$j]['option_id']=$_POST['option_id'][$i];
                            $product_option[$j]['availability']=$v;
                            $product_option[$j]['default_option']=0;
                            if($_POST['option_id'][$i]==$_POST['default_option']){
                                $product_option[$j]['default_option']=1;
                            }
                            $product_option[$j]['option_code']= $_POST['option_code'][$k];
                            $product_option[$j]['hsn_number']= $_POST['opt_hsn_number'][$k];
                            $product_option[$j]['option_qty']= $_POST['option_qty'][$k];
                            $product_option[$j]['weightingrams']= $_POST['weightingrams'][$k];
                            $product_option[$j]['product_option_images']=implode('__&&__',$product_option_images_arr[$k]);
                            $product_option[$j]['product_option_thumb_images']=implode('__&&__',$product_option_thumb_images_arr[$k]);
                            $product_option[$j]['product_option_medium_images']=implode('__&&__',$product_option_medium_images_arr[$k]);
                            $product_option[$j]['actual_price']= $_POST['actual_price'][$k];
                            $product_option[$j]['selling_price']= $_POST['selling_price'][$k];
                            $j++;
                        }
                    }

                }
                $i++;
            }
            if(!empty($product_option)){
                $postdetails['product_option']=$product_option;
            }

        }

		$getresult=$this->products_m->add($postdetails);
			
		if($getresult) {
			$this->session->set_flashdata('notify_success', "Successfully added!");
		} else {
			$this->session->set_flashdata('notify_error', "Problem while inserting!");
		}
        redirect('admin/products');
	}
	
	public function product_image() {
	
		if (isset($_FILES['thumb_image']) && !empty($_FILES['thumb_image']['name'])) {
		
			$upload_path   = 'images/upload/';
            if(!file_exists($upload_path)){
                mkdir($upload_path);
            }
            $upload_path.='products/';
            if(!file_exists($upload_path)){
                mkdir($upload_path);
            }

            $new_name = time().$_FILES["thumb_image"]['name'];
            $config1['file_name'] = $new_name;
            $config1['upload_path'] = $upload_path;
            $config1['allowed_types'] = '*';
            $this->load->library('upload', $config1);
            $this->upload->initialize($config1);
            if ($this->upload->do_upload('thumb_image')) {
                $upload_data = $this->upload->data();
                $_POST['product_image'] = $upload_data['file_name'];
                $_POST['product_thumb_image'] = $this->_product_thumb_image($upload_data);
                $_POST['product_medium_image'] = $this->_product_medium_image($upload_data);
                return true;
            }
		}
        $this->form_validation->set_message('product_image', "You must upload an image!");
        return false;
		
  	}

    public function _product_thumb_image($upload_data){
        $raw_name = $upload_data['raw_name'];
        $file_ext = $upload_data['file_ext'];
        $product_thumb_image=$raw_name.'_thumb'.$file_ext;

        $config['image_library'] = 'gd2';
        $config['source_image'] = $_FILES['thumb_image']['tmp_name'];
        $config['new_image'] = $upload_data['file_path'].$product_thumb_image;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 196;
        $config['height'] = 168;
        $config['master_dim'] = 'height';
        $this->load->library('image_lib', $config);
        $this->image_lib->initialize($config);
        if($this->image_lib->resize()){
            return $product_thumb_image;
        }
        $this->image_lib->clear();
        return false;
    }

    public function _product_medium_image($upload_data){
        $raw_name = $upload_data['raw_name'];
        $file_ext = $upload_data['file_ext'];
        $product_medium_image=$raw_name.'_medium'.$file_ext;

        $config['image_library'] = 'gd2';
        $config['source_image'] = $_FILES['thumb_image']['tmp_name'];
        $config['new_image'] = $upload_data['file_path'].$product_medium_image;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 392;
        $config['height'] = 336;
        $config['master_dim'] = 'height';
        $this->load->library('image_lib', $config);
        $this->image_lib->initialize($config);
        if($this->image_lib->resize()){
            return $product_medium_image;
        }
        $this->image_lib->clear();
        return false;
    }

	public function product_multi_images() {
	
		if (isset($_FILES['product_images']) && !empty($_FILES['product_images']['name'][0])) {

            $upload_path   = 'images/upload/';
            if(!file_exists($upload_path)){
                mkdir($upload_path);
            }
            $upload_path.='products/';
            if(!file_exists($upload_path)){
                mkdir($upload_path);
            }
            $config2['upload_path']=$upload_path;
			$config2['allowed_types'] = 'gif|GIF|JPG|jpg|jpeg|JPEG|PNG|png';
			$this->load->library('upload', $config2);
			$this->upload->initialize($config2);
			if ($this->upload->do_multi_upload('product_images')) {
                $upload_data = $this->upload->get_multi_upload_data();
                foreach ($upload_data as $key => $value) {
                    $orig_file=$value['file_name'];
                    $med_file_name=$value['raw_name']."_medium".$value['file_ext'];
                    $small_file_name=$value['raw_name']."_thumb".$value['file_ext'];

                    //---------Medium image------------
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $value['full_path'];
                    $config['new_image'] = $upload_path.$med_file_name;
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 320;
                    $config['height'] = 240;
                    $config['master_dim'] = 'width';
                    $this->load->library('image_lib', $config);
                    $this->image_lib->initialize($config);
                    if($this->image_lib->resize()){
                        $_POST['medium_image'][] = $med_file_name;
                    }
                    $this->image_lib->clear();
                    //---------------------

                    //------Small image---------------
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $value['full_path'];
                    $config['new_image'] = $upload_path.$small_file_name;
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 121;
                    $config['height'] = 121;
                    $config['master_dim'] = 'width';
                    $this->load->library('image_lib', $config);
                    $this->image_lib->initialize($config);
                    if($this->image_lib->resize()){
                        $_POST['thumb_image'][] = $small_file_name;
                    }
                    $this->image_lib->clear();
                    //---------------------

                    $_POST['orig_image'][] = $orig_file;
                }

				return true;
			} else {
				$this->form_validation->set_message('product_multi_images', $this->upload->display_errors());
				return false;
			}
			
		}
        return true;
		
  	}
	
	//-------------------
	
	public function edit() {
		$id = $this->uri->segment(4);

		$data['category_view']=$this->products_m->categoryview(0, 0);
        $data['category_view_exists']=$this->products_m->categoryview_exists($id);
        foreach($data['category_view_exists'] as $k=>$v){
            $product_category_ids[]=$v['category_id'];
        }
        
        $data['sgst_res']=$this->products_m->get_all_sgst();
        $data['cgst_res']=$this->products_m->get_all_cgst();

        $data['filter_view_exists']=$this->products_m->filterview_exists($id);
		if(!empty($product_category_ids)){
        $this->load->model('admin/categories_m');
			$data['filter_view']=$this->categories_m->get_category_filters($product_category_ids);
		}
       //
        $data['attribute_view_exists']=$this->products_m->attributeview_exists($id);
		$data['attribute_view']=$this->products_m->attributeview();

        $data['offer_products']=$this->products_m->get_offer_products($id);


        $data['option_view_exists']=$this->products_m->optionview_exists($id);
		$data['option_view']=$this->products_m->optionview();

        $data['image_view_exists']=$this->products_m->image_view_exists($id);

        $this->load->model('admin/coupon_m');
        $data['special_coupons']=$this->coupon_m->get_special_coupons();

		$data['admin_results']=$this->products_m->editview($id);

        $this->load->model('admin/settings_m');
        $data['web_settings'] = $this->settings_m->get();

        if(isset($_GET['offset'])){
            $data['offset']=$_GET['offset'];
        }
       // print_r($data['admin_results']);die;
		$this->template('admin/products/edit', $data);
	}
	
	public function open_optionsedit() {
		$id=$this->input->post('id');
        $data['options_view']=$this->products_m->open_optionsedit($id);
		$optid=$this->input->post('optid');
        $open_optionsedit_exists=$this->products_m->open_optionsedit_exists($optid);
       // print_r( $open_optionsedit_exists);
      
        if(!empty($open_optionsedit_exists)){
            $new_open_optionsedit_exists=array();
            foreach($open_optionsedit_exists as $k=>$v){
                $new_open_optionsedit_exists[$v['option_id']]=$v;
            }
            $data['open_optionsedit_exists']=$new_open_optionsedit_exists;
        }
       // print_r($data['open_optionsedit_exists']);die;

    
		echo $this->load->view('admin/products/options',$data);
	}
	
	public function process_edit() {
      //  print_r($_POST);
       // die;
		$id=$this->input->post('proid');
		
		$this->form_validation->set_rules('product_name','product name','required|trim|xss_clean');
		if (!empty($_FILES['thumb_image']['name'])) {
			$this->form_validation->set_rules('thumb_image', 'product image', 'callback_product_image');
		}
		if (!empty($_FILES['product_images']['name'])) {
			$this->form_validation->set_rules('product_images[]','image','callback_product_multi_images');
		}
	
		if($this->form_validation->run() == FALSE) {
			$data['category_view']=$this->products_m->categoryview(0, 0);
			$data['filter_view']=$this->products_m->filterview();
			$data['attribute_view']=$this->products_m->attributeview();
			$data['option_view']=$this->products_m->optionview();
			//$data['vendors_view']=$this->products_m->vendorsview();
			$data['admin_results']=$this->products_m->editview($id);
			$data['category_view_exists']=$this->products_m->categoryview_exists($id);
			$data['filter_view_exists']=$this->products_m->filterview_exists($id);
			$data['attribute_view_exists']=$this->products_m->attributeview_exists($id);
			$data['option_view_exists']=$this->products_m->optionview_exists($id);
			$data['discount_view_exists']=$this->products_m->discount_view_exists($id);
			$data['image_view_exists']=$this->products_m->image_view_exists($id);
			$this->template('admin/products/edit', $data);
		} else {
			$this->editsuccess($_POST);
		}
		
	}
	
	public function editsuccess($postdetails) {
        if(!empty($postdetails['availability'])){
            $i=0;
            $j=0;
            $files =$_FILES;
            foreach($postdetails['availability'] as $k=>$v){
                if(!empty($v)){
                    if(!empty($files['product_option_images']['name'][$k])){
                        $product_option_images_type = $files['product_option_images']['type'][$k];
                        $product_option_images_tmp_name = $files['product_option_images']['tmp_name'][$k];
                        $product_option_images_error = $files['product_option_images']['error'][$k];
                        $product_option_images_size = $files['product_option_images']['size'][$k];

                        $product_option_images_arr[$k][]=(isset($postdetails['product_option_images'][$k]))?$postdetails['product_option_images'][$k]:'';
                        $product_option_thumb_images_arr[$k][]=(isset($postdetails['product_option_thumb_images'][$k]))?$postdetails['product_option_thumb_images'][$k]:'';
                        $product_option_medium_images_arr[$k][]=(isset($postdetails['product_option_medium_images'][$k]))?$postdetails['product_option_medium_images'][$k]:'';
                        foreach($files['product_option_images']['name'][$k] as $k1=>$v1){
                            if(!empty($v1)){
                                $_FILES['product_option_images']['name']= $v1;
                                $_FILES['product_option_images']['type']= $product_option_images_type[$k1];
                                $_FILES['product_option_images']['tmp_name']= $product_option_images_tmp_name[$k1];
                                $_FILES['product_option_images']['error']= $product_option_images_error[$k1];
                                $_FILES['product_option_images']['size']= $product_option_images_size[$k1];

                                $upload_data = $this->_product_option_image();
                                array_push($product_option_images_arr[$k],$upload_data['file_name']);
                                array_push($product_option_thumb_images_arr[$k],$this->_product_option_thumb_image($upload_data));
                                array_push($product_option_medium_images_arr[$k],$this->_product_option_medium_image($upload_data));
                            }
                        }
                        if(!empty($product_option_images_arr[$k])){
                            $product_option[$j]['option_id']=$_POST['option_id'][$i];
                            $product_option[$j]['default_option']=0;
                            if($_POST['option_id'][$i]==$_POST['default_option']){
                                $product_option[$j]['default_option']=1;
                            }
                            $product_option[$j]['availability']=$v;
                            $product_option[$j]['option_code']= $_POST['option_code'][$k];
                            $product_option[$j]['hsn_number']= $_POST['opt_hsn_number'][$k];
                            $product_option[$j]['option_qty']= $_POST['option_qty'][$k];
                            $product_option[$j]['weightingrams']= $_POST['weightingrams'][$k];
                            $product_option[$j]['product_option_images']=trim(implode('__&&__',$product_option_images_arr[$k]),'__&&__');
                            $product_option[$j]['product_option_thumb_images']=trim(implode('__&&__',$product_option_thumb_images_arr[$k]),'__&&__');
                            $product_option[$j]['product_option_medium_images']=trim(implode('__&&__',$product_option_medium_images_arr[$k]),'__&&__');
                            $product_option[$j]['actual_price']= $_POST['actual_price'][$k];
                            $product_option[$j]['selling_price']= $_POST['selling_price'][$k];
                            $j++;
                        }
                    }

                }
                $i++;
            }
            if(!empty($product_option)){
                $postdetails['product_option']=$product_option;
            }

        }
        if(isset($postdetails['offset'])){
            $offset = $postdetails['offset'];
            unset($postdetails['offset']);
        }
  
		$getresult=$this->products_m->edit($postdetails);
			
		if($getresult) {
			$this->session->set_flashdata('notify_success', "Successfully updated!");
		} else {
			$this->session->set_flashdata('notify_error', "Problem while updating!");
		}
        if(isset($offset)){
            redirect('admin/products?offset='.$offset);
        }else{
            redirect('admin/products');
        }

	}

    public function _product_option_image() {

        if (isset($_FILES['product_option_images']) && !empty($_FILES['product_option_images']['name'])) {

            $upload_path   = 'images/upload/';
            if(!file_exists($upload_path)){
                mkdir($upload_path);
            }
            $upload_path.='product_option_images/';
            if(!file_exists($upload_path)){
                mkdir($upload_path);
            }

            $new_name = time().$_FILES["product_option_images"]['name'];
            $config1['file_name'] = $new_name;
            $config1['upload_path'] = $upload_path;
            $config1['allowed_types'] = '*';
            $this->load->library('upload', $config1);
            $this->upload->initialize($config1);
            if ($this->upload->do_upload('product_option_images')) {
                $upload_data = $this->upload->data();
                return $upload_data;
            }
        }
        $this->form_validation->set_message('product_option_images', "You must upload an image!");
        return false;

    }


    public function _product_option_thumb_image($upload_data){
        $raw_name = $upload_data['raw_name'];
        $file_ext = $upload_data['file_ext'];
        $product_option_thumb_image=$raw_name.'_thumb'.$file_ext;

        $config['image_library'] = 'gd2';
        $config['source_image'] = $_FILES['product_option_images']['tmp_name'];
        $config['new_image'] = $upload_data['file_path'].$product_option_thumb_image;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 121;
        $config['height'] = 121;
        $config['master_dim'] = 'width';
        $this->load->library('image_lib', $config);
        $this->image_lib->initialize($config);
        if($this->image_lib->resize()){
            return $product_option_thumb_image;
        }
        $this->image_lib->clear();
        return false;
    }

    public function _product_option_medium_image($upload_data){
        $raw_name = $upload_data['raw_name'];
        $file_ext = $upload_data['file_ext'];
        $product_option_medium_image=$raw_name.'_medium'.$file_ext;

        $config['image_library'] = 'gd2';
        $config['source_image'] = $_FILES['product_option_images']['tmp_name'];
        $config['new_image'] = $upload_data['file_path'].$product_option_medium_image;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 320;
        $config['height'] = 240;
        $config['master_dim'] = 'width';
        $this->load->library('image_lib', $config);
        $this->image_lib->initialize($config);
        if($this->image_lib->resize()){
            return $product_option_medium_image;
        }
        $this->image_lib->clear();
        return false;
    }

	
	public function delete() {
		$id = $this->uri->segment(4);
		$getresult=$this->products_m->delete($id);
			
		if($getresult) {
			$this->session->set_flashdata('notify_success', "Successfully removed!");
		} else {
			$this->session->set_flashdata('notify_error', "Problem while deleting!");
		}
        if(isset($_GET['offset'])){
            $offset = $_GET['offset'];
            redirect('admin/products?offset='.$offset);
        }else{
            redirect('admin/products');
        }
	}
	
	public function deactivate() {
	
		$id = $this->uri->segment(4);
		$getresult=$this->products_m->deactivate($id);
			
		if($getresult) {
			$this->session->set_flashdata('notify_success', "Successfully deactivated!");
		} else {
			$this->session->set_flashdata('notify_error', "Problem while deactivate!");
		}
        if(isset($_GET['offset'])){
            $offset = $_GET['offset'];
            redirect('admin/products?offset='.$offset);
        }else{
            redirect('admin/products');
        }
	}
	
	public function activate() {
	
		$id = $this->uri->segment(4);
		$getresult=$this->products_m->activate($id);
			
		if($getresult) {
			$this->session->set_flashdata('notify_success', "Successfully activated!");
		} else {
			$this->session->set_flashdata('notify_error', "Problem while activate!");
		}
        if(isset($_GET['offset'])){
            $offset = $_GET['offset'];
            redirect('admin/products?offset='.$offset);
        }else{
            redirect('admin/products');
        }
	}
	

	
	public function remove_attribute() {
	
		$id=$this->input->post('id');
		$getresult=$this->products_m->remove_attribute($id);
		if($getresult) {
			return true;
		} else {
			return true;
		}
		
	}
	
	public function remove_image() {
	
		$id=$this->input->post('id');
		$this->products_m->remove_image($id);
	}


    public function process_action(){
        if($_POST['action']=='activate'){
            $this->multi_activate();
        }
        if($_POST['action']=='deactivate'){
            $this->multi_deactivate();
        }
        if($_POST['action']=='delete'){
            $this->multi_delete();
        }
    }

    public function multi_activate(){
        $this->products_m->multi_activate();
        if(isset($_POST['offset'])){
            $offset = $_POST['offset'];
            redirect('admin/products?offset='.$offset);
        }else{
            redirect('admin/products');
        }
    }

    public function multi_deactivate(){
        $this->products_m->multi_deactivate();
        if(isset($_POST['offset'])){
            $offset = $_POST['offset'];
            redirect('admin/products?offset='.$offset);
        }else{
            redirect('admin/products');
        }
    }

    public function multi_delete(){
        $this->products_m->multi_delete();
        if(isset($_POST['offset'])){
            $offset = $_POST['offset'];
            redirect('admin/products?offset='.$offset);
        }else{
            redirect('admin/products');
        }
    }
	
}
?>