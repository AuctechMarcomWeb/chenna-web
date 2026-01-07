<?php
class Product_model extends CI_Model {
	 public function __construct(){
		parent::__construct();
		$this->load->database();
	}

  public function getProduct($type ='',$id='' )
    {
    
      $this->db->order_by('id','DESC');

      if($type!=2){
         if($id!=''){
            /*echo $id; exit;*/

            return $this->db->get_where('product_master',array('added_by_id'=>$id,'reference' => '0'))->result_array();
           }else{
            return $this->db->get_where('product_master',array('reference' => '0'))->result_array();
            }
      } else {

       
        return $this->db->get_where('product_master', array('added_by_id'=>$id, 'reference' => '0'))->result_array();
        
      }
    }

    public function getImage($product_id)
    {
      $sql = "SELECT * FROM `product_images_master` WHERE `product_master_id` = '".$product_id."'";
      $query = $this->db->query($sql)->row_array();
      return $query['product_image'];
    }

  public function getCatgyList(){
    $this->db->order_by('category_name','Asc');
    return $this->db->get_where('category_master')->result_array();    
    }
  public function GetUnit(){
    $this->db->order_by('unit_name','Asc');
    return $this->db->get_where('unit_master')->result_array();    
    }


    
   public function getCatName($id ='')
  {
    $sql =  $this->db->query("SELECT * FROM `category_master` Where id = '".$id."'")->row_array();
    return $sql['category_name'];
  }

  public function getSCatName($id='')
  {
    $sql =  $this->db->query("SELECT * FROM `sub_category_master` Where id = '".$id."'")->row_array();
    return $sql['sub_category_name'];
  }
 
    public function AddProductData($request)
    {

      //echo "<pre>"; print_r($request['reference']); exit;
     
      
      /*$start_date = $request['DOD_Start_Data']."00:00:00";
      $end        = $request['DOD_End_Data']."23:59:59";*/
      $array      = array();

      $array['added_by_id']              = $request['added_by_id'];
      $array['product_unique_id']        = "Prod/".time();
      $array['category_master_id']       = $request['CatId'];
      $array['sub_category_master_id']   = $request['SubCat'];

      $array['brand_master_id']          = $request['BrandID'];
      $array['product_name']             = ucwords($request['ProductName']);
      /*$array['deal_of_day_start']      = ($request['DOD_Start_Data']!='') ? strtotime($start_date):'';
      $array['deal_of_day_end']          = ($request['DOD_End_Data']!='') ?  strtotime($end):'';
      $array['dod_discount_type']        = $request['dealType'];
      $array['dod_amount']               = $request['deal_amountPer'];*/
      $array['product_discount_type']    = $request['DiscounType'];
      $array['product_discount_amount']  = $request['amountPer'];
      $array['price']                    = $request['prod_price'];
      $array['final_price']              = $request['finalPrice'];
      $array['weight_litr']              = $request['whtLtr'];
      $array['unit']                     = $request['unit'];
      $array['quantity']                 = $request['qty']; 
      $array['description']              = $request['Description']; 
      $array['cgst_amount']              = ($request['cgst_amount'] != '') ? $request['cgst_amount'] : ''; 


      $array['sgst_amount']              = ($request['sgst_amount'] != '') ? $request['sgst_amount'] : ''; 

      $array['total_tax_amt']            = ($request['total_tax_amt'] != '') ? $request['total_tax_amt'] : '';
      
      $array['unit_price']               = ($request['unit_price'] != '') ? $request['unit_price'] : ''; 
     
      $array['add_date']                 = time();

      $array['modify_date']              = time();
      $array['status']                   = '1';
      $this->db->insert('product_master',$array);
      $last_id = $this->db->insert_id();
          
        ################# FOR SIMILIAR PRODUCT################ 
       /* if(count($request['reference'])>0)
        {
            foreach ($request['reference'] as $key => $value) {
                $reference['product_discount_type']    = $value['type'];
                $reference['product_discount_amount']  = $value['disc_amt'];
                $reference['price']                    = $value['price'];
                $reference['final_price']              = $value['f_price'];
                $reference['weight_litr']              = $value['whtLtr'];
                $reference['unit']                     = $value['unit'];
                $reference['quantity']                 = $value['qty'];
                $reference['reference']                = $last_id;  

                $reference['add_date']                 = time();
                $reference['modify_date']              = time();
                $reference['status']                   = '1';


                $this->db->insert('product_master',$reference);      
            } 
        }*/

      
      
       if($request['added_by_id']>0) {
       $getVendor = $this->db->get_where('admin_master',array('id'=>$request['added_by_id']))->row_array();
       
       	 $message = urlencode(" Hello Admin, New product is added, Product name : ".ucwords($request['ProductName']).", product added by : ".ucwords($getVendor['name']).""); 
       /* echo $message; exit;*/
       $this->db->select('phone_no');
       $getnumber = $this->db->get_where('admin_master',array('id'=>'1'))->row_array();
        $mobile = urlencode($getnumber); 
      
        $url="http://bulksms.megainfomatix.com/http-api.php?username=lalitmohan&password=123456&senderid=MRNMRS&route=2&number= ".$mobile."&message=".$message;
        //http://bulksms.megainfomatix.com/http-api.php?username=lalitmohan&password=123456&senderid=MRNMRS&route=2&number=".$mobile."&message=".urlencode($message) 

          /*$url = "http://www.wiztechsms.com/http-api.php?username=vishal&password=123@vishal&senderid=FRETAD&route=2&number=".$requestMobile."&message=".urlencode($message);*/
    // $url = "http://138.201.192.131/http-api.php?username=demo&password=demo&senderid=azdemo&route=1&number=".$requestMobile."&message=".urlencode($message);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_exec($ch);
       
       
       }
      
      foreach($_FILES['uploadFile']['name'] as $item => $item_name ){
        $fileName  = $_FILES["uploadFile"]["name"][$item];
        $extension = explode('.',$fileName);
        $extension = strtolower(end($extension));
        $uniqueName= 'prod_'.uniqid().'.'.$extension;
        $type      = $_FILES["uploadFile"]["type"][$item];
        $size      = $_FILES["uploadFile"]["size"][$item];
        $tmp_name  = $_FILES['uploadFile']['tmp_name'][$item];
        $targetlocation = PRODUCT_DIRECTORY.$uniqueName;
      
        if(!empty($fileName)){
        move_uploaded_file($tmp_name, $targetlocation);
        $data['product_image'] = utf8_encode(trim($uniqueName));
       
          $data['product_master_id']  = $last_id;
          $data['add_date']   = time();
          $data['modify_date']= time();
          $data['status']  ='1';
         /* $data['product_image']      = $image;*/
          $this->db->insert('product_images_master',$data);
           } 
      }
     
      return $this->db->affected_rows();
    }

    public function getSingleProductData($id='')
    {
      return $this->db->get_where('product_master',array('id'=>$id))->row_array();
    }

    public function getReferenceData($id='')
    {
      return $this->db->get_where('product_master',array('reference'=>$id, 'status'=>'1'))->result_array();
    }
    public function getSubCatgyList( $id='')
    {
     
      return $this->db->get_where('sub_category_master',array('id'=>$id))->row_array();    
    }
    public function getBrandList()
    {
      $this->db->order_by('brand_name','Asc');
      return $this->db->get_where(' brand_master')->result_array();    
    }

     public function GetProductImages($id='')
     {
        return $this->db->query("SELECT * FROM `product_images_master` where `product_master_id` ='".$id."'")->result_array();
     }

     public  function del_Images($id)
      {
    
       

        $result = $this->db->query("DELETE FROM `product_images_master` WHERE id ='".$id."' ");
      /*  $affected_rows = $this->db->affected_rows();*/
        echo ($result > 0)? '1' :'0';
        
      }

      public function UpdateProductData($request)
    {
     
      
     /* $start_date = $request['DOD_Start_Data']."00:00:00";
      $end        = $request['DOD_End_Data']."23:59:59";*/
      $array = array();

      /*$array['added_by_id']              = "-1";
      $array['product_unique_id']        = "Prod/".time();*/
      $array['category_master_id']       = $request['CatId'];
      $array['sub_category_master_id']   = $request['SubCat'];

      $array['brand_master_id']          = $request['BrandID'];
      $array['product_name']             = ucwords($request['ProductName']);
     /* $array['deal_of_day_start']        = ($request['DOD_Start_Data']!='') ? strtotime($start_date):'';
      $array['deal_of_day_end']          = ($request['DOD_End_Data']!='') ?  strtotime($end):'';
      $array['dod_discount_type']        = $request['dealType'];
      $array['dod_amount']               = $request['deal_amountPer'];*/
      $array['product_discount_type']    = $request['DiscounType'];
      $array['product_discount_amount']  = $request['discountValue'];
      $array['price']                    = $request['prod_price'];
      $array['final_price']              = $request['finalPrice'];
      $array['weight_litr']              = $request['whtLtr'];
      $array['unit']                     = $request['unit'];
      $array['quantity']                 = $request['qty']; 
      $array['description']              = $request['Description']; 
      $array['cgst_amount']              = $request['cgst_amount']; 
      $array['sgst_amount']              = $request['sgst_amount']; 
      $array['total_tax_amt']            = $request['total_tax_amt']; 
      $array['unit_price']               = $request['unit_price']; 
     
      
      $array['modify_date']              = time();
      $this->db->where('id',$request['id']);
      $this->db->update('product_master',$array);
      $last_id = $request['id'];
      
      foreach($_FILES['uploadFile']['name'] as $item => $item_name ){
        $fileName  = $_FILES["uploadFile"]["name"][$item];
        $extension = explode('.',$fileName);
        $extension = strtolower(end($extension));
        $uniqueName= 'prod_'.uniqid().'.'.$extension;
        $type      = $_FILES["uploadFile"]["type"][$item];
        $size      = $_FILES["uploadFile"]["size"][$item];
        $tmp_name  = $_FILES['uploadFile']['tmp_name'][$item];
        $targetlocation = PRODUCT_DIRECTORY.$uniqueName;
      
        if(!empty($fileName)){
        move_uploaded_file($tmp_name, $targetlocation);
        $data['product_image'] = utf8_encode(trim($uniqueName));
          $data['product_master_id']  = $request['id'];
          $data['add_date']   = time();
          $data['modify_date']= time();
          $data['status']  ='1';
         /* $data['product_image']      = $image;*/
          $this->db->insert('product_images_master',$data);
        } 
      }
     
      return $this->db->affected_rows();
    }


    public function GetImages($id='')
    {
      /*echo "SELECT `product_image` from `product_images_master` where  product_master_id ='".$id."' GROUP BY product_master_id "; exit;*/
      $query = $this->db->query("SELECT `product_image` from `product_images_master` where  product_master_id ='".$id."' GROUP BY product_master_id ")->row_array();

     return $query['product_image'];
    }

  public function getproductDeal()
  {
    $id    = $this->uri->segment(4);
    $SQL   = "SELECT * FROM product_master where id = '".$id."'";
    $query = $this->db->query($SQL)->row_array();
    print_r($query);
  }


    public function updateDeal($request){
      /*print_r($request); exit;*/
    // echo $request['type']; exit;
    $start_date = $request['start']."00:00:00";
    $end        = $request['end']."23:59:59";
    $arrayName = array();
    $arrayName['deal_of_day_start']     = ($request['start']!='')? strtotime($start_date) :'';
    $arrayName['deal_of_day_end']       = ($request['end']!='')? strtotime($end):'';
    $arrayName['dod_discount_type']     = $request['offerType'];
    $arrayName['dod_amount']            = $request['amount'];
    $arrayName['modify_date'] = time();
    // print_r($arrayName); exit;
    
      $this->db->where('id',$request['id']);
      $this->db->update('product_master',$arrayName);
      return $this->db->affected_rows();
    
  }
    public function updateCashback($request){
  
    $start_date = $request['start']."00:00:00";
    $end        = $request['end']."23:59:59";
    $arrayName = array();
    $arrayName['cashback_start']     = ($request['start']!='')? strtotime($start_date) :'';
    $arrayName['cashback_end']       = ($request['end']!='')? strtotime($end):'';
    $arrayName['cashback_discount_type']     = $request['offerType1'];
    $arrayName['cashback_amount']            = $request['amount1'];
    $arrayName['modify_date'] = time();
    
      $this->db->where('id',$request['id']);
      $this->db->update('product_master',$arrayName);
      return $this->db->affected_rows();
     }

      public function record_count($table) {
$this->db->where('reference','0');
    return $this->db->count_all($table);
    }

    public function fetch_AllProduct($limit, $start) {
    return $this->db->query("SELECT * FROM product_master WHERE reference = '0' order By id desc LIMIT ".$start.", ".$limit."")->result_array();
    }
  
     public function record_counter($table) {
      $this->db->where('reference','0');
      $keyword = $this->input->post('keyword');
      $this->db->like('product_name',$keyword,'both'); 
    return $this->db->count_all($table);
    }

    public function byKeword_AllProduct($limit, $start) {
       $keyword = $this->input->post('keyword');
     return $this->db->query("SELECT * FROM product_master WHERE reference = '0' and product_name Like '%$keyword%' or description Like '%$keyword%' or final_price Like '%$keyword%' or price Like '%$keyword%' or quantity Like '%$keyword%' or unit Like '%$keyword%' order By id desc LIMIT ".$start.", ".$limit."")->result_array();
     }
      public function AddSubProductData($field) {
     return $this->db->insert('product_master',$field);
     }  

    public function editSubProductData($field,$id) {
            $this->db->where('id',$id);
     return $this->db->update('product_master',$field);
     }
}
 ?>