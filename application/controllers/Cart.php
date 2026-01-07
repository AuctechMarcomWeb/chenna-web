<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library('cart');
        $this->load->helper('url');
        // $this->load->model('cart_model');
    }





        public function update_cart_quantity()
        {
        // echo "<script> </script>";
        // print_r($this->input->post());
         $quantity = $this->input->post('update_qty');
         $row_id = $this->input->post('rowid');
         $pro_id = $this->input->post('pro_id');
         
         
//          $total_item = $this->cart->contents();
   
//   foreach ($total_item as  $value) {
//       if($pro_id==$value['id']){
//          $pro_qty= $value['qty'] ;
//       }
     
//   }

    $product_info = $this->db->get_where('sub_product_master', array('id' => $pro_id))->row_array();


    if($product_info['quantity']>= $quantity){

        $data = array(
            'rowid' => $row_id,
            'qty' => $quantity
        );
        
       $this->cart->update($data);
        // echo $this->cart->total();
        $data = array('qty'=> 'true');
        echo json_encode($data);
    } else {
        $data = array('qty'=>'false');
        echo json_encode($data);
    }

        }



        public function remove_cart($row_id) 
        { 

            $data = array(
                'rowid' => $row_id,
                'qty' => 0
            );
           $remove_cart = $this->cart->update($data);

           if($remove_cart)
           {
            echo 'success';
           }
           
       }



}