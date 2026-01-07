<?php
class Credit_model extends CI_Model {
	 public function __construct(){
		parent::__construct();
		$this->load->database();
	}

   public function AddWallet($request)
   {
     /*print_r($request); exit;*/
     $getdata = $this->db->get_where('user_master',array('id'=>$request['user_master_id']))->row_array();
    //$getdata = $this->db->get_where('user_master',array('id'=>$request['user_master_id']));
      if($request['type']==1)
      {

         $array= array(); 
         $array['wallet_amount'] = $getdata['wallet_amount'] - $request['pay_value'];
         $this->db->where('id',$request['user_master_id']);
         $row = $this->db->update('user_master', $array);
         
         $message = urlencode("Hi, Your Wallet has been debited with Rs. ".$request['pay_value']." /- for ".$request['remark'].". Now, your current Wallet amount is Rs. ".$array['wallet_amount']."/- "); 
       /* echo $message; exit;*/
        $mobile = urlencode($getdata ['phone_no']); 
      
        $url = "http://bulksms.megainfomatix.com/http-api.php?username=lalitmohan&password=123456&senderid=MRNMRS&route=2&number=".$mobile."&message=".$message;
        //echo $url; exit;
        
        $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_exec($ch);
           
           
      }else{
        $array= array(); 
        $array['wallet_amount'] = $getdata['wallet_amount'] + $request['pay_value'];
          $this->db->where('id',$request['user_master_id']);
          $row = $this->db->update('user_master', $array);
          
          
         $message = urlencode("Hi, Your Wallet has been credited with Rs. ".$request['pay_value']."/-  for ".$request['remark'].". Now, your current Wallet amount is Rs. ".$array['wallet_amount']."/- "); 
       /* echo $message; exit;*/
        $mobile = urlencode($getdata ['phone_no']); 
      
        $url = "http://bulksms.megainfomatix.com/http-api.php?username=lalitmohan&password=123456&senderid=MRNMRS&route=2&number=".$mobile."&message=".$message;
        // echo $url; exit;
        
        $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_exec($ch);
      }
        $arrayName =  array();
        $arrayName['user_master_id'] = $request['user_master_id'];
        $arrayName['debit_credit']   = $request['type'];
        $arrayName['amount']         = $request['pay_value'];
        $arrayName['reason']         = '6';
        $arrayName['remark']         = $request['remark'];
        $arrayName['status']         = '1';
        $arrayName['add_date']       = time();
        $arrayName['modify_date']    = time();
        $insert = $this->db->insert('wallet_master',$arrayName);
        
        
        
            $transaction_history= array();
            $transaction_history['type']                  = '3';
            $transaction_history['txn_id']                = "Txn_".time();
            $transaction_history['amount']                = $request['pay_value'];
            $transaction_history['user_master_id']        = $request['user_master_id'];
            $transaction_history['wallet_used']           = 0;
            $transaction_history['debit_credit']          = $request['type'];
            $transaction_history['wallet_used_amount']    = 0;
            $transaction_history['payment_used']          = 0;
            
            $transaction_history['payment_status']        = 2; 
            $transaction_history['add_date']              = time();

            /*$wallet_amount = $this->GetWalletDetail($data['uuid']);*/
            $this->db->insert('transaction_history',$transaction_history); 

        return $insert;

   }

}
?>