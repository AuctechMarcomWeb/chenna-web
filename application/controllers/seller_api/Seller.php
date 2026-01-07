<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seller extends CI_Controller {

	public function __construct(){
		parent::__construct(); 
     $this->load->library('cart');
		$this->load->model('Website_model', 'web_model');  
      $this->load->helper('sellerregistration'); 
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



        } else {
            
            $data['seller_code']    = mb_substr(strtoupper($data['name']), 0, 3).''.substr($data['mobile'], -4);
            $data['add_date']       = time();
            $data['modify_date']    = time();
            $data['status']         = '1';
            $row = $this->db->insert('staff_master',$data);
            $insert_id = $this->db->insert_id(); 
			
			
	$text= "Your seller account has been successfully registered with Dukekart. Kindly visit https://dukekart.in/seller to start uploading your products on Dukekart and start earningRegardsDukekart Real Time Private Limited";	

	
          //  $text="Congratulations! You have successfully registered your seller account with us.\r\nUser name : ".$data['name'];

            sendSMS($data['mobile'],$text,'1007050631475099664');

           
            $email_message = seller_email();

          





            /*
           
            $email_message = 'Dear '.$data['name'].',
 
          Congratulations and welcome to a whole new world of online marketplace 
          You have provisionally created your Dukekart seller  account. 
          Kindly complete your seller profile and connect with us to expand your business.  

          Your Login id is '.$data['mobile'].'';

*/




           sentCommonEmail($data['email'],$email_message,'Dukekart Registration Successfully.');

           $message = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong><h3>Success!</h3></strong>Thanks for registering with us. Now you have to complete your profile and KYC after that you can start listing your product.</div>';

        $this->session->set_flashdata('message', $message);
        redirect(site_url('web/success/'.$insert_id), 'refresh');

    }

  
     } 
        
 }




  public function login(){
  $this->load->view('admin/vendor_login');
  }



}
