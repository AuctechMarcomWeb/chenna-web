<?php

      if (!defined('BASEPATH')) exit('No direct script access allowed');
      require APPPATH . '/libraries/REST_Controller.php';

      class Seller_bank_detail extends REST_Controller {

      public function __construct() { 
      parent::__construct();
      $this->load->model('seller_api/Seller_api_modal');
      }




  /* Update seller bank details record  */

    
    public function get_seller_bank_detail_post(){
	$json       = file_get_contents('php://input');
	$getdata    = json_decode($json, true); 
	$bankData = $this->Seller_api_modal->get_seller_bank_detail($getdata);
  
    if($bankData > 0){

    $this->response([
    'status' => TRUE,
    'message' => 'record found successfully.',
    'seller_bank_data' => $bankData
    ], REST_Controller::HTTP_OK);

    }else{
    $this->response([
    'status' => TRUE,
    'message' => 'opps..! Somthing went wrong.',
    ], REST_Controller::HTTP_OK);
    }
   }





  /* Update seller bank details record  */

      public function update_bank_detail_post(){
      $json       = file_get_contents('php://input');
	  $getdata    = json_decode($json, true); 
      $result_row = $this->Seller_api_modal->updateSellerBankDetail($getdata);

      if($result_row > 0){

      $this->response([
      'status' => TRUE,
      'message' => 'record updated successfully.'
      ], REST_Controller::HTTP_OK);

      }else{
      $this->response([
      'status' => TRUE,
      'message' => 'opps..! Somthing went wrong.',
      ], REST_Controller::HTTP_OK);
      }

     }






}