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
 public function check_duplicate($mobile, $aadhar, $pan)
{
    $q1 = $this->db->where('mobile', $mobile)
                   ->or_where('aadhar_card', $aadhar)
                   ->or_where('pan_card', $pan)
                   ->get('vendors')
                   ->row();

    $q2 = $this->db->where('mobile', $mobile)
                   ->or_where('aadhar_card', $aadhar)
                   ->or_where('pan_card', $pan)
                   ->get('promoters')
                   ->row();

    return ($q1 || $q2);
}


  public function insert_user($data, $role){
        $table = ($role == 'vendor') ? 'vendors' : 'promoters';
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

  public function approve_user($id, $role)
  {
    $this->db->where('id', $id);
    if ($role == 'vendor')
    {
      return $this->db->update('vendors', ['status' => 1]);
    } else
    {
      return $this->db->update('promoters', ['status' => 1]);
    }
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

// ================= GET PROMOTER BY CODE =================
public function get_promoter_by_code($code)
{
    return $this->db->get_where('promoters', ['promoter_code' => $code])->row();
}












  // End Registration
  public function getVendotList()
  {
    return $this->db->query('SELECT * FROM `admin_master` WHERE id != "1" order by id desc ')->result_array();
  }

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