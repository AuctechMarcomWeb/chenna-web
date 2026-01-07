<?php

      if (!defined('BASEPATH')) exit('No direct script access allowed');
      require APPPATH . '/libraries/REST_Controller.php';

      class Seller_shop extends REST_Controller {

      public function __construct() { 
      parent::__construct();
      $this->load->model('seller_api/Seller_api_modal');
      }


  
  /* seller add shop */

      public function add_seller_shop_post(){
      $json = file_get_contents('php://input');
	  $getdata = json_decode($json, true); 

	  $shop_res = $this->Seller_api_modal->add_seller_shop($getdata);

	  if($shop_res > 0 ){
	   $this->response([
	   'status' => TRUE,
	   'message' => 'Shop added successfully.'
	   ], REST_Controller::HTTP_OK);
	  }else{
	   $this->response([
	   'status' => TRUE,
	   'message' => 'opps..! Somthing went wrong.',
	   ], REST_Controller::HTTP_OK);
	    }
      }



    
     /* seller shop list */

      public function seller_shop_list_post(){
      $json = file_get_contents('php://input');
	  $getdata = json_decode($json, true); 

	  $shop_list = $this->Seller_api_modal->seller_shop_list($getdata);

	  if($shop_list > 0 ){
	   $this->response([
	   'status' => TRUE,
	   'message' => 'shop Record found successfully.',
	   'shop_list' => $shop_list
	   ], REST_Controller::HTTP_OK);
	  }else{
	   $this->response([
	   'status' => TRUE,
	   'message' => 'opps..! Somthing went wrong.',
	   ], REST_Controller::HTTP_OK);
	    }
      }






	




}