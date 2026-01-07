<?php
class RechargeModel extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
 
   public function StarteRecharge($data)
   {
      
      $SQL= "SELECT * FROM `user_master` where id ='".$data['uuid']."'";
      $query= $this->db->query($SQL)->row_array();
      
     
      $array = array();
      $time = time();
      $TransID = "RcTxn_ID_".$time;
      $array['transaction_id']               = $TransID;
      $array['user_master_id']               = $data['uuid'];
      $array['recharge_type']                = $data['recharge_type'];
     
      $array['recharge_amt']                 = $data['recharge_amt'];
      $array['dth_mobile_number']            = $data['dth_mobile_number'];
      $array['service_provider']             = $data['service_provider'];
     
      $array['circle_code']                  = $data['circle_code'];
      $array['wallet_used']                  = $data['wallet'];
      $array['add_date']                     = time(); 
      $array['modify_date']                  = time(); 

      $row = $this->db->insert('recharge_master',$array);
      $last_insert_id = $this->db->insert_id();
      

      
      if($data['wallet'] == 1){
        $amount  = $query['wallet_amount'] - $data['recharge_amt']  ;
        //echo $amount; 
         if($data['recharge_amt'] < $query['wallet_amount']){
           //echo "aaa"; exit;
            $sql = "UPDATE `user_master` SET wallet_amount = $amount  where id ='".$data['uuid']."'";
            $this->db->query($sql);
            ############# Transction history ################################
              $transaction_history= array();
              $transaction_history['type']                  = '2';
              $transaction_history['txn_id']                = $TransID;
              $transaction_history['amount']                = $data['recharge_amt'];
              $transaction_history['user_master_id']        = $data['uuid'];
              $transaction_history['wallet_used']           = 1;
              $transaction_history['debit_credit']          = 1;
              $transaction_history['wallet_used_amount']    = ($data['recharge_amt'] > $query['wallet_amount']) ? floor($query['wallet_amount']) : $data['recharge_amt'];
              $transaction_history['payment_used']          = 1;

              $transaction_history['payment_amount']        = abs($amount);
              $transaction_history['status']        = 1; 
              $transaction_history['add_date']              = time(); 


              
              //$wallet_amount = $this->GetWalletDetail($data['uuid']);
              $this->db->insert('transaction_history',$transaction_history);


              $this->db->insert('wallet_master', array('order_recharge_id' => $last_insert_id,'user_master_id' => $data['uuid'],'debit_credit' => '1','amount' => $transaction_history['wallet_used_amount'],'status' => '1','add_date' => $time, 'modify_date' => $time, 'reason' => '1'));
              ############# Wallet Master Record ###########################
                   
             return $apiresponse = $this->Recharge($TransID);
             //print_r($apiresponse); exit;
           

            }
      
        } 

    }

public function Recharge($data)
  {
  
      $sql = "SELECT* FROM `recharge_master` where  `transaction_id` = '".$data."'";
      $query = $this->db->query($sql)->row_array();

      if($query['recharge_type']==1){

          $rechargeUrl ="https://cyrusrecharge.in/api/recharge.aspx?memberid=AP212190&pin=50E3F2846E&number=".$query['dth_mobile_number']."&operator=".$query['service_provider']."&circle=".$query['circle_code']."&amount=".$query['recharge_amt']."&usertx=".$query['transaction_id']."&format=json";
          echo $rechargeUrl; 

          $json = @file_get_contents($rechargeUrl);
          $jsonResult = json_decode($json);

          $ApiTransID['ApiTransID'] = $jsonResult->ApiTransID;
          $this->db->where('transaction_id',$data);
          $this->db->update('recharge_master',$ApiTransID);

          $RechargeStatus['status'] = $jsonResult->Status;
          $RechargeStatus['txn_id'] = $query['transaction_id'];
          return $RechargeStatus;
        }
        if($query['recharge_type']== 2){
          $rechargeUrl ="https://cyrusrecharge.in/api/recharge.aspx?memberid=AP212190&pin=50E3F2846E&number=".$query['dth_mobile_number']."&operator=".$query['service_provider']."&circle=".$query['circle_code']."&amount=".$query['recharge_amt']."&usertx=".$query['transaction_id']."&format=json";

          $json = @file_get_contents($rechargeUrl);
          $jsonResult = json_decode($json);
          // print_r($data);
          ###########################################
          $ApiTransID['ApiTransID'] = $jsonResult->ApiTransID;
          $this->db->where('transaction_id',$data);
          $this->db->update('recharge_master',$ApiTransID);
          ##############################################
          $RechargeStatus['status'] = $jsonResult->Status;
          $RechargeStatus['txn_id'] = $query['transaction_id'];
          return $RechargeStatus;
        }

        if($query['recharge_type']== 3){
          $rechargeUrl ="https://cyrusrecharge.in/api/recharge.aspx?memberid=AP212190&pin=50E3F2846E&number=".$query['dth_mobile_number']."&operator=".$query['service_provider']."&circle=".$query['circle_code']."&amount=".$query['recharge_amt']."&usertx=".$query['transaction_id']."&format=json";
          $json = @file_get_contents($rechargeUrl);
          $jsonResult = json_decode($json);
          // print_r($data);
           ###########################################
          $ApiTransID['ApiTransID'] = $jsonResult->ApiTransID;
          $this->db->where('transaction_id',$data);
          $this->db->update('recharge_master',$ApiTransID);
          ##############################################

          $RechargeStatus['status'] = $jsonResult->Status;
          $RechargeStatus['txn_id'] = $query['transaction_id'];
          return $RechargeStatus; 
        }
         return $apiresponse = $this->GetRechargeStatus($query['transaction_id']);
      
  }


    public function GetRechargeStatus($data)
   {

      $getStatus = "https://cyrusrecharge.in/api/rechargestatus.aspx?memberid=AP212190&pin=50E3F2846E&transid=".$data."&format=json";
      $RechargeResponse = @file_get_contents($getStatus);
     
      $ResponseData     = json_decode($RechargeResponse);
      
 
       $RechargeStatus = $ResponseData->Status;

          if(($RechargeStatus =='FAILURE') || ($RechargeStatus =='Failed')){
              $changeStatus['status'] = '3' ;
             $this->db->where('transaction_id',$data);
             $this->db->update('recharge_master',$changeStatus);




$rechargeData = $this->db->get_where('recharge_master',array('transaction_id'=>$data))->row_array();
              $field = array(); 
              $field['status'] = '3' ;
              $field['remark'] = "You have Failed recharged of Rs. ".$rechargeData['recharge_amt']." in number ".$rechargeData['dth_mobile_number'].".";             
              $this->db->where('txn_id',$data);
              $this->db->update('transaction_history',$field);                   

     $getUser = $this->db->get_where('user_master',array('id'=>$rechargeData['user_master_id']))->row_array();
                        

     $mobile   = urlencode($getUser['phone_no']);
     $message  = urlencode("Dear customer, You have Failed recharge of Rs. ".$rechargeData['recharge_amt']." in number ".$rechargeData['dth_mobile_number'].".\r\nThanks\r\nMrNMrs Ekart");
     $this->SendUserSMS($mobile,$message);

    return 3;
          }
          else if($RechargeStatus =='Success'){
             $changeStatus['status'] = '2' ;
             $this->db->where('transaction_id',$data);
             $this->db->update('recharge_master',$changeStatus);

        $rechargeData = $this->db->get_where('recharge_master',array('transaction_id'=>$data))->row_array();
              $field = array(); 
               $field['status'] = '2' ;
              $field['remark'] = "You have successfully recharged of Rs. ".$rechargeData['recharge_amt']." in number ".$rechargeData['dth_mobile_number'].".";             
              $this->db->where('txn_id',$data);
              $this->db->update('transaction_history',$field);                   

        $getUser = $this->db->get_where('user_master',array('id'=>$rechargeData['user_master_id']))->row_array();
                        

        $mobile   = urlencode($getUser['phone_no']);
        $message  = urlencode("Dear customer, You have successfully recharge of Rs. ".$rechargeData['recharge_amt']." in number ".$rechargeData['dth_mobile_number'].".\r\nThanks\r\nMrNMrs Ekart");
        $this->SendUserSMS($mobile,$message);


             return 2;              
          }
          else if($RechargeStatus =='Refund'){
              $changeStatus['status'] = '4' ;
             $this->db->where('transaction_id',$data);
             $this->db->update('recharge_master',$changeStatus);
            return 4;              
          }
          else if($RechargeStatus =='Pending')
           {

              $changeStatus['status'] = '1' ;
             $this->db->where('transaction_id',$data);
             $this->db->update('recharge_master',$changeStatus);

           $rechargeData = $this->db->get_where('recharge_master',array('transaction_id'=>$data))->row_array();
          $field = array(); 
           $field['status'] = '1' ;
          $field['remark'] = "You have Pending recharged of Rs. ".$rechargeData['recharge_amt']." in number ".$rechargeData['dth_mobile_number'].".";             
          $this->db->where('txn_id',$data);
          $this->db->update('transaction_history',$field); 


            return 1;
           }

           else if($RechargeStatus == '0') {
              return 0;
            }else{
              return '';
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
public function GetWalletDetail($uid)
    {
      $query = $this->db->query("SELECT * FROM `user_master` WHERE id = '".$uid."' ")->row_array();
       return $query['wallet_amount'];
    }  

 public function GetRechargeStatus2($data)
   {


      $getStatus = "https://cyrusrecharge.in/api/rechargestatus.aspx?memberid=AP212190&pin=50E3F2846E&transid=".$data."&format=json";
      $RechargeResponse = @file_get_contents($getStatus);
      $ResponseData     = json_decode($RechargeResponse);
 
       $RechargeStatus = $ResponseData->Status;
         

          if(($RechargeStatus =='FAILURE') || ($RechargeStatus =='Failed')){
              $changeStatus['status'] = '3' ;
             $this->db->where('transaction_id',$data);
             $this->db->update('recharge_master',$changeStatus);

              $rechargeData = $this->db->get_where('recharge_master',array('transaction_id'=>$data))->row_array();
              $field = array(); 
              $field['remark'] = "You have Failed recharged of Rs. ".$rechargeData['recharge_amt']." in number ".$rechargeData['dth_mobile_number'].".";             
              $this->db->where('txn_id',$data);
              $this->db->update('transaction_history',$field);                   

     $getUser = $this->db->get_where('user_master',array('id'=>$rechargeData['user_master_id']))->row_array();
                        

     $mobile   = urlencode($getUser['phone_no']);
     $message  = urlencode("Dear customer, You have Failed recharge of Rs. ".$rechargeData['recharge_amt']." in number ".$rechargeData['dth_mobile_number'].".\r\nThanks\r\nMrNMrs Ekart");
     $this->SendUserSMS($mobile,$message);

        return 3;
          }
          else if($RechargeStatus =='Success'){
             $changeStatus['status'] = '2' ;
             $this->db->where('transaction_id',$data);
             $this->db->update('recharge_master',$changeStatus);

        $rechargeData = $this->db->get_where('recharge_master',array('transaction_id'=>$data))->row_array();
              $field = array(); 
              $field['remark'] = "You have successfully recharged of Rs. ".$rechargeData['recharge_amt']." in number ".$rechargeData['dth_mobile_number'].".";             
              $this->db->where('txn_id',$data);
              $this->db->update('transaction_history',$field);                   

        $getUser = $this->db->get_where('user_master',array('id'=>$rechargeData['user_master_id']))->row_array();
                        

        $mobile   = urlencode($getUser['phone_no']);
        $message  = urlencode("Dear customer, You have successfully recharge of Rs. ".$rechargeData['recharge_amt']." in number ".$rechargeData['dth_mobile_number'].".\r\nThanks\r\nMrNMrs Ekart");
        $this->SendUserSMS($mobile,$message);


             return 2;              
          }
          else if($RechargeStatus =='Refund'){
              $changeStatus['status'] = '4' ;
             $this->db->where('transaction_id',$data);
             $this->db->update('recharge_master',$changeStatus);
            return 4;              
          }
          else if($RechargeStatus =='Pending')
           {

              $changeStatus['status'] = '1' ;
             $this->db->where('transaction_id',$data);
             $this->db->update('recharge_master',$changeStatus);

    $rechargeData = $this->db->get_where('recharge_master',array('transaction_id'=>$data))->row_array();
          $field = array(); 
          $field['remark'] = "You have Pending recharged of Rs. ".$rechargeData['recharge_amt']." in number ".$rechargeData['dth_mobile_number'].".";             
          $this->db->where('txn_id',$data);
          $this->db->update('transaction_history',$field); 


            return 1;
           }

           else if($RechargeStatus == '0') {
              return 0;
            }else{
              return '';
            }
     }
      public function RechargeInfo($data)
    {
      $query = $this->db->query("SELECT * FROM `recharge_master` WHERE `transaction_id` = '".$data."'  ")->row_array();
       $array = array();
      $array['transaction_id']               = $query['transaction_id'];
      $array['user_master_id']               = $query['user_master_id'];
      $array['recharge_type']                = $query['recharge_type'];
     
      $array['recharge_amt']                 = $query['recharge_amt'];
      $array['dth_mobile_number']            = $query['dth_mobile_number'];
      $array['service_provider']             = $query['service_provider'];
      $array['circle_code']                  = $query['circle_code'];
      $array['status']                       = $query['status']; 
      $array['add_date']                     = $query['add_date']; 

      return $array;
    }
     public function DTHRecharge($data)
  {
  /* print_r($data); exit;*/
      $array = array();
      $time = time();
       $TransID = "Txn_ID_".$time;
      $array['transaction_id']               = $TransID;
      $array['user_master_id']              = $data['uuid'];
      $array['recharge_type']               = $data['recharge_type'];
     /* $array['prepaid_postpaid_type']     = $data['prepaid_postpaid_type'];*/
      $array['recharge_amt']                = $data['recharge_amt'];
      $array['dth_mobile_number']           = $data['dth_mobile_number'];
      $array['service_provider']            = $data['service_provider'];
      $array['circle_code']                 = $data['circle_code'];
      $array['add_date']                    = time(); 
      $array['modify_date']                 = time(); 

      $row = $this->db->insert('recharge_master',$array);
      $last_insert_id = $this->db->insert_id(); 
      /*echo $last_insert_id; exit;*/
      if($row > 0)
        {
           
          $rechargeUrl ="https://cyrusrecharge.in/api/recharge.aspx?memberid=AP212190&pin=50E3F2846E&number=".$data['dth_mobile_number']."&operator=".$data['service_provider']."&circle=".$data['circle_code']."&amount=".$data['recharge_amt']."&usertx=".$TransID."&format=json";

          $json = @file_get_contents($rechargeUrl);
          $data = json_decode($json);
          $RechargeStatus['status'] = $data->Status;
          $RechargeStatus['txn_id'] = $TransID;
         
         return $RechargeStatus;
        } else{

          return 0;

        }


  }
 public function insertonlinePayment($data)
   {
      
      $SQL= "SELECT * FROM `user_master` where id ='".$data['userId']."'";
      $query= $this->db->query($SQL)->row_array();
      $array = array();
      $time = time();
      $TransID = $data['tid'];
      $array['transaction_id']               = $TransID;
      $array['user_master_id']               = $data['userId'];
      $array['recharge_type']                = $data['recharge_type'];
      $array['recharge_amt']                 = $data['recharge_amt'];
      $array['dth_mobile_number']            = $data['dth_mobile_number'];
      $array['service_provider']             = $data['service_provider'];
      $array['circle_code']                  = $data['circle_code'];
      /*$array['wallet_used']                  = $data['wallet'];*/
      $array['add_date']                     = time(); 
      $array['modify_date']                  = time(); 

      $row = $this->db->insert('recharge_master',$array);
      $last_insert_id = $this->db->insert_id();
      
      //$this->db->query($sql);
             ############# Transction history ################################

        $amount=$data['recharge_amt'];
              $transaction_history= array();
              $transaction_history['type']                  = '2';
              $transaction_history['txn_id']                = $TransID;
              $transaction_history['amount']                = $data['recharge_amt'];
              $transaction_history['user_master_id']        = $data['userId'];
              $transaction_history['wallet_used']           = 0;
              $transaction_history['debit_credit']          = 1;
              $transaction_history['wallet_used_amount']    = ($data['recharge_amt']) ;
              $transaction_history['payment_used']          = 1;
              $transaction_history['payment_amount']        = abs($amount);
              $transaction_history['payment_status']        = 1; 
               $transaction_history['status']        = 1; 
              $transaction_history['add_date']              = time(); 
              $transaction_history['tracking_id']           = $data['tracking_id'];
              $wallet_amount = $this->GetWalletDetail($data['userId']);
              $this->db->insert('transaction_history',$transaction_history);
            ############# Transction history ################################

            ############# Wallet Master Record ###########################     


              $this->db->insert('wallet_master', array('order_recharge_id' => $last_insert_id,'user_master_id' => $data['uuid'],'debit_credit' => '1','amount' => $transaction_history['wallet_used_amount'],'status' => '1','add_date' => $time, 'modify_date' => $time, 'reason' => '1'));
              ############# Wallet Master Record ###########################
                   
                     


              return array('txn_id'=>$TransID,'payment_req'=>'1', 'status'=>'1', 'payment_status'=>'1','wallet_amount'=>$wallet_amount,'amount'=>abs($amount));

        

        
       

      
   }
 

}


?>