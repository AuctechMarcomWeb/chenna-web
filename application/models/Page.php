<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('email');
		$this->load->library('session');
		$this->load->helper('message');
		$this->load->model('website_model');
        $this->load->model('Ekart_model');
        $this->load->model('RechargeModel');
    }

	public function Payments ()
	{	
	        $data['category'] = GetAllData('category_master','category_name','Asc');	
		$this->load->view('website/header',$data);
                  $this->load->view('website/pages/payment');
		$this->load->view('website/innerFooter');
		
	}

public function Shipping ()
	{	
		$data['category'] = GetAllData('category_master','category_name','Asc');	
		$this->load->view('website/header',$data);
                  $this->load->view('website/pages/Shipping');
		$this->load->view('website/innerFooter');
		
	}

	public function buyerProductionPolicy (){
		$data['category'] = GetAllData('category_master','category_name','Asc');	
		$this->load->view('website/header',$data);
                  $this->load->view('website/pages/BuyerProductPolicy');
		$this->load->view('website/innerFooter');
		
	}
	public function siteMap (){
		$data['category'] = GetAllData('category_master','category_name','Asc');	
		$this->load->view('website/header',$data);
        $this->load->view('website/pages/siteMap');
		$this->load->view('website/innerFooter');
	}

public function contactUs (){
		$data['category'] = GetAllData('category_master','category_name','Asc');	
		$this->load->view('website/header',$data);
        $this->load->view('website/pages/contactus');
		$this->load->view('website/innerFooter');
	}
public function refundPolicy (){
		$data['category'] = GetAllData('category_master','category_name','Asc');	
		$this->load->view('website/header',$data);
        $this->load->view('website/pages/refundPolicy');
		$this->load->view('website/innerFooter');
}
public function shippingPolicy (){
		$data['category'] = GetAllData('category_master','category_name','Asc');	
		$this->load->view('website/header',$data);
        $this->load->view('website/pages/shippingPolicy');
		$this->load->view('website/innerFooter');
}
public function userAgreement (){
		$data['category'] = GetAllData('category_master','category_name','Asc');	
		$this->load->view('website/header',$data);
        $this->load->view('website/pages/userAgreement');
		$this->load->view('website/innerFooter');
}
public function returnReplacementPolicy (){
		$data['category'] = GetAllData('category_master','category_name','Asc');	
		$this->load->view('website/header',$data);
        $this->load->view('website/pages/returnReplacementPolicy');
		$this->load->view('website/innerFooter');
}
	
public function CancellationReturns ()
	{	
		$data['category'] = GetAllData('category_master','category_name','Asc');	
		$this->load->view('website/header',$data);
                  $this->load->view('website/pages/returncancelation');
		$this->load->view('website/innerFooter');
		
	}
	public function FAQ ()
	{	
		$data['category'] = GetAllData('category_master','category_name','Asc');	
		$this->load->view('website/header',$data);
                  $this->load->view('website/pages/faq');
		$this->load->view('website/innerFooter');
		
	}
	
public function ReportInfringement ()
	{	
		$data['category'] = GetAllData('category_master','category_name','Asc');	
		$this->load->view('website/header',$data);
                  $this->load->view('website/pages/ReportInfringement');
		$this->load->view('website/innerFooter');
		
	}
public function AboutUs ()
	{	
		$data['category'] = GetAllData('category_master','category_name','Asc');	
		$this->load->view('website/header',$data);
                  $this->load->view('website/pages/about');
		$this->load->view('website/innerFooter');
		
	}
public function Recharge ()
	{
			
 			
			$data['category'] = GetAllData('category_master','category_name','Asc');	
			$this->load->view('website/header',$data);
            $this->load->view('website/pages/recharge');
			$this->load->view('website/innerFooter');
		
	 }


   public function addRechargeRecord()
	   {
	    $requestJson = $this->input->post();
	    $data = array();
	    $sessiondata=$this->session->userdata('Userlogindata');

        $data['uuid']                   = trim($sessiondata['id']); 
        $data['recharge_amt']           = trim($requestJson['recharge_amt']);
        $data['recharge_type']          = trim($requestJson['recharge_type']);
        $data['dth_mobile_number']      = trim($requestJson['dth_mobile_number']);

if($data['recharge_type'] =='1'){
        $data['service_provider']       = trim($requestJson['service_provider']);
}
else{
 $data['service_provider']       = trim($requestJson['service_provider2']);
}


        $data['circle_code']            = trim($requestJson['circle_code']);
        $data['service_provider2']       = $requestJson['service_provider2'];
        $data['wallet']                 = "1";
        //$data['wallet']          = trim($requestJson['result']['wallet']);
 
        $PrepaidRecharge = $this->RechargeModel->StarteRecharge($data);
       
        $array = array();
         $array['transaction_detial']= $PrepaidRecharge;
          $transactionID  = $array['transaction_detial']['txn_id'];  
           if($transactionID != ""){
     $Rechangeapi1 = $this->RechargeModel->GetRechargeStatus($transactionID);
           		//print_r($Rechangeapi); exit;
               // $RechargeInfo = $this->RechargeModel->RechargeInfo($transactionID);

                 if($Rechangeapi1  == '4')
                 {
                    $msg='Recharge Refund';
                 }
                 elseif($Rechangeapi1  == '3')
                 {
                    $msg='Recharge Failed';
                 }
                 elseif($Rechangeapi1  == '2')
                 {
                   $msg='Recharge Successfully.';
                 }
                 elseif($Rechangeapi1  == '1')
                 {
                    $msg='Recharge Pending.';
                 }
 elseif($Rechangeapi1  == '0')
                 {
                    $msg='Recharge Faild.';
                 }

            if($msg != ""){
         	$this->session->set_flashdata('pinmsg',' <div class="alert alert-success">'.$msg.'</div>');
			redirect('Page/Recharge'); 
         }
         


       
 	
}
}
	 
public function Rechargedth ()
	{	
		
		$this->load->view('website/header');
                  $this->load->view('website/pages/rechargedth');
		$this->load->view('website/innerFooter');
		
	}
public function Careers ()
	{	
		$data['category'] = GetAllData('category_master','category_name','Asc');	
		$this->load->view('website/header',$data);
                  $this->load->view('website/pages/careers');
		$this->load->view('website/innerFooter');
		
	}
public function Stories()
	{	
		$data['category'] = GetAllData('category_master','category_name','Asc');	
		$this->load->view('website/header',$data);
                  $this->load->view('website/pages/stories');
		$this->load->view('website/innerFooter');
		
	}
public function Press()
	{	
		$data['category'] = GetAllData('category_master','category_name','Asc');	
		$this->load->view('website/header',$data);
                  $this->load->view('website/pages/press');
		$this->load->view('website/innerFooter');
		
	}
  public function recheck()
	{	
        $PrepaidRecharge = $this->RechargeModel->GetRechargeStatus("RcTxn_ID_1537363595");
        //print_r($PrepaidRecharge);exit();
		
	}
 public function GatewayRedirect(){ 
    $this->load->view('paymentGateway/ccavResponseHandler2');
  }

 public function confirmOrder(){
		$requestJson = $this->input->post();
	    $data = array();
	    $sessiondata=$this->session->userdata('Userlogindata');
		$data['uuid']                   = '154'; 
        $data['recharge_amt']           = $requestJson['recharge_amt'];
        $data['recharge_type']          = $requestJson['recharge_type'];
        $data['dth_mobile_number']      = $requestJson['dth_mobile_number'];
        $data['service_provider']       = $requestJson['service_provider'];
        $data['circle_code']            = $requestJson['circle_code'];
        $data['wallet']                 = "0";
         

		 $sql =$this->db->query("SELECT * FROM `settings` where id ='1'")->row_array(); 
		 $sessiondata=$this->session->userdata('Userlogindata');
		 $userId 	         = '154';  
		 $price 	         = $this->input->post('recharge_amt');
		 $final_price 	     = $this->input->post('recharge_amt');
		 $mobileno           = $this->input->post('dth_mobile_number');
	     $type             	 = $this->input->post('recharge_type');
	     $time=time();
	     $tid             	 = "RcTxn_ID_".$time;
	     $user_info          = $this->db->get_where('user_address_master',array('	user_master_id'=>$userId))->row_array();
        
					    //$time=time();
 $data['tid']=$tid;
$data['userId']=$userId;
	$data['final_price']=$final_price;
					      	$data2 =  array();
					      	$data2['final_price']=$final_price;
					    
					      	$data2['userId']=$userId;
					      	$data2['currency']='INR';
					      	$data2['merchant_id']='159185';
					      	$data2['order_id']=$tid;
					      	$data2['racking_id']= time(); 
					      	$data2['amount']=$final_price;
					      	$data2['redirect_url']= base_url('Page/GatewayRedirect');
					      	$data2['cancel_url']=base_url('Page/GatewayRedirect');
					      	$data2['language']='EN';
					      	$data2['billing_name']='Mrnmrsekart';
					      	$data2['billing_address']='10 Gali No-2,Prem Nagar Ring Road, Bijnor';
					      	$data2['billing_city']='Bijnor';
					      	$data2['billing_state']='Uttar Pradesh';
					      	$data2['billing_zip']='246701';
					      	$data2['billing_country']='India';
					      	$data2['billing_tel']='91-8006 446008';
					      	$data2['billing_email']='satyadav919@gmil.com';
					      	$data2['merchant_param1']='MrNMrseKart  online shopping ';
					      
					   $PrepaidRecharge = $this->RechargeModel->insertonlinePayment($data);

					       $this->load->view('paymentGateway/ccavRequestHandler2',$data2);
					           $status['status'] ='2';
                             //  $this->db->where('order_number',$isProductBuys);
                              // $this->db->update('order_master',$status);
				
		   
   
}


	public function finalDetail()
	{	
        is_not_logged_in_website();
        $UserData =  $this->session->userdata('Userlogindata');
        $data['cartData'] = $this->Ekart_model->getCartDataById('mycart_master',$UserData['id']);
        $data['countList'] = $session = count($this->Ekart_model->getCartDataById('mycart_master',$UserData['id']));
        $this->session->set_userdata('cartcounting',$session);
        $data['category'] = GetAllData('category_master','category_name','asc');

        $data['addresses'] = $this->Ekart_model->getImageDataBypId('user_address_master','user_master_id',$UserData['id']);

		$data['section4'] = $this->website_model->GetData('4'); # 4 => for section 
		$data['section5'] = $this->website_model->GetData('5'); # 4 => for section 
		$this->load->view('website/header',$data);
		$this->load->view('website/finalDetail');
		$this->load->view('website/innerFooter');
		$this->load->view('website/footerMid');
		$this->load->view('website/thumbnailsJs');
		$this->load->view('website/footerDetail');
	}

public function PaymentRecharge ()
	{
			
 			
			$data['category'] = GetAllData('category_master','category_name','Asc');	
			$this->load->view('website/header',$data);
            $this->load->view('website/pages/paymentrecharge');
			$this->load->view('website/innerFooter');
		
	 }
}
