<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Enquires extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/enquires_m');
    }

    public function index()
    {
        $this->template("admin/enquires/view");
    }

    public function ajax_index()
    {
        $offset = $_GET['start'];
        $limit = $_GET['length'];
        $filter_data = array();
        if (!empty($_GET['formValues'])) {
            parse_str($_GET['formValues'], $filter_data);
        }
        if (!empty($_GET['search']['value'])) {
            $filter_data['search'] = $_GET['search']['value'];
        }
        if (!empty($_GET['order'][0]['column'])) {
            $filter_data['order']['column'] = $_GET['order'][0]['column'];
            $filter_data['order']['dir'] = $_GET['order'][0]['dir'];
        }
        $admin_results = $this->enquires_m->get_all($filter_data, $offset, $limit);
        $total_results = $this->enquires_m->get_total($filter_data);
        $dataTableData = array();
        $dataTableData['draw'] = $_GET['draw'];
        $dataTableData['recordsTotal'] = $total_results;
        $dataTableData['recordsFiltered'] = $total_results;
        $dataTableData['data'] = [];
        if (!empty($admin_results)) {
            foreach ($admin_results as $k => $v) {
                $dataTableData['data'][$k][0] = $v['user_name'];
                $dataTableData['data'][$k][1] = $v['user_mobile'];
                $dataTableData['data'][$k][2] = $v['user_email'];
                $dataTableData['data'][$k][3] = ellipsize($v['user_message'], 30);
                $dataTableData['data'][$k][4] = date('d-m-Y h:i:s', strtotime($v['created']));
                $dataTableData['data'][$k][5] = '<div class="btn-group text-right">                                            <button type="button" class="btn btn-success br2 btn-xs fs12 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Change                                                <span class="caret ml5"></span>                                            </button>                                            <ul class="dropdown-menu" role="menu">                                                <li>                                                    <a title="click to view" href="' . base_url('admin/enquires/view/' . $v['id']) . '">View</a>                                                </li>                                                 <li>                                                    <a class="confirm" title="click to delete" href="' . base_url('admin/enquires/delete/' . $v['id']) . '">Delete</a>                                                </li>                                            </ul>                                        </div>';
            }
        }
        echo json_encode($dataTableData);
    }

    public function view($id)
    {
        $data = $this->enquires_m->get($id);
        $this->template("admin/enquires/view_detail", $data);
    }

    public function delete()
    {
        $id = $this->uri->segment(4);
        $this->enquires_m->delete($id);
        redirect('admin/enquires');
    }
} ?>