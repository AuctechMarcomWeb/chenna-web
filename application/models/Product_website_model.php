<?php
class Product_website_model extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }


    public function GetProdImage($prod_id='')
    {
        $this->db->limit(3);
        return $this->db->get_where('product_images_master', array('product_master_id'=>$prod_id))->result_array();
    }

    

}
?>