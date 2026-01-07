<?php
    if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Seller_api_modal extends CI_Model {

    public function __construct() {
    parent::__construct();
    $this->load->database();
    }




   /* get seller profile record  */

    public function get_seller_profile($seller_id){
    // $this->db->select('name,mobile,whatsaap_number,profile_pic,address,password');
    $this->db->select('*');
	  $this->db->where('id',$seller_id);
	  return $this->db->get('staff_master')->row_array();
    }




    /* Update seller bank details record  */


    public function updateSellerBankDetail($getdata){

     $data['seller_id']  = $getdata['shopmet']['seller_id'];  

     $data['account_holder_name'] =  $getdata['shopmet']['account_holder_name']; 

     $data['account_number'] =  $getdata['shopmet']['account_number']; 

     $data['ifsc'] =  $getdata['shopmet']['ifsc'];

     $data['bank_name'] =  $getdata['shopmet']['bank_name']; 



     $data['modify_date'] =  time();

     $this->db->where('seller_id',$data['seller_id']);
     $bankData = $this->db->get('seller_bank_detail_master')->row_array();
     
     if($bankData){

     $this->db->where('seller_id',$data['seller_id']);
     return $this->db->update('seller_bank_detail_master',$data);

     }else{
     $data['add_date'] =  time(); 
     return $this->db->insert('seller_bank_detail_master',$data);

     }
    }




 /* Update seller bank details record  */


    public function get_seller_bank_detail($getdata){
    $seller_id = $getdata['shopmet']['seller_id']; 

    $this->db->where('seller_id',$seller_id);
    return $this->db->get('seller_bank_detail_master')->row_array();
    }


  

     /* Update seller profile record  */


    public function update_seller_profile($data){

    $seller_id = $data['shopmet']['seller_id'];  

    $field['name'] = $data['shopmet']['name'];

    $profile_pic = $data['shopmet']['profile_pic'];

    $field['mobile'] = $data['shopmet']['contact_no'];

    $field['whatsaap_number'] = $data['shopmet']['whatsapp_no'];

    $field['address'] = $data['shopmet']['address']; 

    $field['password'] = $data['shopmet']['password'];

    $field['locality'] = $data['shopmet']['locality'];
  
    $field['pincode'] = $data['shopmet']['pincode'];
    

    $image= !empty($profile_pic) ? savefileUsingApi($profile_pic,LOGO_DIRECTORY) : "";

    if(!empty($image)){
     $field['profile_pic'] = $image;
    }

    $this->db->where('id',$seller_id);
    return $this->db->update('staff_master',$field);
    
    }




  /* Add seller shop */



  public function add_seller_shop($getdata){
  
  $field['vendor_id']  = $getdata['shopmet']['seller_id'];
  $field['name']  = $getdata['shopmet']['shop_name'];
  $field['slug']  = $getdata['shopmet']['slug'];
  $field['bussiness_name']  = $getdata['shopmet']['bussiness_name'];
  $field['mobile']  = $getdata['shopmet']['mobile'];
  $field['whatsApp_number']  = $getdata['shopmet']['whatsApp_number'];
  $field['pan_no']  = $getdata['shopmet']['pan_no'];

  $field['gst_number']  = $getdata['shopmet']['gst_number'];
  $field['address']  = $getdata['shopmet']['address'];
  $field['locality']  = $getdata['shopmet']['locality'];
  $field['pincode']  = $getdata['shopmet']['pincode'];
  $field['state_id']  = $getdata['shopmet']['state_id'];
  $field['city_id']  = $getdata['shopmet']['city_id'];

  $field['add_date']  = time();
  $field['modify_date']  = time();
  $field['verify_shop']  = '2';
  $field['type']  = '2';
  $field['addedBy']  = $getdata['shopmet']['seller_id'];

  $row = $this->db->insert('shop_master',$field);
  $last_id  = $this->db->insert_id();
  $this->createWarehouse($last_id);
  return $row;

  }



 /* Add seller shop in warehouse on shop adding time */



  public function createWarehouse($shop_id) {
  $shop = $this->db->get_where('shop_master',array('id'=>$shop_id))->row_array();

  $fields['company_name']     = $shop['name'];
  $fields['address1']         = $shop['address'];
  $fields['address2']         = '';
  $fields['mobile']           = $shop['mobile'];
  $fields['pincode']          = $shop['pincode'];
  $fields['city_id']          = '4933';
  $fields['state_id']         = '38';
  $fields['country_id']       = '101';
  $fields['access_token']     = '28b4d9246917ac19f5f9cea9861bc731';
  $fields['secret_key']       = 'df1b745f66e9b39f81b70b8bc2ad4689';
 
   $array_data['data']           = $fields;
   $json_data   = json_encode($array_data);
   $curl = curl_init();
              curl_setopt_array($curl, array(
              CURLOPT_URL             => "https://manage.ithinklogistics.com/api_v3/warehouse/add.json",
              CURLOPT_RETURNTRANSFER  => true,
              CURLOPT_ENCODING        => "",
              CURLOPT_MAXREDIRS       => 10,
              CURLOPT_TIMEOUT         => 30,
              CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST   => "POST",
              CURLOPT_POSTFIELDS      => $json_data,
              CURLOPT_HTTPHEADER      => array(
                  "cache-control: no-cache",
                  "content-type: application/json"
              ),
          ));

          $response = curl_exec($curl);
          $err      = curl_error($curl);
          curl_close($curl);
          if ($err) 
          {
             echo "cURL Error #:" . $err;
          }
          else
          {
             $res_array =json_decode($response,true);
          }
    
     if(!empty($res_array['warehouse_id'])) {

     if(empty($shop['warehouse_id'])) {
            $warehouse['warehouse_id']     =   $res_array['warehouse_id'];
            $this->db->where('id',$shop_id);
            return $this->db->update('shop_master',$warehouse);
       }
      }
    }





    /* seller shop list */

    public function seller_shop_list($getdata){
    $seller_id  = $getdata['shopmet']['seller_id'];

    $this->db->order_by('id','DESC');
    return $this->db->get_where('shop_master',array('type'=>'2','addedBy'=>$seller_id))->result_array();
    }


    /* get category list */

    public function getCatgyList() {
    $this->db->order_by('category_name','Asc');
    return $this->db->get_where('category_master',array('status'=>'1'))->result_array();    
  }


 /* get shop list */

   public function get_shop_list($getdata){
    $seller_id = $getdata['shopmet']['seller_id'];
   return $this->db->get_where('shop_master',array('status'=>'1','type'=>'2','addedBy'=>$seller_id))->result_array();
   }



  /* get subcategory list */

  public function get_subcategory_list($getdata){
  $category_id = $getdata['shopmet']['category_id'];
  return $this->db->get_where('sub_category_master',array('category_master_id'=>$category_id))->result_array();
 }



    /******************product add code start here************************/




   /* save product general information */

  public function save_pro_general_info($getdata){
 
  $fields['shop_id']                     = $getdata['shopmet']['shop_id'];
  $fields['category_id']                 = $getdata['shopmet']['CatId'];
  $fields['sub_category_id']             = $getdata['shopmet']['SubCat'];
  $fields['product_name']                = $getdata['shopmet']['ProductName'];
  $fields['sku_code']                    = $getdata['shopmet']['sku_code'];
  $fields['product_description']         = $getdata['shopmet']['product_description'];

  if(empty($getdata['shopmet']['id'])){  
    return $this->db->insert('tab_general_information',$fields);
   }else {
    $this->db->where('id',$getdata['shopmet']['id']);
    return $this->db->update('tab_general_information',$fields);  
    }

  }




    /* save product color size */

  public function save_pro_color_size($getdata){

  $this->db->where_not_in('id','555555555555555555555555555555555555555555555');
  $this->db->delete('tab_color_master');

  $this->db->where_not_in('id','55555555555555555555555555555555555555555555555');
  $this->db->delete('tab_size_master');

  //$color_item = count($data['color']);
   

  foreach ($getdata as $data) {
    echo '<pre>';
    print_r($data); die;

    $color_item = count($data['color']['color']);
   
    for ($i=0; $i < $color_item; $i++) { 
    print_r($color_item); die;
    $fields['color'] = $color_item['color'][$i];
    
    echo '<pre>';
    print_r($fields['color']);die;

    $row = $this->db->insert('tab_color_master',$fields);

    $insert_id  = $this->db->insert_id();
    
    // $size_item = count($data['size'.$i]); 
    $size_item = count($color_item['size'.$i]); 

     for ($j=0; $j < $size_item; $j++) {

     $field['color_id'] =  $insert_id;
     $field['size']     =  $data['size'.$i][$j];
     $row = $this->db->insert('tab_size_master',$field);
     }

   }
 }





   return $row;

  }




}