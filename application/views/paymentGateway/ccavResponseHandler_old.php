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
print_r($decryptValues);
exit();

foreach ($decryptValues as $value) {
    list($key, $val) = explode('=', $value);
    if ($key === 'order_status') {
        $order_status = $val;
    }
    if ($key === 'order_id') {
        $order_number = $val;
    }
}




          $get_oder  = $this->db->get_where('order_master2',array('order_number'=>$order_number))->row_array();
           $order_id  = $get_oder['id'];
           $get_oder_info=$this->db->get_where('order_master2',array('order_number'=>$order_number))->row_array();
           $user_id = $get_oder_info['user_master_id'];
           $final_amount = $get_oder_info['final_price'] + $get_oder_info['shippment_charge'];
            $get_purchase = $this->db->get_where('purchase_master2',array('order_master_id'=>$order_id))->result_array();
           
        $user_res = $this->db->get_where('user_master2',array('id' => $get_oder['user_master_id']))->row_array();   
     $user_data = array(
        'id'=>$user_res['id'],
        'email'=>$user_res['email_id'],
        'username'=>$user_res['username']
    );
    $user_ses = $this->session->set_userdata('User',$user_data);
    
   //  $this->db->select('product_name,shop_id,sku_code,product_code,main_image');
       //     $product = $this->db->get_where('sub_product_master', array('id' => $value['id']))->row_array();
            
            // $this->db->select('mobile,name,email');
          //  $staff = $this->db->get_where('staff_master', array('id' => $shop['vendor_id']))->row_array();
    
    $data = array(
        'order_response' => json_encode($get_oder),
        'card_response' =>json_encode($get_purchase),
        'order_number' => $order_number
    );
    
    $this->db->insert('logs', $data);     
           
      if($order_status==="Success"):
      	        $status['status'] ='1';
                $status['action_payment']   = 'Yes';
                $status['payment_status']   = 'Paid';
                $status['order_number']     = $get_oder['order_number'];
                $status['user_master_id']   = $get_oder['user_master_id'];
                $status['address_master_id']   = $get_oder['address_master_id'];
                $status['coupon_code_id']   = $get_oder['coupon_code_id'];
                $status['total_price']      = $get_oder['total_price'];
                $status['final_price']      = $get_oder['final_price'];
                $status['discount']         = $get_oder['discount'];
                $status['shippment_charge'] = $get_oder['shippment_charge'];
                $status['payment_type']  = '2';
                $status['pdf_link']         = $get_oder['pdf_link'];
                $status['add_date'] = time();
                
                $status['modify_date'] = time();
                $this->db->insert('order_master', $status);
                $last_id = $this->db->insert_id();
                 /*Admin Place Order message*/
            $admin_message = "Dukekart has received an order on Product name: " . $product['product_name'] . ", Seller Mobile no: ". $staff['mobile'] .".  Regards, Dukekart Real Time Private Limited , www.dukekart.in";
          
                // sendSMS('9935149155',$admin_message,'1007850092609093226');
           // sendSMS('7460833766',$admin_message,'1007850092609093226');
             sendSMS('9198643301',$admin_message,'1007850092609093226');
                $customer_message = "Dear " . $user_res['username'] . " Thanks for your order. We've received your order and will update you soon as the seller confirms your orderRegardsDukakart Real Time Private Limited";
                $template='1007287118749920707';
                $mobile= $user_res['mobile'];
                $url = "http://sms.txly.in/vb/apikey.php?apikey=glNySZAajwGzc6mO&senderid=DUKRLT&templateid=".$template."&number=".$mobile."&message=".urlencode($customer_message);
                   $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,$url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                     curl_exec($ch); 
                   curl_close($ch); 
               
                
                $address_data = $this->db->get_where('order_address_master2',array('order_master_id'=>$order_id))->row_array();

                 $addr['order_master_id']           = $last_id;
                 $addr['title']                     = $address_data['title'];
                 $addr['contact_person']            = $address_data['contact_person'];
                 $addr['mobile_number']             = $address_data['mobile_number'];
                 $addr['alternate_number']          = $address_data['alternate_number'];
                 $addr['address']                   = $address_data['address'];
                 $addr['localty']                   = $address_data['localty'];
                 $addr['landmark']                  = $address_data['landmark'];
                 $addr['pincode']                   = $address_data['pincode'];
                 $addr['city']                      = $address_data['city'];
                 $addr['state']                     = $address_data['state'];
                 $addr['add_date']                  = time();
                 $addr['modify_date']               = time();
                 $row = $this->db->insert('order_address_master',$addr);
                 
                 foreach ($get_purchase as $purchaseValue) {
                     $this->db->insert('purchase_master',array('vendor_master_id'=>'1','shop_id'=>$purchaseValue['shop_id'],'order_master_id'=>$last_id,'price'=>$purchaseValue['price'],'final_price'=>$purchaseValue['final_price'],'product_master_id' => $purchaseValue['product_master_id'],'quantity' => $purchaseValue['quantity'],'size' => $purchaseValue['size'],'color' => $purchaseValue['color'],'modify_date' => time(),'add_date' => time()));
                 }    
                
                 $this->db->where('id',$order_id);
                  $this->db->delete('order_master2');
                 
                  $this->db->where('order_master_id',$order_id);
                  $this->db->delete('purchase_master2');
                 
                  $this->db->where('order_master_id',$order_id);
                  $this->db->delete('order_address_master2');
                  
      	$this->session->set_flashdata('activate','<span style="color:green">YOUR ORDER HAS BEEN SUCCESSFULLY.</span>');
      
        $this->cart->destroy();
        redirect(base_url()."web/order_success2/".$order_number);
     
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