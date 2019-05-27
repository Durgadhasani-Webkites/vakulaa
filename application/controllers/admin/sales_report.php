<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_Report extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $privileges=explode(",", $this->session->userdata('privileges'));
        if(!in_array(22, $privileges)) {
            redirect('admin/index/logout');
        }
        $this->load->model('admin/sales_report_m');
    }

    public function index() {

        $this->template('admin/sales_report/view');
    }

    public function orders_ajax(){

        $this->load->model('admin/orders_m');

        $offset=$_GET['start'];

        $limit=$_GET['length'];

        $filter_data=array();


        if(!empty($_GET['search']['value'])){
            $filter_data['search']=$_GET['search']['value'];
        }

        if(!empty($_GET['formValues'])){
            parse_str($_GET['formValues'],$filter_data);
        }

        if(!empty($_GET['order'][0]['column'])){
            $filter_data['order']['column']=$_GET['order'][0]['column'];
            $filter_data['order']['dir']= $_GET['order'][0]['dir'];
        }

        $admin_results=$this->sales_report_m->get_all($filter_data,$offset,$limit);

        $total_results=$this->sales_report_m->get_total($filter_data);
        $net_total=0;
        if(!empty($total_results)){
            foreach($total_results as $k=>$v){
                $net_total += $v['net_total'];
            }
        }
        $total_results= count($total_results);

        $dataTableData=array();

        $dataTableData['draw']=$_GET['draw'];

        $dataTableData['recordsTotal']=$total_results;

        $dataTableData['recordsFiltered']=$total_results;

        $dataTableData['order_cost']=$net_total;

        $dataTableData['data']=[];

        if(!empty($admin_results)){

            foreach($admin_results as $k=>$v){

                $dataTableData['data'][$k][0]=$v['order_id'];

                $dataTableData['data'][$k][1]=$v['shipping_user_name'];

                $net_total = $v['net_total'];

                $dataTableData['data'][$k][2]=$net_total;

                $dataTableData['data'][$k][3]=$v['order_type'];

                $dataTableData['data'][$k][4]=($v['created']!='0000-00-00 00:00:00')?date('d/m/Y',strtotime($v['created'])):'-';

                if($v['order_type']=='online'){
                    $dataTableData['data'][$k][5] = '<a class="btn btn-primary btn-sm mb5"  target="_blank" title="click to view invoice" href="' . base_url('admin/sales_report/view_invoice/' . $v['id']) . '">Invoice</a>';
                }else{
                    $dataTableData['data'][$k][5] = '<a class="btn btn-primary btn-sm mb5"  target="_blank" title="click to view bill" href="' . base_url('admin/sales_report/view_bill/' . $v['order_id']) . '">Bill</a>';
                }
            }

        }
        echo json_encode($dataTableData);

    }


    public function products_ajax(){



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

        $admin_results=$this->sales_report_m->get_product_sales_report($filter_data,$offset,$limit);

        $total_results=$this->sales_report_m->get_total_product_sales_report($filter_data);

        $dataTableData=array();

        $dataTableData['draw']=$_GET['draw'];

        $dataTableData['recordsTotal']=$total_results;

        $dataTableData['recordsFiltered']=$total_results;

        $dataTableData['data']=[];

        if(!empty($admin_results)){

            foreach($admin_results as $k=>$v){

                $dataTableData['data'][$k][0]=$v['prod_name'].'<br/>('. $v['prod_code'].')';

                $dataTableData['data'][$k][1]=$v['quantity'];

                $dataTableData['data'][$k][2]=$v['order_cost'];

            }

        }
        echo json_encode($dataTableData);

    }

    public function view_bill($order_id){
        $this->load->model('admin/bill_m');
        $data['bill_results'] = $this->bill_m->get_bill($order_id);
        $this->load->model('admin/settings_m');
        $data['supermarket_results'] = $this->settings_m->get_supermarket_results();
        if(!empty($data['bill_results'])){
            foreach($data['bill_results'] as $k=>$v){
                $data['bill_id'] = $v['bill_id'];
                $data['delivery_cost'] = $v['delivery_cost'];
                $data['payment_status'] = $v['payment_status'];
                $data['remarks'] = $v['comments'];
            }
        }
        $this->template('admin/sales_report/view_bill',$data);
    }

    public function view_invoice($id){
        $this->load->model('admin/orders_m');
        $data['order_details'] = $this->orders_m->get($id);
        $order_id = $data['order_details']['order_id'];
        $data['cart_items'] = $this->orders_m->get_cart_items($order_id);
        if(!empty($data['cart_items'])){
            foreach($data['cart_items'] as $k=>$v){
                $filter['cart_id']=$v['id'];
                $order_status = $this->orders_m->get_order_status($filter);
                $status_text='';
                if(!empty($order_status)){
                    $status_text = $order_status['status_text'];
                }
                $data['cart_items'][$k]['status_text'] = $status_text;
                $cart_offer_prod = $this->orders_m->get_cart_offer_products($v['id']);
                $data['cart_items'][$k]['cart_offer_prod']=$cart_offer_prod;
            }
        }

        $this->load->model('admin/settings_m');
        $data['supermarket_results'] = $this->settings_m->get_supermarket_results();

        $data['order_history'] = $this->orders_m->get_order_history($data['order_details']['id']);


        $this->template('admin/sales_report/view_invoice',$data);
    }

}
?>