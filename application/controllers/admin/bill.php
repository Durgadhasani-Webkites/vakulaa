<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Bill extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/bill_m');
    }

    public function index()
    {
        $this->load->model('cart_m');
        $data['order_id'] = $this->cart_m->create_new_order_id();
        if(empty($data['order_id'])){
            $data['order_id']=date('YmdHis').'000001';
        }
        $this->template("admin/bill/view",$data);
    }

    public function get_customer_list()
    {
        $filter_data['search'] = $_GET['q'];
        $offset = 0;
        $limit = $_GET['limit'];
        if (isset($_GET['page']) && $_GET['page'] > 0) {
            $offset = ($_GET['page'] - 1) * $limit;
        }
        $results = $this->bill_m->get_customer_list($filter_data, $offset, $limit);
        $data['items'] = array();
        if ($results) {
            foreach ($results as $k => $v) {
                $user_name = trim(($v['first_name'].' '.$v['last_name']),' ');
                $v['user_name']= $user_name;
                $v['title']= $user_name . ' - ' . $v['contact_number'];
                $data['items'][$k]=$v;
            }
        }
        $data['total_count'] = $this->bill_m->get_total_customer_list($filter_data);
        echo json_encode($data);
    }

    public function get_product_desc()
    {
        $filter_data['search'] = $_GET['q'];
        $offset = 0;
        $limit = $_GET['limit'];
        if (isset($_GET['page']) && $_GET['page'] > 0) {
            $offset = ($_GET['page'] - 1) * $limit;
        }
        $results = $this->bill_m->get_product_desc_list($filter_data, $offset, $limit);
        $data['items'] = array();
        if ($results) {
            foreach ($results as $k => $v) {
                $data['items'][$k]['id'] = $v['product_id'];
                $data['items'][$k]['title'] = $v['product_name'];
            }
        }
        $data['total_count'] = $this->bill_m->get_total_product_desc_list($filter_data);
        echo json_encode($data);
    }

    public function get_product_code()
    {
        $filter_data['search'] = $_GET['q'];
        $offset = 0;
        $limit = $_GET['limit'];
        if (isset($_GET['page']) && $_GET['page'] > 0) {
            $offset = ($_GET['page'] - 1) * $limit;
        }
        $results = $this->bill_m->get_product_code_list($filter_data, $offset, $limit);
        $data['items'] = array();
        if ($results) {
            foreach ($results as $k => $v) {
                $data['items'][$k]['id'] = $v['product_id'];
                $data['items'][$k]['title'] = $v['product_code'];
            }
        }
        $data['total_count'] = $this->bill_m->get_total_product_code_list($filter_data);
        echo json_encode($data);
    }

    public function get_product_code_details()
    {
        $product_code = $_POST['product_code'];
        if (!empty($product_code)) {
            $row = $this->bill_m->get_product_code_details($product_code);
            if (!$row) {
                $row = $this->bill_m->get_option_code_details($product_code);
            }
            echo json_encode($row);
        }
    }

    public function get_product_details()
    {
        $product_option_id = $_POST['product_option_id'];
        if (!empty($product_option_id)) {
            $product_option_arr = explode('_', $product_option_id);
            if ($product_option_arr[1] == 0) {
                $row = $this->bill_m->get_product_details($product_option_arr[0]);
            } else {
                $row = $this->bill_m->get_product_opt_details($product_option_id);
            }
            echo json_encode($row);
        }
    }

    public function process_customer()
    {
        if(!empty($_POST['id'])){
            $id = $this->bill_m->update_customer($_POST);
        }else{
            $id = $this->bill_m->add_customer($_POST);
        }
        if ($id) {
            $option_text = $_POST['customer_name'] . ' - ' . $_POST['customer_phone_no'];
            echo '<option value="' . $id . '" selected="selected">' . $option_text . '</option>';
        }
    }

    public function save_print_bill()
    {
        $this->bill_m->save_bill($_POST);
        $data['bill_results'] = $this->bill_m->get_bill($_POST['order_no']);
        $this->load->model('admin/settings_m');
        $data['supermarket_results'] = $this->settings_m->get_supermarket_results();
        if (!empty($data['bill_results'])) {
            foreach ($data['bill_results'] as $k => $v) {
                $data['bill_id'] = $v['bill_id'];
                $data['bill_date'] = $v['bill_date'];
                $data['total_amount'] = $v['total_amount'];
                $data['net_total'] = $v['net_total'];
                $data['delivery_cost'] = $v['delivery_cost'];
                $data['discount_percent'] = $v['discount_percent'];
                $data['cash_received'] = $v['cash_received'];
                $data['balance_paid'] = $v['balance_paid'];
            }
        }
        $this->load->view('admin/bill/print_bill', $data);
    }
} ?>