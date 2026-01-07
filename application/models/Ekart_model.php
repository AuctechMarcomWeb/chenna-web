<?php
class Ekart_model extends CI_Model {
   public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function updateOtp($phone_number)
  {   
        $response = array();
        $chars = "0123456789";
            $otp = substr(str_shuffle($chars), 0, 4);
            $reg['otp']        = $otp;
            $reg['uuid']       = $otp.time();
            $this->db->where('phone_no' , $phone_number);
            $this->db->update('user_master', $reg);
           if($this->db->affected_rows() > 0)
           {
             $getVerfiedPhoneOtp = $this->db->get_where('user_master', array('phone_no' => $phone_number))->row_array();
             $response['user_id'] = $getVerfiedPhoneOtp['id'];
            $sendOtp = $this->sendOtp($otp,$phone_number);
            if($sendOtp > 0)
              {
               return 1;
              }
              else{
                return 0;
              }    

           }                                            
  }

  public function insertNewNumber($phone_number,$referal_by)
  {  
    //print_r($phone_number);exit; 
    $response = array();
    $chars = "0123456789";
    $chars2 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
       $referel_id = substr(str_shuffle($chars2), 0, 4).substr(str_shuffle($chars), 0, 2);
        $otp = substr(str_shuffle($chars), 0, 4);
        $reg['otp']        = $otp;
        $reg['uuid']       = $otp.time();
        $reg['referel_id'] = $referel_id;
        $reg['refered_by'] = $referal_by;
        $reg['phone_no']   = $phone_number; 
        $reg['profile_pic']= "default.png";         
        $reg['add_date']   = time();
        $reg['modify_date']= time();
        
        $this->db->insert('user_master',$reg);
        $last_insert_id = $this->db->insert_id();
        
        if($this->db->affected_rows() > 0)
        {           
           $response['user_id'] = $last_insert_id;
           $this->sendOtp($otp,$phone_number);
           return 1;  
           
        }else{

           return 0; 
        } 

  }

  public function sendOtp($otp,$phone_number)
    {

      $smstxt="Dear User, Your OTP is: ".$otp;
$url  = "http://bulksms.megainfomatix.com/http-api.php?username=lalitmohan&password=123456&senderid=MRNMRS&route=2&number=".$phone_number."&message=".urlencode($smstxt);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
        return 1;
    }

  public function isNumberExist($phone_number)
  {
    return $this->db->get_where('user_master', array('phone_no' => $phone_number))->num_rows();
  }
  public function isNumberActive($phone_number)
  {
    return $this->db->get_where('user_master', array('phone_no' => $phone_number,'status' => 1))->num_rows();
  }


public function checkOtpp($data)
  {

    $checkOtpCorrect = $this->db->get_where('user_master', array('phone_no' => $data['mobile'],'otp' => $data['otp']))->row_array();
     if($checkOtpCorrect > 0)
     {
      $reg['verfiy_otp'] = 2;
      $this->db->where('phone_no' , $data['mobile']);
      $this->db->update('user_master', $reg);
      return 1; 
     }else{
      return 0;
     }

  }








 public function checkOtp($data,$ProductVal='')
  {

    $checkOtpCorrect = $this->db->get_where('user_master', array('phone_no' => $data['mobile'],'otp' => $data['otp']))->row_array();
     if($checkOtpCorrect > 0)
     {
      $reg['verfiy_otp'] = 2;
      $this->db->where('phone_no' , $data['mobile']);
      $this->db->update('user_master', $reg);
      return 1; 
     }else{
      return 0;
     }

  }
    public function getUserRecord($phone_number)
    {
      return $this->db->get_where('user_master', array('phone_no' => $phone_number,'status' => 1))->row_array();
    }

    public function getDataById($table,$id)
    {
      return $this->db->get_where($table, array('id' => $id,'status' => 1))->row_array();
    }
    public function getCartDataById($table,$id)
    {
      return $this->db->get_where($table, array('user_master_id' => $id,'status' => 1))->result_array();
    }
    public function inserProductCart($table,$field)
    {
      return $this->db->insert($table,$field);
    }
    public function GetProdImage($prod_id='')
    {
       
        return $this->db->get_where('product_images_master', array('product_master_id'=>$prod_id))->row_array();
        
    }
    public function minCart($table,$field,$cartId)
    {
                 $this->db->where('id',$cartId);
        return $this->db->update($table,$field);
    }
    public function deleteCart($table,$cartId)
    {
                 $this->db->where('id',$cartId);
        return $this->db->delete($table);
    }
   public function isPinActive($Pin)
    {
      return $this->db->get_where('pin_code_master', array('pin_code' => $Pin,'status' => 1))->num_rows();
    }
    public function getImageDataBypId($table,$colname,$id)
    {
       return $this->db->get_where($table, array($colname => $id,'status' => 1))->result_array();
      // echo $this->db->last_query();ex
    }

    public function getPidsingle($table,$colname,$id)
    {
        $this->db->order_by('id','ASC');
       return $this->db->get_where($table, array($colname => $id,'status' => 1,'approving_status'=>1))->row_array();
      // echo $this->db->last_query();ex
    }

    public function getDataByrowArray($table,$colname,$id)
    {
       return $this->db->get_where($table, array($colname => $id,'status' => 1))->row_array();
      // echo $this->db->last_query();ex
    }

    public function GetProductsingleImg($id)
    {
 $this->db->order_by('id','DESC');
       return $this->db->get_where('product_images_master', array('product_master_id' => $id,'status' => 1))->row_array();
      // echo $this->db->last_query();ex
    }



      public function GetProductLatestfive()
      {
         $this->db->order_by('id','desc');
         $this->db->limit('5');
          return $this->db->get_where('product_master', array('status'=>1))->result_array();
          
      }  
     //++++++++++++############ Confirm Order #########++++++++++
      public function buyProduct($data,$userId,$price,$final_price,$shipping_charge,$type,$coupon_id,$address_id){
        $adressId = $this->getDataByrowArray('user_address_master','user_master_id',$userId);
        $time = time();

        if(count($data['products']) > 0)
        {   
              $link         = time()."-invoice.pdf";
              $oderId = "ORD".$time;
              $order_insert=array();
              $order_insert['order_number']=$oderId;
              $order_insert['coupon_code_id']=$coupon_id;
              $order_insert['address_master_id']=$address_id;
              $order_insert['user_master_id']=$userId;
              $order_insert['total_price']=round($price);
              $order_insert['final_price']=round($final_price);
              $order_insert['pdf_link']=base_url().'assets/'.$link;
              $order_insert['payment_type']=$type;
              $order_insert['shippment_charge']=$shipping_charge;
              $order_insert['modify_date']=time();
              $order_insert['add_date']=time();
              $this->db->insert('order_master',$order_insert);
              $lastId = $this->db->insert_id();
             $total_final_price = 0;
            foreach ($data['products'] as $value) {
              

              $productValue = $this->db->get_where('product_master',array('id'=>$value['product_master_id']))->row_array();

/*Get Here Offe*/
           $sub_category_id =  json_encode([$productValue['sub_category_master_id']]);
           $time=time();
           $product_id =  $productValue['id'];   
                    
          $Check_deal_of_day =$this->db->query("select * from product_master where id='$product_id' and deal_of_day_end >=$time and status='1'")->row_array();
                   
           $offer_check = $this->db->query("select * from offer_master where sub_category_ids='$sub_category_id' and end_date >=$time and status='1'")->row_array();

################################################################################################################################### Start  Deal  Of The Day Condition #########################
      if(!empty($Check_deal_of_day)){
         if($Check_deal_of_day['dod_discount_type'] == '1'){ 
            $final_price =  round($Check_deal_of_day['price']-$Check_deal_of_day['dod_amount']); 
          } else {
            $holdprice =  $Check_deal_of_day['dod_amount'] * $Check_deal_of_day['price']/ 100 ; 
            $final_price = round($Check_deal_of_day['price'] - $holdprice);
         }
      }
################################################################################################################################### End Deal Condition ################################################

 ###################################################################################################
 ################################ Check Offer Condition ################################################ 
        else { 
 
          if($offer_check['offerType'] == '1'){ 
                        if($offer_check['deal_type'] == '1'){ 
                             $final_price = round($productValue['price'] - $offer_check['deal_amount']);      
                          } else {
          
                             $holdprice =  $offer_check['deal_amount'] / 100 * $productValue['price'] ; 
                             $final_price = round($productValue['price'] - $holdprice);
                          } 
           } else {
                  if($productValue['product_discount_type'] == '1'){ 
                       $final_price =  round($productValue['final_price']);     
                  } else { 
                     $holdprice =  $productValue['product_discount_amount'] * $productValue['price']/ 100 ; 
                     $final_price = round($productValue['price'] - $holdprice) ;
                 }


            }

       }

 #######################################################################################
 ################################ End Offer Condition ##################################

          



/*Get Here Offe*/



                  $vendor_master_id = singlerowparameter('added_by_id','id',$value['product_master_id'],'product_master'); 
                  $price = singlerowparameter('price','id',$value['product_master_id'],'product_master'); 
                 $val = $this->getDataById('product_master',$value['product_master_id']);

                  $calculatePrice =  $val['final_price'] * $val['quantity']; 
                  $total_final_price = round($total_final_price + $calculatePrice) ; 


                  $sql = "UPDATE product_master SET quantity = quantity - '".$value['quantity']."' WHERE id ='".$value['product_master_id']."' "; 

                   $this->db->query($sql);
                if($this->db->affected_rows() > 0)
                {  
                   $this->db->insert('purchase_master',array('vendor_master_id'=>$vendor_master_id,'order_master_id'=>$lastId,'price'=>$price,'final_price'=>$final_price,'discount_type' => '','discount_applied_in'=>'','discount_amount' => '' ,'product_master_id' => $value['product_master_id'],'quantity' => $value['quantity'],'modify_date' => $time,'add_date' => $time));

                  if($vendor_master_id > 0){

                      /*$productname= singlerowparameter('product_name','id',$value['product_master_id'],'product_master');

                      $getnumber= allData2('admin_master','id',$vendor_master_id);

                      $message = urlencode(" Hello Vendor, Your Product - '".ucwords($productname)."', No. of quantity  - ".$value['quantity']."  has been ordered by the customer and Order no. is ".$oderId.""); 

                      $mobile = urlencode($getnumber['phone_no']); 

                      $url = "http://bulksms.megainfomatix.com/http-api.php?username=lalitmohan&password=123456&senderid=MRNMRS&route=2&number=".$mobile."&message=".$message."";
                      $ch = curl_init();
                      curl_setopt($ch, CURLOPT_URL,$url);
                      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                      curl_exec($ch);*/
                  }
                } else { return 0; } 

             }  

            $sql =$this->db->query("SELECT * FROM `settings` where id ='1'")->row_array();

           if($total_final_price < $sql['min_order_bal']) {
              $total_final_price = $total_final_price +$sql['shipping_amount']; 
              $shippingCharge['shippment_charge'] = $sql['shipping_amount'] ;
              $this->db->where('id',$lastId);
              $this->db->update('order_master',$shippingCharge);
            }

             // Use wallet and deduct money from user_master  maintain history in wallet history   & update the final amount in order_master

           $getUserInfo  = singleRowData('user_master','id',$userId);


      ########Transaction History Without Using Wallet ############
          $transaction_history= array();
          $transaction_history['type']                  = '1';
          $transaction_history['txn_id']                = $oderId;
          $transaction_history['amount']                = $total_final_price;
          $transaction_history['user_master_id']        = $userId;
          $transaction_history['payment_used']          = 1;
          $transaction_history['payment_amount']        = $total_final_price;
          $transaction_history['payment_status']        = '1'; 
          $transaction_history['add_date']              = time();

          $this->db->insert('transaction_history',$transaction_history); 

          ############# Transaction History Without Using Wallet ##############
          $this->db->where('id',$lastId);
          /*$this->db->update('order_master', array('total_price' => $total_final_price,'final_price' => $total_final_price,'wallet_used' => '0'));*/ 

          $this->db->where('id',$lastId);
          /*$this->db->update('order_master', array('total_price' => $data['total_amount'],'final_price' => $data['final_amount'],'wallet_used' => '0','discount'=> $data['discount'])); 
*/
          $this->pdfGenrate($lastId,$link); 



            if($this->db->affected_rows() > 0){ 
              $this->db->where('user_master_id',$userId);
              $this->db->delete('mycart_master');
              return $oderId;              
            } else { return 0;}

       } else { 
        return 0; }
  } 
  
  
 public function SendUserSMS($user_id,$order_id,$final_amount)
    { 
      $productname= singlerowparameter('phone_no','id',$user_id,'user_master');
      $OrderId= allData2('order_master','order_number',$order_id);
       $message = urlencode(" We have recevied your order - ".$OrderId['order_number']." amounting to Rs. ".$final_amount."  You can expect delivery by next 10 working days "); 
        
        $mobile = urlencode($productname); 
        
        $url = "http://bulksms.megainfomatix.com/http-api.php?username=lalitmohan&password=123456&senderid=MRNMRS&route=2&number=".$mobile."&message=".$message."";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
    }

  function pdfGenrate($pakage_master_id,$pdfFilePath){
        error_reporting(0);
        $OrderDetail  = $this->db->order_by('id','desc')->get_where('order_master',array('id'=>$pakage_master_id))->row_array();

        $getProduct = $this->db->get_where('purchase_master', array('order_master_id'=>$pakage_master_id))->result_array();


         $getAddress = $this->db->get_where('user_address_master', array('id'=>$OrderDetail['address_master_id']))->row_array();


         $getShippingVal = $this->db->get_where('settings', array('id'=>'1'))->row_array();

         $Landmark = ($getAddress['landmark_optional']!='') ? $getAddress['landmark_optional']: 'NA';

            $tax_type = 'CGST+SGST';
          
        $link         = time()."-invoice.pdf";
        $html  = '';
        $html .= '<h1 style="text-align:center"><u>Invoice</u></h1>';
        $html .= '<div style="float:left;width:100%; margin-top:20px;"><div style="float:left;width:70%"><div class="image"> <img src="'.base_url('assets/Mr&MrsEkart3.png').'" style="width:70px;margin-left: 5px "> </div><div style="margin-left: 30px; top: -60px" > <b style="font-size:16px">MrNMrs Ekart Retail Trading Pvt. Ltd.</b><br>
                <div style="margin-left: 140px !important;"><span style="font-size:13px;">(GSTIN 09AALCM3634J1Z4)</span></div></div></div><div style="float:left;width:30%;"><div><b style="font-size:15px;"> Order No &nbsp;:</b></b>&nbsp;'.$OrderDetail['order_number'].'</div><br><b style="font-size:15px;">Order Date :</b>&nbsp;'.date('d-m-y H:i:s',$OrderDetail['add_date']).' </div>
         </div></div>';

       $total1=0;
       $total=0;
       $i=1;
       foreach ($getProduct as $key => $value) { 
         // echo $value['product_master_id'];
          $PID=$this->db->get_where('product_master',array('id'=>$value['product_master_id']))->row_array();
          $productValue = $this->db->get_where('product_master',array('id'=>$value['product_master_id']))->row_array();
/*Get Here Offe*/
           $sub_category_id =  json_encode([$productValue['sub_category_master_id']]);
           $time=time();
           $product_id =  $productValue['id'];   
                    
          $Check_deal_of_day =$this->db->query("select * from product_master where id='$product_id' and deal_of_day_end >=$time and status='1'")->row_array();
                   
           $offer_check = $this->db->query("select * from offer_master where sub_category_ids='$sub_category_id' and end_date >=$time and status='1'")->row_array();

################################################################################################################################### Start  Deal  Of The Day Condition #########################
      if(!empty($Check_deal_of_day)){
         if($Check_deal_of_day['dod_discount_type'] == '1'){ 
            $final_price =  round($Check_deal_of_day['price']-$Check_deal_of_day['dod_amount']); 
          } else {
            $holdprice =  $Check_deal_of_day['dod_amount'] * $Check_deal_of_day['price']/ 100 ; 
            $final_price = round($Check_deal_of_day['price'] - $holdprice);
         }
      }
################################################################################################################################### End Deal Condition ################################################

 ###################################################################################################
 ################################ Check Offer Condition ################################################ 
        else { 
 
          if($offer_check['offerType'] == '1'){ 
                        if($offer_check['deal_type'] == '1'){ 
                             $final_price = round($productValue['price'] - $offer_check['deal_amount']);      
                          } else {
          
                             $holdprice =  $offer_check['deal_amount'] / 100 * $productValue['price'] ; 
                             $final_price = round($productValue['price'] - $holdprice);
                          } 
           } else {
                  if($productValue['product_discount_type'] == '1'){ 
                       $final_price =  round($productValue['final_price']);     
                  } else { 
                     $holdprice =  $productValue['product_discount_amount'] * $productValue['price']/ 100 ; 
                     $final_price = round($productValue['price'] - $holdprice) ;
                 }


            }

       }

 #######################################################################################
 ################################ End Offer Condition ##################################

         $catValue=$this->db->get_where('sub_category_master',array('id'=>$PID['sub_category_master_id']))->row_array();  

          $unit_price  = $final_price/$catValue['intergst'];
          $unit_price    = round($unit_price, 2); 
          $total_tax_amt = $final_price -$unit_price;

          
            if((!empty($catValue['intergst'])) && ($catValue['intergst'] != '0'))
            {
            $totaldis=(($catValue['intergst']*100)-100); 
            }else{
            $totaldis='0';
            }
                $i++;
        $total += round($value['quantity']*$final_price);
       $total1 += $total_tax_amt;
       }
           if($getShippingVal['min_order_bal'] < $total)
                     {
                      $shippingAmount = '0';
                     }else{
                      $shippingAmount = $getShippingVal['shipping_amount'];
                     }
          $TotalValue =round($total + $shippingAmount);




        $html .= '<div style="width:100%; margin-top:40px;"><div style="width:70%;float:left;"><b>Delivery Address : </b><br> '.ucwords($getAddress['name']).'<br>'.$getAddress['area_streat_address'].' '.$getAddress['locality'].' '.$getAddress['district_city_town'].'.<br> <b>Pincode</b> '.$getAddress['pincode'].'<br> <b>Mob. No.</b>'.$getAddress['phone_no'].'</div>
        <div style="width:30%;float:right"><b font-size:13px;> Total Item&nbsp;&nbsp;&nbsp;: </b>'.count($getProduct).'<br><br><b font-size:13px;> Total Value Rs : </b>'.$TotalValue.'/- </div></div>';




        $html .= '<div style="float:left;width:100%; margin-top:50px;"><table width="100%" border="1"><tr><th>Sr. No.</th><th>Product List</th><th>Unit Price</th><th>Qty</th><th>Unit</th><th>Tax Rate</th><th>Tax Type</th><th>Tax Amount</th><th>Total Amount</th></tr>';
       $total1  = 0;
       $total   = 0;
        $i = 1;
        foreach ($getProduct as $key => $value) {
         // echo $value['product_master_id'];
          $PID=$this->db->get_where('product_master',array('id'=>$value['product_master_id']))->row_array();


 $productValue = $this->db->get_where('product_master',array('id'=>$value['product_master_id']))->row_array();
/*Get Here Offe*/
           $sub_category_id =  json_encode([$productValue['sub_category_master_id']]);
           $time = time();
           $product_id =  $productValue['id'];   
                    
          $Check_deal_of_day =$this->db->query("select * from product_master where id='$product_id' and deal_of_day_end >=$time and status='1'")->row_array();
                   
           $offer_check = $this->db->query("select * from offer_master where sub_category_ids='$sub_category_id' and end_date >=$time and status='1'")->row_array();

################################################################################################################################### Start  Deal  Of The Day Condition #########################
      if(!empty($Check_deal_of_day)){
         if($Check_deal_of_day['dod_discount_type'] == '1'){ 
            $final_price =  round($Check_deal_of_day['price']-$Check_deal_of_day['dod_amount']); 
          } else {
            $holdprice =  $Check_deal_of_day['dod_amount'] * $Check_deal_of_day['price']/ 100 ; 
            $final_price = round($Check_deal_of_day['price'] - $holdprice);
         }
      }
################################################################################################################################### End Deal Condition ################################################

 ###################################################################################################
 ################################ Check Offer Condition ################################################ 
        else { 
 
          if($offer_check['offerType'] == '1'){ 
                        if($offer_check['deal_type'] == '1'){ 
                             $final_price = round($productValue['price'] - $offer_check['deal_amount']);      
                          } else {
          
                             $holdprice =  $offer_check['deal_amount'] / 100 * $productValue['price'] ; 
                             $final_price = round($productValue['price'] - $holdprice);
                          } 
           } else {
                  if($productValue['product_discount_type'] == '1'){ 
                       $final_price =  round($productValue['final_price']);     
                  } else { 
                     $holdprice =  $productValue['product_discount_amount'] * $productValue['price']/ 100 ; 
                     $final_price = round($productValue['price'] - $holdprice) ;
                 }


            }

       }

 #######################################################################################
 ################################ End Offer Condition ##################################



           $UnitName=$this->db->get_where('unit_master',array('id'=>$PID['unit']))->row_array();
         $catValue=$this->db->get_where('sub_category_master',array('id'=>$PID['sub_category_master_id']))->row_array();    
            if((!empty($catValue['intergst'])) && ($catValue['intergst'] != '0'))
            {
            $totaldis=(($catValue['intergst']*100)-100); 
            }else{
            $totaldis='0';
            }
          $unit_price  = $final_price/$catValue['intergst'];
          $unit_price    = round($unit_price, 2); 
          $total_tax_amt = $final_price -$unit_price;



         // echo $value['product_master_id'];
        $html .= '<tr><td>'.$i.'.</td><td>'.singlerowparameter2('product_name','id',$value['product_master_id'],'product_master').'</td><td>'.$unit_price.'</td><td>'.$value['quantity'].'</td><td>'.$PID['weight_litr'].''.$UnitName['unit_name'].'</td><td>'.$totaldis.'%</td><td>'.$tax_type.'</td><td>'.$total_tax_amt*$value['quantity'].'</td><td>Rs. '.$value['quantity']*$final_price.'/-</td></tr>';
         $i++;
        $total += $value['quantity']*$final_price;
       $total1 += $total_tax_amt*$value['quantity'];
         }


                  if($getShippingVal['min_order_bal'] < $total)
                     {
                      $shippingAmount = '0';
                     }else{
                      $shippingAmount = $getShippingVal['shipping_amount'];
                     }
                $TotalValue =round($total + $shippingAmount);
                  
       $html .= '<tr><td colspan="7">Total</td><td>'.$total1.'</td><td>Rs. '.$total.'/-</td></tr>';

       $html .=  '</table></div>';
       $html .= '<div style="float:left;width:100%; margin-top:50px;"><div style="float:left;width:60%"></div><div style="float:right;width:40%"><table><tr><td><p style="font-size:14px;"><b>Grand Total Rs</b></p></td><td></td><td>'.round($total).'/-</td></tr><tr><td><p style="font-size:14px;">Shipping & Delivery Charge Rs</p></td><td> </td><td>'.$shippingAmount.'/-</td></tr><tr><td><p style="font-size:14px;">Total Value Rs</p></td><td> 
       </td><td><b>'.$TotalValue.'/-</b></td></tr></table>

        <p style="color:red">Note: Including Shipping Charges and taxes.</p></div></div>';
      $html .= '<div style="float:left;width:70%;margin-left:40%"><table><tr><td><p style="font-size:18px;">Thank you...</p>Shopping Karen befike.<br>Order By - </td><td><div class="image" style="margin-top:4px;"><br><img src="'.base_url('assets/Mr&MrsEkart3.png').'" style="width:70px;margin-left: 5px"> </div><div style="top: -60px" > <b style="font-size:13px;">&nbsp;&nbsp;&nbsp;MrNMrs Ekart Retail Trading Pvt. Ltd.</b>
        </div></td></tr></table></div>
      ';        

      $html .= '<br><p style="text-align:center;">(This is a system generated invoice and does not require a signature.)</p>';
              

        $pdfFilePath =  INVOICE_DIRECTORY.$pdfFilePath;

        //load mPDF library
        $this->load->library('m_pdf');
        $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
       //generate the PDF from html
        $this->m_pdf->pdf->WriteHTML($PDFContent);
 
        //download PDF
        $this->m_pdf->pdf->Output($pdfFilePath, "F");  
    }











}
 ?>