<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customers extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/customers_m');
    }

    public function index(){
        $this->template('admin/customers/view');
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

        $admin_results=$this->customers_m->get_all($filter_data,$offset,$limit);

        $total_results=$this->customers_m->get_total($filter_data);

        $dataTableData=array();

        $dataTableData['draw']=$_GET['draw'];

        $dataTableData['recordsTotal']=$total_results;

        $dataTableData['recordsFiltered']=$total_results;

        $dataTableData['data']=[];

        if(!empty($admin_results)){

            foreach($admin_results as $k=>$v){

                $dataTableData['data'][$k][0]='<label class="option block mn">
                                            <input type="checkbox" name="id[]" class="mul_ch" value="'.$v['id'].'">
                                            <span class="checkbox mn"></span>
                                        </label>';

                $dataTableData['data'][$k][1]=$v['user_name'];

                $dataTableData['data'][$k][2]=$v['user_email'];

                $dataTableData['data'][$k][3]=$v['user_phone'];

                $dataTableData['data'][$k][4]=date('d/m/Y h:i:s A',strtotime($v['created']));

                $dataTableData['data'][$k][5] = '<a class="btn btn-primary btn-sm mb5" title="Order history" href="' . base_url('admin/customers/order_history/'.$v['id']) . '">Order History</a>';
                $dataTableData['data'][$k][5] .= '<a class="btn btn-success btn-sm mb5" title="Shipping Addres" href="' . base_url('admin/customers/shipping_address/'.$v['id']) . '">Shipping Address</a>';
                $dataTableData['data'][$k][5] .= '<a class="btn btn-danger btn-sm mb5 confirm" title="Delete" href="' . base_url('admin/customers/delete/'.$v['id']) . '">Delete</a>';
            }

        }
        echo json_encode($dataTableData);

    }

    public function order_history($id){
        $offset =0;
        $limit =5;
        $filter['customer_id']=$id;
        $order_results=$this->customers_m->get_order_history($filter,$limit,$offset);
        $total_orders=$this->customers_m->get_total_order_history($filter);

        $data['order_history'] = $order_results;

        $this->load->library('pagination');
        $base_url = base_url() . 'admin/customers/order_history_ajax/'.$id;
        $config['base_url'] = $base_url;
        $config['total_rows'] = $total_orders;
        $config['per_page'] = $limit;
        $config['uri_segment'] = 5;
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tag_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tag_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tag_close'] = "</li>";
        $this->pagination->initialize($config);
        $jsFunction['name'] = 'ajax_paginate';
        $jsFunction['params'] = array();
        $this->pagination->initialize_js_function($jsFunction);
        $data['page_link'] = $this->pagination->create_js_links();
        $data['base_url'] = $base_url;
        $this->template('admin/customers/order_history',$data);
    }

    public function order_history_ajax($id,$offset=0){
        $filter['customer_id']=$id;
        $limit =5;
        $order_results=$this->customers_m->get_order_history($filter,$limit,$offset);
        $total_orders=$this->customers_m->get_total_order_history($filter);
        $data['order_history'] = $order_results;
        $this->load->library('pagination');
        $base_url = base_url() . 'admin/customers/order_history_ajax/'.$id;
        $config['base_url'] = $base_url;
        $config['total_rows'] = $total_orders;
        $config['per_page'] = $limit;
        $config['uri_segment'] = 5;
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tag_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tag_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tag_close'] = "</li>";
        $this->pagination->initialize($config);
        $jsFunction['name'] = 'ajax_paginate';
        $jsFunction['params'] = array();
        $this->pagination->initialize_js_function($jsFunction);
        $response['page_link'] = $this->pagination->create_js_links();
        $data['base_url'] = $base_url;
        $response['html'] = $this->load->view('admin/customers/order_history_ajax', $data, true);

        echo json_encode($response);
    }

    public function customers_download(){
        $results=$this->customers_m->get_all_customers();
       // print_r($results);die;
        if(!empty($results)){
            $table_columns = array('ID','Name','Email','Phone No','Registered','Status');

            $this->load->library("excel");
            $object = new PHPExcel();

            $object->setActiveSheetIndex(0);
            $column = 0;
            foreach($table_columns as $field)
            {
                $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
                $column++;
            }

            $excel_row = 2;
            foreach($results as $k=>$v) {

               $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $v['id']);
               $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $v['user_name']);
               $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $v['user_email']);
               $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $v['user_phone']);
               $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $v['created']);
               $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $v['status']);
                $excel_row++;
            }
            $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="customers_'.date("ymdhis").'.xls"');
            $object_writer->save('php://output');

        }else{
            $this->session->set_flashdata('notify_error',"No details found");
            redirect('admin/customers');
        }
    }

    public function view_invoice($id){
        $this->load->model('user_m');
        $data['order_details'] = $this->user_m->get_order_detail($id);
        $order_id = $data['order_details']['order_id'];
        $data['cart_items'] = $this->user_m->get_cart_items($order_id);
        //  print_r($data);die;
        if(!empty($data['cart_items'])){
            foreach($data['cart_items'] as $k=>$v){
                $cart_offer_prod = $this->user_m->get_cart_offer_products($v['id']);
                $data['cart_items'][$k]['cart_offer_prod']=$cart_offer_prod;
            }
        }
        $this->load->model('admin/settings_m');
        $data['supermarket_results'] = $this->settings_m->get_supermarket_results();
        $this->template('admin/customers/view_invoice',$data);
    }

    public function track_invoice($order_id){
        $data['order_details'] = $this->customers_m->get_order($order_id);
        $this->load->model('user_m');
        $data['cart_items'] = $this->user_m->get_cart_items($order_id);
        if(!empty($data['cart_items'])){
            foreach($data['cart_items'] as $k=>$v){
                $cart_offer_prod = $this->user_m->get_cart_offer_products($v['id']);
                $status_results  = $this->customers_m->get_order_status($data['order_details']['id'],$v['id']);
                $new_status=array();
                if(!empty($status_results)){
                    foreach($status_results as $k1=>$v1){
                        $new_status[$v1['status_text']]=$v1;
                    }
                }
                $data['cart_items'][$k]['status_results']  = $new_status;
                $data['cart_items'][$k]['cart_offer_prod']=$cart_offer_prod;
            }
        }
       // print_r($data);die;
        $this->template('admin/customers/view_invoice_track',$data);
    }

    public function shipping_address($customer_id){
        $data['customer_id']=$customer_id;
        $this->template('admin/customers/view_shipping_address',$data);
    }

    public function shipping_address_index(){

        $offset=$_GET['start'];

        $limit=$_GET['length'];

        $filter_data=array();


        if(!empty($_GET['customer_id'])){
            $filter_data['customer_id']=$_GET['customer_id'];
        }

        if(!empty($_GET['search']['value'])){
            $filter_data['search']=$_GET['search']['value'];
        }

        if(!empty($_GET['order'][0]['column'])){
            $filter_data['order']['column']=$_GET['order'][0]['column'];
            $filter_data['order']['dir']= $_GET['order'][0]['dir'];
        }

        $admin_results=$this->customers_m->get_all_shipping_address($filter_data,$offset,$limit);

        $total_results=$this->customers_m->get_total_shipping_address($filter_data);

        $dataTableData=array();

        $dataTableData['draw']=$_GET['draw'];

        $dataTableData['recordsTotal']=$total_results;

        $dataTableData['recordsFiltered']=$total_results;

        $dataTableData['data']=[];

        if(!empty($admin_results)){

            foreach($admin_results as $k=>$v){


                $dataTableData['data'][$k][0]=$v['first_name'].' '.$v['last_name'];

                $dataTableData['data'][$k][1]=$v['email_address'];

                $dataTableData['data'][$k][2]=$v['contact_number'];

                $dataTableData['data'][$k][3]=$v['city_name'];

                $dataTableData['data'][$k][4]=$v['pincode'];

                $default_address ='<i class="fa fa-times"></i>';
                if($v['default_address']==1){
                    $default_address ='<i class="fa fa-check"></i>';
                }

                $dataTableData['data'][$k][5]=$default_address;

                $dataTableData['data'][$k][6]=date('d/m/Y h:i:s A',strtotime($v['created']));

                $dataTableData['data'][$k][7] = '<a class="btn btn-success btn-sm mb5" title="Edit" href="' . base_url('admin/customers/shipping_address_edit/'.$v['id']) . '">Edit</a>';
                $dataTableData['data'][$k][7] .= '<a class="btn btn-danger btn-sm mb5" title="Delete" href="' . base_url('admin/customers/shipping_address_delete/'.$v['id']) . '">Delete</a>';
            }

        }
        echo json_encode($dataTableData);

    }

    public function shipping_address_add($customer_id){
        $data['customer_id'] = $customer_id;
        $this->template('admin/customers/add_shipping_address',$data);
    }

    public function process_add_shipping_address(){
        $result=$this->customers_m->add_shipping_address($_POST);

        if($result) {
            $this->session->set_flashdata('notify_success', "Successfully added!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while adding details!");
        }
        redirect('admin/customers/shipping_address/'.$_POST['user_id']);
    }

    public function shipping_address_edit($id){
        $data = $this->customers_m->get_shipping_address($id);
        $this->template('admin/customers/edit_shipping_address',$data);
    }

    public function process_edit_shipping_address(){
        $result=$this->customers_m->edit_shipping_address($_POST);

        if($result) {
            $this->session->set_flashdata('notify_success', "Successfully updated!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while updating details!");
        }
        redirect('admin/customers/shipping_address/'.$result['user_id']);
    }

    public function shipping_address_delete($id){
        $result=$this->customers_m->delete_shipping_address($id);
        if($result) {
            $this->session->set_flashdata('notify_success', "Successfully deleted!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while deleting details!");
        }
        redirect('admin/customers/shipping_address/'.$result['user_id']);
    }

    public function delete($id){
        $result=$this->customers_m->delete($id);
        if($result) {
            $this->session->set_flashdata('notify_success', "Successfully deleted!");
        } else {
            $this->session->set_flashdata('notify_error', "Problem while deleting details!");
        }
        redirect('admin/customers');
    }

    public function process_action(){
        if($_POST['action']=='delete'){
            $this->multi_delete();
        }
    }

    public function multi_delete(){
        $this->customers_m->multi_delete();
        redirect('admin/customers');
    }



}