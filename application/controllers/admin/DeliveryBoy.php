<?php defined('BASEPATH') OR exit('No direct script access allowed');
class DeliveryBoy extends CI_Controller {

		public function __construct() {
		parent::__construct();
		$this->load->library('email');
		$this->load->library('session');
		$this->load->helper('message');
		$this->load->model('DeleveryBoyModel');
      
    }

	public function index()
	{
		$data['index']          = 'deliverlist';
		$data['index2']         = '';
     	$data['title']          = 'Manage Users';
     	$data['getData']		=  $this->DeleveryBoyModel->getUserList();
	
		$this->load->view('include/header',$data);
		$this->load->view('deliveryboy/DeliverboyList');
		$this->load->view('include/footer');
	}
	public function AddDeliveryBoy()
	{
		
		$data['index']          = 'addUser';
		$data['index2']         = '';
     	$data['title']          = 'Manage Users';
     	    	
		$this->load->view('include/header',$data);
		$this->load->view('deliveryboy/AddDeliveryBoy');
		$this->load->view('include/footer');
	}


	public function DeliveryBoyPost()
	{
		$data = $this->input->post();

	 	$row  = $this->DeleveryBoyModel->AddUsersData($data);
	      if($row > 0){
	         $this->session->set_flashdata('activate', getCustomAlert('S',' Data has been added Successfully.'));
	          redirect('admin/DeliveryBoy/');
	        }else {
	         $this->session->set_flashdata('activate', getCustomAlert('S','!Opps Something is worng.Please try again.'));
	          redirect('admin/DeliveryBoy');
	        }
	 }

public function alotOrder()
{
	$data                     = $this->input->post();
	$param                    = array();
	$param['deliverBoyId']    = $data['deliverBoyId'];
	$param['order_id']        = $data['order_id'];
	$param['add_date']        = time();
  $ifOrderExist =  $this->db->get_where('assign_order',array('order_id'=>$data['order_id']))->row_array();

    if($ifOrderExist['order_id'] == $data['order_id'])
	     {
	     	$this->db->set('deliverBoyId', $data['deliverBoyId']); 
            $this->db->where('order_id', $ifOrderExist['order_id']); 
            $this->db->update('assign_order');
		 $this->session->set_flashdata('activate', getCustomAlert('S','Order has been alloted Successfully.'));
		  redirect('admin/Order/');
	    }
    $run = $this->db->insert('assign_order',$param);
    if($run > 0){
		$this->session->set_flashdata('activate', getCustomAlert('S',' Order has been alloted Successfully.'));
		redirect('admin/Order/');
}else {
 $this->session->set_flashdata('activate', getCustomAlert('D','!Opps Something is worng.Please try again.'));
  redirect('admin/Order/');
}

}

public function alotMembershipOrder(){
	$data                     = $this->input->post();
	$param                    = array();
	$param['deliverBoyId']    = $data['deliverBoyId'];
	$param['order_id']        = $data['order_id'];
	$param['add_date']        = time();
  $ifOrderExist =  $this->db->get_where('assign_membership_order',array('order_id'=>$data['order_id']))->row_array();

    if($ifOrderExist['order_id'] == $data['order_id'])
	     {
	     	$this->db->set('deliverBoyId', $data['deliverBoyId']); 
            $this->db->where('order_id', $ifOrderExist['order_id']); 
            $this->db->update('assign_membership_order');
		 $this->session->set_flashdata('activate', getCustomAlert('S','Order has been alloted Successfully.'));
		  redirect('admin/Membership/planList');
	    }
    $run = $this->db->insert('assign_membership_order',$param);
    if($run > 0){
		$this->session->set_flashdata('activate', getCustomAlert('S',' Order has been alloted Successfully.'));
		redirect('admin/Order/');
}else {
 $this->session->set_flashdata('activate', getCustomAlert('D','!Opps Something is worng.Please try again.'));
  redirect('admin/Membership/planList');
}

}




	public function Useraddress($id ='')
	{
		$data['index']          = 'Users';
		$data['index2']         = '';
     	$data['title']          = 'View User Address';
     	$data['getData']		=  $this->Manage_Users_Model->GetUserAddress($id);
     	$data['getSingleData']	=  $this->Manage_Users_Model->getSingleData($id,'user_master','username');
     	/*echo "<pre>";
     	print_r($data['getSingleData']); exit;*/
	
		$this->load->view('include/header',$data);
		$this->load->view('Users/ViewAddress');
		$this->load->view('include/footer');
	}
	 public function ResetPass($id='')
	 {
	 	$query = $this->db->query("SELECT * FROM `user_master` where id = '".$id."'")->row_array();	 	
	 	$SendSMS = $this->randomPassword($id,$query['phone_no']);
	 	echo $SendSMS; 
	 }

	public function randomPassword($id='',$mobile='') {

    $alphabet = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 10; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
      }
   		// Send msg to user
       /*echo implode($pass); exit;*/

     	$message = urlencode("Hi, Your New Password : ".implode($pass)."."); 
     	/*echo $message; exit;*/
        $mobile = urlencode($mobile); 
        $url = "http://www.wiztechsms.com/http-api.php?username=shiblee&password=Mega@123&senderid=VPUNCH&route=2&number=".$mobile."&message=".$message;
       //print_r($url); exit;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_exec($ch);
                     // return 1;


            $arrayName =array();
            $arrayName['password'] = base64_encode(implode($pass));	
            $this->db->where('id',$id);
	   		$row = $this->db->update('user_master',$arrayName);
			return ($row==1)?'1':'';
	   		
    }

	 public function UsersStatus($id)
	 {
	 	$id = $this->uri->segment(4);
	  	$sql =$this->db->query("SELECT * from user_master where id= '".$id."'")->row_array();
		$sql['status'];
		$arrayName=  array();
		$arrayName['status'] = ($sql['status']==1) ? '2' : '1'; 
	  	$this->db->where('id',$id);
	    $this->db->update('user_master',$arrayName);
	    echo $arrayName['status'];

	 }

	 public function UpdateUsers($id='')
	{
		
		$data['index']          = 'UpdtUsers';
		$data['index2']         = '';
     	$data['title']          = 'Manage Users';

     	$data['getData']		=  $this->Manage_Users_Model->getSingleUsersData($id);
     	/*echo "aaa<pre>";
     	print_r($data['getData']); exit;
     	    	*/
		$this->load->view('include/header',$data);
		$this->load->view('Users/UpdateUsers');
		$this->load->view('include/footer');
	}


	public function UpdateUserData($id='')
	{
		$data = $this->input->post();
		$data['id'] = $id;
	
 		$fileName  = $_FILES["uploadFileUsers"]["name"];
		$extension = explode('.',$fileName);
		$extension = strtolower(end($extension));
		$uniqueName= 'User_'.uniqid().'.'.$extension;
		$type      = $_FILES["uploadFileUsers"]["type"];
		$size      = $_FILES["uploadFileUsers"]["size"];
		$tmp_name  = $_FILES['uploadFileUsers']['tmp_name'];
		$targetlocation= PROFILE_DIRECTORY.$uniqueName;

		if(!empty($fileName)){
		move_uploaded_file($tmp_name,$targetlocation);
		$data['profile_pic'] = utf8_encode(trim($uniqueName));
		}
	 	$row  = $this->Manage_Users_Model->UpdateUsersData($data);
	      if($row > 0){
	         $this->session->set_flashdata('activate', getCustomAlert('S',' Users details has been Updated Successfully.'));
	          redirect('admin/Users/');
	        }else {
	         $this->session->set_flashdata('activate', getCustomAlert('S','!Opps Something is worng.Please try again.'));
	          redirect('admin/Users/');
	        }
	 }

	public function UserTransaction($user='')
	{
		$data['index']              = 'Users';
		$data['index2']             = '';
     		$data['title']          = 'Manage Users';
     		$this->db->order_by('id','desc');
     		$data['getData']		=  $this->db->get_where('transaction_history', array('user_master_id'=>$user))->result_array();
     		$data['user_id']        = $user;
     
		$this->load->view('include/header',$data);
		$this->load->view('Users/transaction');
		$this->load->view('include/footer');
	}
	public function creditWallet($userId='')
	{

		$data['index']              = 'Users';
		$data['index2']             = '';
     		$data['title']          = 'Manage Credit';
     		$data['getData']		=  $this->db->get_where('user_master', array('id'=>$userId))->row_array();
     
		$this->load->view('include/header',$data);
		$this->load->view('Users/creditWallet');
		$this->load->view('include/footer');
	}
	public function creditAmountPost($userId='')
	{

        $amount = $this->input->post('amount');

     	$oldAmt		=  $this->db->get_where('user_master', array('id'=>$userId))->row_array();
     	$updateAmt  = $oldAmt['wallet_amount'] + $amount;

     	$array = array();
        $array['wallet_amount'] = $updateAmt;

     	$this->db->where('id',$userId);
     	$run = $this->db->update('user_master',$array);
       if($run > 0){
         $field              = array();
         $field['type']      = '3';
         $field['amount']    = $amount;
         $field['user_master_id']    = $userId;
         $field['debit_credit']    = "2";
         $field['status']    = '2';
         $field['add_date']  = time();
         $this->db->insert('transaction_history',$field);

     $mobile   = urlencode($oldAmt['phone_no']);
     $message  = urlencode("Dear customer, You have received Rs.".$amount." in your wallet by MrNMrs Ekart.\r\nThanks\r\nMrNMrs Ekart");
       $this->SendUserSMS($mobile,$message);
      
         $this->session->set_flashdata('activate', getCustomAlert('S','Amount has been added Successfully.'));
        redirect('admin/Users/');     

          }else{
	         $this->session->set_flashdata('activate', getCustomAlert('S','!Opps Something is worng.Please try again.'));
	          redirect('admin/Users/');  
       }
	}

	public function SendUserSMS($mobile,$message)
    {    
      $url = "http://bulksms.megainfomatix.com/http-api.php?username=lalitmohan&password=123456&senderid=MRNMRS&route=2&number=".$mobile."&message=".$message."";
        
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
        return 1;
        
     }

}