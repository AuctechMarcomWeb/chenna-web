<?php
class Vendor_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }


  // Registration
  // ================= Step-7 =================

  public function insert_user($data, $table)
  {
    $this->db->insert($table, $data);
    return $this->db->insert_id();
  }
  public function get_all_vendors()
  {
    $this->db->select('*');
    $this->db->from('vendors');
    $this->db->order_by('add_date', 'DESC');
    return $this->db->get()->result();
  }

  public function admin_approve_and_update_vendor_password($id, $role, $hashed_password)
  {
    if ($role == 'vendor')
    {
      return $this->db->where('id', $id)->update('vendors', ['status' => 1, 'password' => $hashed_password]);
    }
  }


  public function admin_update_vendor_status($id, $role, $status)
  {
    if ($role == 'vendor')
    {
      return $this->db->where('id', $id)->update('vendors', ['status' => $status]);
    }
  }

  public function get_admin_vendor_by_id($id)
  {
    return $this->db->where('id', $id)
      ->get('vendors')
      ->row();
  }

  public function admin_delete_vendor($id)
  {
    return $this->db->where('id', $id)->delete('vendors');
  }


  public function check_duplicate($mobile, $aadhar, $pan)
  {
    $this->db->where('mobile', $mobile);
    if (!empty($aadhar))
    {
      $this->db->or_where('aadhar_card', $aadhar);
    }
    if (!empty($pan))
    {
      $this->db->or_where('pan_card', $pan);
    }
    $query = $this->db->get('vendors');
    return $query->num_rows() > 0;
  }


  public function get_user($id, $role)
  {
    if ($role == 'vendor')
    {
      return $this->db->get_where('vendors', ['id' => $id])->row();
    } else
    {
      return $this->db->get_where('promoters', ['id' => $id])->row();
    }
  }

  public function getSingleVendorsData($id)
  {
    return $this->db->get_where('vendors', ['id' => $id])->row_array();
  }

  // Update vendor
  public function updateVendor($id, $data)
  {
    $this->db->where('id', $id);
    return $this->db->update('vendors', $data);
  }
  // ================= GET PROMOTER BY CODE =================
  public function get_promoter_by_code($code)
  {
    return $this->db->get_where('promoters', ['promoter_code' => $code])->row();
  }

  public function getOrderMaster($order_id)
  {
    return $this->db->where('id', $order_id)
      ->get('order_master')
      ->row_array();
  }

  public function getVendorPurchase($order_id, $vendor_id)
  {
    return $this->db->select('pm.*, sp.product_name, sp.main_image')
      ->from('purchase_master pm')
      ->join('sub_product_master sp', 'sp.id = pm.product_master_id', 'left')
      ->where('pm.order_master_id', $order_id)
      ->where('pm.vendor_id', $vendor_id)
      ->get()
      ->result_array();
  }

  public function checkVendorReturn($order_id, $vendor_id)
  {
    return $this->db->where([
      'order_master_id' => $order_id,
      'vendor_id' => $vendor_id,
      'status' => 8
    ])->get('purchase_master')->num_rows();
  }

  public function getPurchaseSummary($vendor_id = '')
  {
    $this->db->select("
        COUNT(id) AS total_orders,
        SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) AS pending_orders,
        SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) AS cancelled_orders,
        SUM(CASE WHEN status = 4 THEN 1 ELSE 0 END) AS shipped_orders,
        SUM(CASE WHEN status = 5 THEN 1 ELSE 0 END) AS delivered_orders
    ");
    $this->db->from('purchase_master');

    if ($vendor_id != '')
    {
      $this->db->where('vendor_id', $vendor_id);
    }

    $query = $this->db->get();
    return $query->row_array(); // returns a single row
  }



  public function insert_promoters_user($data, $table)
  {
    $this->db->insert($table, $data);
    return $this->db->insert_id();
  }
  public function check_promoter_duplicate($mobile, $email)
  {
    $this->db->where('mobile', $mobile);
    $this->db->or_where('email', $email);
    $query = $this->db->get('promoters');
    return $query->num_rows() > 0;
  }


  public function get_all_promoters()
  {
    $this->db->select('*');
    $this->db->from('promoters');
    $this->db->order_by('add_date', 'DESC');
    return $this->db->get()->result();
  }

  public function admin_approve_and_update_promoter_password($id, $role, $hashed_password)
  {
    if ($role == 'promoter')
    {
      return $this->db->where('id', $id)->update('promoters', ['status' => 1, 'password' => $hashed_password]);
    }
  }

  public function admin_update_promoter_status($id, $role, $status)
  {
    if ($role == 'promoter')
    {
      return $this->db->where('id', $id)->update('promoters', ['status' => $status]);
    }
  }

  public function get_admin_promoter_by_id($id)
  {
    return $this->db->where('id', $id)
      ->get('promoters')
      ->row();
  }

  public function admin_delete_promoter($id)
  {
    return $this->db->where('id', $id)->delete('promoters');
  }
  // End Registration
  // public function getVendotList()
  // {
  //   return $this->db->query('SELECT * FROM `admin_master` WHERE id != "1" order by id desc ')->result_array();
  // }

  public function AddVendorData($request)
  {

    $link = site_url("/admin");


    $arrayName = array();
    $arrayName['name'] = $request['VendorName'];
    $arrayName['username'] = $request['VendorUserName'];
    $arrayName['email'] = $request['VendorEmail'];
    $arrayName['password'] = base64_encode($this->randomPassword());

    /*echo $arrayName['password']; exit;*/
    /*  $arrayName['password']    = (base64_encode($request['password']) == $sql['password']) ? $sql['password'] : base64_encode($request['password']);*/
    $arrayName['phone_no'] = $request['VendorCntct'];
    $arrayName['home_address'] = preg_replace('/["]/', '', $request['address1']);
    $arrayName['company_address'] = preg_replace('/["]/', '', $request['address2']);
    $arrayName['company_name'] = $request['CompanyName'];
    $arrayName['company_phone_no'] = $request['CompanyPhone'];
    $arrayName['company_pan_no'] = $request['CompanyPan'];
    $arrayName['company_tin_no'] = $request['CompanyTin'];

    if (!empty($request['profile_pic']))
    {
      $arrayName['profile_pic'] = $request['profile_pic'];
    }
    $arrayName['add_date'] = time();
    $arrayName['modify_date'] = time();
    $arrayName['status'] = '1';
    /*print_r($arrayName); exit;*/
    $insert = $this->db->insert('admin_master', $arrayName);
    if ($insert > 0)
    {
      $message = urlencode("Hi  " . $arrayName['name'] . " , Your Account has been successfully registered. Now you can Login your Login-Id : " . $request['VendorEmail'] . " and Password : " . base64_decode($arrayName['password']) . ". Click For Login " . $link . "");
      /* echo $message; exit;*/
      $mobile = urlencode($arrayName['phone_no']);

      $url = "http://bulksms.megainfomatix.com/http-api.php?username=lalitmohan&password=123456&senderid=MRNMRS&route=2&number=" . $mobile . "&message=" . $message;

      /*$url = "http://www.wiztechsms.com/http-api.php?username=vishal&password=123@vishal&senderid=FRETAD&route=2&number=".$requestMobile."&message=".urlencode($message);*/
      // $url = "http://138.201.192.131/http-api.php?username=demo&password=demo&senderid=azdemo&route=1&number=".$requestMobile."&message=".urlencode($message);
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_exec($ch);
      return 1;


      /* echo $url; exit;*/
    }
    return $this->db->affected_rows();
  }


  public function CheckContact($num = '')
  {
    $query = $this->db->query("SELECT * FROM `admin_master` where phone_no = '" . $num . "'")->num_rows();
    /*echo $this->db->last_query();exit;*/
    echo ($query > 0) ? '1' : '';
  }


  public function randomPassword()
  {
    $alphabet = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 10; $i++)
    {
      $n = rand(0, $alphaLength);
      $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
  }

  public function getSingleVendorData($id)
  {

    return $this->db->query('SELECT * FROM `admin_master` WHERE id = "' . $id . '" ')->row_array();
  }


  public function UpdateVendorData($request)
  {

    $arrayName = array();
    $arrayName['name'] = $request['VendorName'];
    $arrayName['username'] = $request['VendorUserName'];
    $arrayName['email'] = $request['VendorEmail'];
    $arrayName['phone_no'] = $request['VendorCntct'];
    $arrayName['home_address'] = preg_replace('/["]/', '', $request['address1']);
    $arrayName['company_address'] = preg_replace('/["]/', '', $request['address2']);
    $arrayName['company_name'] = $request['CompanyName'];
    $arrayName['company_phone_no'] = $request['CompanyPhone'];
    $arrayName['company_pan_no'] = $request['CompanyPan'];
    $arrayName['company_tin_no'] = $request['CompanyTin'];

    if (!empty($request['profile_pic']))
    {
      $arrayName['profile_pic'] = $request['profile_pic'];
    }

    $arrayName['modify_date'] = time();

    /*print_r($arrayName); exit;*/


    $this->db->where('id', $request['id']);
    $this->db->update('admin_master', $arrayName);

    return $this->db->affected_rows();
  }


  public function GetVendorProductTotal($v_id)
  {
    return $this->db->get_where("product_master", array('added_by_id' => $v_id, 'status!=' => '2'))->num_rows();
  }


  public function GetVendorTotalOrder($v_id)
  {
    return $this->db->get_where('purchase_master', array('vendor_master_id' => $v_id))->num_rows();
  }
}
