<?php
class Api_model extends CI_Model {
   public function __construct(){
    parent::__construct();
    $this->load->database();

  }



/*User Registration*/

  public function userSignUp($request) {

    $field['username']       = $request['name'];
    $field['email_id']       = $request['email'];
    $field['mobile']         = $request['mobile'];
    $field['password']       = $request['password'];
    $field['status']         = '1';
    $field['add_date']       = time();
    $field['modify_date']    = time();

    $check = $this->db->get_where('user_master',array('mobile'=>$request['mobile']))->row_array();
    if(empty($check)) {
      $this->db->insert('user_master',$field);

       $message_content='Your customer account has been successfully registered with Shopmet Go and check out soon https://www.shopmet.com/ for exciting offers and discount';

        $email_content='Your customer account has been successfully registered with Shopmet. Welcome to a new world of online shopping Go and check out soon https://www.shopmet.com/ for exciting offers and discount. You will get best shopping experience and great services with us';

       sendSMS($request['mobile'],$message_content);

        //sentCommonEmail($request['email'],$email_content,'Registration successfully.');
      generateServerResponse('1','2',$field);
    } else {
      $this->db->where('mobile',$request['mobile']);
      $this->db->update('user_master',$field);
      generateServerResponse('1','2',$field);
    }

    
}


/*Customer Login*/

public function userLogin($request) {
  
   $check = $this->db->get_where('user_master',array('mobile'=>$request['mobile'],'password'=>$request['password'],'status'=>'1'))->row_array();



   if(!empty($check)) {

          $cartCount = $this->db->get_where('mycart_master',array('user_master_id'=>$check['id']))->num_rows();

           $loginId = $this->loginManager($request);
           $response['userId']             = $check['id'];
           $response['loginId']            = $loginId;
           $response['userName']           = $check['username'];
           $response['email']              = $check['email_id'];
           $response['mobile']             = $check['mobile'];
           $response['profile_pic']        = base_url().'assets/profile_image/'.$check['profile_pic'];
           $response['whatsaap_number']    = $check['whatsaap_number'];
           $response['alternate_number']   = $check['alternate_number'];
           $response['address']            = $check['address'];
           $response['locality']           = $check['locality'];
           $response['city']               = $check['city'];
           $response['state']              = $check['state'];
           $response['pincode']            = $check['pincode'];
           $response['password']           = $check['password'];
           $response['wallet_amount']      = $check['wallet_amount'];
           $response['cartCount']          = $cartCount;
           
          generateServerResponse('1', '210',$response);

       } else {

         generateServerResponse('0', '222'); 

      }

  }





/*Log History*/
 public function loginManager($data) {

      $user = $this->db->get_where('user_master',array('mobile'=>$data['mobile']))->row_array();
      $login_array                        =  array();
      $login_array['user_master_id']      =  $user['id'];
      $login_array['device_id']           =  $data['deviceId'];
      $login_array['fcm_id']              =  $data['fcmId'];
      $login_array['add_date']            =  time();
      $login_array['modify_date']         =  time();
      $this->db->insert('login_manager', $login_array);
      $login_insert_id = $this->db->insert_id();
      return $login_insert_id;

 }



/*Dashbord*/
public function dashbordList($request) {
   
    $this->db->select('id,banner_image');
    $sliderList =$this->db->get_where('banner_master',array('status'=>'1'))->result_array();


    $this->db->order_by('id', 'RANDOM');
    $this->db->where_in('id',array(9,29,2,1));
    $this->db->select('id,app_icon,sub_category_name as category_name,category_master_id');
    $categoryList =  $this->db->get('sub_category_master')->result_array();
 

    $this->db->select('product_ids,name');
    $tag1  = $this->db->get_where('tag_master', array('id' => '1'))->row_array(); 
    $product_ids = json_decode($tag1['product_ids'],true);

    $this->db->select('id,size,color,category_id,sub_category_id,product_name,price,final_price,main_image,sku_code');
    $this->db->limit(8);
    $this->db->where_in('id',$product_ids);
    $Featured = $this->db->get_where('sub_product_master', array('status' => 1))->result_array();


    $this->db->select('product_ids,name');
    $tag2  = $this->db->get_where('tag_master', array('id' => '2'))->row_array(); 
    $product_ids2 = json_decode($tag2['product_ids'],true);

   $this->db->select('id,size,color,category_id,sub_category_id,product_name,price,final_price,main_image,sku_code');
   $this->db->limit(8);
   $this->db->where_in('id',$product_ids2);
   $Topselling = $this->db->get_where('sub_product_master', array('status' => 1))->result_array(); 



    $this->db->select('product_ids,name');
    $tag3  = $this->db->get_where('tag_master', array('id' => '3'))->row_array(); 
    $product_ids3 = json_decode($tag3['product_ids'],true);

    $this->db->select('id,size,color,category_id,sub_category_id,product_name,price,final_price,main_image,sku_code');
    $this->db->limit(8);
    $this->db->where_in('id',$product_ids3);
    $Recommended  = $this->db->get_where('sub_product_master', array('status' => 1))->result_array(); 


   /*Banner Display Here*/

     $main_array  = array();
     $main_array['Banner1']      = base_url().'assets/banner_images/Banner_5f756c2535cc0.jpg';
     $main_array['Banner2']      = base_url().'assets/banner_images/Banner_5f756c387b2b0.jpg';
     $main_array['Banner3']      = base_url().'assets/banner_images/Banner_5f756c2535cc0.jpg';
     $main_array['Banner4']      = base_url().'assets/banner_images/Banner_5f756c387b2b0.jpg';


      /*Slider Array Here*/

       $slider   = array();
         
         foreach ($sliderList as $key => $sliderList) {
           $slider['Id']     = $sliderList['id'];
           $slider['image']  = base_url().'/assets/banner_images/'.$sliderList['banner_image'];
           $hold_slider[]    = $slider;
         }

        $main_array['Slider'] = $hold_slider;


      /*Category Array Here*/

        $hold_category  = array();

        foreach ($categoryList as $key => $categoryList) {
           $category['Id']     = $categoryList['id'];
           $category['Name']   = $categoryList['category_name'];
           $category['Thumb']  = base_url().'/assets/category_images/'.$categoryList['app_icon'];
           $hold_category[]    = $category;
        }
      $main_array['Category'] = $hold_category;



      /*Featured Product Array here*/ 

        $featured  = array();

       foreach ($Featured as $key => $Featured) {
         $this->db->select('category_name');
         $category =  $this->db->get_where('category_master',array('id'=>$Featured['category_id']))->row_array();

         $this->db->select('id');
         $wish = $this->db->get_where('wishlist_master',array('product_master_id'=>$Featured['id'],'user_master_id'=>$request['user_id']))->row_array();

         $featured['Id']               = $Featured['id'];
         $featured['Category']         = $category['category_name'];
         $featured['SKU']              = $Featured['sku_code'];
         $featured['Color']            = $Featured['color'];
         $featured['Size']             = $Featured['size'];
         $featured['ProductName']      = $Featured['product_name'];
         $featured['RegularPrice']     = $Featured['final_price'];
         $featured['MRP']              = $Featured['price'];
 //        $featured['ImagePrimary']     = $Featured['main_image'];
         $featured['Tags']             = 'Featured';

//************************* *****************************************************************************

         $array_url  = parse_url($Featured['image']);

          if(empty($array_url['host'])) { 

          $fields['ImagePrimary']     = base_url().'/assets/product_images/'.$Featured['main_image'];

          } else {

           $fields['ImagePrimary']     = $Featured['main_image'];

          }

//***********************************************************************************************************          



         if(!empty($wish)) {
            $featured['WishlistStatus']   = 'true';
            $featured['WishlistId']       = $wish['id'];
         } else {
           $featured['WishlistStatus']   = 'false';
           $featured['WishlistId']        = '';
         }
         
        $hold_featured[]               = $featured;
       }

      $main_array['Featured'] = $hold_featured;


      /*Topselling Product Array here*/ 

        $topselling  = array();

        foreach ($Topselling as $key => $Topselling) {

           $this->db->select('category_name');
           $category =  $this->db->get_where('category_master',array('id'=>$Topselling['category_id']))->row_array();

            $this->db->select('id');
            $wish = $this->db->get_where('wishlist_master',array('product_master_id'=>$Topselling['id'],'user_master_id'=>$request['user_id']))->row_array();

           $topselling['Id']               = $Topselling['id'];
           $topselling['Category']         = $category['category_name'];
           $topselling['SKU']              = $Topselling['sku_code'];
           $topselling['Color']            = $Topselling['color'];
           $topselling['Size']             = $Topselling['size'];
           $topselling['ProductName']      = $Topselling['product_name'];
           $topselling['RegularPrice']     = $Topselling['final_price'];
           $topselling['MRP']              = $Topselling['price'];
   //        $topselling['ImagePrimary']     = $Topselling['main_image'];
           $topselling['Tags']             = 'Topseller, Top Best Selling';

//************************* *****************************************************************************

         $array_url  = parse_url($Topselling['image']);

          if(empty($array_url['host'])) { 

          $fields['ImagePrimary']     = base_url().'/assets/product_images/'.$Topselling['main_image'];

          } else {

           $fields['ImagePrimary']     = $Topselling['main_image'];

          }

//***********************************************************************************************************          



          if(!empty($wish)) {
              $topselling['WishlistStatus']   = 'true';
              $topselling['WishlistId']       = $wish['id'];
           } else {
             $topselling['WishlistStatus']    = 'false';
             $topselling['WishlistId']        = '';
           }

           $hold_topselling[]             = $topselling;
       }

      $main_array['Topselling'] = $hold_topselling;


      /*Recommended Product Array here*/ 

        $recommended  = array();
        $recommended_array['Title']  = 'Top Rated Products';
        foreach ($Recommended as $key => $Recommended) {
          $this->db->select('category_name');
           $category =  $this->db->get_where('category_master',array('id'=>$Recommended['category_id']))->row_array();

          $this->db->select('id');
          $wish = $this->db->get_where('wishlist_master',array('product_master_id'=>$Recommended['id'],'user_master_id'=>$request['user_id']))->row_array();

           $recommended['Id']               = $Recommended['id'];
           $recommended['Category']         = $category['category_name'];
           $recommended['SKU']              = $Recommended['sku_code'];
           $recommended['Color']            = $Recommended['color'];
           $recommended['Size']             = $Recommended['size'];
           $recommended['ProductName']      = $Recommended['product_name'];
           $recommended['RegularPrice']     = $Recommended['final_price'];
           $recommended['MRP']              = $Recommended['price'];
       //    $recommended['ImagePrimary']     = $Recommended['main_image'];
           $recommended['Tags']             = 'Toprated,Top Rated Products';

//*********************************************************************************************************** 
            $array_url  = parse_url($Recommended['image']);

          if(empty($array_url['host'])) { 

          $fields['ImagePrimary']     = base_url().'/assets/product_images/'.$Recommended['main_image'];

          } else {

           $fields['ImagePrimary']     = $Recommended['main_image'];

          }

//***********************************************************************************************************           

           if(!empty($wish)) {
              $recommended['WishlistStatus']   = 'true';
              $recommended['WishlistId']       = $wish['id'];
           } else {
             $recommended['WishlistStatus']    = 'false';
             $recommended['WishlistId']        = '';
           }

           $hold_recommended[] = $recommended;
       }


      $main_array['RecommendedForYou'] = $hold_recommended;
      $response['Data']     = $main_array;

      generateServerResponse('1', 'S',$response);

}

/*Logout*/

public function logout($request) {
  $fields['login_status'] = '2';
  $fields['modify_date']  =  time();
  $this->db->where(array('user_master_id'=>$request['user_id'],'device_id'=>$request['device_id']));
   $row = $this->db->update('login_manager',$fields);
   if($row > 0) {
     generateServerResponse('1', '211');
   } else {
    generateServerResponse('0', 'W');

   }
}


/*Change Password*/

public function changeUserPassword($data) {

  $user_info = $this->db->get_where('user_master',array('mobile'=>$data['mobile']))->row_array();

   if($user_info['password'] == $data['oldPassword']) {
    
    $this->db->where('id',$user_info['id']);
    $this->db->update('user_master',array('password'=>$data['newPassword']));
    generateServerResponse('1', '220');

   } else {

    generateServerResponse('0', '219');
   
   } 

}




/*Product List */

public function getProductList($request) {
    $offset = '';
    $limit = 10;
    if($request['pageindex'] == '')
    {     
      $offset = 0;

    } else {

      $offset = $request['pageindex']; 

    }



   $this->db->limit($limit,$offset);
   $this->db->order_by('id','DESC');
   $this->db->group_by('product_code');


     $productList = $this->db->get_where('sub_product_master',array('status'=>'1','category_id'=>$request['categoryId']))->result_array();

  
 

    $hold_product = array();  
    foreach ($productList as $key => $value) {
            $this->db->select('category_name');
             $category =  $this->db->get_where('category_master',array('id'=>$value['category_id']))->row_array();
             $fields['Id']               = $value['id'];
             $fields['Category']         = $category['category_name'];
             $fields['SKU']              = $value['sku_code'];
             $fields['Color']            = $value['color'];
             $fields['Size']             = $value['size'];
             $fields['ProductName']      = $value['product_name'];
             $fields['RegularPrice']     = $value['final_price'];
             $fields['MRP']              = $value['price'];
          //   $fields['ImagePrimary']     = $value['main_image'];
             $fields['WishlistStatus']   = '2';
             $hold_product[]             = $fields;

//*********************************************************************************************************** 
              $array_url  = parse_url($value['image']);

          if(empty($array_url['host'])) { 

          $fields['ImagePrimary']     = base_url().'/assets/product_images/'.$value['main_image'];

          } else {

           $fields['ImagePrimary']     = $value['main_image'];

          }

//*********************************************************************************************************** 

    }

     $response['pageindex'] = $request['pageindex'] + count($productList); 
      $response['ProductList'] = $hold_product; 
      if (count($response['ProductList']) > 0) {
        generateServerResponse('1','103',$response);
      } else {
        generateServerResponse('0','102');
   }



}



/*Product List */

public function getProductList1($request) {
    $offset = '';
    $limit = 10;
    if($request['pageindex'] == '')
    {     
      $offset = 0;

    } else {

      $offset = $request['pageindex']; 

    }



   $this->db->limit($limit,$offset);
   $this->db->order_by('id','DESC');
   $this->db->group_by('product_code');


     $productList = $this->db->get_where('sub_product_master',array('status'=>'1','sub_category_id'=>$request['subcategory_id']))->result_array();

  
 

    $hold_product = array();  
    foreach ($productList as $key => $value) {
            $this->db->select('category_name');
             $category =  $this->db->get_where('category_master',array('id'=>$value['category_id']))->row_array();
             $fields['Id']               = $value['id'];
             $fields['Category']         = $category['category_name'];
             $fields['SKU']              = $value['sku_code'];
             $fields['Color']            = $value['color'];
             $fields['Size']             = $value['size'];
             $fields['ProductName']      = $value['product_name'];
             $fields['RegularPrice']     = $value['final_price'];
             $fields['MRP']              = $value['price'];
          //   $fields['ImagePrimary']     = $value['main_image'];
             $fields['WishlistStatus']   = '2';
             $hold_product[]             = $fields;

//*********************************************************************************************************** 
              $array_url  = parse_url($value['image']);

          if(empty($array_url['host'])) { 

          $fields['ImagePrimary']     = base_url().'/assets/product_images/'.$value['main_image'];

          } else {

           $fields['ImagePrimary']     = $value['main_image'];

          }

//*********************************************************************************************************** 

    }

     $response['pageindex'] = $request['pageindex'] + count($productList); 
      $response['ProductList'] = $hold_product; 
      if (count($response['ProductList']) > 0) {
        generateServerResponse('1','103',$response);
      } else {
        generateServerResponse('0','102');
   }



}

public function getProductDetails($request) {

  $Product = $this->db->get_where('sub_product_master',array('id'=>$request['product_id']))->row_array();

  $this->db->select('category_name');
  $category =  $this->db->get_where('category_master',array('id'=>$Product['category_id']))->row_array();

  $this->db->select('DISTINCT(color) as color,color_code');
  $color = $this->db->get_where('sub_product_master',array('product_code'=>$Product['product_code']))->result_array();

  

  $this->db->select('id,vendor_id');
  $shop = $this->db->get_where('shop_master',array('id'=>$Product['shop_id']))->row_array();

  $this->db->select('id,name');
  $vendor = $this->db->get_where('staff_master',array('id'=>$shop['vendor_id']))->row_array();

  $this->db->select('id');
  $wish = $this->db->get_where('wishlist_master',array('product_master_id'=>$Product['id'],'user_master_id'=>$request['user_id']))->row_array();

  $cartData = $this->db->get_where('mycart_master',array('product_master_id'=>$Product['id'],'user_master_id'=>$request['user_id']))->row_array(); 


   $response['id']               =  $Product['id'];
   if(!empty($wish)){
    $response['WishlistStatus']   =  'true';
    $response['WishlistId']       =  $wish['id'];
   } else {
    $response['WishlistStatus']   =  'false';
    $response['WishlistId']       =  ''; 
   }

   if(!empty($cartData)) {

     $response['CartStatus']         =  'true';
     $response['CartId']             =  $cartData['id'];
     $response['quantity']           =  $cartData['quantity'];

   } else {

     $response['CartStatus']         =  'false';
     $response['CartId']             =  '';
     $response['quantity']           =  '';

   }
   $response['Category']         =  $category['category_name'];
   $response['SKU']              =  $Product['sku_code'];
   $response['Color']            =  $Product['color'];
   $response['Size']             =  $Product['size'];
   $response['ProductName']      =  $Product['product_name'];
   $response['RegularPrice']     =  $Product['final_price'];
   $response['MRP']              =  $Product['price'];
   $response['Highlights']       =  $Product['highlights'];
   $response['Brand']            =  $Product['brand'];
   $response['Seller']           =  $vendor['name'];
   $response['Description']      =  $Product['product_description'];

     $hold_color = array();
    foreach ($color as $key => $color)  {

      $this->db->select('id,size');
      $size_array = $this->db->get_where('sub_product_master',array('color_code'=>$color['color_code']))->result_array();


      $this->db->select('id,main_image');
      $pro_id = $this->db->get_where('sub_product_master',array('color_code'=>$color['color_code'],'color'=>$color['color']))->row_array();
     $field['product_id']          =   $pro_id['id'];
     $field['color']               =   $color['color'];
     $field['color_code']          =   $color['color_code'];
     $field['main_image']          =   $pro_id['main_image'];
     

      $hold_size = array();
      foreach ($size_array as $key => $size) {

       $size_data['product_id']      =    $size['id'];
       $size_data['size']            =    $size['size'];
       $hold_size[]                  =    $size_data;

      }
 
      $field['sizeData']             =   $hold_size;
      $hold_color[]                  =   $field;

    }

   $response['ColorList']     =  $hold_color;

    

  $response['sizeList']     =  $hold_size;


     $response['sleev_length']                 =  $Product['sleev_length'];
     $response['neckline']                     =  $Product['neckline'];
     $response['prints_patterns']              =  $Product['prints_patterns'];
     $response['blouse_piece']                 =  $Product['blouse_piece'];
     $response['occasion']                     =  $Product['occasion'];
     $response['combo']                        =  $Product['combo'];
     $response['fit']                          =  $Product['fit'];
     $response['collor']                       =  $Product['collor'];
     $response['fabric']                       =  $Product['fabric'];
     $response['fabric_care']                  =  $Product['fabric_care'];
     $response['pack_of']                      =  $Product['pack_of'];
     $response['type']                         =  $Product['type'];
     $response['style']                        =  $Product['style'];
     $response['length']                       =  $Product['length'];
     $response['art_work']                     =  $Product['art_work'];
     $response['stretchable']                  =  $Product['stretchable'];
     $response['back_type']                    =  $Product['back_type'];
     $response['ideal_for']                    =  $Product['ideal_for'];
     $response['generic_name']                 =  $Product['generic_name'];
     $response['main_image']                   =  $Product['main_image'];
     $response['image1']                       =  $Product['image1'];
     $response['image2']                       =  $Product['image2'];
     $response['image3']                       =  $Product['image3'];
     $response['image4']                       =  $Product['image4'];
     $response['image5']                       =  $Product['image5'];
   

  if (!empty($response)) {

        generateServerResponse('1','103',$response);

      } else {

        generateServerResponse('0','102');
   }


}





  public function AddToCard($request) {

    $check = $this->db->get_where('mycart_master',array('user_master_id'=>$request['user_id'],'product_master_id'=>$request['product_id']))->row_array();
      $fields['user_master_id']       =     $request['user_id'];
      $fields['product_master_id']    =     $request['product_id'];
      $fields['quantity']             =     '1';
      $fields['status']               =     '1';
      $fields['add_date']             =     time();
      $fields['modify_date']          =     time();
      $this->db->insert('mycart_master',$fields);

    if (!empty($check)) {

       generateServerResponse('0','120');

    } else  {

       generateServerResponse('1','121');
          
     }


  }



    public function cartList($request) {

       $cartList = $this->db->get_where('mycart_master',array('user_master_id'=>$request['user_id']))->result_array();


       $hold = array();
       foreach ($cartList as $key => $value) {
        $Product = $this->db->get_where('sub_product_master',array('id'=>$value['product_master_id']))->row_array();

         $fields['id']                 = $value['id'];
         $fields['product_id']         = $value['product_master_id'];
         $fields['productName']        = $Product['product_name'];
         $fields['size']               = $Product['size'];
         $fields['color']              = $Product['color'];
         $fields['quantity']           = $value['quantity'];
         $fields['main_image']         = $Product['main_image'];
         $fields['price']              = $Product['price'];
         $fields['final_price']        = $Product['final_price'];
         $fields['shippingCharge']     = '';
         $fields['totalProductPrice']  = $Product['final_price']*$value['quantity'];
         $hold[]                       = $fields;
       }

       $response['CartList']           = $hold;

      if (count($response['CartList']) > 0) {
            generateServerResponse('1','103',$response);
          } else {
            generateServerResponse('0','102');
       }

    }



   public function updateQty($request) {

    $fields['quantity']     = $request['quantity'];
    $this->db->where(array('user_master_id'=>$request['user_id'],'product_master_id'=>$request['product_id']));
    $row = $this->db->update('mycart_master',$fields);
    if($row > 0){
      generateServerResponse('1','S',$fields);
    } else {
      generateServerResponse('0','W');
    }
   

   }



 public function removeProduct($request) {

  $this->db->where(array('user_master_id'=>$request['user_id'],'product_master_id'=>$request['product_id']));
  $row = $this->db->delete('mycart_master');

  if($row > 0){
      generateServerResponse('1','S');
    } else {
      generateServerResponse('0','W');
    }
 }  


           
public function RemoveFromWish($request){
 $this->db->where(array('id'=>$request['wishlist_id']));
  $row = $this->db->delete('wishlist_master');

  if($row > 0){
      generateServerResponse('1','233');
    } else {
      generateServerResponse('0','W');
    }
 }  





public function AddAddress($request) {

   $fields['user_master_id']      = $request['user_id'];
   $fields['title']               = $request['title'];
   $fields['contact_person']      = $request['contact_person'];
   $fields['mobile_number']       = $request['mobile_number'];
   $fields['alternate_number']    = $request['alternate_number'];
   $fields['address']             = $request['address'];
   $fields['localty']             = $request['localty'];
   $fields['landmark']            = $request['landmark'];
   $fields['pincode']             = $request['pincode'];
   $fields['state']               = $request['state'];
   $fields['city']                = $request['city'];
   $fields['add_date']            = time();
   $fields['modify_date']         = time();

    $row = $this->db->insert('user_address_master',$fields);

  if($row > 0){
      generateServerResponse('1','S',$fields);
    } else {
      generateServerResponse('0','W');
    }

}

public function UpdateAddress($request) {

   $fields['title']               = $request['title'];
   $fields['contact_person']      = $request['contact_person'];
   $fields['mobile_number']       = $request['mobile_number'];
   $fields['alternate_number']    = $request['alternate_number'];
   $fields['address']             = $request['address'];
   $fields['localty']             = $request['localty'];
   $fields['landmark']            = $request['landmark'];
   $fields['pincode']             = $request['pincode'];
   $fields['state']               = $request['state'];
   $fields['city']                = $request['city'];
   $fields['modify_date']         = time();

    $this->db->where('id',$request['address_id']);
    $row = $this->db->update('user_address_master',$fields);

  if($row > 0){
      generateServerResponse('1','S',$fields);
    } else {
      generateServerResponse('0','W');
    }

}



public function DeleteAddress($request) {

   $this->db->where('id',$request['address_id']);
   $row = $this->db->delete('user_address_master');
   if($row > 0){
      generateServerResponse('1','S');
    } else {
      generateServerResponse('0','W');
    }
}




public function addressList($request) {

  $address = $this->db->get_where('user_address_master',array('user_master_id'=>$request['user_id']))->result_array();

    $hold = array();
    foreach ($address as $key => $address) {

       $fields['address_id']          = $address['id'];
       $fields['user_master_id']      = $address['user_master_id'];
       $fields['title']               = $address['title'];
       $fields['contact_person']      = $address['contact_person'];
       $fields['mobile_number']       = $address['mobile_number'];
       $fields['alternate_number']    = $address['alternate_number'];
       $fields['address']             = $address['address'];
       $fields['localty']             = $address['localty'];
       $fields['landmark']            = $address['landmark'];
       $fields['pincode']             = $address['pincode'];
       $fields['state']               = $address['state'];
       $fields['state']               = $address['state'];
       $fields['city']                = $address['city'];
       $hold[]                        = $fields;
    }

    $response['AddressList']        = $hold;

      if (count($response['AddressList']) > 0) {
            generateServerResponse('1','103',$response);
         } else {
            generateServerResponse('0','102');
       }



}



public function AddWishList($request) {

   $check = $this->db->get_where('wishlist_master',array('product_master_id'=>$request['product_id'],'user_master_id'=>$request['user_id']))->num_rows();
   $fields['product_master_id'] = $request['product_id'];
   $fields['user_master_id']    = $request['user_id'];
   $fields['status']            = '1';
   $fields['add_date']          = time();
   $fields['modify_date']       = time();

 if($check=='0') {

   $this->db->insert('wishlist_master',$fields);
   generateServerResponse('1','232');

 } else {

   generateServerResponse('0','234');
 }


}

public function GetWishList($request) {

 $WishList = $this->db->get_where('wishlist_master',array('user_master_id'=>$request['user_id']))->result_array();

  $hold = array();

 foreach ($WishList as $key => $value) {

  $Product = $this->db->get_where('sub_product_master',array('id'=>$value['product_master_id']))->row_array();

   $fields['id']               =  $value['id'];
   $fields['product_id']       =  $value['product_master_id'];
   $fields['SKU']              =  $Product['sku_code'];
   $fields['Color']            =  $Product['color'];
   $fields['Size']             =  $Product['size'];
   $fields['ProductName']      =  $Product['product_name'];
   $fields['RegularPrice']     =  $Product['final_price'];
   $fields['MRP']              =  $Product['price'];
   $fields['Highlights']       =  $Product['highlights'];
   $fields['Brand']            =  $Product['brand'];
   $fields['Description']      =  $Product['product_description'];
   $fields['main_image']       =  $Product['main_image'];
   $fields['image2']           =  $Product['image2'];
   $hold[]                     =  $fields;

  }

       $response['WishList']           = $hold;

         if (!empty($WishList)) {

            generateServerResponse('1','103',$response);

          } else {

            generateServerResponse('0','102');
       }
}






/*Place Order  */

public function placeOrder($request) {
  $date = date("d M,Y h:i");
 

        $isProductBuys = $this->buyProduct($request); 
         $isProductBuy =  explode("D", $isProductBuys);
              
          if($isProductBuy > 0) {
            $this->db->select('final_price,user_master_id');
            $getPrice = $this->db->get_where('order_master',array('order_number'=>$isProductBuys))->row_array();

             generateServerResponse('1', '', array('order_id' => $isProductBuys,'add_date'=>$date,'final_price'=>$getPrice['final_price']));


           $this->db->select('username,email_id,mobile');
           $userinfo = $this->db->get_where('user_master',array('id'=>$getPrice['user_master_id']))->row_array();

           $mes = "Dear ".$userinfo['username'].", Your order no. ".$isProductBuys." has been placed successfully. We will update you soon as your order is ready for shipping. Thanks for shopping with us";

           sendSMS($userinfo['mobile'],$mes);
           sentCommonEmail($userinfo['email_id'],$mes,'Order Placed Successfully');

          } else {

              generateServerResponse('0', '104');

            }

    /*}*/

}


/*Buy Pruduct Place Order use this Function*/

 public function buyProduct($data) {
      
    $link         = time()."-invoice.pdf";
   
     $cart = $this->db->get_where('mycart_master',array('user_master_id'=>$data['userId']))->result_array();
    
   if(count($cart) > 0) { 


        /*Insert Value In Order Master Table*/

           $fields['add_date']             = time();
           $fields['modify_date']          = time();
           $oderId                         = "ORD".time();
           $fields['order_number']         = $oderId;
           $fields['user_master_id']       = $data['userId'];
           $fields['payment_type']         = $data['paymentType'];
           $fields['transaction_id']       = $data['transaction_id'];
           $fields['pdf_link']             = base_url().'assets/invoice/'.$link;
           $fields['status']                = '1';
           $this->db->insert('order_master',$fields);
           $lastId = $this->db->insert_id();
           $order = $this->db->get_where('order_master',array('id'=>$lastId))->row_array();
           $this->db->select('mobile,email_id,username');
           $user_info = $this->db->get_where('user_master',array('id'=>$order['user_master_id']))->row_array();

          $total_final_price = '0';
         
         
          foreach ($cart as $value) {

            $product = $this->db->get_where('sub_product_master',array('id'=>$value['product_master_id']))->row_array();

              $total_final_price+=  $product['final_price'] * $value['quantity']; 
            

              $sql = "UPDATE sub_product_master SET quantity = quantity - '".$value['quantity']."' WHERE id ='".$value['product_master_id']."' ";
              $this->db->query($sql);

               if($this->db->affected_rows() > 0) {

                  $productData = $this->db->get_where('sub_product_master',array('id'=>$value['product_master_id']))->row_array();

                  /*Insert Value in Purchase Master Table*/
                 $this->db->insert('purchase_master',array('vendor_master_id'=>'1','shop_id'=>$productData['shop_id'],'order_master_id'=>$lastId,'price'=>$product['price'],'final_price'=>$product['final_price'],'product_master_id' => $value['product_master_id'],'quantity' => $value['quantity'],'size' => $product['size'],'color' => $product['color'],'modify_date' => time(),'add_date' => time()));


          $this->db->select('vendor_id');
          $shop = $this->db->get_where('shop_master',array('id'=>$productData['shop_id']))->row_array();
          $this->db->select('mobile,name'); 
          $staff = $this->db->get_where('staff_master',array('id'=>$shop['vendor_id']))->row_array(); 

         /*Admin Place Order message*/

         
          $admin_message = "Shopmet has received an order on Product name:".$productData['product_name']." Seller name:".$staff['name']." Mobile no:".$staff['mobile']."";


            /*Seller Place Order Message*/


            $seller_login_link = "https://shopmet.com/seller-login";
 

            $seller_message="You have received an order on ".$order['order_number']." of SKU ".$productData['sku_code'].". Check this link ".$seller_login_link." and confirm the order from your side. For help contact 8934990990 -From Shopmet";

         

            sendSMS('9807626339',$admin_message,'1307161760182866974');
           
            sendSMS($staff['mobile'],$seller_message,'1307161760258221353');
         
            
            
          

               } else {
                 return 0;
              }

          }

      

            
             $field['total_price']               = $total_final_price;
             $field['final_price']               = $total_final_price;
             $this->db->where('id',$lastId);
             $this->db->update('order_master',$field);
            
                
           $address_data = $this->db->get_where('user_address_master',array('id'=>$data['address_id']))->row_array();

             $addr['order_master_id']           = $lastId;
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

              $this->pdfGenrate($lastId,$link);

               $customer_message = "Dear ".$user_info['username']." Thanks for your order. We've received your order and will update you soon as your order is confirmed by the seller";

          sendSMS($user_info['mobile'],$customer_message,'1307161738031333502');
          $this->order_place_temp($lastId);

            return $oderId;  


       
      }
   
  } 


  public function order_place_temp($order_id){
    
  $OrderDetail = $this->db->get_where('order_master',array('id'=>$order_id))->row_array();
  $user_info   = $this->db->get_where('user_master',array('id'=>$OrderDetail['user_master_id']))->row_array();
  $purchase   = $this->db->get_where('purchase_master',array('order_master_id'=>$order_id))->result_array();
  $address_info   = $this->db->get_where('order_address_master',array('order_master_id'=>$order_id))->row_array();

  $html ='';
 
$html.='<div class="container" style="margin: 0 70px;background-color: white;margin-top:20px;border:4px solid rgb(239,126,45);height: auto;padding: 20px;border-radius: 10px;font-size: 15px;">
    <img class="img-fluid" src="https://shopmet.com/assets/img/logo2.png" alt="Shopmet" style="position: absolute;top: 0;height: 42px;width: 200px;">
    <div class="billing-head" style="margin: 0px;float: right;font-size: 15px;font-weight: 500;">
      <div class="row" >
        <div class="col-12"><p style="margin: 0px;float: right;font-size: 15px;font-weight: 500;">Order Placed</p></div>
        <div class="col-12"><p style="margin: 0px;float: right;font-size: 15px;font-weight: 500;">Order No. <span>'.$OrderDetail['order_number'].'</span></p></div>
      </div>  
    </div>
    <div class="row" style="padding:1em 1em 0;">
      <div class="col-12"><span style="font-size:17px;
      font-weight: 500;">Hello '.$user_info['username'].',</span><p style="text-indent: 3em;">Your order no. '.$OrderDetail['order_number'].' has been confirmed by the seller and ready for the shipping. Once your shipment is ready we will notify you with order tracking details.</p></div>
      <!--  <div class="col-12"><p>Order No. <span>'.$OrderDetail['order_number'].'</span></p></div> -->
    </div>
    <section style=" padding: 0px 10% 0 10%; margin: 5px 0px 10px;">
    <h3>Order Details <span style="font-size:17px;font-weight: 700;padding-left: 10em;"><h3>';
    

   foreach ($purchase as $key => $purchase) { 

          $product = $this->db->get_where('sub_product_master',array('id'=>$purchase['product_master_id']))->row_array();

          $array_url  = parse_url($product['main_image']);

              if(empty($array_url['host'])) {
                $img_url= base_url().'/assets/product_images/'.$product['main_image'];
              } else {
                $img_url ='https://'.$array_url['host'].''.$array_url['path'].'?raw=1';
              }

    $html.='
    <ul style="display: flex;list-style-type: none">
      <li>
      <img class="product-img" src="'.$img_url.'" alt="Product Image" style="height: 150px;width: 185px;border: 0.01em solid #666;padding: 8px;border-radius: 10px;">
      </li>
      <li style="padding-left: 5em;">
        <p style="font-size:15px;font-weight: 600;">'.$product['product_name'].'</p>
        <p style="font-size:15px;font-weight: 600;">Size: '.$purchase['size'].'</p>
        <p style="font-size:15px;font-weight: 600;">Color: '.$purchase['color'].'</p>
        <p style="font-size:15px;font-weight: 600;">QTY: '.$purchase['quantity'].'</p>
      </li>
    </ul>';


  }
    $html.='</section>
      <table style="width:100%; padding: 0px 10% 0 13%; margin: 5px 0px 10px;">
    
      <tr>
        <td><span style="font-size:19px;font-weight: 500;">Price</span></td>
        <td style="padding-left: 10em"> '.$OrderDetail['total_price'].'</td>

      </tr>
      <tr>
        <td><span style="font-size:19px;font-weight: 500;">Shipping Charges</span></td>
        <td style="padding-left: 10em"> 0</td>
      </tr>
      <tr>
        <td><span style="font-size:19px;font-weight: 500;">Discount</span></td>
        <td style="padding-left: 10em"> 0</td>
      </tr>
      <tr>
        <td><span style="font-size:19px;font-weight: 500;">Total</span></td>
        <td  style="padding-left: 10em"> '.$OrderDetail['final_price'].'</td>
      </tr>
    </table>


    <table style="width:100%; padding: 0px 10% 0 11%; margin: 5px 0px 10px;border: 1.5px solid rgb(239,126,45); padding-bottom: 17px;background: #f5f5f5;">
      <tr>
        <td><img src="https://shopmet.com/assets/flow.png" alt="Request Flow" style="height: 65px;width:55%;margin-bottom: 10px;"></td>
        <td><span style="padding-top:1em;font-size:15px;font-weight: 500;">Delivery Details</span></td>
      </tr>
      <tr>
        <td><span style="font-size:15px;font-weight: 600;padding-left: 20px;">Expected Delivery: '.date('d M, Y', strtotime('+10 day', $OrderDetail['add_date'])).'</span></td>
        <td><span style="font-size:15px;font-weight: 500;">User Name: <span>'.$user_info['username'].'</span></p></span>
        </tr>
      <tr>
        <td><span style="font-size:15px;font-weight: 600;padding-left: 20px;"> Order Placed On ('.date("d M, Y",
$OrderDetail['add_date']).')</span></td>
        <td><span style="font-size:15px;font-weight: 500;">Address:<span>'.$address_info['address'].'</span></span></td>
      </tr>
      <tr>
        <td></td>
        <td><span style="font-size:15px;font-weight: 500;">Location:<span>'.$address_info['city'].','.$address_info['state'].'</span></span></td>
      </tr>
    </table>
  
   <table style="width:100%;padding: 0px 10% 0 13%; margin: 5px 0px 10px;">
      
      <tr>
        <td><img src="https://shopmet.com/assets/img/logo2.png" alt="Shopmet" style="height: 38px;width: 100px;"></td>
        <td><img src="https://shopmet.com/assets/google_play.png" alt="Shopmet" style="width:100px;margin-top:-12px;"></td>
        <td><a href="https://www.facebook.com/infoshopmet"><img src="https://shopmet.com/assets/facebook.png" alt="Shopmet" style="height: 36px;width: 42px;background: transparent;margin-right: 16px;"></a>
          <a href="https://www.instagram.com/shopmet_official"><img src="https://shopmet.com/assets/instagram.png" alt="Shopmet" style="height: 36px;width: 42px;background: transparent;margin-right: 16px;"></a>
          <a href="https://twitter.com/infoshopmet"><img src="https://shopmet.com/assets/twitter.jpg" alt="Shopmet" style="height: 36px;width: 42px;background: transparent;margin-right: 16px;"></a></td>
      </tr>
    </table>
  </div>';







   $this->sentCommonEmail2($user_info['email_id'],$html,'Order Place Successfully.');




  

}

function sentCommonEmail2($email,$smsmessage,$sub){
        // ++++++++++++++
      $to      = $email;
      $subject = $sub;
      $message .="Note - This is a System Generated Mail, please do not reply.\r\n";
      $headers = "From:"."shopmetcs@gmail.com"."\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-type: text/html; charset=utf-8\r\n";
      mail($to,$subject,$smsmessage,$headers);
     return 1;
}



function pdfGenrate($pakage_master_id,$pdfFilePath) {
    
        error_reporting(0);
        $OrderDetail  = $this->db->order_by('id','desc')->get_where('order_master',array('id'=>$pakage_master_id))->row_array();

        $getProduct = $this->db->get_where('purchase_master', array('order_master_id'=>$pakage_master_id))->result_array();


         $getAddress = $this->db->get_where('order_address_master', array('order_master_id'=>$pakage_master_id))->row_array();


         $getShippingVal = $this->db->get_where('settings', array('id'=>'1'))->row_array();

        

        
        $link         = time()."-invoice.pdf";
        $html  = '';
        $html .= '<h1 style="text-align:center"><u>Invoice</u></h1>';
        $html .= '<div style="float:left;width:100%; margin-top:20px;"><div style="float:left;width:70%"><div class="image"><h3>ASAM SHOPMET PRIVATE LIMITED</h3></div><div style="margin-left: 30px; top: -60px" > 
                <div style="margin-left: 140px !important;"></div></div></div><div style="float:left;width:30%;"><div><b style="font-size:15px;"> Order No &nbsp;:</b></b>&nbsp;'.$OrderDetail['order_number'].'</div><br><b style="font-size:15px;"> Order Date :</b>&nbsp;'.date('d-m-Y',$OrderDetail['add_date']).' </div>
         </div></div>';

       $total1 = 0;
       $total  = 0;
       $i      = 1;
       
       foreach ($getProduct as $key => $value) { 
         $total+= $value['price']*$value['quantity'];  
       }
           
          $TotalValue = $total;




        $html .= '<div style="width:100%; margin-top:10px;"><div style="width:70%;float:left;"><b>Delivery Address : </b><br> '.ucwords($getAddress['title']).'<br>'.$getAddress['contact_person'].', '.$getAddress['address'].', '.$getAddress['localty'].'<br>'.$getAddress['city'].', '.$getAddress['state'].' .<br> <b>Pincode</b> '.$getAddress['pincode'].'<br> <b>Mob. No.</b>'.$getAddress['mobile_number'].'</div>
        <div style="width:30%;float:right"><b font-size:13px;> Total Item&nbsp;&nbsp;&nbsp;: </b>'.count($getProduct).'<br><br><b font-size:13px;> Total Value Rs : </b>'.$TotalValue.'/- </div></div>';




        $html .= '<div style="float:left;width:100%; margin-top:50px;"><table width="100%" border="1"><tr><th width="60px;">Sr. No.</th><th>Product&nbsp;List</th><th>Unit&nbsp;Price</th><th>quantity</th><th>Size</th><th>Color</th><th>Total Amount</th></tr>';
       $total1 = 0;
       $total  = 0;
       $i      = 1;
        foreach ($getProduct as $key => $value) {
        
           $html .= '<tr><td>'.$i.'.</td><td>'.$value['product_name'].'</td><td>'.$value['price'] .'</td><td>'.$value['quantity'].'</td><td>'.$value['size'].'</td><td>'.$value['color'].'</td><td>Rs. '.$value['price']*$value['quantity'].'/-</td></tr>';
       
       
           $i++;
          $total += $value['price']*$value['quantity'];
          
         }


      $shippingAmount = '0';           
      $TotalValue = $total + $shippingAmount;
                  
       $html .= '<tr><td colspan="6">Total</td><td>Rs. '.$total.'/-</td></tr>';

       $html .=  '</table></div>';
       $html .= '<div style="float:left;width:100%; margin-top:50px;"><div style="float:left;width:60%"></div><div style="float:right;width:40%"><table><tr><td><p style="font-size:14px;"><b>Grand Total Rs</b></p></td><td></td><td>'.$total.'/-</td></tr><tr><td><p style="font-size:14px;">Shipping & Delivery Charge Rs</p></td><td> </td><td>'.$shippingAmount.'/-</td></tr><tr><td><p style="font-size:14px;">Total Value Rs</p></td><td> </td><td><b>'.$TotalValue.'/-</b></td></tr></table>

        <p style="color:red">Note: Including Shipping Charges and taxes.</p></div></div>';

      $html .= '<div style="float:left;width:70%;margin-left:40%"><table><tr><td><p style="font-size:18px;">Thank you...</p>Order By - </td><td><div class="image" style="margin-top:4px;"><br><h4>Shopmet</h4></div><div style="top: -60px">
        </div></td></tr></table></div>
      ';        

      $html .= '<br><p style="text-align:center;">(This is a system generated invoice and does not require a signature.)</p>';
        $pdfFilePath =  INVOICE_DIRECTORY.$pdfFilePath;

        $this->load->library('m_pdf');
        $this->m_pdf->pdf->autoScriptToLang = true;
        $this->m_pdf->pdf->autoLangToFont = true;
        $PDFContent = mb_convert_encoding($html, 'utf-8', 'A4-C');
        $this->m_pdf->pdf->WriteHTML($PDFContent);
        $this->m_pdf->pdf->Output($pdfFilePath, "F");

        $this->db->where('user_master_id',$OrderDetail['user_master_id']);
        $this->db->delete('mycart_master');
    }




public function OrderList($request) {
    $this->db->order_by('id','DESC');
    $isOrderExist = $this->db->get_where('order_master',array('user_master_id'=>$request['userId']))->result_array();
     if(count($isOrderExist) > 0) {
            foreach ($isOrderExist as  $value) {                     
                     $temp = array();
                     $arr['id']            =  $value['id'];
                     $arr['order_id']      =  $value['order_number'] ;                   
                     $arr['total_price']   =  $value['final_price'] ;
                     $arr['status']        =  $value['status'] ;
                     $arr['add_date']      =  date("d M, h:i A",$value['add_date']) ;
                     $arr['modify_date']   =  $value['modify_date'];
                     $post[] = $arr;                      
                  }
                
                $response['OrderList'] = $post;                                
                generateServerResponse('1','103',$response);


           } else { 
            generateServerResponse('0', '102');
        }          
}




public function orderDetails($request){

   $isOrderExist = $this->db->get_where('order_master',array('order_number'=>$request['orderId']))->row_array();

  $time_ago=date("Y-m-d H:i:s", $isOrderExist['modify_date']);
  $time_ago = strtotime($time_ago);
  $cur_time   = time();
  $time_elapsed   = $cur_time - $time_ago;
  $days  = round($time_elapsed / 86400 );
  

    

     $response['order_id']                  = $isOrderExist['id'];
     $response['order_number']              = $isOrderExist['order_number'];
     $response['user_master_id']            = $isOrderExist['user_master_id'];
     $response['total_price']               = $isOrderExist['total_price'];
     $response['final_price']               = $isOrderExist['final_price'];
     $response['order_date']                = $isOrderExist['add_date'];
     $response['order_satatus']             = $isOrderExist['status'];

    $user_info = $this->db->get_where('user_master',array('id'=>$isOrderExist['user_master_id']))->row_array();

    $addressInfo = $this->db->get_where('order_address_master',array('order_master_id'=>$isOrderExist['id']))->row_array();
    
    $purchse = $this->db->get_where('purchase_master',array('order_master_id'=>$isOrderExist['id']))->result_array();
   $response['total_Items']             = count($purchse);


  $address['id']                         =      $addressInfo['id'];
  $address['order_master_id']            =      $addressInfo['order_master_id'];
  $address['title']                      =      $addressInfo['title'];
  $address['contact_person']             =      $addressInfo['contact_person'];
  $address['mobile_number']              =      $addressInfo['mobile_number'];
  $address['alternate_number']           =      $addressInfo['alternate_number'];
  $address['address']                    =      $addressInfo['address'];
  $address['localty']                    =      $addressInfo['localty'];
  $address['landmark']                   =      $addressInfo['landmark'];
  $address['pincode']                    =      $addressInfo['pincode'];
  $address['city']                       =      $addressInfo['city'];
  $address['state']                      =      $addressInfo['state'];
  


  
  $address_info                 = array();
  $address_info[]               = $address;

         $post = array();
         foreach ($purchse as  $purchse) {                     
                    $temp = array();
              $value = $this->db->get_where('sub_product_master',array('id'=>$purchse['product_master_id']))->row_array(); 
             

               
              $product['product_id']          = $value['id'];
              $product['sku_code']            = $value['sku_code'];
              $product['product_name']        = $value['product_name'];
              $product['size']                = $value['size'];
              $product['color']               = $value['color'];
              $product['brand']               = $value['brand'];
              $product['price']               = $purchse['price'];
              $product['final_price']         = $purchse['final_price'];
              $product['quantity']            = $purchse['quantity'];
              $product['main_image']          = $value['main_image'];
              $product['image1']              = $value['image1'];
              $post[]  = $product;          
          }

          $response['ShippingAddress'] = $address_info;                               
          $response['ProductList'] = $post;                               
          generateServerResponse('1','103',$response);

}



/*By this function Get All Reasion*/
public function getReason() {
    $isStateExist = $this->db->get_where('reason_master')->result_array();
     if(count($isStateExist) > 0) {
            foreach ($isStateExist as  $value) {                     
                     $temp = array();
                     $arr['id']       =  $value['id'];                
                     $arr['reason']   =  $value['reason'] ;                   
                     $post[] = $arr;                      
                  }
                
                $response['reasonList'] = $post;                                
                generateServerResponse('1','103',$response);


           } else { 
            generateServerResponse('0', '102');
        }          
}

/*By this function Get All Tag */
public function getTag() {

    $tag1 = $this->db->get_where('tag_master',array('id'=>'1'))->row_array();
    $tag2 = $this->db->get_where('tag_master',array('id'=>'2'))->row_array();
    $tag3 = $this->db->get_where('tag_master',array('id'=>'3'))->row_array();
    
     $response['tag1']   =  $tag1['name'];                
     $response['tag2']   =  $tag2['name'];                   
     $response['tag3']   =  $tag3['name'];                   
                    
    generateServerResponse('1','103',$response);

         
}



public function GetSubCategory($request){

$sub_category_list = $this->db->get_where('sub_category_master',array('status'=>'1','category_master_id'=>$request['category_id']))->result_array();
         $hold_sub = array();
               foreach ($sub_category_list as $key => $sub_category_list) {
                
                  $sub_category['Id']     = $sub_category_list['id'];
                  $sub_category['Name']   = $sub_category_list['sub_category_name'];
                  $sub_category['Thumb']  = base_url().'/assets/category_images/'.$sub_category_list['app_icon'];
                  $hold_sub[]    = $sub_category;
               }

             $response['SubCategory'] = $hold_sub;
        if (count($response['SubCategory']) > 0) {
          generateServerResponse('1','103',$response);
        } else {
          generateServerResponse('0','102');
     }


}





/*By this function Get All Category*/
public function getAllCategory() {
   

    $main_category = $this->db->get_where('parent_category_master',array('status'=>'1'))->result_array();

     if(count($main_category) > 0) {
       $hold_main_category = array();
      foreach ($main_category as $key => $main_cate) {
        $fields['Id']     = $main_cate['id'];
        $fields['Name']   = $main_cate['name'];
        
        

        $this->db->select('id,category_name,app_icon');
        $categoryList =  $this->db->get_where('category_master',array('status'=>'1','mai_id'=>$main_cate['id']))->result_array();
       
           $hold_category = array();
            foreach ($categoryList as $key => $categoryList) {
               
               $sub_category_list = $this->db->get_where('sub_category_master',array('status'=>'1','category_master_id'=>$categoryList['id']))->result_array();

             $category['Id']     = $categoryList['id'];
             $category['Name']   = $categoryList['category_name'];
             $category['Thumb']  = base_url().'/assets/category_images/'.$categoryList['app_icon'];
            


               $hold_sub = array();
               foreach ($sub_category_list as $key => $sub_category_list) {
                  $sub_category['Id']     = $sub_category_list['id'];
                  $sub_category['Name']   = $sub_category_list['sub_category_name'];
                  $sub_category['Thumb']  = base_url().'/assets/category_images/'.$sub_category_list['app_icon'];
                  $hold_sub[]    = $sub_category;
               }


             $category['SubCategory'] = $hold_sub;
             
              $hold_category[]    = $category;



            }

           $fields['categoryList']  = $hold_category;
           $hold_main_category[]    = $fields;
            

          }  

          
           $response['MaincategoryList'] = $hold_main_category;                                 
            generateServerResponse('1','103',$response);


           } else { 
            generateServerResponse('0', '102');
        }          
}



public function CancelSingleProduct($request){
  $oder = $this->db->get_where('order_master',array('order_number'=>$request['orderId']))->row_array();

       

   $check = $this->db->query("SELECT id FROM purchase_master where order_master_id=".$oder['id']." AND status='1'")->num_rows();

   $get_product_price = $this->db->get_where('purchase_master',array('order_master_id'=>$oder['id'],'product_master_id'=>$request['productId']))->row_array();

 $product_info = $this->db->get_where('sub_product_master',array('id'=>$request['productId']))->row_array();



     if($check == '1') {

         $fileds['quantity'] = $product_info['quantity']+$get_product_price['quantity'];
          $this->db->where('id',$request['productId']);   
          $this->db->update('sub_product_master',$fileds);   

            /* Update Order table Status*/
                  $status['status']            = '4';
                  $status['reasonId']          = $request['reasonId'];
                  $status['remark']            = $request['remark'];
                  $this->db->where('id',$oder['id']);
                  $this->db->update('order_master',$status);

         /*Update Purchase Status*/
                  $statuss['status'] = '4';
                  $statuss['reasonId'] = $request['reasonId'];
                  $statuss['remark']   = $request['remark'];
                  $this->db->where('id',$get_product_price['id']);
                  $this->db->update('purchase_master',$statuss);

               $response['order_id'] = $request['orderId'];
              generateServerResponse('1','235',$response);
        

   } else {

    $perchase = $this->db->get_where('purchase_master',array('order_master_id'=>$oder['id'],'product_master_id'=>$request['productId']))->row_array();

      $price['total_price'] = $oder['total_price']-$perchase['final_price'];
      $price['final_price'] = $oder['final_price']-$perchase['final_price'];
  
      $this->db->where('id',$oder['id']);
      $this->db->update('order_master',$price);


          $fileds['quantity'] = $product_info['quantity']+$perchase['quantity'];
          $this->db->where('id',$request['productId']);   
          $this->db->update('sub_product_master',$fileds);

       

            /* Update Purchase table Status*/
              $status['reasonId'] = $request['reasonId'];
              $status['remark']   = $request['remark'];
              $status['status']   = '4';
              $this->db->where('id',$get_product_price['id']);
              $this->db->update('purchase_master',$status);
              $response['order_id'] = $request['orderId'];
              generateServerResponse('1','236',$response);




   }

}


public function CancelOrder($request){
  $oder = $this->db->get_where('order_master',array('order_number'=>$request['orderId']))->row_array();

       
            /* Update Order table Status*/
                  $status['status']            = '4';
                  $status['reasonId']          = $request['reasonId'];
                  $status['remark']            = $request['remark'];
                  $this->db->where('id',$oder['id']);
                  $this->db->update('order_master',$status);

         /*Update Purchase Status*/
                  $statuss['status'] = '4';
                  $statuss['reasonId'] = $request['reasonId'];
                  $statuss['remark']   = $request['remark'];
                  $this->db->where('order_master_id',$oder['id']);
                  $this->db->update('purchase_master',$statuss);

               $response['order_id'] = $request['orderId'];
              generateServerResponse('1','235',$response);
        

   

}



public function getVersions() { 
        $check = $this->db->get('settings')->row_array();
        $fields = array();
        $fields['version']   = $check['app_verison'];
        $fields['type']      = $check['type'];
        $fields[STATUS]      = "1";
      if(COUNT($check) > 0){ 
          generateServerResponse(S,'S',$fields);   
      } else {
          generateServerResponse('0','102');
      }         
 }



public function updateProfilePicture($data){
  $query = $this->db->get_where('user_master', array('id'=>$data['user_id']))->row_array();
       if(!empty($data['profile_pic'])){
              $image          = $data['profile_pic'];
              $get_http = explode(':',$image);
              if($get_http[0] == 'https') {
                $pic      =   $query['profile_pic'];
              } else {

               $pic = saveProfilesImage1($data['profile_pic']);
              }

              } else {
                 $pic = $query['profile_pic'];
              }
              $field['profile_pic']         = $pic;
              $field['username']            = $data['username'];
              $field['email_id']            = $data['email_id'];
              $field['mobile']              = $data['mobile'];
              $field['whatsaap_number']     = $data['whatsaap_number'];
              $field['alternate_number']    = $data['alternate_number'];
              $field['address']             = $data['address'];
              $field['locality']            = $data['locality'];
              $field['city']                = $data['city'];
              $field['state']               = $data['state'];
              $field['pincode']             = $data['pincode'];
              $this->db->where('id',$data['user_id']);
              $this->db->update('user_master',$field);

 $check = $this->db->get_where('user_master', array('id'=>$data['user_id']))->row_array();


   if(!empty($check)){
         
           $response['userId']             = $check['id'];
           $response['userName']           = $check['username'];
           $response['email']              = $check['email_id'];
           $response['mobile']             = $check['mobile'];
           $response['profile_pic']        = base_url().'assets/profile_image/'.$check['profile_pic'];
           $response['whatsaap_number']    = $check['whatsaap_number'];
           $response['alternate_number']   = $check['alternate_number'];
           $response['address']            = $check['address'];
           $response['locality']           = $check['locality'];
           $response['city']               = $check['city'];
           $response['state']              = $check['state'];
           $response['pincode']            = $check['pincode'];
           $response['password']           = $check['password'];
           $response['wallet_amount']      = $check['wallet_amount'];
           
          generateServerResponse('1', '171',$response);

       } else {

         generateServerResponse('0', '222'); 

      }

}


public function forgotPassword($request) {
 
  if($request['newPassword']== $request['confPassword']) {

   $fields['password'] = $request['newPassword'];
   $this->db->where('mobile',$request['mobile']);
   $this->db->update('user_master',$fields);
   $response['mobile'] = $request['mobile'];
   generateServerResponse(S,'220',$response);

  } else {
    
   generateServerResponse(0,'240');
   
  }  



}

public function forgotPasswordOtp($request){
 $check = $this->db->get_where('user_master',array('mobile'=>$request['mobile']))->row_array();

 if(!empty($check)){
     $chars = "0123456789";
     $otp = substr(str_shuffle($chars), 0, 6);
	 
	 
	 
  // $message ="Dear ".$check['username'].", Your Forgot password OTP is ".$otp." Thanks. ASAM SHOPMET PRIVATE LIMITED.";
   
   //New
   
  // $message ="Otp Test";
  
  $message = $otp. " is your One Time Password (OTP) You can now reset your password with the given otp! - From www.shopmet.com";
  // $message = $otp." is your One Time Password (OTP) You can now reset your password with the given otp! - From www.shopmet.com";
   sendSMS($request['mobile'],$message,'1307161782605117278');
   $fields['otp'] = $otp;
   $this->db->where('mobile',$request['mobile']);
   $this->db->update('user_master',$fields);
   $response['mobile'] = $request['mobile'];
   generateServerResponse(S,'127',$response);

 } else {

   generateServerResponse(0,'106');

 }

}


public function verifyOtp($request){

$check = $this->db->get_where('user_master',array('mobile'=>$request['mobile'],'otp'=>$request['otp']))->row_array();

if(!empty($check)){
   $response['mobile'] = $request['mobile'];
   $response['otp']    = $request['otp'];
   generateServerResponse(S,'239',$response);

 } else {

   generateServerResponse(0,'130');

 }


}






public function showAllProduct($request) {

    $this->db->select('product_ids');
    $tag  = $this->db->get_where('tag_master', array('id' => $request['tag']))->row_array(); 
    $product_ids = json_decode($tag['product_ids'],true);


   $this->db->select('id,size,color,category_id,sub_category_id,product_name,price,final_price,main_image,sku_code');
   $this->db->where_in('id',$product_ids);
   $ProductList = $this->db->get_where('sub_product_master', array('status' => 1))->result_array(); 


    

      $hold_product  = array();

       foreach ($ProductList as $key => $product) {
         $this->db->select('category_name');
         $category =  $this->db->get_where('category_master',array('id'=>$product['category_id']))->row_array();

         $this->db->select('id');
         $wish = $this->db->get_where('wishlist_master',array('product_master_id'=>$product['id'],'user_master_id'=>$request['user_id']))->row_array();

         $fields['Id']               = $product['id'];
         $fields['Category']         = $category['category_name'];
         $fields['SKU']              = $product['sku_code'];
         $fields['Color']            = $product['color'];
         $fields['Size']             = $product['size'];
         $fields['ProductName']      = $product['product_name'];
         $fields['RegularPrice']     = $product['final_price'];
         $fields['MRP']              = $product['price'];
     //    $fields['ImagePrimary']     = $product['main_image'];
         $fields['Tags']             = $request['tag'];

//*********************************************************************************************************** 
          $array_url  = parse_url($product['image']);

          if(empty($array_url['host'])) { 

          $fields['ImagePrimary']     = base_url().'/assets/product_images/'.$product['main_image'];

          } else {

           $fields['ImagePrimary']     = $product['main_image'];

          }

//***********************************************************************************************************           

         if(!empty($wish)) {
            $fields['WishlistStatus']   = 'true';
            $fields['WishlistId']       = $wish['id'];
         } else {
           $fields['WishlistStatus']   = 'false';
           $fields['WishlistId']        = '';
         }
         
        $hold_product[]               = $fields;
       }

       $response['Products'] = $hold_product; 


       if (!empty($ProductList)) {
            generateServerResponse('1','103',$response);
          } else {
            generateServerResponse('0','102');
       }

}




public function showAllCategoryProduct($request) {

        $offset = '';
        $limit = 10;
        if($request['pageindex'] == '')
        {     
          $offset = 0;
        }else
        {
          $offset = $request['pageindex'];     
          
        }


  $this->db->limit($limit,$offset);
  $this->db->group_by('product_code');

  if($request['category_id']=='9' OR $request['category_id']=='29' OR $request['category_id']=='2' OR $request['category_id']=='1') {

      $totalProductList = $this->db->get_where('sub_product_master',array('status'=>'1','sub_category_id'=>$request['category_id']))->result_array();

  } else {

     $totalProductList = $this->db->get_where('sub_product_master',array('status'=>'1','category_id'=>$request['category_id']))->result_array();

  }
       
        

      $hold_product  = array();

       foreach ($totalProductList as $key => $product) {
         $this->db->select('category_name');
         $category =  $this->db->get_where('category_master',array('id'=>$product['category_id']))->row_array();

         $this->db->select('id');
         $wish = $this->db->get_where('wishlist_master',array('product_master_id'=>$product['id'],'user_master_id'=>$request['user_id']))->row_array();

         $fields['Id']               = $product['id'];
         $fields['Category']         = $category['category_name'];
         $fields['SKU']              = $product['sku_code'];
         $fields['Color']            = $product['color'];
         $fields['Size']             = $product['size'];
         $fields['ProductName']      = $product['product_name'];
         $fields['RegularPrice']     = $product['final_price'];
         $fields['MRP']              = $product['price'];

//*********************************************************************************************************** 
          $array_url  = parse_url($product['image']);

          if(empty($array_url['host'])) { 

          $fields['ImagePrimary']     = base_url().'/assets/product_images/'.$product['main_image'];

          } else {

           $fields['ImagePrimary']     = $product['main_image'];

          }

//***********************************************************************************************************          

         if(!empty($wish)) {
            $fields['WishlistStatus']   = 'true';
            $fields['WishlistId']       = $wish['id'];
         } else {
           $fields['WishlistStatus']   = 'false';
           $fields['WishlistId']        = '';
         }
         
        $hold_product[]               = $fields;
       }




      $response['pageindex'] = $request['pageindex'] + count($totalProductList); 
        $response['ProductList'] = $hold_product; 
        if (count($response['ProductList']) > 0) {
          generateServerResponse('1','103',$response);
        } else {
          generateServerResponse('0','102');
     }


}


/* Searching Data By Keyword*/    
public function SearchData($request) {

        $order = '';
        $offset = '';
        $limit = 10;
        if($request['pageindex'] == '')
        {     
          $offset = 0;
        }else
        {
          $offset = $request['pageindex'];     
          
        }

       

                      
        $this->db->like('product_name',$request['keyword']);
        $this->db->or_like('size',$request['keyword']); 
        $this->db->or_like('color',$request['keyword']); 
        $this->db->or_like('brand',$request['keyword']); 
        $this->db->or_like('sku_code',$request['keyword']); 
        $this->db->limit($limit,$offset);
        $this->db->group_by('product_code');
        $totalProductList = $this->db->get_where('sub_product_master',array('status'=>'1'))->result_array();
       
      
       
        $hold_product  = array();

       foreach ($totalProductList as $key => $product) {
         $this->db->select('category_name');
         $category =  $this->db->get_where('category_master',array('id'=>$product['category_id']))->row_array();

         $this->db->select('id');
         $wish = $this->db->get_where('wishlist_master',array('product_master_id'=>$product['id'],'user_master_id'=>$request['user_id']))->row_array();

         $fields['Id']               = $product['id'];
         $fields['Category']         = $category['category_name'];
         $fields['SKU']              = $product['sku_code'];
         $fields['Color']            = $product['color'];
         $fields['Size']             = $product['size'];
         $fields['ProductName']      = $product['product_name'];
         $fields['RegularPrice']     = $product['final_price'];
         $fields['MRP']              = $product['price'];
    //   $fields['ImagePrimary']     = $product['main_image'];

//*********************************************************************************************************** 
          $array_url  = parse_url($product['image']);

          if(empty($array_url['host'])) { 

          $fields['ImagePrimary']     = base_url().'/assets/product_images/'.$product['main_image'];

          } else {

           $fields['ImagePrimary']     = $product['main_image'];

          }

//*********************************************************************************************************** 

  
         

         if(!empty($wish)) {
            $fields['WishlistStatus']   = 'true';
            $fields['WishlistId']       = $wish['id'];
         } else {
           $fields['WishlistStatus']   = 'false';
           $fields['WishlistId']        = '';
         }
         
        $hold_product[]               = $fields;
       }




      $response['pageindex'] = $request['pageindex'] + count($totalProductList); 
        $response['SearchProductList'] = $hold_product; 
        if (count($response['SearchProductList']) > 0) {
          generateServerResponse('1','103',$response);
        } else {
          generateServerResponse('0','102');
     }

}







public function returnOrder($request) {
  
   $oder = $this->db->get_where('order_master',array('order_number'=>$request['orderId']))->row_array();
    $this->db->select('username,mobile');
    $user =$this->db->get_where('user_master',array('id'=>$oder['user_master_id']))->row_array();

   $check = $this->db->query("SELECT id FROM purchase_master where order_master_id=".$oder['id']."")->num_rows();

   $get_product_price = $this->db->get_where('purchase_master',array('order_master_id'=>$oder['id'],'product_master_id'=>$request['productId']))->row_array();

 $product_info = $this->db->get_where('sub_product_master',array('id'=>$request['productId']))->row_array();

  $reason=$this->db->get_where('reason_master',array('id'=>$request['reasonId']))->row_array();


     if($check == '1') {
            /* Update Order table Status*/
                  $status['status']         = '7';
                  $status['reasonId']    = $request['reasonId'];
                  $status['remark']      = $request['remark'];
                  $this->db->where('id',$oder['id']);
                  $this->db->update('order_master',$status);

         /*Update Purchase Status*/
                  $statuss['status'] = '7';
                  $statuss['reasonId'] = $request['reasonId'];
                  $statuss['remark']   = $request['remark'];
                  $this->db->where('id',$get_product_price['id']);
                  $this->db->update('purchase_master',$statuss);


              $message = "Dear ".$user['username'].", we regret to inform you the return request of your product: ".$product_info['product_name']." And Order ID: #".$request['orderId']."";

                sendSMS($user['mobile'],$message);

               $response['order_id'] = $request['orderId'];
              generateServerResponse('1','238',$response);
        

   } else {

    $perchase = $this->db->get_where('purchase_master',array('id'=>$get_product_price['id']))->row_array();

            /* Update Purchase table Status*/
              $status['reasonId'] = $request['reasonId'];
              $status['remark']   = $request['remark'];
              $status['status']   = '7';
              $this->db->where('id',$get_product_price['id']);
              $this->db->update('purchase_master',$status);
              $response['order_id'] = $request['orderId'];

              $message = "Dear ".$user['username'].", we regret to inform you the return request of your product: ".$product_info['product_name']." And Order ID: #".$request['orderId']."";

                sendSMS($user['mobile'],$message);

              generateServerResponse('1','237',$response);
        



   }

} 


public function returnFullyOrder($request) {
  
   $oder = $this->db->get_where('order_master',array('order_number'=>$request['orderId']))->row_array();
    $this->db->select('username,mobile');
    $user =$this->db->get_where('user_master',array('id'=>$oder['user_master_id']))->row_array();


  $reason=$this->db->get_where('reason_master',array('id'=>$request['reasonId']))->row_array();


   
            /* Update Order table Status*/
                  $status['status']         = '7';
                  $status['reasonId']    = $request['reasonId'];
                  $status['remark']      = $request['remark'];
                  $this->db->where('id',$oder['id']);
                  $this->db->update('order_master',$status);

         /*Update Purchase Status*/
                  $statuss['status'] = '7';
                  $statuss['reasonId'] = $request['reasonId'];
                  $statuss['remark']   = $request['remark'];
                  $this->db->where('order_master_id',$oder['id']);
                  $this->db->update('purchase_master',$statuss);


              $message = "Dear ".$user['username'].", we regret to inform you the return request of your  Order ID: #".$request['orderId']."";

                sendSMS($user['mobile'],$message);

               $response['order_id'] = $request['orderId'];
              generateServerResponse('1','238',$response);
        

   

}






}


  


