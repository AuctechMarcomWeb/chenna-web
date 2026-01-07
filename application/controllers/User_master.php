<?php

defined("BASEPATH") or exit("No direct script access allowed");

class User_master extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library("session");
        $this->load->library("cart");
        $this->load->helper("url");
        $this->load->model("User_master_model");
    }
    
    
   public function account_delete_req()
{
   
    $data = $this->input->post();
    
    
    $email = $data["email"];
    $reason = $data["reason"];
    $recipient_email = $data["email_id"];
    
   
    $subject = "Delete Account Request";
    
   
    $email_body = "Email: " . $email . "\nReason for Deletion: " . $reason;
    
    
    sentCommonEmailtest($recipient_email, $email_body, $subject);
    
  
    $this->session->set_flashdata('success_message', 'Delete account request submitted successfully!');
    
   
    echo '<script>
            setTimeout(function() {
                window.location.href = "' . base_url() . '";
            }, 1000);
          </script>';
}


    public function user_registration()
    {
        $table = "user_master";
        $data = $this->input->post();
        $email = $data["email_id"];
        $mobile = $data["phone_no"];

        $checkEmail = $this->User_master_model->check_mobile($mobile);
        if ($checkEmail > 0) {
            $this->session->set_flashdata(
                "error",
                '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button>Mobile Number Already exist, Please sign in.</div></div>'
            );
            redirect("/web");
        } else {
            $field["username"] = $data["username"];
            $field["email_id"] = $data["email_id"];
            $field["mobile"] = $data["phone_no"];
            $field["password"] = $data["password"];
            $field["status"] = "1";

            $field["add_date"] = time();
            $field["modify_date"] = time();

            $res = $this->db->insert($table, $field);
            $lastId = $this->db->insert_id();
            if ($res) {
                $user_data = [
                    "id" => $lastId,
                    "email" => $data["email_id"],
                    "username" => $data["username"],
                ];
                $user_ses = $this->session->set_userdata("User", $user_data);

                //******************************************************************************************* */
                $user = $user_data["username"];
                $emailid = $user_data["email"];
                $this->load->helper("/email/temp5");
                $status = "Registration Successfull";
                $dash_link = "https://www.dukekart.in/";
                $email_text =
                    "Your customer account has been successfully registered with Dukekart. Welcome to a new world of online shopping Go and check out soon https://www.dukekart.in/ for exciting offers and discount. You will get best shopping experience and great services with us";
                $email_body = temp5($status, $user, $email_text, $dash_link);
                $subject =
                    "Your customer account registration has been successfull";
                //******************************************************************************************** */

                $this->session->set_flashdata(
                    "activate",
                    '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button>Congratulations! You have successfully registered.</div></div>'
                );

                $message_content =
                    "Your customer account has been successfully registered with Dukekart  Regards, Dukekart Real time Private Limited , www.dukekart.in";

                //**OLD**	//$message_content='Your customer account has been successfully registered with Dukekart Go and check out soon https://www.dukekart.in/ for exciting offers and discount';

                $email_content =
                    "Your customer account has been successfully registered with Dukekart. Welcome to a new world of online shopping Go and check out soon https://www.dukekart.in/ for exciting offers and discount. You will get best shopping experience and great services with us";

                //   sendSMS($data['phone_no'],$message_content,'1307161736492501636');
                //sentCommonEmail($data['email_id'],$email_content,'Registration successfully.');

                sentCommonEmail($data["email_id"], $email_body, $subject);
                sendSMS(
                    $data["phone_no"],
                    $message_content,
                    "1007348779454247004"
                );

                redirect("/web");
            } else {
                $this->session->set_flashdata(
                    "error",
                    '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button>Somthing went wrong.</div></div>'
                );
                redirect("/web");
            }
        }
    }

    public function sendVerificationSMS()
    {
        // Get the mobile number from POST data
        $mobile_num = $this->input->post("mobile_num");

        // Extract only digits from the mobile number
        $mobile = $mobile_num;
        $mobile_otp = $this->input->post("otp");

        // Check if the mobile number is valid (10 digits)
        if (strlen($mobile) === 10 && strlen($mobile_otp) != 0) {
            // You can also get other parameters like $message and $template from POST data if needed
            $text =
                "Dear Customer Your Mobile Verification OTP is: " .
                $mobile_otp .
                " Please enter this OTP to verify your mobile number. From www.dukekart.inRegardsDukekart Real Time Private Limited";

            sendSMS($mobile_num, $text, "1007086055987083292");

            $this->output
                ->set_status_header(200)
                ->set_content_type("application/json")
                ->set_output(
                    json_encode([
                        "status" => "Success",
                        "message" => "SMS sent successfully",
                    ])
                );
        } else {
            // Return an error response for invalid mobile number
            $this->output
                ->set_status_header(400)
                ->set_content_type("application/json")
                ->set_output(
                    json_encode([
                        "status" => "Error",
                        "message" => "Invalid mobile number",
                    ])
                );
        }
    }

    public function user_login()
    {
        $data = $this->input->post();
        
        $mobile = $data["phone_no"];
        //  $password = $data['password'];
        //  $curr_url = $data['curr_url'];

        if (!empty($mobile)) {
            $user_res = $this->User_master_model->check_user($mobile);

            if (!empty($user_res)) {
                $user_data = [
                    "id" => $user_res["id"],
                    "email" => $user_res["email_id"],
                    "username" => $user_res["username"],
                ];
                $user_ses = $this->session->set_userdata("User", $user_data);

                // $this->session->set_flashdata('activate', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button>You have Sign In successfully.</div></div>');

                // redirect(base_url());

                $this->output
                    ->set_status_header(200)
                    ->set_content_type("application/json")
                    ->set_output(
                        json_encode([
                            "status" => "Success",
                            "message" => "Login successfull",
                        ])
                    );
            } else {
                // echo "<script> alert('Please Check your mobile or password'); </script>";

                // $this->session->set_flashdata('activate', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button>Please Check your mobile or password</div></div>');
                // redirect(base_url());
                $this->output
                    ->set_status_header(400)
                    ->set_content_type("application/json")
                    ->set_output(
                        json_encode([
                            "status" => "failure",
                            "message" => "Number not registered. Sign Up First",
                        ])
                    );
            }
        } else {
            $this->output
                ->set_status_header(400)
                ->set_content_type("application/json")
                ->set_output(
                    json_encode([
                        "status" => "failure",
                        "message" => "Your mobile number is not valid",
                    ])
                );
            // $this->session->set_flashdata('activate', '<div class="col-xs-12 col-sm-12 divPadding" id="err_success"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width: auto; color: #333; height: 20px;">×</button>Please Provide your mobile and password</div></div>');

            // redirect(base_url());
        }
    }
}
