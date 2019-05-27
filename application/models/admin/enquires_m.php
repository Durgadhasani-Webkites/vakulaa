<?php
    Class Enquires_M extends MY_Model{

    public function __construct()
    {
        parent::__construct();
        $this->table_name = 'user_enquires';
    }

    public function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function get_all($filter_data = array(), $offset = '', $limit = '')
    {
        $this->db->select('a.*', false);
        $this->db->from($this->table_name . ' a');
        if (!empty($filter_data)) {
            if (isset($filter_data['search'])) {
                $search = '(a.user_name LIKE "%' . $filter_data['search'] . '%")';
                $this->db->where($search);
            }
            if (!empty($filter_data['user_name'])) {
                $this->db->like('a.user_name', $filter_data['user_name']);
            }
            if (!empty($filter_data['user_mobile'])) {
                $this->db->like('a.user_mobile', $filter_data['user_mobile']);
            }
            if (!empty($filter_data['user_email'])) {
                $this->db->like('a.user_email', $filter_data['user_email']);
            }
            if (isset($filter_data['order'])) {
                $dir = $filter_data['order']['dir'];
                if ($filter_data['order']['column'] == '0') {
                    $this->db->order_by('a.user_name', $dir);
                }
                if ($filter_data['order']['column'] == '1') {
                    $this->db->order_by('a.user_mobile', $dir);
                }
                if ($filter_data['order']['column'] == '2') {
                    $this->db->order_by('a.user_email', $dir);
                }
                if ($filter_data['order']['column'] == '3') {
                    $this->db->order_by('a.user_email', $dir);
                }
                if ($filter_data['order']['column'] == '4') {
                    $this->db->order_by('TIMESTAMP(a.created)', $dir);
                }
            }
        }
        $this->db->order_by('a.id', 'desc');
        if (!empty($limit)) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_total($filter_data)
    {
        $this->db->select('a.id', false);
        $this->db->from($this->table_name . ' a');
        if (!empty($filter_data)) {
            if (isset($filter_data['search'])) {
                $search = '(a.user_name LIKE "%' . $filter_data['search'] . '%")';
                $this->db->where($search);
            }
            if (!empty($filter_data['user_name'])) {
                $this->db->like('a.user_name', $filter_data['user_name']);
            }
            if (!empty($filter_data['user_mobile'])) {
                $this->db->like('a.user_mobile', $filter_data['user_mobile']);
            }
            if (!empty($filter_data['user_email'])) {
                $this->db->like('a.user_email', $filter_data['user_email']);
            }
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function delete($id)
    {
        $this->db->from($this->table_name);
        $this->db->where('id', $id);
        $this->db->delete();
        $this->notify_success("Deleted successfully!");
        return true;
    }
}