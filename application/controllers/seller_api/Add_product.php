<?php

      if (!defined('BASEPATH')) exit('No direct script access allowed');
      require APPPATH . '/libraries/REST_Controller.php';

      class Add_product extends REST_Controller {

      public function __construct() { 
      parent::__construct();
      $this->load->model('seller_api/Seller_api_modal');
      }




  /* get all category list*/

    
    public function category_list_get(){
	  // $json       = file_get_contents('php://input');
	  // $getdata    = json_decode($json, true); 
	  $categoryData = $this->Seller_api_modal->getCatgyList();
  
    if($categoryData > 0){

    $this->response([
    'status' => TRUE,
    'message' => 'record found successfully.',
    'category_data' => $categoryData
    ], REST_Controller::HTTP_OK);

    }else{
    $this->response([
    'status' => TRUE,
    'message' => 'opps..! Somthing went wrong.',
    ], REST_Controller::HTTP_OK);
    }
   }




/*  get all shop list */


    public function shop_list_post(){
    $json       = file_get_contents('php://input');
    $getdata    = json_decode($json, true); 
    $shopData = $this->Seller_api_modal->get_shop_list($getdata );
  
    if($shopData){

    $this->response([
    'status' => TRUE,
    'message' => 'record found successfully.',
    'shop_data' => $shopData
    ], REST_Controller::HTTP_OK);

    }else{
    $this->response([
    'status' => TRUE,
    'message' => 'opps..! Somthing went wrong.',
    ], REST_Controller::HTTP_OK);
    }
   }




   /*  get all subcategory list */


    public function subcategory_list_post(){
    $json       = file_get_contents('php://input');
    $getdata    = json_decode($json, true); 
    $subcategoryData = $this->Seller_api_modal->get_subcategory_list($getdata );
  
    if($subcategoryData){

    $this->response([
    'status' => TRUE,
    'message' => 'record found successfully.',
    'subcategory_data' => $subcategoryData
    ], REST_Controller::HTTP_OK);

    }else{
    $this->response([
    'status' => TRUE,
    'message' => 'opps..! Somthing went wrong.',
    ], REST_Controller::HTTP_OK);
    }
   }




   /* save product code start here */


   public function save_general_info_post(){
   $json       = file_get_contents('php://input');
   $getdata    = json_decode($json, true); 
   $generalInfoData = $this->Seller_api_modal->save_pro_general_info($getdata);

   if($generalInfoData > 0){

   $this->response([
   'status' => TRUE,
   'message' => 'general Information Added successfully.'
   ], REST_Controller::HTTP_OK);

   }else{
   $this->response([
   'status' => TRUE,
   'message' => 'opps..! Somthing went wrong.',
    ], REST_Controller::HTTP_OK);
   }
 }




    /* save product color and size start here */


   public function save_color_size_post(){
   $json       = file_get_contents('php://input');
   $getdata    = json_decode($json, true); 

   $color_size_Data = $this->Seller_api_modal->save_pro_color_size($getdata);

   if($color_size_Data > 0){

   $this->response([
   'status' => TRUE,
   'message' => 'color size save successfully.'
   ], REST_Controller::HTTP_OK);

   }else{
   $this->response([
   'status' => TRUE,
   'message' => 'opps..! Somthing went wrong.',
    ], REST_Controller::HTTP_OK);
   }
 }







 }