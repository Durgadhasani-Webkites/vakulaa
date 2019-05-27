<?php
class Admin_Controller extends MY_Controller {

    function __construct(){
        parent::__construct();
        ini_set('max_execution_time', 0);
        $this->load->model('admin/modules_m');
        $this->modules=$this->modules_m->get_all_modules();
        $privileges=explode(",", $this->session->userdata('privileges'));
        //print_r($this->modules);die;
        if(!empty($this->modules)){
            foreach($this->modules as $k=>$v){
                if(!empty($v['sub_modules'])){
                    foreach($v['sub_modules'] as $k1=>$v1){
                        if($this->uri->segment(2)==$v1['link'] && !in_array($v1['id'], $privileges)){
                            redirect('admin/index');
                        }
                    }
                }else{
                    if($this->uri->segment(2)==$v['link'] && !in_array($v['id'], $privileges)) {
                        redirect('admin/index');
                    }
                }
            }
        }
    }

    public function template($view = '',$data=array()){
        $data['modules']=$this->modules;
        $data['unseen_orders']= $this->get_unseen_orders();
        $this->load->view('admin/common/header',$data);
        $this->load->view($view, $data);
        $this->load->view('admin/common/footer',$data);
    }

    public function get_unseen_orders(){
        $offset=0;
        $limit=5;
        $filter_data['seen_status']=0;
        $this->load->model('admin/orders_m');
        $response['list']=$this->orders_m->get_all($filter_data,$offset,$limit);
        $response['count']=$this->orders_m->get_total($filter_data);
        return $response;
    }
	
}
?>