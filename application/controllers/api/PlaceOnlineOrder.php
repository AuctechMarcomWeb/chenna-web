
<?php if(!defined('BASEPATH')) exit ('No direct script access allowed'); 
class PlaceOnlineOrder extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
    $this->load->model('api/Api_model');  
  }


 public function index() {
    //  echo "<pre>";print_r('a');exit();
     $request_data           = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input'); 
      $requestJson            = json_decode($request_data, true);
      $check_request_keys     = array('0' => 'user_id','1'=>'amount','2'=>'order_id');
        // echo "<pre>";print_r($requestJson);exit();                     
        $resultJson = validateJson($requestJson, $check_request_keys);
        // echo "<pre>";print_r($resultJson);exit();
        if($resultJson > 0)
        {
        
           $this->Api_model->placeOnlineOrder($requestJson);
        
        }else
        {
          generateServerResponse('0', '101');
        }

  }

}?>