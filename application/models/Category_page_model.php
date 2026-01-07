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

/*public function get_current_page_records($limit, $start, $search_key) {

            if (!empty($search_key)) {
                $this->db->like('polling_unit_name', $search_key);
            }
            $this->db->limit($limit, $start);
            $query = $this->db->get("polling_units");
     
            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data[] = $row;
                }
                return $data;
            }
            return false;
        }*/


    public function get_current_page_records($limit, $start, $keyword) {
            $query = $this->db->query("select pm.product_discount_type,pm.product_discount_amount,pm.deal_of_day_start,pm.reference, pm.`id`,pm.`cashback_start`,pm.`cashback_end`,pm.`cashback_discount_type`,pm.`cashback_amount`,pm.`status`,pm.`deal_of_day_end`,pm.`category_master_id`,pm.`sub_category_master_id`,pm.`dod_amount`,pm.`dod_discount_type`,pm.`product_name`,pm.`description`,pm.`final_price`,pm.`price`,pm.`unit`,pm.`quantity`,cm.`category_name`,scm.`sub_category_name` from product_master as pm left join category_master as cm on pm.`category_master_id` = cm.`id` left join sub_category_master as scm on pm.`sub_category_master_id` = scm.`id` where pm.status='1' and pm.approving_status='1' and (cm.`category_name` Like '%$keyword%' or scm.`sub_category_name` Like '%$keyword%' or pm.`product_name` Like '%$keyword%' or pm.`description` Like '%$keyword%' or pm.`price` Like '%$keyword%' or pm.`quantity` Like '%$keyword%' or pm.`unit` Like '%$keyword%') LIMIT $start,$limit");
               if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data[] = $row;
                }
                return $data;
             }
             return false;
            
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
                                          'category_master_id' => $Cat_id))->result_array();
        return $Return_Data;
    }


    public function GetSubCatProducts($sub_id='')
    {
        $this->db->select('id');
        $this->db->select('product_name');
        $this->db->select('cashback_discount_type');
        $this->db->select('cashback_start');
        $this->db->select('cashback_end');
        $this->db->select('cashback_amount');
        $this->db->select('product_discount_type');
        $this->db->select('product_discount_amount');
        $this->db->select('category_master_id');
        $this->db->select('sub_category_master_id');
        $this->db->select('final_price');
        $this->db->select('quantity');
        $this->db->select('price');
        $this->db->order_by('id','RANDOM');
        $Return_Data = $this->db->get_where('product_master', 
                                      array('sub_category_master_id' => $sub_id,'approving_status'=>1,
                                            'status' => 1))->result_array();
        shuffle($Return_Data);
        return $Return_Data;
    }




}
?>