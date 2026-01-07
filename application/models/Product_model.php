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

            return $this->db->get_where('product_master',array('Type'=>$id,'reference' => '0'))->result_array();
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

   



  public function getBasicInfo(){
   return $this->db->get_where('tab_general_information',array('type'=>'1'))->row_array();  
  }

  public function getBasicInfo1($id){
   return $this->db->get_where('tab_general_information',array('product_id'=>$id))->row_array();  
  }
 


  public function getSizeColor(){
  return $this->db->get_where('tab_color_master',array('type'=>'1'))->result_array();
  }


  public function getSizeColor1($id){
  return $this->db->get_where('tab_color_master',array('product_id'=>$id))->result_array();
  }

    public function getParCatgyList() {
    $this->db->order_by('name','Asc');
    return $this->db->get_where('parent_category_master',array('status'=>'1'))->result_array();    
  }

  public function getCatgyList() {
    $this->db->order_by('category_name','Asc');
    return $this->db->get_where('category_master',array('status'=>'1'))->result_array();    
  }
 

  public function GetUnit() {
    $this->db->order_by('id','Asc');
    return $this->db->get_where('unit_master',array('status'=>'1'))->result_array();    
  }

   public function getParCatName($id ='') {
    $sql =  $this->db->query("SELECT * FROM `parent_category_master` Where id = '".$id."'")->row_array();
    return $sql['name'];
  }
    
   public function getCatName($id ='') {
    $sql =  $this->db->query("SELECT * FROM `category_master` Where id = '".$id."'")->row_array();
    return $sql['category_name'];
  }

  public function getSCatName($id=''){ 

    $sql =  $this->db->query("SELECT * FROM `sub_category_master` Where id = '".$id."'")->row_array();
    return $sql['sub_category_name'];
  }
   public function AddProductData($request) {
    $adminData = $this->session->userdata('adminData');
    $array = array();

    if ($adminData['Type'] == '1') {
        $array['Type'] = '1';
    } else {
        $array['Type'] = $adminData['Id'];
    }

    $array['added_by_id']                = $request['added_by_id'];
    $array['product_unique_id']          = "Prod/".time();
    $array['parent_category_master']    = $request['par_category_id'];
    $array['category_master_id']         = $request['category_id'];
    $array['sub_category_master_id']     = $request['sub_category_id'];
    $array['brand_master_id']            = $request['BrandID'];
    $array['product_name']               = ucwords($request['ProductName']);
    $array['product_discount_type']      = $request['DiscounType'];
    $array['product_discount_amount']    = $request['amountPer'];
    $array['price']                      = $request['prod_price'];
    $array['final_price']                = $request['finalPrice'];
    $array['weight_litr']                = $request['whtLtr'];
    $array['unit']                       = $request['unit'];
    $array['quantity']                   = $request['qty']; 
    $array['description']                = $request['Description'];
     $array['gst']               = @$request['gst'] ? @$request['gst'] : 0; 

    if (!empty($request['feature_product'])) {
        $request['feature_product'] = $request['feature_product'];
    } else {
        $request['feature_product'] = 0;
    }
    $array['feature_product']            = $request['feature_product'];

    $array['cgst_amount']                = ($request['cgst_amount'] != '') ? $request['cgst_amount'] : ''; 
    $array['sgst_amount']                = ($request['sgst_amount'] != '') ? $request['sgst_amount'] : ''; 
    $array['total_tax_amt']              = ($request['total_tax_amt'] != '') ? $request['total_tax_amt'] : '';
    $array['unit_price']                 = ($request['unit_price'] != '') ? $request['unit_price'] : ''; 

    // ✅ New fields add here:
    $array['ingredients']                = $request['ingredients'];
    $array['specialty']                  = $request['specialty'];
    $array['package']                    = $request['package'];
    $array['manufacturer']               = $request['manufacturer'];
    $array['nutritional']                = $request['nutritional'];
    $array['net_quantity']               = $request['net_quantity'];

    $array['add_date']                   = time();
    $array['modify_date']                = time();
    $array['status']                     = '1';

    if ($adminData['Type'] == '1') {
        $array['approving_status'] = '1';
    } else {
        $array['approving_status'] = '2';
    }

    // Insert into product_master
    $this->db->insert('product_master', $array);
    $last_id = $this->db->insert_id();

    /********************************** log history **************************************/
    $log_data['vendor_id']         = $adminData['Id'];
    $log_data['product_id']        = $last_id;
    $log_data['approving_status']  = ($adminData['Type'] == '1') ? 1 : 2;
    $log_data['remark']            = "";
    $log_data['add_date']          = time();
    $this->db->insert('approving_product_log', $log_data);
    /*************************************************************************************/

    // ✅ Handle multiple images
    foreach ($_FILES['uploadFile']['name'] as $item => $item_name) {
        $fileName    = $_FILES["uploadFile"]["name"][$item];
        $extension   = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $uniqueName  = 'prod_'.uniqid().'.'.$extension;
        $tmp_name    = $_FILES['uploadFile']['tmp_name'][$item];
        $targetlocation = PRODUCT_DIRECTORY.$uniqueName;

        if (!empty($fileName)) {
            move_uploaded_file($tmp_name, $targetlocation);
            $data['product_image']       = utf8_encode(trim($uniqueName));
            $data['product_master_id']   = $last_id;
            $data['add_date']            = time();
            $data['modify_date']         = time();
            $data['status']              = '1';
            $this->db->insert('product_images_master', $data);
        }
    }

    return $this->db->affected_rows();
}


    public function getSingleProductData($id='')
    {
      return $this->db->get_where('sub_product_master',array('id'=>$id))->row_array();
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
      return $this->db->get_where('brand_master')->result_array();    
    }

    public function getColorList()
    {
      $this->db->order_by('id','DESC');
      return $this->db->get_where('color_master')->result_array();    
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

public function UpdateProductData($request, $login_id) {
    $array = array();

    $array['status']                    = $request['status'];
    $array['category_master_id']        = $request['CatId'];
    $array['sub_category_master_id']    = $request['SubCat'];
    $array['brand_master_id']           = $request['BrandID'];
    $array['product_name']              = ucwords($request['ProductName']);
    $array['product_discount_type']     = $request['DiscounType'];
    $array['product_discount_amount']   = $request['discountValue'];
    $array['price']                     = $request['prod_price'];
    $array['final_price']               = $request['finalPrice'];
    $array['weight_litr']               = $request['whtLtr'];
    $array['unit']                      = $request['unit'];
    $array['quantity']                  = $request['qty']; 
    $array['description']               = $request['Description']; 
    $array['gst']                        = @$request['gst'] ? @$request['gst'] : 0; 
    $array['total_tax_amt']             = $request['total_tax_amt']; 
    $array['unit_price']                = $request['unit_price'];
    $array['approving_status']          = $request['approving_status'];
    $array['feature_product']           = $request['feature_product'];
    $array['remark']                    = $request['remark'] ? $request['remark'] : '';

    // ✅ New fields
    $array['ingredients']               = $request['ingredients'];
    $array['specialty']                 = $request['specialty'];
    $array['package']                   = $request['package'];
    $array['manufacturer']              = $request['manufacturer'];
    $array['nutritional']               = $request['nutritional'];
    $array['net_quantity']              = $request['net_quantity'];

    $array['modify_date']               = time();

    // 🔹 Update only the main row
    $this->db->where('id', $request['id']);
    $this->db->update('product_master', $array);
    $last_id = $request['id'];

    // 🔹 Log history (optional)
    $log_data['vendor_id']              = $login_id;
    $log_data['product_id']             = $request['id'];
    $log_data['approving_status']       = $request['approving_status'];
    $log_data['remark']                 = $request['remark'];
    $log_data['add_date']               = time();
    $this->db->insert('approving_product_log', $log_data);

    // 🔹 Handle multiple new images upload
    if (isset($_FILES['uploadFile'])) {
        foreach ($_FILES['uploadFile']['name'] as $item => $item_name) {
            $fileName    = $_FILES["uploadFile"]["name"][$item];
            $extension   = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $uniqueName  = 'prod_'.uniqid().'.'.$extension;
            $tmp_name    = $_FILES['uploadFile']['tmp_name'][$item];
            $targetlocation = PRODUCT_DIRECTORY.$uniqueName;

            if (!empty($fileName)) {
                move_uploaded_file($tmp_name, $targetlocation);
                $data['product_image']        = utf8_encode(trim($uniqueName));
                $data['product_master_id']    = $request['id'];
                $data['add_date']             = time();
                $data['modify_date']          = time();
                $data['status']               = '1';
                $this->db->insert('product_images_master', $data);
            }
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
    
    // -------------------
    public function getParentCategories_v2()
    {
        return $this->db->get_where('parent_category_master', ['status' => 1])->result_array();
    }


    public function getCategoriesByParent_v2($parent_id)
    {
        $this->db->select('id, category_name');
        $this->db->from('category_master');
        $this->db->where('mai_id', (int)$parent_id);
        $this->db->where('status', 1);
        return $this->db->get()->result_array();
    }

    public function getSubcategoriesByCategory_v2($cat_id)
    {
        $this->db->select('id, sub_category_name');
        $this->db->from('sub_category_master');
        $this->db->where('category_master_id', (int)$cat_id);
        $this->db->where('status', 1);
        return $this->db->get()->result_array();
    }
    
}
 ?>