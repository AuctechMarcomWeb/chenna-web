<?php
class Category_page_model extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function GetAllSubCat_of_Category($catgy_id='')
    {
        $ReturnDate = $this->db->get_where('sub_category_master', 
                        array('status' => 1,
                              'category_master_id' =>$catgy_id))->result_array();
        shuffle($ReturnDate); 
        return $ReturnDate;
    }

    public function GetSubCatList($catgy_id='')
    {   
        $this->db->select('id');
        $this->db->select('sub_category_name');
        $this->db->order_by('id','RANDOM');
        return $this->db->get_where('sub_category_master', 
                        array('status' => 1,
                              'category_master_id' => $catgy_id))->result_array();
    }


    public function Sub_Catgy($Cat_id ='')
    {
        $this->db->select('id');
        $this->db->select('sub_category_name');
        $this->db->order_by('id','RANDOM');
        $this->db->limit(15);
        $Return_Data = $this->db->get_where('sub_category_master', 
                                      array('status' => 1,
                                            'category_master_id' =>$Cat_id))->result_array();
        return $Return_Data;
    }


    public function GetSubCatProducts($sub_id='')
    {
        $this->db->select('id');
        $this->db->select('product_name');
        $this->db->select('product_discount_type');
        $this->db->select('product_discount_amount');
        $this->db->select('category_master_id');
        $this->db->select('final_price');
        $this->db->select('price');
        $this->db->order_by('id','RANDOM');
        $this->db->limit(15);
        $Return_Data = $this->db->get_where('product_master', 
                                      array('category_master_id' => $sub_id,
                                            'status' => 1))->result_array();
        shuffle($Return_Data);
        return $Return_Data;
    }




}
?>