<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Failed_Orders extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/failed_orders_m');
    }

    public function index(){
        $this->template('admin/failed_orders/view');
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

        $admin_results=$this->failed_orders_m->get_all($filter_data,$offset,$limit);

        $total_results=$this->failed_orders_m->get_total($filter_data);

        $dataTableData=array();

        $dataTableData['draw']=$_GET['draw'];

        $dataTableData['recordsTotal']=$total_results;

        $dataTableData['recordsFiltered']=$total_results;

        $dataTableData['data']=[];

        if(!empty($admin_results)){

            foreach($admin_results as $k=>$v){

                $dataTableData['data'][$k][0]=$v['order_id'];

                $dataTableData['data'][$k][1]=$v['shipping_user_name'];

                $dataTableData['data'][$k][2]=$v['shipping_user_contact_no'];

                $net_total = $v['net_total']-$v['coupon_discount'];

                $dataTableData['data'][$k][3]=$net_total;

                $dataTableData['data'][$k][4]=$v['payment_mode'];

                $dataTableData['data'][$k][5]=($v['created']!='0000-00-00 00:00:00')?date('d/m/Y h:i:s A',strtotime($v['created'])):'-';

                if($v['payment_status']==2){
                    $status_text='<span class="label label-success">Paid</span>';
                }else{
                    $status_text='<span class="label label-danger">Not Paid</span>';
                }

                $dataTableData['data'][$k][6]=$status_text;

            }

        }
        echo json_encode($dataTableData);

    }



}