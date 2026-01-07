<?php
class DeleveryBoyModel extends CI_Model {
   public function __construct(){
    parent::__construct();
    $this->load->database();
  }

 
   public function orderList_for_membership($request){
  
      $data = $this->OrderListByPagingForMemberShip($request['delivery_boy_id'],$request['offset']);

      $array  = array();
      $arr    = array();

      $login_status    = $this->db->get_where('deliver_boy_master', array('id' => $request['delivery_boy_id']))->row_array();
          foreach ($data as $value) {
            

            $getOrder    = $this->db->get_where('assign_membership_order', array('id' => $value['order_id']))->row_array();

            $getU    = $this->db->get_where('user_membership_plan', array('id' => $value['order_id']))->row_array(); 

            $getUser     = $this->db->get_where('user_master', array('id' => $getU['user_id']))->row_array();
            $getAddress  = $this->db->get_where('user_address_master', array('id' => $getU['user_id']))->row_array();
           $getState    = $this->db->get_where('states', array('id' => $getAddress['state_master_id']))->row_array();
        
           
            $fields['order_id']            = $value['order_id'];
            $fields['order_number']        = $getU['order_number'];
            $fields['payment_type']        = '1';
            $fields['plan_price']          = $getU['plan_price'];
            $fields['customer_address']     = $getAddress['area_streat_address'].', '.$getAddress['locality'].', '.$getAddress['district_city_town'].', '.$getState['name'];
            $fields['customer_name']       = $getUser['username'];
           if($getU['status']=='2'){
            $fields['order_date']          = $getU['modify_date'];

           }else{
            $fields['order_date']          = $value['add_date'];
           }
            $fields['order_type']          = $getU['status'];

             $arr[]                        = $fields;

            }

               $resposne['login_status']        = $login_status['login_status'];
               $resposne['Order List']          = $arr;
               $resposne['result_found']        = count($data);
               $resposne['offset']              = count($data)+$request['offset'];

         if (count($resposne['Order List']) > 0) {

             generateServerResponse('1','S',$resposne);

          }else{
          generateServerResponse('0', 'E');
       }
     }     

public function OrderListByPagingForMemberShip($userId,$offset)
  {
  $offset    = (!empty($offset) ? $offset : 0);
  $limit     = 20;
    $statement = "SELECT * FROM `assign_membership_order` where  status='1' and `deliverBoyId` ='".$userId."'  order by id desc LIMIT ".$offset." ,".$limit."";   
    return  $this->db->query($statement)->result_array();     
  }
     
public function memberorderDetail($request){
      
      $getOrder    = $this->db->get_where('user_membership_plan', array('id' => $request['order_id']))->row_array();
      $get= $this->db->get_where('assign_membership_order', array('order_id' => $request['order_id']))->row_array();
      $sta= $this->db->get_where('deliver_boy_master', array('id' => $get['deliverBoyId']))->row_array();
      $getUser     = $this->db->get_where('user_master', array('id' => $getOrder['user_id']))->row_array();
      $getAddress  = $this->db->get_where('user_address_master', array('id' => $getOrder['user_id']))->row_array();
      $getState    = $this->db->get_where('states', array('id' => $getAddress['state_master_id']))->row_array();
      
            $fields['order_id']            = $request['order_id'];
            $fields['order_number']        = $getOrder['order_number'];
            $fields['payment_type']        = '1';
            $fields['plan_price']          = $getOrder['plan_price'];
            $fields['wallet_amount']       = $getOrder['wallet_amount'];
            $fields['description']         = $getOrder['description'];
            $fields['customer_address']     = $getAddress['area_streat_address'].', '.$getAddress['locality'].', '.$getAddress['district_city_town'].', '.$getState['name'];
            $fields['customer_name']       = $getUser['username'];
            $fields['phone_no']            = $getUser['phone_no'];
            $fields['signature']           = ($getOrder['signature'] != '') ? 'https://mrnmrsekart.com/assets/sign/'.$getOrder['signature'] : '';
            $fields['order_date']          = $getOrder['add_date'];
            $fields['order_type']          = $getOrder['deliver_status'];

            $resposne['login_status']    = $sta['login_status'];
            $resposne['Order Detail']    = $fields;
      if($getOrder > 0){
             generateServerResponse('1','S',$resposne);
        }else{
          generateServerResponse('0', 'E');
       }
     }




public function SubmitSingleProduct($request){
       $ifProductExist = $this->db->get_where('purchase_master', array('order_master_id' => $request['order_id'],'product_master_id'=>$request['product_id']))->row_array();
       if($ifProductExist > 0){

          $param                           = array();
          $param['reject_status']          = '1';
          $this->db->where('id',$ifProductExist['id']);
          $this->db->update('purchase_master',$param);

          generateServerResponse('1', '214');

       }else{
          generateServerResponse('0', 'W');
       }
     }

 public function AddUsersData($request){

    $arrayName = array();
  
    $arrayName['name']       = $request['name'];
    $arrayName['mobile']       = $request['mobile'];
    $arrayName['address']       = $request['address'];
    $arrayName['add_date']       = time();

   return $this->db->insert('deliver_boy_master',$arrayName);

  }

public function F($base64){
        $img       = imagecreatefromstring(base64_decode($base64));
       if($img != false){ 
          $imageName = time().'.jpg';
         $path      = $_SERVER['DOCUMENT_ROOT'].'/assets/signature/'.$imageName;
          if(imagejpeg($img,$path)) 
              return $imageName;
          else
              return '';
      }
    }


 public function saveProfilesImage($base64){
        $img       = imagecreatefromstring(base64_decode($base64));
       if($img != false){ 
          $imageName = time().'.jpg';
         $path      = $_SERVER['DOCUMENT_ROOT'].'/assets/signature/'.$imageName;
        
          if(imagejpeg($img,$path)) 
              return $imageName;
          else
              return '';
      }
    }

public function saveProfilesImage1($base64){
        $img       = imagecreatefromstring(base64_decode($base64));
       if($img != false){ 
          $imageName = time().'.jpg';
          $path      = $_SERVER['DOCUMENT_ROOT'].'/assets/sign/'.$imageName;
          if(imagejpeg($img,$path)) 
              return $imageName;
          else
              return '';
      }
    }  



public function insert_delivery_transaction($request){
    
          $field['login_status']      =      '1';
          $field['delivery_boy_id']   =      $request['delivery_boy_id'];
          $field['total_amount']      =      $request['total_amount'];
          $field['one']               =      $request['one'];
          $field['two']               =      $request['two'];
          $field['five']              =      $request['five'];
          $field['ten']               =      $request['ten'];
          $field['twenty']            =      $request['twenty'];
          $field['fifty']             =      $request['fifty'];
          $field['hundred']           =      $request['hundred'];
          $field['two_hundred']       =      $request['two_hundred'];
          $field['five_hundred']      =      $request['five_hundred'];
          $field['two_thousand']      =      $request['two_thousand'];
          $field['add_date']          =      time();
      
         $res =  $this->db->insert('delivery_boy_transaction',$field);
      if ($res > 0) {

          generateServerResponse('1', 'S',$field);
       }
       else{
          generateServerResponse('0', 'W');
       }
     }





 public function getUserList()
  {
    return $this->db->query("SELECT * FROM deliver_boy_master order by id desc")->result_array();
  }
 public function getActiveBoy()
  {
   return $this->db->query("SELECT * FROM deliver_boy_master where status='1' order by id desc")->result_array();
   //echo $this->db->last_query();exit;
  }

  public function getSingleUsersData($id)
    {
     
      $query = 'SELECT Um.`id` AS User_id, Um.`username`, Um.`gender`, Um.`email_id`, Um.`user_type_login`,Um.`phone_no`, Um.`verfiy_otp`,Um.`profile_pic`, Um.`dob` From `user_master` AS Um  Left Join `user_address_master` As Uam on Um.`id` = Uam.`user_master_id` WHERE Um.`id` = "'.$id.'"';
      return $this->db->query(  $query)->row_array();
    }


  public function UpdateUsersData($request){

    $arrayName = array();
  
    $arrayName['username']       = $request['UserName'];
    $arrayName['email_id']       = $request['UsersEmail'];
    $arrayName['dob']            = strtotime($request['Dob']);
    $arrayName['phone_no']       = $request['UsersCntct'];
    $arrayName['gender']         = $request['gender'];

    if (!empty($request['profile_pic'])) {
      $arrayName['profile_pic']    = $request['profile_pic'];
    }
      
     $arrayName['modify_date'] = time();

    $this->db->where('id',$request['id']);
    $this->db->update('user_master',$arrayName);

    return $this->db->affected_rows();
  }
  public function GetUserAddress($id ='')
  {

    return $this->db->query('SELECT * FROM `user_address_master`  where `user_master_id` = "'.$id.'" order by id desc ')->result_array();
  }
  public function getSingleData($id ='',$table='',$field ='')
  {
    $query =  $this->db->query('SELECT * FROM `'.$table.'`  where `id` = '.$id.' ')->row_array();
    return $query[$field];
  }



//  delivery api model
  public function isNumberExist($phone_number)
    {
    return $this->db->get_where('deliver_boy_master', array('mobile' => $phone_number))->num_rows();
    }

  public function loginBoy($phone_number)
    {

      $otp = rand('9999','1000');
      $array        = array();
      $array['otp'] = $otp;

      $mobile = urlencode($phone_number['phone_number']);
      $message = urlencode('Your Otp is: '.$otp);
      $this->SendUserSMS($mobile,$message);

      $this->db->where('mobile',$mobile);
      $this->db->update('deliver_boy_master',$array);
       $this->db->query("update deliver_boy_master set login_status='1' where mobile=".$phone_number['phone_number']."");
      return 1;

    }
  public function verifyOtp($phone_number)
    {

  
       $ifPinExist = $this->db->get_where('deliver_boy_master', array('mobile' => $phone_number['phone_number'],'otp'=>$phone_number['otp']))->num_rows();
       if($ifPinExist > 0){
          $getData = $this->db->get_where('deliver_boy_master', array('mobile' => $phone_number['phone_number']))->row_array();

          $param               = array();
          $param['user_id']    = $getData['id'];
          $param['logintime']  = time();
          $param['device_id']  = $phone_number['device_id'];
        
          $this->db->insert('delivery_boy_manager',$param);
          $array['id']                  = $getData['id'];
          $array['login_status']        = $getData['login_status'];
          $array['name']                = $getData['name'];
          $array['mobile']              = $getData['mobile'];
          $array['alternate_mobile']    = $getData['alternate_mobile'];
          $array['dob']                 = $getData['dob'];
          $array['gender']              = $getData['gender'];
          $array['email']               = $getData['email'];
          $array['address']             = $getData['address'];
          $array['add_date']            = $getData['add_date'];
         if(!empty($getData['profile_pic'])){
          $array['profile_pic']         = base_url().'assets/banner_images/boy/'.$getData['profile_pic'];
          }else{
          $array['profile_pic']         = base_url().'assets/banner_images/boy/'.'imgpsh_fullsize.png';
         }


          generateServerResponse('1', '210',$array);
       }else{
          generateServerResponse('0', '130');
       }


    }

  public function logout($request)
    {

       $this->db->order_by('id','desc');
       $ifUserExist = $this->db->get_where('delivery_boy_manager', array('user_id' => $request['user_id'],'device_id'=>$request['device_id'],'status'=>'1'))->num_rows();
       if($ifUserExist > 0){

          $getData = $this->db->get_where('delivery_boy_manager', array('user_id' => $request['user_id'],'device_id'=>$request['device_id'],'status'=>'1'))->row_array();
         
          $param                   = array();
          $param['status']         = '2';
          $param['logintime']      = time();

          $this->db->where('id',$getData['id']);
          $this->db->update('delivery_boy_manager',$param);

          generateServerResponse('1', '211');

       }else{
          generateServerResponse('0', 'W');
       }
     }

  public function orderList($request)
    {

      $data = $this->OrderListByPaging($request['user_id'],$request['offset']);
      $array  = array();
      $arr    = array();

      $login_status    = $this->db->get_where('deliver_boy_master', array('id' => $request['user_id']))->row_array();
          foreach ($data as $value) {
            $getOrder    = $this->db->get_where('order_master', array('id' => $value['order_id']))->row_array();
            $getUser     = $this->db->get_where('user_master', array('id' => $getOrder['user_master_id']))->row_array();
            $getAddress  = $this->db->get_where('user_address_master', array('id' => $getOrder['address_master_id']))->row_array();
            $getState    = $this->db->get_where('states', array('id' => $getAddress['state_master_id']))->row_array();
           $getSetting  = $this->db->get_where('settings', array('id' => '1'))->row_array();
           
            $fields['id']                  = $value['id'];
            $fields['order_id']            = $value['order_id'];
            $fields['order_number']        = $getOrder['order_number'];
            $set_amount                    = $getSetting['min_order_bal'];
            if($set_amount > $getOrder['final_price']){
              $fields['order_amount']     = $getOrder['final_price']+$getSetting['shipping_amount'];
            }else{
               $fields['order_amount']        = $getOrder['final_price'];
            }
            

            $fields['customer_name']       = $getUser['username'];

            $fields['payment_type']        = $getOrder['payment_type'];
            $fields['customer_address']    = $getAddress['area_streat_address'].', '.$getAddress['locality'].', '.$getAddress['district_city_town'].', '.$getState['name'];
            $fields['customer_phone']      = $getAddress['phone_no'];
            $fields['order_date']          = $value['add_date'];
             $arr[]                        = $fields;
            }
           
           
               $resposne['login_status']        = $login_status['login_status'];
               $resposne['Order List']          = $arr;
               $resposne['result_found']        = count($data);
               $resposne['offset']              = count($data)+$request['offset'];

         if (count($resposne['Order List']) > 0) {

             generateServerResponse('1','S',$resposne);

          }else{
          generateServerResponse('0', 'E');
       }
     }     

  public function orderDetail($request)
    {

      $getallProduct    = $this->db->get_where('purchase_master', array('order_master_id' => $request['order_id']))->result_array();

      $getOrder    = $this->db->get_where('order_master', array('id' => $request['order_id']))->row_array();
      $getSetting  = $this->db->get_where('settings', array('id' => '1'))->row_array();
      $get= $this->db->get_where('assign_order', array('order_id' => $request['order_id']))->row_array();
      $sta= $this->db->get_where('deliver_boy_master', array('id' => $get['deliverBoyId']))->row_array();
      $getUser     = $this->db->get_where('user_master', array('id' => $getOrder['user_master_id']))->row_array();
      $getAddress  = $this->db->get_where('user_address_master', array('id' => $getOrder['address_master_id']))->row_array();
      $getState    = $this->db->get_where('states', array('id' => $getAddress['state_master_id']))->row_array();
      
        $fields                        = array();
        $fields['order_number']        = $getOrder['order_number'];
        $fields['final_price']         = $getOrder['final_price'];
         $set_amount                   = $getSetting['min_order_bal'];
        if($set_amount > $getOrder['final_price']){
          $fields['shipping_amount']     = $getSetting['shipping_amount'];
        }else{
           $fields['shipping_amount']     ='0';
        }

        $fields['final_price']         = $getOrder['final_price'];
        $fields['customer_name']       = $getUser['username'];
$fields['signature']           = ($getOrder['signature'] != '') ? base_url().'assets/signature/'.$getOrder['signature'] : '';
        $fields['payment_type']        = $getOrder['payment_type'];
        $fields['customer_address']    = $getAddress['area_streat_address'].', '.$getAddress['locality'].', '.$getAddress['district_city_town'].', '.$getState['name'];
        $fields['customer_phone']      = $getAddress['phone_no'];
          $hold           =  array();
              foreach ($getallProduct as $key => $value) {
           $getProduct    = $this->db->get_where('product_master', array('id' => $value['product_master_id']))->row_array();
           $ProductRf    = $this->db->get_where('product_master', array('id' => $getProduct['reference']))->row_array();
           $getimage    = $this->db->get_where('product_images_master', array('product_master_id' => $value['product_master_id']))->row_array();
           $Refmage    = $this->db->get_where('product_images_master', array('product_master_id' => $getProduct['reference']))->row_array();
        $getUnit       = $this->db->get_where('unit_master', array('id' => $getProduct['unit']))->row_array();
      
              $param['id']         =  $value['product_master_id'];
        if($getProduct['product_name']==''){
        $param['name']       =  $ProductRf['product_name']; 
        }else{
                $param['name']       =  $getProduct['product_name'];  
           
        }
              $param['quantity']   =  $value['quantity'];
              $param['weight']     =  $getProduct['weight_litr']." ".$getUnit['unit_name'];
              $param['price']      =  $value['final_price'];
         if($getimage['product_image']==''){
         $param['image']      =  base_url().'assets/product_images/'.$Refmage['product_image'];   
        }else{
                $param['image']      =  base_url().'assets/product_images/'.$getimage['product_image'];
        }
             
              $param['status']     =  $value['status'];


              $hold[] = $param;
         }

           
               $fields['Product Detail']    = $hold;
               $resposne['login_status']    = $sta['login_status'];
               $resposne['Order Detail']    = $fields;
      if($getOrder > 0){
             generateServerResponse('1','S',$resposne);
        }else{
          generateServerResponse('0', 'E');
       }
     }

  public function OrderListByPaging($userId,$offset)
  {
  $offset    = (!empty($offset) ? $offset : 0);
  $limit     = 20;
    $statement = "SELECT * FROM `assign_order` where  status='1' and `deliverBoyId` ='".$userId."'  order by id desc LIMIT ".$offset." ,".$limit."";   
    return  $this->db->query($statement)->result_array();     
  }




  public function cancelSingleProduct($request)
    {

       $ifProductExist = $this->db->get_where('purchase_master', array('order_master_id' => $request['order_id'],'product_master_id'=>$request['product_id']))->row_array();
       if($ifProductExist > 0){

          $param                   = array();
          $param['reason_id']      = $request['reason_id'];
          $param['status']         = '2';
          $param['modify_date']    = time();

          $this->db->where('id',$ifProductExist['id']);
          $this->db->update('purchase_master',$param);

         $getOrder = $this->db->get_where('order_master', array('id' => $request['order_id']))->row_array();
      
          $oldAmt = $getOrder['final_price'] - $ifProductExist['final_price'] * $ifProductExist['quantity'];
          $sql =$this->db->query("SELECT * FROM `settings` where id ='1'")->row_array();

          $field                   = array();

         if($oldAmt < $sql['min_order_bal'])
          {
          $field['shippment_charge'] = $sql['shipping_amount'] ;         
          }
          $field['final_price']    = $oldAmt;
          $field['modify_date']    = time();

          $this->db->where('id',$request['order_id']);
          $this->db->update('order_master',$field);

          generateServerResponse('1', '212');

       }else{
          generateServerResponse('0', 'W');
       }
     }

 public function signatureMembershipOrder($request){
   $getValue  = $this->db->get_where('user_membership_plan',array('id'=>$request['signature']))->row_array();


       $signature = $this->saveProfilesImage1($request['signature']);


          $param                   = array();
          $param['signature']      = ($signature != '') ? $signature : '';
          $param['status']         = '2';
          $param['modify_date']    = time();

           $field                  =  array();

          $this->db->where('id',$request['order_id']);
         $res = $this->db->update('user_membership_plan',$param);
      if ($res > 0) {

          generateServerResponse('1', '213');
       }
       else{
          generateServerResponse('0', 'W');
       }
     }



 public function signatureOrder($request)
    {

       $signature = $this->saveProfilesImage($request['signature']);


          $param                   = array();
          $param['signature']      = ($signature != '') ? $signature : '';
          $param['status']         = '3';
          $param['modify_date']    = time();

          $this->db->where('id',$request['order_id']);
         $res = $this->db->update('order_master',$param);

          $field                   = array();
          $field['status']         = '5';
          $field['modify_date']    = time();

          $this->db->where('status!=',2);
          $this->db->where('order_master_id',$request['order_id']);
          $res =  $this->db->update('purchase_master',$field);
          $this->db->query("update assign_order set status='2' where order_id=".$request['order_id']."");

      if ($res > 0) {

          generateServerResponse('1', '213');
       }
       else{
          generateServerResponse('0', 'W');
       }
     }


  public function getDeliveredLiist($request)
    {

      $data = $this->DeliverdOrderListByPaging($request['user_id'],$request['offset']);

      $array  = array();
      $arr    = array();
      $getstatus = $this->db->get_where('deliver_boy_master', array('id' => $request['user_id']))->row_array();
          foreach ($data as $value) {
            $getOrder    = $this->db->get_where('order_master', array('id' => $value['order_id']))->row_array();
            $getUser     = $this->db->get_where('user_master', array('id' => $getOrder['user_master_id']))->row_array();
            $getAddress  = $this->db->get_where('user_address_master', array('id' => $getOrder['address_master_id']))->row_array();
            $getState    = $this->db->get_where('states', array('id' => $getAddress['state_master_id']))->row_array();
            $sett  = $this->db->get_where('settings', array('id' =>'1'))->row_array();
            $fields['id']                  = $value['id'];
            $fields['order_id']            = $value['order_id'];
            $fields['order_number']        = $getOrder['order_number'];
            $fields['signature']           = base_url().'assets/signature/'.$getOrder['signature'];
           if($sett['min_order_bal'] > $getOrder['final_price']){
            $fields['order_amount']        = $getOrder['final_price']+$sett['shipping_amount'].'.00'; 
            }else{
            $fields['order_amount']        = $getOrder['final_price']; 
            }
            $fields['customer_name']       = $getUser['username'];

            $fields['payment_type']        = $getOrder['payment_type'];
            $fields['customer_address']    = $getAddress['area_streat_address'].', '.$getAddress['locality'].', '.$getAddress['district_city_town'].', '.$getState['name'];
            $fields['customer_phone']      = $getAddress['phone_no'];
            $fields['order_date']          = $getOrder['add_date'];
             $arr[]                        = $fields;
            }
           
               $resposne['login_status']  = $getstatus['login_status'];;
               $resposne['Order List']    = $arr;
               $resposne['result_found']  = count($data);
               $resposne['offset']        = count($data)+$request['offset'];

         if (count($resposne['Order List']) > 0) {

             generateServerResponse('1','S',$resposne);

          }else{
          generateServerResponse('0', 'E');
       }
     } 

 public function DeliverdOrderListByPaging($userId,$offset)
  {

  $offset    = (!empty($offset) ? $offset : 0);
  $limit     = 20;
  return $this->db->query("select am.`id`,am.`order_id` from assign_order as am left join order_master as om on am.`order_id` = om.`id` where am.deliverBoyId=".$userId." and  om.`status`='3' ORDER BY om.`id` DESC LIMIT ".$offset.", ".$limit."")->result_array();
   // echo $this->db->last_query();exit;     
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
