<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Membership extends CI_Controller {

		public function __construct() {
		parent::__construct();
		$this->load->library('email');
		$this->load->library('session');
		$this->load->helper('message');
		$this->load->model('Membership_Model');
      
    }

	public function plan(){
		$data['index']          = 'plan';
		$data['index2']         = '';
     	$data['title']          = 'Manage Membership Plan';
     	$data['getData']		=  $this->Membership_Model->getUserPlanList();
		$this->load->view('include/header',$data);
		$this->load->view('Membership/plan_list');
		$this->load->view('include/footer');
	}

	public function usesPlanList($id){
		$data['index']          = 'plan';
		$data['index2']         = '';
     	$data['title']          = 'Manage Membership Plan';
     	$data['getData']		=  $this->Membership_Model->getMembershipListUser($id);
		$this->load->view('include/header',$data);
		$this->load->view('Membership/UsersList');
		$this->load->view('include/footer');
	}

	public function planList($id=''){
		$data['index']          = 'planList';
		$data['index2']         = '';
     	$data['title']          = 'Manage Membership Plan';
     	if(empty($id)){
     	$data['getData']		=  $this->Membership_Model->getUserMembershipList();
     	} else {
          $data['getData']		=  $this->Membership_Model->getMembershipListUser($id);
     	}
		$this->load->view('include/header',$data);
		$this->load->view('Membership/member_list');
		$this->load->view('include/footer');
	}
	public function orderDetail($oder_number){
		$data['index']          = 'planList';
		$data['index2']         = '';
     	$data['title']          = 'Manage Membership Plan';
     	$data['getData']		=  $this->Membership_Model->getUserMembershipList();
		$this->load->view('include/header',$data);
		$this->load->view('Membership/order_detail');
		$this->load->view('include/footer');
	}


	public function addPlan(){
		$data['index']          = 'plan';
		$data['index2']         = '';
     	$data['title']          = 'Manage Membership Plan';
     	$data['getData']		=  $this->Membership_Model->getUserPlanList();
		$this->load->view('include/header',$data);
		$this->load->view('Membership/addPlan');
		$this->load->view('include/footer');
	}

	public function update_plan($id){
		$data['index']          = 'plan';
		$data['index2']         = '';
     	$data['title']          = 'Manage Membership Plan';
     	$data['getData']		=  $this->db->get_where('member_plan',array('id'=>$id))->row_array();
		$this->load->view('include/header',$data);
		$this->load->view('Membership/updatePlan');
		$this->load->view('include/footer');
	}


public function addPlanData(){
		$data =   $this->input->post();
		$field                   =   array();
        $field['plan']           =  $data['plan'];
        $field['plan_price']     =  $data['plan_price'];
        $field['description']    =  $data['description'];
        $field['add_date']       =  time();
        $field['status']         =  '1';
       $result  = $this->db->insert('member_plan',$field);
       if($result > 0){
	         $this->session->set_flashdata('activate', getCustomAlert('S',' Membership has been Added Successfully.'));
	          redirect('admin/Membership/plan/');
	        }else {
	         $this->session->set_flashdata('activate', getCustomAlert('D','!Opps Something is worng.Please try again.'));
	          redirect('admin/Membership/plan/');
	        }
	}


	public function UpdateOrderStatus($id){
		$data =   $this->input->post();
		$remark                  = $data['remark'];
		$description             = $data['description'];
		$field                   =  array();
        $status                  =  $data['StatusUpdate'];
        $order_number            =  $data['order_number'];
        $mobile                  =  $data['mobile'];
        $field['status']         = $status;
        $field['modify_date']    = time();

      if($status=='3'){
       	   $order = $this->db->get_where('user_membership_plan',array('order_number'=>$id))->row_array();
             $data                   =      array();
             $data['wallet_amount']  =      $order['wallet_amount'];
           $this->db->where('phone_no',$mobile);
           $result =$this->db->update('user_master', $data);
           $this->SendUserSMSForWalletTransaction($user_id,$order_id,$order['wallet_amount'],$mobile);
           $transaction = array();
           $transaction['type']                    = '1';
           $transaction['txn_id']                  =  $data['order_number'];
           $transaction['amount']                  =  $order['wallet_amount'];
           $transaction['payment_status']          =  '2';
           $transaction['debit_credit']            =  '2';
           $this->db->insert('transaction_history',$transaction);
         }



        if( $status=='4'){
             $this->SendUserSMS($user_id,$order_id,$remark,$description,$mobile);
        }
            $this->db->where('order_number',$id);
       $result  = $this->db->update('user_membership_plan',$field);
       if($result > 0){
	         $this->session->set_flashdata('activate', getCustomAlert('S',' Order Status has been Changed Successfully.'));
	         redirect(base_url()."admin/Membership/orderDetail/".$order_number);
	        }else {
	         $this->session->set_flashdata('activate', getCustomAlert('D','!Opps Something is worng.Please try again.'));
	           redirect(base_url()."admin/Membership/orderDetail/".$order_number);
	        }
	}

public function SendUserSMS($user_id,$order_id,$message,$description,$mobile)  { 
     
        $OrderId= allData2('order_master','order_number',$order_id);
        $message = urlencode("Dear customer,Your Membership plan of  ".PROJECT_tit." - ".$description." has been canceled by admin because ".$message." \r\nThanks\r\n".PROJECT_tit); 
        
        $mobile = urlencode($mobile); 
        
        $url = "http://bulksms.megainfomatix.com/http-api.php?username=lalitmohan&password=123456&senderid=MRNMRS&route=2&number=".$mobile."&message=".$message."";
        
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
        
        
    }


    public function SendUserSMSForWalletTransaction($user_id,$order_id,$wallet_amount,$mobile){ 
        $message = urlencode("Dear customer,You Received  RS - ".$wallet_amount." in Your Wallet because Your oder  has been Accepted by admin.\r\nThanks\r\n".PROJECT_tit);
        $mobile = urlencode($mobile); 
        $url = "http://bulksms.megainfomatix.com/http-api.php?username=lalitmohan&password=123456&senderid=MRNMRS&route=2&number=".$mobile."&message=".$message."";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
        
    }


	public function updatePlanData($id){
		$data =   $this->input->post();
		$field                   =   array();
        $field['plan']           =  $data['plan'];
        $field['plan_price']     =  $data['plan_price'];
        $field['description']    =  $data['description'];
        $field['add_date']       =  time();
        $field['status']         =  '1';
            $this->db->where('id',$id);
       $result  = $this->db->update('member_plan',$field);
       if($result > 0){
	         $this->session->set_flashdata('activate', getCustomAlert('S',' Membership has been Updated Successfully.'));
	          redirect('admin/Membership/plan/');
	        }else {
	         $this->session->set_flashdata('activate', getCustomAlert('D','!Opps Something is worng.Please try again.'));
	          redirect('admin/Membership/plan/');
	        }
	}

	public function UsersStatus($id)
	 {
	 	$id = $this->uri->segment(4);
	  	$sql =$this->db->query("SELECT * from member_plan where id= '".$id."'")->row_array();
		$sql['status'];
		$arrayName=  array();
		$arrayName['status'] = ($sql['status']==1) ? '2' : '1'; 
	  	$this->db->where('id',$id);
	    $this->db->update('member_plan',$arrayName);
	    echo $arrayName['status'];

	 }

    


	public function changeStatus() {
		$table       = $this->input->post('table');
		$id          = $this->input->post('id');
		$user_id     = $this->input->post('user_id');
		$user_wallet = $this->input->post('user_wallet');

		$wallet['wallet_amount']  =  $user_wallet;
        $this->db->where('id',$user_id);
        $this->db->update('user_master',$wallet);
		$update_status = $this->changeStatuss($id, $table);
		echo $update_status; die();
	}

public function changeStatuss($row_id, $table_name) {
			$qry = $this->db
						->select('*')
						->from($table_name)
						->where('id', $row_id)
						->get()
						->row_array();

			$cur_date = strtotime(date('d-m-Y'));

			if ($qry['status'] == '1') {

				$data = array(
								'status' 		=> '2',
								'modify_date'	=> $cur_date
							);
				$update_data = $this->db->where('id', $row_id)->update($table_name, $data);
				return 2;

			} else if ($qry['status'] == '2') {

				$data = array(
								'status' 		=> '1',
								'modify_date'	=> $cur_date
							);
				$update_data = $this->db->where('id', $row_id)->update($table_name, $data);
				return 1;

			}
	 }



}