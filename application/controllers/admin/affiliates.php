<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Affiliates extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/affiliates_m');
    }

    public function index(){
        $this->template('admin/affiliates/view');
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

        $admin_results=$this->affiliates_m->get_all($filter_data,$offset,$limit);

        $total_results=$this->affiliates_m->get_total($filter_data);

        $dataTableData=array();

        $dataTableData['draw']=$_GET['draw'];

        $dataTableData['recordsTotal']=$total_results;

        $dataTableData['recordsFiltered']=$total_results;

        $dataTableData['data']=[];

        if(!empty($admin_results)){

            foreach($admin_results as $k=>$v){

                $dataTableData['data'][$k][0]=$v['user_name'];

                $dataTableData['data'][$k][1]=$v['user_email'];

                $dataTableData['data'][$k][2]=$v['user_mobile'];

                $dataTableData['data'][$k][3]=$v['business_type'];

                $dataTableData['data'][$k][4]=$v['business_name'];

                $dataTableData['data'][$k][5]=date('d/m/Y h:i:s A',strtotime($v['created']));

                $dataTableData['data'][$k][6]='<a class="btn btn-primary btn-sm mb5" target="_blank" title="click to view" href="' . base_url('admin/affiliates/view/' . $v['id']) . '">View</a>';
            }

        }
        echo json_encode($dataTableData);

    }

    public function view($id){
        $data = $this->affiliates_m->get($id);
        $this->template('admin/affiliates/view_detail',$data);
    }



}