<?php
class StartSchoolFee_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->helper('api');  
  }



  public function StartSchoolFee($data)
   {
      
      $SQL= "SELECT * FROM `user_master` where id ='".$data['uuid']."'";
      $query= $this->db->query($SQL)->row_array();


      
     
      $array = array();
      $time = time();
      $TransID = "SchTnx_ID_".$time;
      $array['transaction_id']               = $TransID;
      $array['user_master_id']               = $data['uuid'];
     
      $array['school_id']                    = $data['school_id'];
      $array['branch_id']                    = $data['branch_id'];
      $array['std_class']                    = $data['std_class'];
      $array['std_batch']                    = $data['std_batch'];
      $array['std_roll_no']                  = $data['std_roll_no'];
      $array['std_name']                     = $data['std_name'];
      $array['fees']                         = $data['std_fee'];
      /* $array['fee_from']                     = $data['fee_from']; */
      $array['fees_from']                    = $data['fee_from'];
      $array['fees_to']                      = $data['fee_to'];
      $array['add_date']                     = time(); 
      $array['modify_date']                  = time(); 

      $row = $this->db->insert('fee_master',$array);
      $last_insert_id = $this->db->insert_id();
      

      
      if($data['wallet'] == 1){
        $amount  = $query['wallet_amount'] - $data['std_fee']  ;
        //echo $amount; 
         if($data['std_fee'] > $query['wallet_amount']){
           //echo "aaa"; exit;
            $sql = "UPDATE `user_master` SET wallet_amount = '0'  where id ='".$data['uuid']."'";
            $this->db->query($sql);

              $transaction_history= array();
              $transaction_history['type']                  = '5';
              $transaction_history['txn_id']                = $TransID;
              $transaction_history['amount']                = $data['std_fee'];
              $transaction_history['user_master_id']        = $data['uuid'];
              $transaction_history['wallet_used']           = 1;
              $transaction_history['wallet_used_amount']    = ($data['std_fee'] > $query['wallet_amount']) ? floor($query['wallet_amount']) : $data['std_fee'];
              $transaction_history['payment_used']          = 1;
              $transaction_history['payment_amount']        = abs($amount);
              $transaction_history['payment_status']        = 1; 
              $transaction_history['add_date']              = time();
               //print_r($transaction_history); exit;
              

              $this->db->insert('transaction_history',$transaction_history);
              return array('txn_id'=>$TransID,'payment_req'=>'1', 'payment_status'=>'1','amount'=>abs($amount));

         }else{
           //echo "bbb"; exit;
          $sql = "UPDATE `user_master` SET wallet_amount = wallet_amount - '".$data['insurance_amt']."'  where id ='".$data['uuid']."'";
            $this->db->query($sql);

              $transaction_history= array();
              $transaction_history['type']                  = '5';
              $transaction_history['txn_id']                = $TransID;
              $transaction_history['amount']                = $data['std_fee'];
              $transaction_history['user_master_id']        = $data['uuid'];
              $transaction_history['wallet_used']           = 1;
              $transaction_history['wallet_used_amount']    = $data['std_fee'];
              $transaction_history['payment_used']          = 0;
              $transaction_history['payment_status']        = 0; 
              $transaction_history['add_date']              = time(); 
               //print_r($transaction_history); exit;
              
              $this->db->insert('transaction_history',$transaction_history);
              return array('txn_id'=>$TransID,'payment_req'=>'0', 'payment_status'=>'0','amount'=>'0');
         }

      }else{
        $amount  = $data['std_fee'];
      }

        $transaction_history= array();
        $transaction_history['type']                  = '5';
        $transaction_history['txn_id']                = $TransID;
        $transaction_history['amount']                = $data['std_fee'];
        $transaction_history['user_master_id']        = $data['uuid'];
        $transaction_history['wallet_used']           = '0';
        $transaction_history['wallet_used_amount']    = 'NULL';
        $transaction_history['payment_used']          = '1';
        $transaction_history['payment_amount']        =  $data['std_fee'];
        $transaction_history['payment_status']        = 1;  
        $transaction_history['add_date']              = time(); 
         //print_r($transaction_history); exit;
       

        $this->db->insert('transaction_history',$transaction_history);
        return array('txn_id'=>$TransID,'payment_req'=>'1', 'payment_status'=>'1','amount'=>abs($amount));

      
   }



  

  public function ChangeStatus($response)
  {
    $getDetail = $this->GetTrans_Detail($response['TransID']);
    // print_r($getDetail); exit;
      if(($response['Status'] =='FAILURE') || ($response['Status'] =='Failed')){
        $changeStatus['status'] = '3' ;
        $this->db->where('transaction_id',$response['TransID']);
        $this->db->update('recharge_master',$changeStatus);
        // Update Transaction Table // 

        /*$changeStatus['payment_status'] = '3' ;
        $where = array('type' => '2', 'txn_id' => $getDetail['id']);
        $this->db->where($where);
        $this->db->update('transaction_history',$changeStatus);*/

         /// Refund Amount if Wallet is used////

          if($getDetail['wallet_used'] == 1)
          {
            $sql = "UPDATE `user_master` SET wallet_amount = wallet_amount - '".$getDetail['wallet_used_amount']."'  where id ='".$getDetail['user_master_id']."'";
            $this->db->query($sql);
          }


        return '3';
      }
      if($response['Status'] =='Success'){
        $changeStatus['status'] = '2' ;
        $this->db->where('transaction_id',$response['TransID']);
        $this->db->update('recharge_master',$changeStatus);

        // Update Transaction Table //

        /*$where = array('type' => '2', 'txn_id' => $getDetail['id']);
        $this->db->where($where);
        $this->db->update('transaction_history',$changeStatus);*/

        return '2';              
      }
      if($response['Status'] == 'Refund') {
        $changeStatus['status'] = '4' ;
        $this->db->where('transaction_id',$response['TransID']);
        $this->db->update('recharge_master',$changeStatus);

        // Update Transaction Table //

      /*  $changeStatus['payment_status'] = '4' ;
        $where = array('type' => '2', 'txn_id' => $getDetail['id']);
        $this->db->where($where);
        $this->db->update('transaction_history',$changeStatus);*/

        /// Refund Amount if Wallet is used////

        if($getDetail['wallet_used'] == 1)
        {
        $sql = "UPDATE `user_master` SET wallet_amount = wallet_amount - '".$getDetail['wallet_used_amount']."'  where id ='".$getDetail['user_master_id']."'";
        $this->db->query($sql);
        }


        return '4';   
      }
     if($response['Status'] == 'Pending') {
        
        return '1';   
      }
    }

  public function GetTrans_Detail($txn_id)
    {
      $query = $this->db->query("SELECT * FROM `recharge_master` WHERE transaction_id = '".$txn_id."' ")->row_array();
       return $query;
    }  



}