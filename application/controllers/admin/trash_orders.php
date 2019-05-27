<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Trash_Orders extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/trash_orders_m');
    }

    public function index(){
        $this->template('admin/trash_orders/view');
    }

    public function ajax_index(){

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

        $admin_results=$this->trash_orders_m->get_all($filter_data,$offset,$limit);

        $total_results=$this->trash_orders_m->get_total($filter_data);

        $dataTableData=array();

        $dataTableData['draw']=$_GET['draw'];

        $dataTableData['recordsTotal']=$total_results;

        $dataTableData['recordsFiltered']=$total_results;

        $dataTableData['data']=[];

        if(!empty($admin_results)){

            foreach($admin_results as $k=>$v){
                if($v['order_type']=='offline'){
                    $order_type='<span class="label label-warning">Offline</span>';
                }else{
                    $order_type='<span class="label label-success">Online</span>';
                }
                $dataTableData['data'][$k][0]=$v['order_id'].'<br/><b>Order Type: </b>'.$order_type;

                $dataTableData['data'][$k][1]=$v['shipping_user_name'];

                $dataTableData['data'][$k][2]=$v['shipping_user_contact_no'];

                $net_total = $v['net_total']-$v['coupon_discount'];

                $dataTableData['data'][$k][3]=$net_total;

                $dataTableData['data'][$k][4]=$v['payment_mode'];

                $dataTableData['data'][$k][5]=date('d/m/Y h:i:s A',strtotime($v['created']));

                if($v['payment_status']==2){
                    $status_text='<span class="label label-success">Paid</span>';
                }elseif($v['status'] == 4){
                    $status_text = '<span class="label label-warning">Cancelled</span>';
                }else{
                    $status_text='<span class="label label-danger">Not Paid</span>';
                }

                $dataTableData['data'][$k][6]=$status_text;

                if($v['order_type']=='offline'){
                    $dataTableData['data'][$k][7] = '<a class="btn btn-primary btn-sm mb5" target="_blank" title="click to view bill" href="' . base_url('admin/trash_orders/view_bill/' . $v['order_id']) . '">Bill</a>';
                }else{
                    $dataTableData['data'][$k][7] = '<a class="btn btn-primary btn-sm mb5" target="_blank" title="click to view invoice" href="' . base_url('admin/trash_orders/view_invoice/' . $v['id']) . '">Invoice</a>';
                }

                $dataTableData['data'][$k][7] .= '<a class="btn btn-danger btn-sm mb5" title="click to restore" href="' . base_url('admin/trash_orders/restore_bill/' . $v['id']) . '">Restore</a>';
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
                $data['discount_percent'] = $v['discount_percent'];
                $data['payment_status'] = $v['payment_status'];
                $data['remarks'] = $v['comments'];
            }
        }

        $this->template('admin/trash_orders/view_bill',$data);
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


        $this->template('admin/trash_orders/view_invoice',$data);
    }


    public function restore_bill($id){
        $this->trash_orders_m->restore_bill($id);
        redirect('admin/trash_orders');
    }


}