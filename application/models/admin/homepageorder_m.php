<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homepageorder_m extends CI_Model {

    public function __construct() {
        parent::__construct();
       
    }

    public function get() {
       $this->db->order_by('sortorder');
        $result=$this->db->get('admin_homepage');
        return $result->result_array();
    }
    
    public function update(){
        //print_r($_POST);
      
        foreach($_POST['order'] as $key=>$val)
        {
           $id=$key+1;
         //  echo $_POST['order'][$key];
           $update['sortorder']=$_POST['order'][$key];
           $update['status']=$_POST['status'][$key];
            //print_r($update);
            //print_r($_POST );
           // die;

           $this->db->where('id',$id);
           $this->db->update('admin_homepage',$update);
           //echo $this->db->last_query();
           
        }
        $this->session->set_flashdata('notify_success', "Successfully updated!");
        redirect('admin/homepage_order');
        
    }

}
?>