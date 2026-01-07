<?php if(!defined('BASEPATH')) exit ('No direct script access allowed'); 
class Signup extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
    $this->load->model('api/Api_model');  
  }

  public function index(){
     $request_data           = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input'); 
     $requestJson            = json_decode($request_data, true);
    $check_request_keys = array( '0'  => 'name',
                                 '1'  => 'mobile',
                                 '2'  => 'email',
                                 '3'  => 'password'
                                 
                                   );
        $resultJson = validateJson($requestJson, $check_request_keys);
        if($resultJson > 0)
        {
        //   $this->Api_model->userSignUp($requestJson[APP_NAME]);
           $this->Api_model->userSignUp($requestJson);
        
        }else
        {
          generateServerResponse('0', '101');
        }

  }

}?>