<?php
Class Coupon_M extends MY_Model{

    public function __construct()
    {
        parent::__construct();
        $this->table_name='admin_coupon';
    }

    public function get($id){
        $this->db->where('id',$id);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    public function get_special_coupons(){
        $this->db->where('coupon_type','special');
        $this->db->where('status',2);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all($filter_data=array(),$offset='',$limit=''){
        if(!empty($filter_data)){
            if(isset($filter_data['search'])){
                $this->db->like('coupon_code',$filter_data['search']);
            }
            if(isset($filter_data['active'])){
                $this->db->where('status',2);
            }
            if(isset($filter_data['order'])){
                $dir=$filter_data['order']['dir'];
                if($filter_data['order']['column']=='1'){
                    $this->db->order_by('coupon_name',$dir);
                }
                if($filter_data['order']['column']=='2'){
                    $this->db->order_by('coupon_code',$dir);
                }
                if($filter_data['order']['column']=='3'){
                    $this->db->order_by('TIMESTAMP(valid_from)',$dir);
                }
                if($filter_data['order']['column']=='4'){
                    $this->db->order_by('TIMESTAMP(valid_to)',$dir);
                }
                if($filter_data['order']['column']=='5'){
                    $this->db->order_by('TIMESTAMP(created)',$dir);
                }
                if($filter_data['order']['column']=='6'){
                    $this->db->order_by('status',$dir);
                }
            }
        }
        $this->db->order_by('id','desc');
        if(!empty($limit)){
            $this->db->limit($limit,$offset);
        }
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_total($filter_data){
        if(!empty($filter_data)){
            if(isset($filter_data['search'])){
                $this->db->like('coupon_code',$filter_data['search']);
            }
            if(isset($filter_data['active'])){
                $this->db->where('status',2);
            }
        }
        $query = $this->db->get($this->table_name);
        return $query->num_rows();
    }

    public  function add($data)
    {
        if(!empty($data['categories'])){
            $data['categories'] = implode(',',$data['categories']);
        }
        if(!empty($data['valid_from'])){
            $data['valid_from']=date("Y-m-d",strtotime($data['valid_from']));
        }
        if(!empty($data['valid_to'])){
            $data['valid_to']=date("Y-m-d",strtotime($data['valid_to']));
        }
        $data['created']=date("Y-m-d H:i:s");
        $this->db->insert($this->table_name,$data);
        $this->session->set_flashdata('notify_success',"Added Successfully!");
        return true;
    }

    public  function update($id,$data)
    {
        if(!empty($data['categories'])){
            $data['categories'] = implode(',',$data['categories']);
        }
        if(!empty($data['valid_from'])){
            $data['valid_from']=date("Y-m-d",strtotime($data['valid_from']));
        }
        if(!empty($data['valid_to'])){
            $data['valid_to']=date("Y-m-d",strtotime($data['valid_to']));
        }
        $data['updated']=date("Y-m-d H:i:s");
        $this->db->where('id', $id);
        $this->db->update($this->table_name,$data);
        $this->session->set_flashdata('notify_success',"Updated Successfully!");
        return true;
    }

    public function delete($id) {
        $this->db->from($this->table_name);
        $this->db->where('id', $id);
        $this->db->delete();
        $this->notify_success("Deleted successfully!");
        return true;
    }

}?>