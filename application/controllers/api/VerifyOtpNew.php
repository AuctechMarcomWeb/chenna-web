<?php if(!defined('BASEPATH')) exit ('No direct script access allowed'); 
class VerifyOtpNew extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
    $this->load->model('api/Api_model');  
  }

  public function index(){
     $request_data           = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input'); 
     $requestJson            = json_decode($request_data, true);
     $check_request_keys = array( 
                                '0'  => 'mobile',
                                '1'  => 'otp',
                                '2'  => 'deviceId',
                                '3'  => 'fcmId',
                              );
                                 
                                
                                  
        $resultJson = validateJson($requestJson, $check_request_keys);
        // echo "<pre>";print_r($resultJson);exit();
        if($resultJson > 0)
        {
           $this->Api_model->verifyOtp_new($requestJson);
        
        }else
        {
          generateServerResponse('0', '101');
        }

  }

}?>