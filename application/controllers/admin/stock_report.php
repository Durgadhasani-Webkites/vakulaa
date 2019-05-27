<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock_Report extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $privileges=explode(",", $this->session->userdata('privileges'));
        if(!in_array(25, $privileges)) {
            redirect('admin/index/logout');
        }
        $this->load->model('admin/stock_report_m');
    }

    public function index() {
        $this->template('admin/stock_report/view');
    }


    public function get_category(){
        if(isset($_GET['q'])){
            $filter_data['search']=$_GET['q'];
        }
        $offset=0;
        $limit=$_GET['limit'];
        if(isset($_GET['page']) && $_GET['page']>0){
            $offset= ($_GET['page']-1)*$limit;
        }
        $filter_data['active']=true;
        $option_res=$this->stock_report_m->get_all_category($filter_data,$offset,$limit);
        $items=array();
        if(!empty($option_res)){
            $i=0;
            foreach($option_res as $k=>$v){
                $items[$i]['title']=$v['category_name'];
                $items[$i]['id']=$v['id'];
                $i++;
            }
        }
        $data['items']=$items;
        $data['total_count']=$this->stock_report_m->get_total_category($filter_data);
        echo json_encode($data);
    }

    public function process(){

        $report_results=$this->stock_report_m->get_stock_report($_POST);
        if(!empty($report_results)){
            $table_columns = array('Product','Stock','Per Cost','value');

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
            foreach($report_results as $k=>$v) {
              if(!empty($v['product_name'])){
                $price = $v['price'];
                $stock = $v['stock'];
                $total_cost = $stock * $price;
                $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $v['product_name']);
                $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $stock);
                $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $price);
                $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $total_cost);
                $excel_row++;
              }
            }

            $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="stock_report_'.date("ymdhis").'.xls"');
            $object_writer->save('php://output');

        }else{
            $this->session->set_flashdata('notify_error',"No details found");
            redirect('admin/stock_report');
        }
    }

}
?>
