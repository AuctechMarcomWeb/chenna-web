<?php include('Crypto.php');?>
<?php
$this->load->library('cart');
error_reporting(0);
$workingKey = '22F45F6F17E5AAEFF614240D0282D19C'; // Working Key should be provided here

$encResponse = $_POST["encResp"]; // This is the response sent by the CCAvenue Server
$rcvdString = decrypt($encResponse, $workingKey); // Crypto Decryption using the specified working key

$order_status = "";
$order_number = "";

$decryptValues = explode('&', $rcvdString);

foreach ($decryptValues as $value) {
    list($key, $val) = explode('=', $value);
    if ($key === 'order_status') {
        $order_status = $val;
    }
    if ($key === 'order_id') {
        $order_number = $val;
    }
}

$data = array(
    'order_response' => $order_number,
    'card_response' => $order_status,
    'order_number' => $order_number
);

$this->db->insert('logs', $data);


          $get_oder  = $this->db->get_where('order_master',array('order_number'=>$order_number))->row_array();
           $order_id  = $get_oder['id'];
           $get_oder_info=$this->db->get_where('order_master',array('order_number'=>$order_id))->row_array();
           $user_id = $get_oder_info['user_master_id'];
           $final_amount = $get_oder_info['final_price'] + $get_oder_info['shippment_charge'];
           
           
        $user_res = $this->db->get_where('user_master',array('id' => $get_oder['user_master_id']))->row_array();   
     $user_data = array(
        'id'=>$user_res['id'],
        'email'=>$user_res['email_id'],
        'username'=>$user_res['username']
    );
    $user_ses = $this->session->set_userdata('User',$user_data);
           
           
      if($order_status==="Success"):
      	        $status['status'] ='1';
      	        $status['action_payment'] = 'Yes';
      	        $status['payment_status'] = 'Paid';
      	        
               // $this->SendUserSMS($user_id,$order_id,$final_amount);
                $this->db->where('order_number',$order_number);
                $this->db->update('order_master',$status);
      	$this->session->set_flashdata('activate','<span style="color:green">YOUR ORDER HAS BEEN SUCCESSFULLY.</span>');
      	$order_id = base64_encode($order_id);
        $this->cart->destroy();
        redirect(base_url()."web/order_success/".$order_id);
     
       elseif($order_status=='Aborted'):
       	$this->session->set_flashdata('activate','<span style="color:red">YOUR ORDER HAS BEEN CANCEL.</span>');
                    $status['status'] ='4';
                    $status['action_payment'] = 'Yes';
                    $status['payment_status'] = 'Unpaid';
                    $this->db->where('order_number',$order_number);
                   $row=$this->db->update('order_master',$status);
                if($row > 0):
                     $statuss['status']='2';
                     $status['action_payment'] = 'Yes';
                     $status['payment_status'] = 'Unpaid';
                     $this->db->where('order_master_id',$order_id);
                    $this->db->update('purchase_master',$statuss);
                endif;
            redirect(base_url());
       elseif($order_status=='Failure'):
       	$this->session->set_flashdata('activate','<span style="color:red">YOUR ORDER HAS BEEN CANCEL.</span>');
                $status['status'] ='2';
                $status['action_payment'] = 'Yes';
                $status['payment_status'] = 'Unpaid';
                $this->db->where('order_number',$order_number);
                   $row=$this->db->update('order_master',$status);
                if($row > 0):
                	$statuss['status']='2';
                	$status['action_payment'] = 'Yes';
                	$status['payment_status'] = 'Unpaid';
                  $this->db->where('order_master_id',$order_id);
                   $this->db->update('purchase_master',$statuss);
                endif; 
            redirect(base_url());
       endif;
       
    //   $order_id = base64_encode($order_id);
    //   $this->cart->destroy();
    //   redirect(base_url()."web/order_success/".$order_id);
     	



?>