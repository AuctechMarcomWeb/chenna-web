<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Welcome extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('message');
    $this->load->library('session');
    $this->load->model('user_model');
  }



  public function index()
  {
    $this->load->view('/admin/login');
  }



  public function forgot_pass()
  {
    $this->load->view('admin/forgot_password');
  }

  public function check_mobile()
  {

    $mobile = $this->input->post('mobile');

    $count = $this->db->get_where('staff_master', array('mobile' => $mobile))->num_rows();

    if ($count == '0')
    {

      echo '0';
      exit;

    } else
    {

      echo '1';
      $this->send_otp($mobile);
      exit;
    }

  }


  public function send_otp($mobile)
  {
    $chars = "0123456789";
    $otp = substr(str_shuffle($chars), 0, 6);
    $field['mobile_otp'] = $otp;
    $this->db->where('mobile', $mobile);
    $this->db->update('staff_master', $field);
    $text = 'Dear Customer Your Forgot Password OTP is: ' . $otp . ' Thanks. DUKEKART PRIVATE LIMITED.';

    sendSMS($mobile, $text, '1007390806821450886');

  }

  function sendSMS($mobile, $message, $template)
  {

    $url = "http://sms.txly.in/vb/apikey.php?apikey=glNySZAajwGzc6mO&senderid=DUKRLT&templateid=" . $template . "&number=" . $mobile . "&message=" . urlencode($message);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_exec($ch);


    return 1;

  }


  public function check_otp()
  {

    $mobile = $this->input->post('mobile');
    $otp = $this->input->post('otp');
    $check = $this->db->get_where('staff_master', array('mobile' => $mobile, 'mobile_otp' => $otp))->row_array();

    if (empty($check))
    {

      echo '0';
      exit;

    } else
    {

      echo '1';
      exit;

    }


  }


  public function change_password()
  {
    $mobile = $this->input->post('mobile');
    $password = $this->input->post('password');
    $field['password'] = $password;
    $this->db->where('mobile', $mobile);
    echo $row = $this->db->update('staff_master', $field);
    exit;

  }








  public function doLogin()
  {
    $loginType = $this->input->post('loginType'); // 1=Admin, 2=Vendor, 3=Promoter
    $identity = $this->input->post('identity');  // email for admin, mobile for others
    $password = $this->input->post('password');

    $user = $this->user_model->login($identity, $password, $loginType);

    if (!empty($user))
    {

      // ===== CHECK APPROVAL FOR VENDOR & PROMOTER =====
      if (($loginType == 2 || $loginType == 3) && $user['status'] == 0)
      {
        $this->session->set_flashdata(
          'login_message',
          "<div class='alert alert-danger'>Your account is not approved by Admin yet!</div>"
        );
        redirect('login');
      }

      // ===== SET SESSION =====
      $sessionData = array(
        'is_logged_in' => true,
        'Type' => $loginType,
        'Id' => $user['id'],
        'Name' => ucwords($user['name'] ?? $user['username']),
        'Email' => $user['email'],
        'Picture' => $user['profile_pic']
      );
      $this->session->set_userdata('adminData', $sessionData);

      // ===== SUCCESS MESSAGE =====
      $this->session->set_flashdata(
        'login_message',
        "<div class='alert alert-success'>Welcome <strong>{$sessionData['Name']}</strong>. Login successful.</div>"
      );

      // ===== REDIRECT BASED ON ROLE =====
      if ($loginType == 1)
      {
        redirect('admin/Dashboard/index');
      }
      if ($loginType == 2)
      {
        redirect('vendor/Dashboard');
      }
      if ($loginType == 3)
      {
        redirect('promoter/Dashboard');
      }

    } else
    {
      $this->session->set_flashdata(
        'login_message',
        "<div class='alert alert-danger'>Invalid Login Details</div>"
      );
      redirect('login');
    }
  }


  public function approveUser($id, $role)
  {
    $this->Vendor_model->approve_user($id, $role);
    $user = $this->Vendor_model->get_user($id, $role);

    $msg = "Hello {$user->name},<br><br>
            Your account has been <b>Approved</b> by Admin.<br>
            <b>Login ID:</b> {$user->mobile}<br>
            <b>Password:</b> (same as registered)<br><br>
            Team Chenna";

    $this->email_send->send_email($user->email, $msg, "Account Approved");

    $this->session->set_flashdata('success', 'User Approved & Mail Sent');
    redirect('admin/Dashboard');
  }






  public function sellerLogin()
  {
    $login_array = $this->input->post();
    //print_r($login_array); exit;
    $loginType = $login_array['loginType'];
    $mobile = $login_array['mobile'];
    $password = $login_array['password'];


    /////////////////////////////// $oginType 1  IS FOR ADMIN LOGIN ///////////////////////////////


    $admin = $this->user_model->login($mobile, $password, $loginType);


    if (!empty($admin))
    {

      $adminData = array(
        'is_logged_in' => true,
        'Type' => $loginType,
        'Id' => $admin['id'],
        'Name' => ucwords($admin['name']),
        'Email' => $admin['email'],
        'Picture' => $admin['profile_pic']
      );
      $this->session->set_userdata('adminData', $adminData);


      $message = 'Welcome <strong>' . ucwords($admin['username']) . '</strong>.You have successfully logged in.';
      $this->session->set_flashdata('login_message', getCustomAlert('S', $message));
      //print_r($_SESSION); exit;
      // $success = base64_encode('1');
      $success = '1';
      redirect('admin/Dashboard/index/' . $success);

    } else
    {
      $this->session->set_flashdata('login_message', generateAdminAlert('D', 9));
      redirect('seller-login');
    }

  }


  //This function is not in use yet. it was made for admin dashboard to open seller dashboard using a get url.
  public function sellerLoginGet()
  {
    $login_array = $this->input->get();
    //print_r($login_array); exit;
    $loginType = $login_array['loginType'];
    $mobile = $login_array['mobile'];
    $password = $login_array['password'];


    /////////////////////////////// $oginType 1  IS FOR ADMIN LOGIN ///////////////////////////////


    $admin = $this->user_model->login($mobile, $password, $loginType);


    if (!empty($admin))
    {

      $adminData = array(
        'is_logged_in' => true,
        'Type' => $loginType,
        'Id' => $admin['id'],
        'Name' => ucwords($admin['name']),
        'Email' => $admin['email'],
        'Picture' => $admin['profile_pic']
      );
      $this->session->set_userdata('sellerData', $adminData);


      $message = 'Welcome <strong>' . ucwords($admin['username']) . '</strong>.You have successfully logged in.';
      $this->session->set_flashdata('login_message', getCustomAlert('S', $message));
      //print_r($_SESSION); exit;
      // $success = base64_encode('1');
      $success = '1';
      redirect('admin/Dashboard/index/' . $success);

    } else
    {
      $this->session->set_flashdata('login_message', generateAdminAlert('D', 9));
      redirect('seller-login');
    }

  }



  public function logout()
  {

    $adminData = $this->session->userdata('adminData');
    if ($adminData['Type'] == '1')
    {

      $this->session->unset_userdata('adminData');
      $this->session->set_flashdata('login_message', generateAdminAlert('S', 8));
      redirect('admin/Welcome');

    } else
    {

      $this->session->unset_userdata('adminData');
      $this->session->set_flashdata('login_message', generateAdminAlert('S', 8));
      redirect('seller-login');
    }
  }


  public function School_logout()
  {
    $this->session->unset_userdata('adminData');
    $this->session->set_flashdata('login_message', generateAdminAlert('S', 8));
    redirect('school');
  }
}
?>