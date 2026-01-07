<?php
class Notification_model extends CI_Model {
	 public function __construct(){
		parent::__construct();
		$this->load->database();
	}

    public function GetAllNotification()
   {
      return $this->db->query("SELECT * FROM `push_messge` order by id desc")->result_array();
   }

  public function GetSingleNotification($id)
   {
      return $this->db->query("SELECT * FROM `push_messge`  where  id = '".$id."'")->row_array();
   }
  
  public function pushNotificationSend($request){
      $loginData  =  $this->db->query("SELECT DISTINCT fcm_id FROM `user_fcm_ids` where fcm_id!='' order by id desc limit 10")->result_array();
      // echo '<pre>';
      // print_r($loginData); die();

      $arrayName2 =array();
      $arrayName2['type']        =  '1';
      $arrayName2['push_msg']    =  $request['message'];
      $arrayName2['image']       =  ($request['image']!='') ? $request['image'] :'';

      $arrayName2['title']       =  $request['title'];
      $arrayName2['add_date']    =  time();
      /* echo base_url('assets/notification_images').'/'.$arrayName2['image']; exit;*/
      $this->db->insert('push_messge',$arrayName2);
      $last_inserted = $this->db->insert_id();
      $array_push = array();

    foreach ($loginData as $value){
      //$this->sendPushNotification_new($value['fcm_id'],$request['title'],$request['message'], $arrayName2['image']);
      //  $this->sendPushNotification($value['fcm_id'],$last_inserted);
      array_push($array_push,$value['fcm_id']);
      }
      $this->sendPushNotification($array_push,$last_inserted);
      
    return 1;
  }
    public function pushNotificationAndSms($request){
	   if($request['user_limit']=='1'){
         $loginData =  $this->db->query("SELECT * FROM user_fcm_ids LIMIT 1,100")->result_array();  
	  }else if($request['user_limit']=='2'){
		  $loginData =  $this->db->query("SELECT * FROM user_fcm_ids LIMIT 101,100")->result_array();
	  }else if($request['user_limit']=='3'){
		 $loginData =  $this->db->query("SELECT * FROM user_fcm_ids LIMIT 201,100")->result_array();
	  }else if($request['user_limit']=='4'){
		  $loginData =  $this->db->query("SELECT * FROM user_fcm_ids LIMIT 301,100")->result_array();
      }else {	
	   $loginData =  $this->db->query("SELECT * FROM user_fcm_ids LIMIT 401,100")->result_array();
	 }	  
		 
      $arrayName2 =array();
      $arrayName2['type']        =  '1';
      $arrayName2['push_msg']    =  $request['message2'];
      $arrayName2['image']       =  ($request['image']!='') ? $request['image'] :'';
      $arrayName2['title']       =  $request['title1'];
      $arrayName2['add_date']    =  time();
      /* echo base_url('assets/notification_images').'/'.$arrayName2['image']; exit;*/
      $this->db->insert('push_messge',$arrayName2);
       $last_inserted = $this->db->insert_id();
        //echo $last_inserted; exit;
    foreach ($loginData as $value){
      //$this->sendPushNotification_new($value['fcm_id'],$request['title'],$request['message'], $arrayName2['image']);
      $this->sendPushNotification($value['fcm_id'],$last_inserted);
      }
      
    return 1;
  }
  
  
  public function pushSmsWithNotification($request){
	  
         
  if($request['user_limit']=='1'){
         $loginData =  $this->db->query("SELECT * FROM user_master LIMIT 1,100")->result_array();  
	  }else if($request['user_limit']=='2'){
		  $loginData =  $this->db->query("SELECT * FROM user_master LIMIT 101,100")->result_array();
	  }else if($request['user_limit']=='3'){
		 $loginData =  $this->db->query("SELECT * FROM user_master LIMIT 201,100")->result_array();
	  }else if($request['user_limit']=='4'){
		  $loginData =  $this->db->query("SELECT * FROM user_master LIMIT 301,100")->result_array();
      }else {	
	   $loginData =  $this->db->query("SELECT * FROM user_master LIMIT 401,100")->result_array();
	 }
	 
      $arrayName2 =array();
      $arrayName2['type']        =  '1';
      $arrayName2['push_msg']    =  $request['message2'];
      $arrayName2['add_date']    =  time();
      /* echo base_url('assets/notification_images').'/'.$arrayName2['image']; exit;*/
      $this->db->insert('push_messge',$arrayName2);
        //echo $last_inserted; exit;
    foreach ($loginData as $value){
      //$this->sendPushNotification_new($value['fcm_id'],$request['title'],$request['message'], $arrayName2['image']);
      $this->SendSMS($request['message2'],$value['phone_no']);
      }
      
    return 1;
  }
  
  public function pushSmsSend($request){
      $loginData =  $this->db->query("SELECT * FROM user_master where status='1'")->result_array();
      $arrayName2 =array();
      $arrayName2['type']        =  '1';
      $arrayName2['push_msg']    =  $request['message1'];
      $arrayName2['add_date']    =  time();
      /* echo base_url('assets/notification_images').'/'.$arrayName2['image']; exit;*/
      $this->db->insert('push_messge',$arrayName2);
        //echo $last_inserted; exit;
    foreach ($loginData as $value){
      //$this->sendPushNotification_new($value['fcm_id'],$request['title'],$request['message'], $arrayName2['image']);
      $this->SendSMS($request['message1'],$value['phone_no']);
      }
      
    return 1;
  }
  
  
 public function SendSMS($message,$mobile){
        $message = urlencode("Dear customer, ".$message."\r\nThanks\r\n".PROJECT_tit); 
        $mobile = urlencode($mobile); 
        $url = "http://bulksms.megainfomatix.com/http-api.php?username=lalitmohan&password=123456&senderid=MRNMRS&route=2&number=".$mobile."&message=".$message."";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);  
    }



   public function sendPushNotification($fcm_id,$last_inserted){
      $registrationIds = $fcm_id;

      $pushDetail = $this->db->query("SELECT * FROM `push_messge` where id='".$last_inserted."' ")->row_array();
      $img =($pushDetail['image']!='') ?base_url('assets/notification_images').'/'. $pushDetail['image']:'';
       #prep the bundle
        
        $msg2 = array
              (
                
                'id'         => $pushDetail['id'],
                'message'    => $pushDetail['push_msg'],
                'title'      => $pushDetail['title'],
                'type'       => $pushDetail['type'],
                'largeIcon'  => $img,/*Default Icon*/
                
                'add_date'   => $pushDetail['add_date']
                        
              );
         $msg = array
              (
                //'to'         => $registrationIds,
                'body'       => $msg2,
/*
                'title'      => $pushDetail['title'],
                'type'       => $pushDetail['type'],
                'largeIcon'  => $img,/*Default Icon*/
                
               /* 'add_date'   => $pushDetail['add_date']
                        */
              );

      $fields = array
          (
            'to'    => $registrationIds,
            'data'  => $msg2
          );
       /* echo  json_encode( $msg ); exit;*/
      $headers = array
          (
            'Authorization: key='.API_ACCESS_KEY,
            'Content-Type: application/json'
          );


         if(count($fcm_id)>1){

            foreach ($fcm_id as $key => $fcmid) {
                     $fields = array(
                        'to'    => $fcmid,
                        'data'  => $msg2
                      );

                     $ch = curl_init();
                      curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
                      curl_setopt( $ch,CURLOPT_POST, true );
                      curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                      curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                      curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                      curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields) );
                      $result = curl_exec($ch );
                      curl_close( $ch );
             }

         }else{
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields) );
            $result = curl_exec($ch );
            curl_close( $ch );
         }

          #Send Reponse To FireBase Server  
            
        #Echo Result Of FireBase Server
            //echo $result;
             /*print_r($msg2);*/
            /*echo  $result; */
          return $result;
  }


################################# FOR Example ######################################

   public function sendPushNotificationExample($msg, $ids, $service_id='') {
    // Insert real GCM API key from the Google APIs Console
    // https://code.google.com/apis/console/        
    //$apiKey = 'AAAAiFUVv-g:APA91bEnFi0bMj6Pwi_5mP-jhKKFoE2vaFEpQIb6warwbpFa0Y4d_HjIgVzS9YPmrHUROxsD06wvBDXIC_e_5tBduzkwhL70LrppzC-s_YjtN53za5rMmFtj1ht6dMV3BZZaydcHVav2';
    
    
   
       $apiKey = GOOGLE_FIREBASE_SERVER_KEY_13; #Haji
   
     



    $message = array('body' => $msg,
            'sound' => 'default',
            'priority' => 'high',
            'icon' => 'myicon',
            'color' => 'red'
            );
    // Set POST request body
    $post = array(
                    'registration_ids'  => $ids,
                    'notification'      => $message,
                 );

    // Set CURL request headers 
    $headers = array( 
                        'Authorization: key=' .$apiKey,
                        'Content-Type: application/json'
                    );

    // Initialize curl handle       
    $ch = curl_init();

    // Set URL to GCM push endpoint     
    curl_setopt($ch, CURLOPT_URL, 'https://gcm-http.googleapis.com/gcm/send');

    // Set request method to POST       
    curl_setopt($ch, CURLOPT_POST, true);

    // Set custom request headers       
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Get the response back as string instead of printing it       
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Set JSON post data
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));

    // Actually send the request    
    $result = curl_exec($ch);

    // Handle errors
    //if (curl_errno($ch)) {
       //echo 'GCM error: ' . curl_error($ch);
   // }

    // Close curl handle
    curl_close($ch);

    // Debug GCM response       
    //echo $result;


}
 

 ################################# FOR Example ###################################### 



}

?>