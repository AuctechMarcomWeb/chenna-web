<?php
class Website_model extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function GetData($type)
    {
        if($type == 1){

          $this->db->select('id');
          $this->db->select('product_name');
          $this->db->select('product_discount_type');
          $this->db->select('product_discount_amount');
          $this->db->select('product_discount_amount');
          $this->db->select('category_master_id');
          $this->db->order_by('id','RANDOM');
          $this->db->limit(8);
          $Return_Data = $this->db->get_where('product_master', 
                                        array('product_discount_type' => 2,
                                              'product_discount_amount >=' => 20,
                                              'product_discount_amount <=' => 50,
                                              'status' => 1))->result_array();
          //echo $this->db->last_query(); exit;
        }

        return $Return_Data;
    }

}
?>