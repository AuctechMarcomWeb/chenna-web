<?php if(!defined('BASEPATH')) exit ('No direct script access allowed'); 
class PaymentGateway extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
    $this->load->model('api/Api_model');  
  }

  public function index(){
     $request_data           = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input'); 
     $requestJson            = json_decode($request_data, true);
    $check_request_keys = array( '0'  => 'final_price',
                                 '1'  => 'shipping_charge',
                                 '2'  => 'userId',
                                 '3'  => 'order_id',
                                 '4'  => 'tid',
                                 '5'  => 'amount',
                                 '6'  => 'redirect_url',
                                 '7'  => 'cancel_url',
                                 '8'  => 'billing_name',
                                 '9'  => 'billing_address',
                                 '10'  => 'billing_city',
                                 '11'  => 'billing_state',
                                 '12'  => 'billing_zip',
                                 '13'  => 'billing_tel',
                                 '14'  => 'billing_email'
                                 
                                 );
        $resultJson = validateJson($requestJson, $check_request_keys);
        if($resultJson > 0)
        {
            // echo "<pre>";print_r($requestJson);exit();
           $this->Api_model->PaymentGateway($requestJson);
        
        }else
        {
          generateServerResponse('0', '101');
        }

  }

}?>