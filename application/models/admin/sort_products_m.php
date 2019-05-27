<?php
Class Sort_Products_M extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->table_name = 'admin_product';
    }

    public function get_products_by_category($category_id){
        $this->db->select('b.id,b.product_name,IF(c.option_id IS NULL,b.quantity,c.option_qty) as stock_quantity',false);
        $this->db->from('admin_product_category a');
        $this->db->join($this->table_name.' b','a.product_id = b.id','left');
        $this->db->join('admin_product_option_value c', 'c.product_id = b.id AND default_option=1', 'left');
        $this->db->where('a.category_id',$category_id);
        $this->db->where('b.status', 2);
        $this->db->group_by('a.product_id');
        $this->db->having('stock_quantity > 0');
        $this->db->order_by('b.sort_order','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function update_sorting(){
        $date=date('Y-m-d H:i:s');
        if(!empty($_POST['item'])){
            $i=1;
            foreach($_POST['item'] as $k=>$v){
                $data['updated']= $date;
                $data['sort_order']= $i;
                $this->db->where('id',$v);
                $this->db->update($this->table_name,$data);
                $i++;
            }
        }
    }
}