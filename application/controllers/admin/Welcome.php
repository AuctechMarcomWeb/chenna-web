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








  // public function doLogin()
  // {
  //   $login_array = $this->input->post();

  //   //print_r($login_array); exit;
  //   $email = $login_array['email'];
  //   $password = $login_array['password'];

  //   $check = $this->db->get_where('admin_master', array('id' => '1'))->row_array();
  //   if ($check['email'] == $email)
  //   {
  //     $loginType = '1';
  //   } else
  //   {
  //     $loginType = '2';
  //   }


  //   /////////////////////////////// $oginType 1  IS FOR ADMIN LOGIN ///////////////////////////////


  //   $admin = $this->user_model->login($email, base64_encode($password), $loginType);

  //   if (!empty($admin))
  //   {

  //     $adminData = array(
  //       'is_logged_in' => true,
  //       'Type' => $loginType,
  //       'Id' => $admin['id'],
  //       'Name' => ucwords($admin['username']),
  //       'Email' => $admin['email'],
  //       'Picture' => $admin['profile_pic']
  //     );
  //     $this->session->set_userdata('adminData', $adminData);


  //     $message = 'Welcome <strong>' . ucwords($admin['username']) . '</strong>.You have successfully logged in.';
  //     $this->session->set_flashdata('login_message', getCustomAlert('S', $message));
  //     //print_r($_SESSION); exit;
  //     redirect('admin/Dashboard/index');

  //   } else
  //   {
  //     $this->session->set_flashdata('login_message', generateAdminAlert('D', 1));
  //     redirect('admin/Welcome');
  //   }

  // }

// public function doLogin()
// {
//     $post = $this->input->post();

//     $username = $post['email'];     // email
//     $password = $post['password'];  // plain password

//     // ---------------- ADMIN LOGIN ----------------
//     $admin = $this->user_model->login($username, $password); // ✅ FIXED

//     if (!empty($admin)) {
//         $adminData = array(
//             'is_logged_in' => true,
//             'Type' => 1,
//             'Id' => $admin['id'],
//             'Name' => ucwords($admin['username']),
//             'Email' => $admin['email'],
//             'Picture' => $admin['profile_pic']
//         );

//         $this->session->set_userdata('adminData', $adminData);
//         redirect('admin/Dashboard/index');
//         return;
//     }

//     // ---------------- VENDOR LOGIN ----------------
//     $vendor = $this->user_model->vendorLogin($username, $password);

//     if (!empty($vendor)) {
//         $vendorData = array(
//             'is_logged_in' => true,
//             'Type' => 2,
//             'Id' => $vendor['id'],
//             'Name' => ucwords($vendor['name']),
//             'Email' => $vendor['email'],
//             'Picture' => $vendor['profile_pic']
//         );

//         $this->session->set_userdata('adminData', $vendorData);
//         redirect('admin/Dashboard/index');
//         return;
//     }

//     // ---------------- INVALID LOGIN ----------------
//     $this->session->set_flashdata('login_message', '<div class="alert alert-danger">Invalid Email or Password</div>');
//     redirect('admin/Welcome');
// }

public function doLogin()
{
    $post = $this->input->post();

    $input    = trim($post['email']);   // Email OR Mobile
    $password = $post['password'];

    /* ===============================
       1️⃣ CHECK: EMAIL OR MOBILE
    =============================== */
    if (filter_var($input, FILTER_VALIDATE_EMAIL)) {

        // ---------------- ADMIN LOGIN (EMAIL ONLY) ----------------
        $admin = $this->user_model->adminLogin($input, $password);

        if (!empty($admin)) {
            $adminData = array(
                'is_logged_in' => true,
                'Type'   => 1,   // 1 = Admin
                'Id'     => $admin['id'],
                'Name'   => ucwords($admin['username']),
                'Email'  => $admin['email'],
                'Picture'=> $admin['profile_pic']
            );

            $this->session->set_userdata('adminData', $adminData);
            redirect('admin/Dashboard/index');
            return;
        }

        // Email se vendor ko login allow nahi
        $this->session->set_flashdata(
            'login_message',
            '<div class="alert alert-danger">Admin login only allowed using Email.</div>'
        );
        redirect('admin/Welcome');
        return;

    } elseif (preg_match('/^[0-9]{10}$/', $input)) {

        // ---------------- VENDOR LOGIN (MOBILE ONLY) ----------------
        $vendor = $this->user_model->vendorLogin($input, $password);

        if (!empty($vendor)) {
            $vendorData = array(
                'is_logged_in' => true,
                'Type'   => 2,   // 2 = Vendor
                'Id'     => $vendor['id'],
                'Name'   => ucwords($vendor['name']),
                'Email'  => $vendor['email'],
                'Picture'=> $vendor['profile_pic']
            );

            $this->session->set_userdata('adminData', $vendorData);
            redirect('admin/Dashboard/index');
            return;
        }

        // Mobile se admin ko login allow nahi
        $this->session->set_flashdata(
            'login_message',
            '<div class="alert alert-danger">Vendor login only allowed using Mobile Number.</div>'
        );
        redirect('admin/Welcome');
        return;
    }

    // ---------------- INVALID FORMAT ----------------
    $this->session->set_flashdata(
        'login_message',
        '<div class="alert alert-danger">Please enter valid Email (Admin) or Mobile Number (Vendor).</div>'
    );
    redirect('admin/Welcome');
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
      redirect('admin/Welcome');
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