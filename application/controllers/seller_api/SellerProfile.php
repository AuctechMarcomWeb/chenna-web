<?php

      if (!defined('BASEPATH')) exit('No direct script access allowed');
      require APPPATH . '/libraries/REST_Controller.php';

      class SellerProfile extends REST_Controller {

      public function __construct() { 
      parent::__construct();
      $this->load->model('seller_api/Seller_api_modal');
      }






	  /*seller profile listing*/

	 public function seller_profile_list_post(){
	 $json = file_get_contents('php://input');
	 $getdata = json_decode($json, true); 

	 $seller_id  = $getdata['shopmet']['seller_id'];  

	 $profileData = $this->Seller_api_modal->get_seller_profile($seller_id);
	
	 if($profileData){
        
     $this->response([
     'status' => TRUE,
     'message' => 'record found successfully.',
     'seller_profileData' => $profileData
     ], REST_Controller::HTTP_OK);
   
     }else{

     $this->response([
     'status' => TRUE,
     'message' => 'opps..! Somthing went wrong.',
     ], REST_Controller::HTTP_OK);
    
    }

	}






      /*seller profile listing*/

   public function seller_profile_update_post(){
   $json = file_get_contents('php://input');
   $getdata = json_decode($json, true);  

   $profileData = $this->Seller_api_modal->update_seller_profile($getdata);
  
   if($profileData){
        
     $this->response([
     'status' => TRUE,
     'message' => 'record updated successfully.'
     // 'seller_profileData' => $profileData
     ], REST_Controller::HTTP_OK);
   
     }else{

     $this->response([
     'status' => TRUE,
     'message' => 'opps..! Somthing went wrong.',
     ], REST_Controller::HTTP_OK);
    
    }

  }







}