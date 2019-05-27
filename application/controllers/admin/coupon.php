<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coupon extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/coupon_m');
    }

    public function index() {
        $this->template('admin/coupon/view');
    }

    public function ajax_index(){
        $offset=$_GET['start'];
        $limit=$_GET['length'];
        $filter_data=array();
        if(!empty($_GET['search']['value'])){
            $filter_data['search']=$_GET['search']['value'];
        }
        if(!empty($_GET['order'][0]['column'])){
            $filter_data['order']['column']=$_GET['order'][0]['column'];
            $filter_data['order']['dir']= $_GET['order'][0]['dir'];
        }

        $admin_results=$this->coupon_m->get_all($filter_data,$offset,$limit);
        $total_results=$this->coupon_m->get_total($filter_data);
        $dataTableData=array();
        $dataTableData['draw']=$_GET['draw'];
        $dataTableData['recordsTotal']=$total_results;
        $dataTableData['recordsFiltered']=$total_results;
        $dataTableData['data']=[];
        if(!empty($admin_results)){
            foreach($admin_results as $k=>$v){
                $id=$v['id'];
                $status = '<span class="label label-danger">InActive</span>';
                if($v['status']==2){
                    $status = '<span class="label label-success">Active</span>';
                }
                $dataTableData['data'][$k][0]='<label class="option block mn">
                                            <input type="checkbox" name="id[]" class="mul_ch" value="'.$id.'">
                                            <span class="checkbox mn"></span>
                                        </label>';
                $dataTableData['data'][$k][1]=$v['coupon_name'];
                $dataTableData['data'][$k][2]=$v['coupon_code'];
                if($v['valid_from']!='0000-00-00'){
                    $valid_from = date('d/m/Y',strtotime($v['valid_from']));
                }else{
                    $valid_from = "-";
                }
                if($v['valid_to']!='0000-00-00'){
                    $valid_to = date('d/m/Y',strtotime($v['valid_to']));
                }else{
                    $valid_to = "-";
                }
                $dataTableData['data'][$k][3]=$valid_from;
                $dataTableData['data'][$k][4]=$valid_to;
                $dataTableData['data'][$k][5]=date('Y-m-d',strtotime($v['created']));
                $dataTableData['data'][$k][6]=$status;
                $dataTableData['data'][$k][7] = '<div class="btn-group text-right">
                                            <button type="button" class="btn btn-success br2 btn-xs fs12 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Change
                                                <span class="caret ml5"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <a title="click to edit" href="'. base_url('admin/coupon/edit/'.$id).'">Edit</a>
                                                    <a title="click to activate" href="'. base_url('admin/coupon/activate/'.$id).'">Activate</a>
                                                    <a title="click to deactivate" href="'. base_url('admin/coupon/deactivate/'.$id).'">Deactivate</a>
                                                    <a class="confirm" title="click to delete" href="'.base_url('admin/coupon/delete/'.$id).'">Remove</a>
                                                </li>
                                            </ul>
                                        </div>';

            }

        }
        echo json_encode($dataTableData);

    }

    public function add(){
        $this->load->model('admin/products_m');
        $data['category_view']=$this->products_m->categoryview(0, 0);
        $this->template('admin/coupon/add',$data);
    }

    public function process_add()
    {
        $res=$this->db->get_where('admin_coupon',array('coupon_code'=>$_POST['coupon_code']))->num_rows();
        if(!$res){
            $this->coupon_m->add($_POST);
        }else{
            $this->session->set_flashdata('notify_error', "Details already added!");
        }
        redirect('admin/coupon');
    }

    public function edit($id)
    {
        $this->load->model('admin/products_m');
        $data['category_view']=$this->products_m->categoryview(0, 0);
        $data['admin_results'] = $this->coupon_m->get($id);
        $this->template('admin/coupon/edit', $data);
    }

    public function process_edit()
    {
        $this->coupon_m->update($_POST['id'],$_POST);
        redirect('admin/coupon');
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
        $this->coupon_m->multi_activate();
        redirect('admin/coupon');
    }

    public function multi_deactivate(){
        $this->coupon_m->multi_deactivate();
        redirect('admin/coupon');
    }

    public function multi_delete(){
        $this->coupon_m->multi_delete();
        redirect('admin/coupon');
    }


    public function activate($id){
        $this->coupon_m->activate($id);
        redirect('admin/coupon');
    }

    public function deactivate($id){
        $this->coupon_m->deactivate($id);
        redirect('admin/coupon');
    }

    public function delete($id) {
        $this->coupon_m->delete($id);
        redirect('admin/coupon');
    }
}
?>