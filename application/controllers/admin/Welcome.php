<?php
defined('BASEPATH') or exit('No direct script access allowed');
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

    if ($count == '0') {

      echo '0';
      exit;
    } else {

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

    if (empty($check)) {

      echo '0';
      exit;
    } else {

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
    $post = $this->input->post();

    $input    = trim($post['email']);
    $password = $post['password'];

    /* ===============================
       ADMIN LOGIN (EMAIL ONLY)
    =============================== */
    if (filter_var($input, FILTER_VALIDATE_EMAIL))
    {
        $admin = $this->user_model->adminLogin($input, $password);

        if (!empty($admin)) {
            $this->session->set_userdata('adminData', [
                'is_logged_in' => true,
                'Type'   => 1,
                'Id'     => $admin['id'],
                'Name'   => ucwords($admin['username']),
                'Email'  => $admin['email'],
                'Picture'=> $admin['profile_pic']
            ]);

            redirect('admin/Dashboard/index');
            return;
        }

        $this->session->set_flashdata(
            'login_message',
            '<div class="alert alert-danger">Invalid Admin Email or Password.</div>'
        );
        redirect('admin/Welcome');
        return;
    }

    /* ===============================
       MOBILE LOGIN (VENDOR / PROMOTER)
    =============================== */
    if (preg_match('/^[0-9]{10}$/', $input))
    {
        // -------- VENDOR --------
        $vendor = $this->user_model->vendorLogin($input, $password);
        if (!empty($vendor)) {
            $this->session->set_userdata('adminData', [
                'is_logged_in' => true,
                'Type'   => 2,
                'Id'     => $vendor['id'],
                'Name'   => ucwords($vendor['name']),
                'Email'  => $vendor['email'],
                'Picture'=> $vendor['profile_pic']
            ]);

            redirect('admin/Dashboard/index');
            return;
        }

        // -------- PROMOTER --------
        $promoter = $this->user_model->promoterLogin($input, $password);
        if (!empty($promoter)) {
            $this->session->set_userdata('adminData', [
                'is_logged_in' => true,
                'Type'   => 3,
                'Id'     => $promoter['id'],
                'Name'   => ucwords($promoter['name']),
                'Email'  => $promoter['email'],
                'Picture'=> $promoter['profile_pic']
            ]);

            redirect('admin/Dashboard/index');
            return;
        }

        // INVALID MOBILE LOGIN
        $this->session->set_flashdata(
            'login_message',
            '<div class="alert alert-danger">Invalid Mobile Number or Password.</div>'
        );
        redirect('admin/Welcome');
        return;
    }

    /* ===============================
       INVALID INPUT
    =============================== */
    $this->session->set_flashdata(
        'login_message',
        '<div class="alert alert-danger">Please enter valid Email or 10 digit Mobile Number.</div>'
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


    if (!empty($admin)) {

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
    } else {
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


    if (!empty($admin)) {

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
    } else {
      $this->session->set_flashdata('login_message', generateAdminAlert('D', 9));
      redirect('seller-login');
    }
  }



  public function logout()
  {

    $adminData = $this->session->userdata('adminData');
    if ($adminData['Type'] == '1') {

      $this->session->unset_userdata('adminData');
      $this->session->set_flashdata('login_message', generateAdminAlert('S', 8));
      redirect('admin/Welcome');
    } else {

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
