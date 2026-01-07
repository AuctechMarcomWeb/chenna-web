<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seller extends CI_Controller {

	public function __construct(){
		parent::__construct(); 
     $this->load->library('cart');
		 $this->load->model('Website_model', 'web_model');  
      
	}




  public function index(){  

      $data = $this->input->post();

      if(empty($data)) {
         $data['bannerList']         = $this->web_model->getBannerList();
         $data['MainCategoryList']   = $this->web_model->getMainCategoryList();

         $data['title']  = 'Welcome to Dukekart | Seller Login';
         $this->load->view('web/include/header',$data);
         $this->load->view('web/seller');
         $this->load->view('web/include/footer');

      } else {

        $check_mobile =$this->db->get_where('staff_master',array('mobile'=>$data['mobile']))->num_rows();
        $check_email = $this->db->get_where('staff_master',array('email'=>$data['email']))->num_rows();

        if($check_mobile > 0 ){
        	
           $message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong><h3>Registration Failed!<h3></strong>Mobile no already registered</div>';

           $this->session->set_flashdata('message', $message);
           redirect(site_url('web/success/'), 'refresh');
        } else if($check_email > 0){

          $message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong><h3>Fail!<h3></strong>Email Id already registered</div>';

           $this->session->set_flashdata('message', $message);
           redirect(site_url('web/success/'), 'refresh');



        } 


//***********  Seller Registration *******************
        else {
            
            $data['seller_code']    = mb_substr(strtoupper($data['name']), 0, 3).''.substr($data['mobile'], -4);
            $data['add_date']       = time();
            $data['modify_date']    = time();
            $data['status']         = '1';
            $row = $this->db->insert('staff_master',$data);
            $insert_id = $this->db->insert_id(); 
			
			       

//***********  Seller Registration Email *******************

$text= "Your seller account has been successfully registered with Dukekart. Kindly visit https://dukekart.in/seller to start uploading your products on Dukekart and start earningRegardsDukekart Real Time Private Limited";  

sendSMS($data['mobile'],$text,'1007050631475099664');


//***********  Seller Registration Email *******************

$status="Registration Successful";
$user=$data['name'];
$email_text="You have been successfully registered with Dukekart. Now you can explore the new world of shopping and start selling with Dukekart. First complete rest of your profile details to unlock unlimited possibilities with Dukekart";
$mobile=$data['mobile'];
$emailid=$data['email'];
$dlink='https://dukekart.in/seller-login';


$this->load->helper('/email/temp5');


$email_body=temp5($status,$user,$email_text,$dlink);

$subject='Seller registration successful';  

//$this->email_send->send_email($emailid,$email_body,$subject);

sentCommonEmail($emailid,$email_body,$subject);

 //  sentCommonEmail($data['email'],$email_message,'Dukekart Registration Successfully.');

           $message = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong><h3>Success!</h3></strong>Thanks for registering with us. Now you have to complete your profile and KYC after that you can start listing your product.</div>';

      //  $this->session->set_flashdata('message', $message);
       redirect(site_url('web/success/'.$insert_id), 'refresh');

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
  function sentCommonEmail($email, $smsmessage, $sub)
  {
    // ++++++++++++++
    $to = $email;
    $subject = $sub;
    $message .= "Note - This is a System Generated Mail, please do not reply.\r\n";
    $headers = "From:" . "support@dukekart.in" . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    mail($to, $subject, $smsmessage, $headers);
    return 1;
  }



  public function login(){
  $this->load->view('admin/vendor_login');
  }



}
