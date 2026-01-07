<?php if(!defined('BASEPATH')) exit ('No direct script access allowed'); 
class UpdateProfile extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
    $this->load->model('api/Api_model');  
  }

  public function index(){
     $request_data           = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input'); 
     $requestJson            = json_decode($request_data, true);
    $check_request_keys = array( 
                                '0'  => 'user_id', 
                                '1'  => 'username', 
                                '2'  => 'email_id', 
                                '3'  => 'mobile', 
                                '4'  => 'whatsaap_number', 
                                '5'  => 'alternate_number', 
                                '6'  => 'address', 
                                '7'  => 'locality', 
                                '8'  => 'city', 
                                '9'  => 'state', 
                                '10'  => 'pincode', 
                                '11'  => 'profile_pic' 
                              );
                                 
                                
                                  
        $resultJson = validateJson($requestJson, $check_request_keys);
        if($resultJson > 0)
        {
           $this->Api_model->updateProfilePicture($requestJson);
        
        }else
        {
          generateServerResponse('0', '101');
        }

  }

}?>