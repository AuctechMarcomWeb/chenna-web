<?php if(!defined('BASEPATH')) exit ('No direct script access allowed'); 
class RemoveWishList extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
    $this->load->model('api/Api_model');  
  }

  public function index(){
     $request_data           = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input'); 
     $requestJson            = json_decode($request_data, true);
    $check_request_keys = array( '0'  => 'wishlist_id'
                                 
                                 
                                 );
        $resultJson = validateJson($requestJson, $check_request_keys);
        if($resultJson > 0)
        {
           $this->Api_model->RemoveFromWish($requestJson);
        
        }else
        {
          generateServerResponse('0', '101');
        }

  }

}?>