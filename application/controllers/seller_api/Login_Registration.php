<?php

      if (!defined('BASEPATH')) exit('No direct script access allowed');
      require APPPATH . '/libraries/REST_Controller.php';

      class Login_Registration extends REST_Controller {

      public function __construct() { 
      parent::__construct();
      // $this->load->model('api_model/UserLogin_model');
      }






  /*seller registration*/

 public function seller_registration_post(){
 $json = file_get_contents('php://input');
 $getdata = json_decode($json, true); 

 $name  = $getdata['shopmet']['name'];
 $mobile  = $getdata['shopmet']['mobile'];
 $email  = $getdata['shopmet']['email'];
 $password  = $getdata['shopmet']['password'];

 $check_mobile =$this->db->get_where('staff_master',array('mobile'=>$mobile))->num_rows();
 $check_email = $this->db->get_where('staff_master',array('email'=>$email))->num_rows();

 if($check_mobile > 0 ){
        
    $this->response([
    'status' => TRUE,
    'message' => 'Mobile Already Exits. Please try another.'
    // 'userRec' => $user_rec
    ], REST_Controller::HTTP_OK);
   
    }else if($check_email > 0){
    $this->response([
    'status' => TRUE,
    'message' => 'Email Already Exits. Please try another.'
    ], REST_Controller::HTTP_OK);
   }else{

    $data['name']       = $name;
    $data['mobile']       = $mobile;
    $data['email']       = $email;
    $data['password']       = $password;
    $data['seller_code']    = mb_substr(strtoupper($name), 0, 3).''.substr($mobile, -4);
    $data['add_date']       = time();
    $data['modify_date']    = time();
    $data['status']         = '1';

    $row = $this->db->insert('staff_master',$data);
    $insert_id = $this->db->insert_id(); 


    $text="Your seller account has been successfully registered with Dukekart. Kindly visit https://dukekart.in/seller to start uploading your products on Dukekart and start earningRegardsDukekart Real Time Private Limited";

    sendSMS($mobile,$text,'1007050631475099664');

    sentCommonEmail($email,$text,'Account Verification OTP.');
    
    if($row > 0 ){
        
    $this->response([
    'status' => TRUE,
    'message' => 'Seller registered successfully.',
    'insert_id' => $insert_id
    ], REST_Controller::HTTP_OK);
   
    }else{

    $this->response([
    'status' => TRUE,
    'message' => 'opps..! Somthing went wrong.',
    ], REST_Controller::HTTP_OK);
    
    }
   }
  }


function sendSMS($mobile,$message,$template) {

 $url = "http://sms.txly.in/vb/apikey.php?apikey=glNySZAajwGzc6mO&senderid=DUKRLT&templateid=".$template."&number=".$mobile."&message=".urlencode($message);
       $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         curl_exec($ch); 


        return 1;  

}



  /*send otp on seller mobile number*/

  public function send_otp_post(){
  $json = file_get_contents('php://input');
  $getdata = json_decode($json, true); 

  $serller_id  = $getdata['shopmet']['serller_id'];  

  $chars = "0123456789";
  $mobile_otp = substr(str_shuffle($chars), 0, 6);

  $chars = "0123456789";
  $email_otp = substr(str_shuffle($chars), 0, 6);

  $this->db->select('name,mobile,email');
  $staff = $this->db->get_where('staff_master',array('id'=>$serller_id))->row_array();
  
  if(!empty($staff)){
  $this->db->where('id',$serller_id);
  $row = $this->db->update('staff_master',array('mobile_otp'=>$mobile_otp,'email_otp'=>$email_otp));

//   $text = 'Dear '.$staff['name'].' Your Mobile Verification OTP is: '.$mobile_otp;
  $text = 'Dear '.$staff['name'].' Your Mobile Verification OTP is: '.$mobile_otp. ' Please enter this OTP to verify your mobile number. From www.Dukekart.inRegardsDukekart Real Time Private Limited';


  $email_message = 'Dear '.$staff['name'].' Your Email Verification OTP is: '.$email_otp;

  sentCommonEmail($staff['email'],$email_message,'Account Verification OTP.');

  sendSMS($staff['mobile'],$text,'1007086055987083292');

   if($row > 0 ){    
    $this->response([
    'status' => TRUE,
    'message' => 'OTP send successfully.'
    // 'insert_id' => $insert_id
    ], REST_Controller::HTTP_OK);
   
    }else{

    $this->response([
    'status' => TRUE,
    'message' => 'opps..! Somthing went wrong.'
    ], REST_Controller::HTTP_OK);
    
      }
    }else{
    $this->response([
    'status' => TRUE,
    'message' => 'user id not exist.'
    ], REST_Controller::HTTP_OK);
    }
  }






  /*verify seller mobile and OTP*/
  
   public function verify_seller_mobile_post(){
    $json = file_get_contents('php://input');
    $getdata = json_decode($json, true); 

    $serller_id  = $getdata['shopmet']['serller_id']; 
    $otp  = $getdata['shopmet']['otp']; 

    $this->db->select('mobile_otp,email_verify');
    $staff = $this->db->get_where('staff_master',array('id'=>$serller_id))->row_array();
    
    if($staff['mobile_otp']==$otp) {

     $this->db->where('id',$serller_id);
     $update_row = $this->db->update('staff_master',array('mobile_verify'=>'1'));
     $message['mobile_verify'] ='1';
     $message['email_verify']  = $staff['email_verify'];
     $message['type']          = '1';
      
     if($update_row > 0 ){    
     $this->response([
     'status' => TRUE,
     'message' => 'OTP verify successfully.',
     'seller_verification_data' => $message
     ], REST_Controller::HTTP_OK);
   
     }else{

     $this->response([
     'status' => TRUE,
     'message' => 'opps..! Somthing went wrong.'
     ], REST_Controller::HTTP_OK);
     }

     } else {

      $message['mobile_verify'] ='2';
      $message['email_verify']  = $staff['email_verify'];
      $message['type']          = '2';

      $this->response([
      'status' => TRUE,
      'message' => 'OTP not match successfully.',
      'seller_verification_data' => $message
      ], REST_Controller::HTTP_OK);

    }

  }






   /*verify seller email and OTP*/

    public function verify_seller_email_post(){

    $json       = file_get_contents('php://input');
    $getdata    = json_decode($json, true); 
    $serller_id = $getdata['shopmet']['serller_id']; 
    $otp        = $getdata['shopmet']['otp'];  

    $this->db->select('email_otp,mobile_verify');
    $staff = $this->db->get_where('staff_master',array('id'=>$serller_id))->row_array();

    if($staff['email_otp']==$otp) {
    $this->db->where('id',$serller_id);
    $update_row = $this->db->update('staff_master',array('email_verify'=>'1'));

    $message['mobile_verify'] = $staff['mobile_verify'];
    $message['email_verify']  = '1';
    $message['type']          = '1';

    if($update_row > 0 ){    
     $this->response([
     'status' => TRUE,
     'message' => 'OTP verify successfully.',
     'seller_email_verification_data' => $message
     ], REST_Controller::HTTP_OK);
   
     }else{

     $this->response([
     'status' => TRUE,
     'message' => 'opps..! Somthing went wrong.'
     ], REST_Controller::HTTP_OK);
     }

    } else {

    $message['mobile_verify'] = $staff['mobile_verify'];
    $message['email_verify']  = '2';
    $message['type']          = '2';

    $this->response([
    'status' => TRUE,
    'message' => 'OTP not matched.',
    'seller_verification_data' => $message
    ], REST_Controller::HTTP_OK);

    }

  }






    /*seller Login*/

    public function seller_login_post(){
    $json       = file_get_contents('php://input');
    $getdata    = json_decode($json, true); 

    $loginType = $getdata['shopmet']['loginType'];
    $mobile = $getdata['shopmet']['mobile'];
    $password = $getdata['shopmet']['password'];

    $this->db->select("id, name,email,profile_pic");
    $admin = $this->db->get_where('staff_master', array('mobile' => $mobile,'password'=>$password,'status'=>'1'))->row_array();

    if($admin){

    $adminData = array(
        'is_logged_in'  => true,
        'Type'      => $loginType,
        'Id'        => $admin['id'],
        'Name'      => ucwords($admin['name']),
        'Email'     => $admin['email'],
        'Picture'   => $admin['profile_pic']
      );

     $this->session->set_userdata('sellerData', $adminData);

     $seller_ses_data = $this->session->userdata('sellerData');
      
     if($seller_ses_data){    
     $this->response([
     'status' => TRUE,
     'message' => 'Login successfully.',
     'sellerData' => $seller_ses_data
     ], REST_Controller::HTTP_OK);
   
     }else{

     $this->response([
     'status' => TRUE,
     'message' => 'opps..! Somthing went wrong.'
     ], REST_Controller::HTTP_OK);
     }


    }else{

     $this->response([
     'status' => TRUE,
     'message' => 'mobile number or password is wrong'
     ], REST_Controller::HTTP_OK);

    }

    }



}