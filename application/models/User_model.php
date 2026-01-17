<?php
class User_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function getShops()
  {
    $this->db->select('id, name');
    $this->db->from('shop_master');
    $this->db->where('status', 1);
    return $this->db->get()->result();
  }

  public function getParentCategories()
  {
    $this->db->select('id, name');
    $this->db->from('parent_category_master');
    $this->db->where('status', 1);
    return $this->db->get()->result();
  }

  public function getCategories()
  {
    $this->db->select('id, category_name, mai_id');
    $this->db->from('category_master');
    $this->db->where('status', 1);
    return $this->db->get()->result();
  }

  public function getSubCategory()
  {
    $this->db->select('id, sub_category_name, category_master_id');
    $this->db->from('sub_category_master');
    $this->db->where('status', 1);
    return $this->db->get()->result();
  }

  public function getProducts()
  {
    $this->db->select('id, product_name, sub_category_id');
    $this->db->from('sub_product_master');
    $this->db->where('status', 1);
    return $this->db->get()->result();
  }







  # Admin login here
// ---------------- ADMIN LOGIN ----------------
 public function adminLogin($email, $password)
    {
        $this->db->select("id, username, email, profile_pic");
        $query = $this->db->get_where('admin_master', [
            'email'    => $email,
            'password' => base64_encode($password), // admin password encoded
            'status'   => 0   // 0 = active
        ]);

        return $query->row_array();
    }

    // ---------------- VENDOR LOGIN ----------------
  public function vendorLogin($mobile, $password)
{
    $this->db->select("id, name, email, mobile, profile_pic, password, status");
    $query = $this->db->get_where('vendors', [
        'mobile' => $mobile,
        'status' => 1   // 1 = active vendor
    ]);

    $vendor = $query->row_array();

    if ($vendor) {
        // bcrypt password verify
        if (password_verify($password, $vendor['password'])) {
            return $vendor;
        }
    }

    return false;
}
// ---------------- PROMOTER LOGIN ----------------
public function promoterLogin($mobile, $password)
{
    $this->db->select("id, name, email, mobile, profile_pic, password, status");
    $query = $this->db->get_where('promoters', [
        'mobile' => $mobile,
        'status' => 1   // active promoter
    ]);

    $promoter = $query->row_array();

    if ($promoter) {
        if (password_verify($password, $promoter['password'])) {
            return $promoter;
        }
    }

    return false;
}



  // public function login($username, $password, $loginType)
  //   {
  //       if ($loginType == 1)
  //       {
  //           $this->db->select("id, username, email, profile_pic");
  //           $query = $this->db->get_where('admin_master', [
  //               'email'    => $username,
  //               'password' => $password,
  //               'status'   => '0' 
  //           ]);
  //           return $query->row_array();
  //       } 
  //       else 
  //       {
  //           $this->db->select("id, name, email, mobile, profile_pic");
  //           $query = $this->db->get_where('vendors', [
  //               'mobile'   => $username,
  //               'password' => $password,
  //               'status'   => '1' 
  //           ]);
  //           return $query->row_array();
  //       }
  //   }

  public function add_pincode_data($request)
  {
    $arrayName = array();
    $arrayName['pin_code'] = $request['pin_code'];
    $arrayName['location_name'] = $request['location_name'];
    $arrayName['pin_status'] = $request['pin_status'];
    $arrayName['status'] = '1';
    $this->db->insert('pin_code_master', $arrayName);
    return $this->db->affected_rows();
  }


  public function edit_pincode_data($request, $id)
  {
    $arrayName['pin_code'] = $request['pin_code'];
    $arrayName['location_name'] = $request['location_name'];
    $arrayName['pin_status'] = $request['pin_status'];
    $arrayName['status'] = '1';
    $this->db->where('id', $id);
    return $this->db->update('pin_code_master', $arrayName);

  }

  public function getVendotList()
  {
    $this->db->order_by('id', 'DESC');
    return $this->db->get_where('staff_master')->result_array();
  }

  public function getSingleVendorData($id)
  {
    return $this->db->get_where('staff_master', array('id' => $id))->row_array();
  }


  public function UpdateSettingBannerDataPost($request)
  {
    $arrayName = array();
    $arrayName['banner'] = $request['banner_image'];

    $this->db->where('id', '1');
    $this->db->update('settings', $arrayName);
    return $this->db->affected_rows();
  }

  public function getDeliveryBoy()
  {
    return $this->db->query("SELECT * FROM `deliver_boy_master`")->result_array();
  }


  public function UpdateBoyData($request, $id)
  {
    $array = array();
    $array['name'] = $request['name'];
    $array['mobile'] = $request['mobile'];
    $array['alternate_mobile'] = $request['alternate_mobile'];
    $array['dob'] = $request['dob'];
    $array['gender'] = $request['gender'];
    $array['email'] = $request['email'];
    $array['address'] = $request['address'];
    $array['profile_pic'] = $request['photo'];
    $this->db->where('id', $id);
    return $this->db->update('deliver_boy_master', $array);

  }

  public function AddBoyData($request)
  {
    $array = array();
    $array['name'] = $request['name'];
    $array['mobile'] = $request['mobile'];
    $array['alternate_mobile'] = $request['alternate_mobile'];
    $array['dob'] = $request['dob'];
    $array['gender'] = $request['gender'];
    $array['email'] = $request['email'];
    $array['profile_pic'] = $request['photo'];
    $array['address'] = $request['address'];
    $array['add_date'] = date("d-m-Y");
    $array['status'] = '1';
    $this->db->insert('deliver_boy_master', $array);
    return $this->db->affected_rows();
  }

  public function GetSchoolALlBranch($id = '')
  {
    return $this->db->query("SELECT * FROM `branch_master` Where school_master_id='" . $id . "'")->result_array();
  }

  public function TotalGetCategorie()
  {
    return $this->db->query("Select* from `category_master`")->num_rows();
  }
  public function TotalSchool()
  {
    return $this->db->query("Select* from `school_master`")->num_rows();
  }
  public function TotalGetBrand()
  {
    return $this->db->query("Select* from `brand_master`")->num_rows();
  }
  public function TotalGetBanners()
  {
    return $this->db->query("Select* from `banner_master`")->num_rows();
  }
  public function TotalGetUsers()
  {
    return $this->db->query("Select* from `user_master`")->num_rows();
  }
  public function TotalGetVendors()
  {
    return $this->db->query('Select * from `admin_master` where id != -1')->num_rows();
  }

  public function TotalGetProducts()
  {
    $adminData = $this->session->userdata('adminData');
    if ($adminData['Type'] == '1')
    {

      return $this->db->query("Select* from `sub_product_master`")->num_rows();
      //return  $this->db->get_where('sub_product_master')->num_rows(); 

    } else
    {

      $this->db->select('size,color,id,shop_id,sub_category_id,product_code,sku_code,product_name,price,final_price,quantity,verify_status');
      $this->db->order_by('id', 'desc');
      $this->db->group_by('product_code');
      return $this->db->get_where('sub_product_master', array('added_type' => '2', 'addedBy' => $adminData['Id']))->num_rows();

    }
  }


  public function getTotalShop()
  {
    $adminData = $this->session->userdata('adminData');
    if ($adminData['Type'] == '1')
    {
      $this->db->order_by('id', 'DESC');
      return $this->db->get_where('shop_master', array('type' => '1', 'addedBy' => '1'))->num_rows();
    } else
    {
      $this->db->order_by('id', 'DESC');
      return $this->db->get_where('shop_master', array('type' => '2', 'addedBy' => $adminData['Id']))->num_rows();
    }

  }


  public function TotalGetOrders()
  {
    return $this->db->query('Select * from `order_master`')->num_rows();
  }
  public function TotalGetVendorProduct($id = '')
  {
    return $this->db->query('Select * from `product_master` where added_by_id = ' . $id . '')->num_rows();
  }

  public function TotalGetPush()
  {
    return $this->db->query('Select * from `push_messge`')->num_rows();
  }

  public function TotalWalletDetail()
  {
    return $this->db->query('Select * from `wallet_master` where reason = 6')->num_rows();
  }



  public function TotalGetOffers()
  {
    return $this->db->query('Select * from `offer_master` where  status != 2 ')->num_rows();
  }

  public function TotalGetMainCatProd($id = '')
  {
    return $this->db->query('Select * from `sub_product_master` where parent_category_id = ' . $id . '')->num_rows();
  }

  public function TotalGetCatProd($id = '')
  {
    return $this->db->query('Select * from `sub_product_master` where category_id = ' . $id . '')->num_rows();
  }

  public function TotalGetSubCatProd($id = '')
  {
    return $this->db->query('Select * from `sub_product_master` where sub_category_id = ' . $id . '')->num_rows();
  }



  public function addCategoryData($request)
  {
    $array = array();
    $array['category_name'] = ucwords($request['Category']);
    $array['mai_id'] = $request['mai_id'];
    $array['app_icon'] = $request['app_icon'];
    $array['add_date'] = time();
    $array['modify_date'] = time();
    $array['status'] = '1';

    // Use reusable helper
    $array['slug'] = slugify($array['category_name']);

    $this->db->insert('category_master', $array);

    return $this->db->affected_rows();
  }



  public function getCatgy_list($id)
  {
    $this->db->Order_by('category_name', 'Asc');
    $query = $this->db->get_where('category_master', array('status !=' => '3', 'mai_id' => $id))->result_array();

    return $query;
    // return $this->db->get_where('category_master',array('status '=>1))->result_array();
  }

  public function getParCatgy_list()
  {
    $this->db->Order_by('name', 'Asc');
    $query = $this->db->get_where('parent_category_master', array('status !=' => '3'))->result_array();
    return $query;

  }


  public function getBrandList()
  {
    return $this->db->get_where('brand_master', array('status' => '1'))->result_array();

  }



  public function getCatName($id = '')
  {
    $sql = $this->db->query("SELECT * FROM `category_master` Where id = '" . $id . "'")->row_array();
    return $sql['category_name'];
  }

  public function getSCatName($id = '')
  {
    $sql = $this->db->query("SELECT * FROM `sub_category_master` Where id = '" . $id . "'")->row_array();
    return $sql['sub_category_name'];
  }
  public function getCatName2($id = '')
  {
    $SQL = "SELECT cm.`id`AS catId , cm.`category_name`, sm.`id` AS subid , sm.`app_icon`,sm.`web_icon`,sm.`sub_category_name`, sm.`status` AS subStatus, sm.`featured_sub_category` AS f_sub , `sm`.offer_sub_cateorgy_start_date , `sm`.offer_sub_cateorgy_end_date, `sm`.deal_type , `sm`.deal_amount FROM sub_category_master AS sm LEFT JOIN category_master AS cm ON cm.`id` = sm.`category_master_id` WHERE  sm.`id` = '" . $id . "' ";

    $query = $this->db->query($SQL)->row_array();
    print_r($query);

    return $query['category_name'];
  }

  public function getSubCatCount($id = '')
  {
    return $this->db->query("SELECT * FROM `sub_category_master` Where status != '3' And category_master_id = '" . $id . "'")->num_rows();

  }

  public function getShopCount($id = '')
  {
    return $this->db->query("SELECT * FROM `shop_master` Where vendor_id = '" . $id . "'")->num_rows();
  }

  public function getCatCount($id = '')
  {
    return $this->db->query("SELECT * FROM `category_master` Where mai_id = '" . $id . "'" . "AND status != 3")->num_rows();
  }

  public function getSubCatgy_list($id = "")
  {
    /*echo $id; exit;*/

    #, sm.`featured_sub_category` as f_sub
    $SQL = "SELECT cm.`id`AS catId , cm.`category_name`, sm.`id` AS subid , sm.`app_icon`,sm.`web_icon`,sm.`cgst`,sm.`sub_category_name`, sm.`status` AS subStatus, sm.`featured_sub_category` AS f_sub , `sm`.offer_sub_cateorgy_start_date , `sm`.offer_sub_cateorgy_end_date, `sm`.deal_type , `sm`.deal_amount FROM sub_category_master AS sm LEFT JOIN category_master AS cm ON cm.`id` = sm.`category_master_id` WHERE  sm.`status` != '3' And sm.`category_master_id` = '" . $id . "' ORDER by subid DESC";

    $query = $this->db->query($SQL)->result_array();

    return $query;

  }

  public function GetAdminData($id = '')
  {
    return $this->db->get_where('admin_master', array('id' => $id))->row_array();
  }

  public function getALLcatgy()
  {
    $SQL = "SELECT * from  category_master where status='1'  Order by category_name asc";
    $query = $this->db->query($SQL)->result_array();
    // print_r($query);exit;
    return $query;
  }


  public function getCatgy_Data($id)
  {

    $query = $this->db->get_where('category_master', array('id ' => $id))->row_array();

    return $query;
    // return $this->db->get_where('category_master',array('status '=>1))->result_array();
  }

  public function UpdateCategoryPost($request)
  {
    //echo $request['id']; exit;
    $arrayName = array();
    $arrayName['status'] = ucwords($request['status']);
    $arrayName['category_name'] = ucwords($request['Category']);
    if (!empty($request['app_icon']))
    {
      $arrayName['app_icon'] = $request['app_icon'];
    }

    $arrayName['slug'] = str_replace(' ', '-', strtolower($arrayName['category_name']));

    $arrayName['modify_date'] = time();

    $this->db->where('id', $request['id']);
    $this->db->update('category_master', $arrayName);
    return $this->db->affected_rows();
  }

  public function addSubCatPostData($request)
  {
    $array = array();
    $array['category_master_id'] = $request['catgyName'];
    $array['cgst'] = $request['gst'];
    $array['sub_category_name'] = ucwords($request['subCat']);
    $array['featured_sub_category'] = '1';
    $array['app_icon'] = (!empty($request['app_icon'])) ? $request['app_icon'] : NULL;
    $array['add_date'] = time();
    $array['modify_date'] = time();
    $array['status'] = '1';

    // ✅ Proper slugify call
    $array['slug'] = slugify($array['sub_category_name']);

    $this->db->insert('sub_category_master', $array);

    return $this->db->affected_rows();
  }



  public function getSubCatgyData($id)
  {
    $sql = "SELECT  cm.`id`as catId , cm.`category_name`, sm.`id` as subid ,sm.`cgst` as cgst,sm.`igst` as igst,sm.`intergst` as intergst, sm.`sub_category_name`, sm.`app_icon`,sm.`web_icon`,sm.`sub_category_name`, sm.`featured_sub_category` as f_sub , sm.`status` as substatus,sm.`CommissionRate` as CommissionRate from sub_category_master as sm left join category_master as cm ON cm.`id` = sm.`category_master_id` where sm.`id` = '" . $id . "' Order by sm.`id` desc";
    $query = $this->db->query($sql)->row_array();
    // echo  $this->db->last_query();
    return $query;
  }

  public function UpdateSubCategoryData($request)
  {

    $arrayName = array();
    $arrayName['status'] = $request['status'];
    $arrayName['category_master_id'] = $request['catgyName'];
    $arrayName['cgst'] = $request['gst'];
    $arrayName['sub_category_name'] = ucwords($request['subCat']);

    if (!empty($request['app_icon']))
    {
      $arrayName['app_icon'] = $request['app_icon'];
    }

    $arrayName['slug'] = str_replace(' ', '-', strtolower($arrayName['sub_category_name']));
    $arrayName['modify_date'] = time();
    $checkdata = $this->checkdata($arrayName['sub_category_name']);
    $this->db->where('id', $request['id']);
    $this->db->update('sub_category_master', $arrayName);
    /* echo $this->db->last_query();
    exit();*/
    return $this->db->affected_rows();
  }




  public function checkdata($value)
  {
    $sql = $this->db->query("Select * from sub_category_master where `sub_category_name` = '" . $value . "'")->num_rows();
    return ($sql > 0) ? '1' : '0';
  }


  public function updateOffer($request)
  {
    // echo $request['type']; exit;
    $start_date = $request['start'] . "00:00:00";
    $end = $request['end'] . "23:59:59";
    $arrayName = array();
    $arrayName['offer_sub_cateorgy_start_date'] = strtotime($start_date);
    $arrayName['offer_sub_cateorgy_end_date'] = strtotime($end);
    $arrayName['deal_type'] = $request['offerType'];
    $arrayName['deal_amount'] = $request['amount'];
    $arrayName['modify_date'] = time();

    $this->db->where('id', $request['id']);
    $this->db->update('sub_category_master', $arrayName);
    return $this->db->affected_rows();

  }


  public function delCatgy($id)
  {
    $arrayName = array();
    $arrayName['status'] = '3';
    $this->db->where('id', $id);
    $this->db->update('category_master', $arrayName);
    return $this->db->affected_rows();
  }


  public function SubdelCatgy($id)
  {
    $arrayName = array();
    $arrayName['status'] = '3';
    $this->db->where('id', $id);
    $this->db->update('sub_category_master', $arrayName);
    return $this->db->affected_rows();
  }

  public function getAllBrands()
  {
    return $this->db->get_where('brand_master')->result_array();
  }


  public function getALLSubCat()
  {
    $SQL = "SELECT * from  sub_category_master   Order by sub_category_name asc";
    $query = $this->db->query($SQL)->result_array();
    // print_r($query);exit;
    return $query;
  }

  public function addBrandData($request)
  {

    $array = array();
    $array['brand_name'] = ucwords($request['BrandName']);
    $array['brand_image'] = $request['brand_image'];
    $array['add_date'] = time();
    $array['modify_date'] = time();
    $array['status'] = '1';
    $this->db->insert('brand_master', $array);

    return $this->db->affected_rows();
  }

  public function GetBrandDetail($id)
  {
    return $this->db->get_where('brand_master', array('id' => $id))->row_array();
  }


  public function GetColor()
  {
    $this->db->order_by('id', 'DESC');
    return $this->db->get_where('color_master')->result_array();
  }

  public function AddColorData($request)
  {
    $array['name'] = $request['ColorName'];
    $array['image'] = $request['image'];
    $array['add_date'] = time();
    $array['modify_date'] = time();
    $array['status'] = '1';
    $this->db->insert('color_master', $array);
    return $this->db->affected_rows();

  }

  public function getColor_Data($id)
  {
    $query = $this->db->get_where('color_master', array('id ' => $id))->row_array();
    return $query;
  }
  public function UpdateColorData($request, $id)
  {
    $arrayName = array();
    $arrayName['name'] = $request['ColorName'];
    $arrayName['status'] = $request['status'];
    if (!empty($request['image']))
    {
      $arrayName['image'] = $request['image'];
    }

    $arrayName['modify_date'] = time();

    $this->db->where('id', $id);
    $this->db->update('color_master', $arrayName);
    return $this->db->affected_rows();
  }

  public function UpdateBrandData($request)
  {

    $arrayName = array();
    $arrayName['status'] = $request['status'];
    $arrayName['brand_name'] = ucwords($request['BrandName']);
    if (!empty($request['brand_image']))
    {
      $arrayName['brand_image'] = $request['brand_image'];
    }

    $arrayName['modify_date'] = time();
    $this->db->where('id', $request['id']);
    $this->db->update('brand_master', $arrayName);
    return $this->db->affected_rows();
  }


  public function unitList()
  {
    $this->db->order_by('id', 'ASC');
    return $this->db->get('unit_master')->result_array();
  }

  public function AddUnitData($request)
  {
    $array = array();
    $array['unit_name'] = ucwords($request['UnitName']);
    $array['add_date'] = time();
    $array['modify_date'] = time();
    $array['status'] = '1';
    $this->db->insert('unit_master', $array);
    return $this->db->affected_rows();
  }

  public function getUnit_Data($id)
  {
    return $this->db->get_where('unit_master', array('id' => $id))->row_array();
  }

  public function updateUnitData($request)
  {
    $array = array();
    $array['unit_name'] = ucwords($request['UnitName']);
    $array['status'] = $request['status'];

    $array['modify_date'] = time();
    $this->db->where('id', $request['id']);
    $this->db->update('unit_master', $array);
    return $this->db->affected_rows();
  }
  public function distinguish()
  {
    $this->db->order_by('id', 'DESC');
    return $this->db->get('distinguish_master')->result_array();
  }

  public function add_distData($request)
  {
    $array = array();
    $array['distinguish_name'] = ucwords($request['Dist_Name']);
    $array['add_date'] = time();
    $array['modify_date'] = time();
    $this->db->insert('distinguish_master', $array);
    return $this->db->affected_rows();
  }
  public function getDist_Data($id)
  {
    return $this->db->get_where('distinguish_master', array('id' => $id))->row_array();
  }
  public function updateDistData($request)
  {
    $array = array();
    $array['distinguish_name'] = ucwords($request['Dist_Name']);
    $array['modify_date'] = time();

    $this->db->where('id', $request['id']);
    $this->db->update('distinguish_master', $array);
    return $this->db->affected_rows();
  }

  public function filterList()
  {
    $SQL = "SELECT  Fm.`id` as FmID , Fm.`filter_name` , Fm.`status` AS FM_status , Sm.`sub_category_name`, Um.`unit_name` , Dm.`distinguish_name`  FROM filter_master As Fm LEFT JOIN unit_master As Um ON (Fm.`unit_master_id`= Um.`id`) LEFT JOIN distinguish_master As Dm ON (Fm.`distinguish_id`= Dm.`id`) LEFT JOIN sub_category_master As Sm ON (Fm.`sub_category_master_id`= Sm.`id`)";

    $query = $this->db->query($SQL)->result_array();
    return $query;
  }

  public function getSubCat()
  {
    $this->db->Select('sub_category_name');
    $this->db->Select('id');
    $this->db->Order_by('sub_category_name Asc');
    return $this->db->get_where('sub_category_master', array('status' => 1))->result_array();
  }

  public function getUnit()
  {
    $this->db->Order_by('unit_name Asc');
    return $this->db->get_where('unit_master', array('status' => 1))->result_array();
  }
  public function getDist()
  {
    $this->db->Order_by('distinguish_name Asc');
    return $this->db->get_where('distinguish_master', array('status' => 1))->result_array();
  }
  public function AddFilterData($request)
  {
    $array = array();
    $array['sub_category_master_id'] = $request['subCatgy'];
    $array['filter_name'] = $request['filter'];
    $array['unit_master_id'] = $request['unit'];
    $array['distinguish_id'] = $request['dist'];

    $array['add_date'] = time();
    $array['modify_date'] = time();
    $array['status'] = '1';
    $this->db->insert('filter_master', $array);
    return $this->db->affected_rows();
  }

  public function getSingleFilterData($id)
  {
    return $this->db->get_where('filter_master', array('id' => $id))->row_array();

  }

  public function UpdateFilterData($request)
  {

    $arrayName = array();
    $arrayName['sub_category_master_id'] = $request['subCatgy'];
    $arrayName['filter_name'] = $request['filter'];
    $arrayName['unit_master_id'] = $request['unit'];
    $arrayName['distinguish_id'] = $request['dist'];
    $arrayName['modify_date'] = time();

    $this->db->where('id', $request['id']);
    $this->db->update('filter_master', $arrayName);
    return $this->db->affected_rows();
  }

  public function UpdateAdminData($request)
  {
    /* $sql = $this->db->query('Select * from admin_master where id ='.$request['id'].' ')->row_array();*/
    $arrayName = array();
    $arrayName['name'] = $request['name'];
    $arrayName['email'] = $request['email'];
    $arrayName['password'] = base64_encode($request['password']);
    /*  $arrayName['password']    = (base64_encode($request['password']) == $sql['password']) ? $sql['password'] : base64_encode($request['password']);*/
    $arrayName['phone_no'] = $request['phone_no'];

    if (!empty($request['profile_pic']))
    {
      $arrayName['profile_pic'] = $request['profile_pic'];
    }

    $arrayName['modify_date'] = time();
    /*print_r($arrayName); exit;*/
    $this->db->where('id', $request['id']);
    $this->db->update('admin_master', $arrayName);
    // echo $this->db->last_query();
    // exit;

    return $this->db->affected_rows();
  }

  public function GetOffer()
  {

    /*$sql = "SELECT * FROM offer_master As'Om' Left Join filter_masterFiletr As'Fm' On   "*/
    $this->db->Order_by('id', 'DESC');
    return $this->db->get_where('offer_master')->result_array();
  }


  public function getALLSubcatgy($id)
  {
    return $this->db->get_where('offer_master', array('category_master_id' => $id))->result_array();
  }

  public function AddOfferData($request)
  {
    $start_date = $request['StartDate'] . "00:00:00";
    $end = $request['EndDate'] . "23:59:59";
    $arrayName = array();
    $arrayName['offer_name'] = ucwords($request['offerName']);

    $arrayName['sub_category_ids'] = (!empty($request['SubCat']) ? json_encode([$request['SubCat']]) : '');
    $arrayName['start_date'] = strtotime($start_date);
    $arrayName['end_date'] = strtotime($end);
    $arrayName['offerType'] = $request['offerType'];
    $arrayName['deal_type'] = $request['dealType'];
    $arrayName['deal_amount'] = $request['amountPer'];
    $arrayName['status'] = '1';
    $arrayName['add_date'] = time();
    $arrayName['modify_date'] = time();
    $this->db->insert('offer_master', $arrayName);
    return $this->db->affected_rows();
  }



  public function getCategoryOffer($id = '')
  {
    $sql = $this->db->query("SELECT * FROM `sub_category_master` where id= '" . $id . "' ")->row_array();
    /*print_r($sql); exit;*/
    return $sql['category_master_id'];
  }

  public function UpdateOfferData($request)
  {

    $start_date = $request['StartDate'] . "00:00:00";
    $end = $request['EndDate'] . "23:59:59";
    $arrayName = array();
    $arrayName['offer_name'] = ucwords($request['offerName']);
    // $arrayName['sub_category_ids']  = $request['SubCat'];
    $arrayName['sub_category_ids'] = (!empty($request['SubCat']) ? json_encode([$request['SubCat']]) : '');
    $arrayName['start_date'] = strtotime($start_date);
    $arrayName['end_date'] = strtotime($end);
    $arrayName['offerType'] = $request['offerType'];
    $arrayName['deal_type'] = $request['dealType'];
    $arrayName['deal_amount'] = $request['amountPer'];
    $arrayName['status'] = '1';
    $arrayName['add_date'] = time();
    $arrayName['modify_date'] = time();
    $this->db->where('id', $request['id']);
    $this->db->update('offer_master', $arrayName);
    return $this->db->affected_rows();
  }

  public function GetBanners()
  {
    $this->db->order_by('id', 'DESC');
    return $this->db->get_where('banner_master')->result_array();
  }

  public function AddBannerData($request)
  {
    $arrayName = array();
    $arrayName['banner_on'] = @$request['Banner_On'] ? @$request['Banner_On'] : 0;
    $arrayName['featured_banner'] = @$request['bannerfeature'] ? @$request['bannerfeature'] : 0;
    $arrayName['banner_image'] = $request['banner_image'];
    $arrayName['bannerType'] = $request['bannerType'];
    $arrayName['level'] = @$request['level'] ? @$request['level'] : 0;
    $arrayName['status'] = '1';
    $arrayName['add_date'] = time();
    $arrayName['modify_date'] = time();
    if ($request['product_list'] == '' && $request['sub_product_list'] == '' && $request['keyword'] == '')
    {
      $arrayName['sub_category_product_master_id'] = $request['details'];
    } else if ($request['details'] == '' && $request['sub_product_list'] == '' && $request['keyword'] == '')
    {
      $arrayName['sub_category_product_master_id'] = $request['product_list'];
    } else if ($request['product_list'] == '' && $request['sub_product_list'] == '' && $request['details'] == '')
    {
      $arrayName['sub_category_product_master_id'] = $request['keyword'];
    } else
    {
      $arrayName['sub_category_product_master_id'] = $request['sub_product_list'];
    }
    $this->db->insert('banner_master', $arrayName);
    return $this->db->affected_rows();
  }


  public function GetBannerData($id = '')
  {
    return $this->db->get_where('banner_master', array('id' => $id))->row_array();
  }


  public function UpdateBannerDataPost($request)
  {
    $arrayName = array();
    $arrayName['banner_on'] = @$request['Banner_On'] ? @$request['Banner_On'] : 0;
    $arrayName['featured_banner'] = @$request['bannerfeature'] ? @$request['bannerfeature'] : 0;
    if (!empty($request['banner_image']))
    {
      $arrayName['banner_image'] = $request['banner_image'];
    }
    $arrayName['add_date'] = time();
    $arrayName['modify_date'] = time();
    $arrayName['level'] = @$request['level'] ? @$request['level'] : 0;
    $arrayName['bannerType'] = $request['bannerType'];
    if ($request['Banner_On'] == 1)
    {
      if (!empty($request['sub_product_list']))
      {
        $arrayName['sub_category_product_master_id'] = $request['sub_product_list'];
      } elseif (!empty($request['product_list']))
      {
        $arrayName['sub_category_product_master_id'] = $request['product_list'];
      }
      /*http://localhost/mrnmrsekart/admin/Dashboard/UpdateBannerData/51
       */
    } else if ($request['Banner_On'] == 2)
    {
      $arrayName['sub_category_product_master_id'] = $request['product_list'];
    } else if ($request['Banner_On'] == 3)
    {
      $arrayName['sub_category_product_master_id'] = $request['keyword'];
    } else
    {
      $arrayName['sub_category_product_master_id'] = $request['details'];
    }
    //print_r($arrayName); exit;
    $this->db->where('id', $request['id']);
    $this->db->update('banner_master', $arrayName);
    return $this->db->affected_rows();
  }


  public function GetOfferData($id = '')
  {
    return $this->db->get_where('offer_master', array('id' => $id))->row_array();
  }
  public function GetSort()
  {
    $this->db->order_by('id', 'DESC');
    return $this->db->get_where('sort_master')->result_array();
  }

  public function AddSortData($request)
  {
    $array = array();
    $array['sort_name'] = ucwords($request['SortName']);
    $array['add_date'] = time();
    $array['modify_date'] = time();
    $array['status'] = '1';
    $this->db->insert('sort_master', $array);
    return $this->db->affected_rows();
  }

  public function getSort_Data($id)
  {
    return $this->db->get_where('sort_master', array('id' => $id))->row_array();
  }

  public function updateSortData($request)
  {
    $array = array();
    $array['sort_name'] = ucwords($request['SortName']);

    $array['modify_date'] = time();
    $this->db->where('id', $request['id']);
    $this->db->update('sort_master', $array);
    return $this->db->affected_rows();
  }

  public function GetCoupan()
  {
    $this->db->order_by('id', 'DESC');
    return $this->db->get_where('coupon_manager_master')->result_array();
  }

  public function AddCouponData($request)
  {
    $start_date = $request['start_date'];
    $end_date = $request['end_date'];

    $data = array();
    $data['coupon_code'] = $request['coupon_code'];
   
    $data['discount_type'] = $request['discount_type'];
    $data['discount_value'] = $request['discount_value'];
   
    $data['start_date'] = date('Y-m-d H:i:s', strtotime($start_date));
    $data['end_date'] = date('Y-m-d H:i:s', strtotime($end_date));
    $data['usage_limit_total'] = $request['usage_limit_total'] ?? 0;
    $data['usage_limit_per_user'] = $request['usage_limit_per_user'] ?? 1;
 
    $data['parent_category_id'] = $request['parent_category_id'] ?? null;
    $data['category_ids'] = isset($request['category_ids']) ? implode(',', $request['category_ids']) : '';
    $data['product_ids'] = isset($request['product_ids']) ? implode(',', $request['product_ids']) : '';
    $data['sub_category_ids'] = isset($request['sub_category_ids']) ? implode(',', $request['sub_category_ids']) : '';
   
    $data['status'] = $request['status'] ?? 1;
    $data['created_at'] = date('Y-m-d H:i:s');
    $data['updated_at'] = date('Y-m-d H:i:s');

    $this->db->insert('coupon_manager_master', $data);
    return $this->db->affected_rows();
  }



  public function getCoupon_Data($id)
  {
    return $this->db->get_where('coupon_manager_master', array('id' => $id))->row_array();
  }



public function UpdateCouponData($request)
{
    if (empty($request['id'])) {
        return 0;
    }

    $start_date = $request['start_date'] ?? date('Y-m-d H:i:s');
    $end_date   = $request['end_date'] ?? date('Y-m-d H:i:s');

    $data = [
        'coupon_code'          => $request['coupon_code'] ?? '',
     
        'discount_type'        => $request['discount_type'] ?? 'fixed',
        'discount_value'       => $request['discount_value'] ?? 0,
      
        'start_date'           => date('Y-m-d H:i:s', strtotime($start_date)),
        'end_date'             => date('Y-m-d H:i:s', strtotime($end_date)),
        'usage_limit_total'    => $request['usage_limit_total'] ?? 0,
        'usage_limit_per_user' => $request['usage_limit_per_user'] ?? 1,
     
        'parent_category_id'   => $request['parent_category_id'] ?? null,
        'category_ids'         => isset($request['category_ids']) ? implode(',', $request['category_ids']) : '',
        'sub_category_ids'     => isset($request['sub_category_ids']) ? implode(',', $request['sub_category_ids']) : '',
        'product_ids'          => isset($request['product_ids']) ? implode(',', $request['product_ids']) : '',
       
        'status'               => $request['status'] ?? 1,
        'updated_at'           => date('Y-m-d H:i:s')
    ];

    $this->db->where('id', $request['id']);
    $this->db->update('coupon_manager_master', $data);

    return $this->db->affected_rows();
}




  public function Setting($request)
  {

    $this->db->where('id', '1');
    $update = $this->db->update('settings', $request);
    return $update;
  }

  /* code added by sitaram shreevastava */
  /*
      check gst value are set or not 
  */
  public function chk_set_gst()
  {
    return $this->db->get_where('developer_link', array('id' => 1))->row_array();
  }

  public function DataSave($table, $data)
  {
    $this->db->insert($table, $data);
    return $last_id = $this->db->insert_id();
  }

  public function updateData($table_name, $condition, $input_data)
  {
    $update_data = $this->db->where($condition)->update($table_name, $input_data);
    return true;
  }


  public function getData($table, $condition, $id = '')
  {
    if (!empty($id))
    {
      $data = $this->db->get_where($table, $condition)->row_array();
    } else
    {
      $this->db->order_by('id', 'desc');
      $data = $this->db->get_where($table, $condition)->result_array();
    }
    return $data;
  }

}
?>