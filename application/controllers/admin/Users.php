<?php defined('BASEPATH') or exit('No direct script access allowed');
class Users extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('email');
		$this->load->library('session');
		$this->load->helper('message');
		$this->load->model('Manage_Users_Model');
		 is_not_logged_in();
		 

	}

	public function index()
	{
		is_not_logged_in();
		$data['index'] = 'Users';
		$data['index2'] = '';
		$data['title'] = 'Manage Users';

		$users = $this->Manage_Users_Model->getUserList();

		foreach ($users as &$user)
		{
			$user['total_orders'] = $this->Manage_Users_Model->getTotalOrders($user['id']);
			$user['total_amount_spent'] = $this->Manage_Users_Model->getTotalAmountSpent($user['id']);
			$user['addresses'] = $this->Manage_Users_Model->GetUserAddress($user['id']);
		}

		$data['getData'] = $users;

		$this->load->view('include/header', $data);
		$this->load->view('Users/UsersList');
		$this->load->view('include/footer');
	}



	public function AddUsers()
	{

		$data['index'] = 'addUser';
		$data['index2'] = '';
		$data['title'] = 'Manage Users';

		$this->load->view('include/header', $data);
		$this->load->view('Users/AddUser');
		$this->load->view('include/footer');
	}


	public function AddUsersData()
	{
		$data = $this->input->post();
		/*	echo"<pre>";
			 print_r($data); exit;*/

		/*$fileName  = $_FILES["uploadFileVendor"]["name"];
	   $extension = explode('.',$fileName);
	   $extension = strtolower(end($extension));
	   $uniqueName= 'Vendor_'.uniqid().'.'.$extension;
	   $type      = $_FILES["uploadFileVendor"]["type"];
	   $size      = $_FILES["uploadFileVendor"]["size"];
	   $tmp_name  = $_FILES['uploadFileVendor']['tmp_name'];
	   $targetlocation= PROFILE_DIRECTORY.$uniqueName;

	   if(!empty($fileName)){
	   move_uploaded_file($tmp_name,$targetlocation);
	   $data['profile_pic'] = utf8_encode(trim($uniqueName));
	   }*/

		$row = $this->Manage_Users_Model->AddUsersData($data);
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', ' Users has been add Successfully.'));
			redirect('admin/Vendor/');
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
			redirect('admin/Vendor/');
		}
	}



	public function Useraddress($id = '')
	{
		$data['index'] = 'Users';
		$data['index2'] = '';
		$data['title'] = 'View User Address';
		$data['getData'] = $this->Manage_Users_Model->GetUserAddress($id);
		$data['getSingleData'] = $this->Manage_Users_Model->getSingleData($id, 'user_master', 'username');
		/*echo "<pre>";
		print_r($data['getSingleData']); exit;*/

		$this->load->view('include/header', $data);
		$this->load->view('Users/ViewAddress');
		$this->load->view('include/footer');
	}


	public function ResetPass($id = '')
	{
		$query = $this->db->query("SELECT * FROM `user_master` where id = '" . $id . "'")->row_array();
		$SendSMS = $this->randomPassword($id, $query['phone_no']);
		echo $SendSMS;
	}


	public function forgotPassword()
	{


		$templateId = '1007860657778009217';
		$mobile = $this->input->post('mobile');
		$check = $this->db->get_where('user_master', array('mobile' => $mobile))->row_array();

		if (!empty($check))
		{
			$chars = "0123456789";
			$otp = substr(str_shuffle($chars), 0, 6);

			$message = $otp . " is your One Time Password (OTP) You can now reset your password with the given otp! - From www.dukekart.inRegards DUKEKART REALTIME PRIVATE";
			// $message ="Dear ".$check['username'].", Your OTP is ".$otp." Thanks.DUKEKART PRIVATE LIMITED.";
			sendSMS($mobile, $message, $templateId);
			$fields['otp'] = $otp;
			$this->db->where('mobile', $mobile);
			$this->db->update('user_master', $fields);

			echo '1';
			exit;

		} else
		{

			echo '2';
			exit;

		}


	}


	public function resendOTP($mobile)
	{

		$check = $this->db->get_where('user_master', array('mobile' => $mobile))->row_array();

		if (!empty($check))
		{
			$chars = "0123456789";
			$otp = substr(str_shuffle($chars), 0, 6);
			$message = "Dear " . $check['username'] . ", Your Forgot password OTP is " . $otp . " Thanks. DUKEKART PRIVATE LIMITED.";
			sendSMS($mobile, $message, '1007390806821450886');
			$fields['otp'] = $otp;
			$this->db->where('mobile', $mobile);
			$this->db->update('user_master', $fields);

			echo '1';
			exit;

		} else
		{

			echo '2';
			exit;

		}


	}




	public function randomPassword($id = '', $mobile = '')
	{

		$alphabet = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 10; $i++)
		{
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		// Send msg to user
		/*echo implode($pass); exit;*/

		$message = urlencode("Hi, Your New Password : " . implode($pass) . ".");
		/*echo $message; exit;*/
		$mobile = urlencode($mobile);
		$url = "http://www.wiztechsms.com/http-api.php?username=shiblee&password=Mega@123&senderid=VPUNCH&route=2&number=" . $mobile . "&message=" . $message;
		//print_r($url); exit;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_exec($ch);
		// return 1;


		$arrayName = array();
		$arrayName['password'] = base64_encode(implode($pass));
		$this->db->where('id', $id);
		$row = $this->db->update('user_master', $arrayName);
		return ($row == 1) ? '1' : '';

	}



	public function UsersStatus($id)
	{
		$id = $this->uri->segment(4);
		$sql = $this->db->query("SELECT * from user_master where id= '" . $id . "'")->row_array();
		$sql['status'];
		$arrayName = array();
		$arrayName['status'] = ($sql['status'] == 1) ? '2' : '1';
		$this->db->where('id', $id);
		$this->db->update('user_master', $arrayName);
		echo $arrayName['status'];

	}

	public function UpdateUsers($id = '')
	{
		$data['index'] = 'UpdtUsers';
		$data['index2'] = '';
		$data['title'] = 'Manage Users';
		$data['getData'] = $this->Manage_Users_Model->getSingleUsersData($id);
		$data['user_address'] = $this->Manage_Users_Model->GetData('user_addressmaster', array('user_master_id' => $id), '', $id);
		$data['countries_list'] = $this->Manage_Users_Model->GetData('countries_list', array(), array('column' => 'name', 'columnData' => 'asc'), '');
		/* echo "<pre>";
		print_r($data['user_address']); exit;*/

		$this->load->view('include/header', $data);
		$this->load->view('Users/UpdateUsers');
		$this->load->view('include/footer');
	}


	public function UpdateUserData($id = '')
	{
		$data = $this->input->post();
		$data['id'] = $id;

		$fileName = $_FILES["uploadFileUsers"]["name"];
		$extension = explode('.', $fileName);
		$extension = strtolower(end($extension));
		$uniqueName = 'User_' . uniqid() . '.' . $extension;
		$type = $_FILES["uploadFileUsers"]["type"];
		$size = $_FILES["uploadFileUsers"]["size"];
		$tmp_name = $_FILES['uploadFileUsers']['tmp_name'];
		$targetlocation = PROFILE_DIRECTORY . $uniqueName;


		$userDeatil = array(
			'username' => $data['username'],
			'email_id' => $data['email_id'],
			'mobile' => $data['mobile'],
			'whatsaap_number' => $data['whatsaap_number'],
			'alternate_number' => $data['alternate_number'],
			'address' => $data['address'],
			'locality' => $data['locality'],
			'city' => $data['city'],
			'state' => $data['state'],
			'pincode' => $data['pincode'],
			'status' => $data['status'],
			'modify_date' => time(),

		);




		if (!empty($fileName))
		{
			$user_address = $this->Manage_Users_Model->GetData('user_master', array('id' => $id), '', $id);
			unlink('assets/Website/img/' . $user_address['profile_pic']);
			move_uploaded_file($tmp_name, $targetlocation);
			$data['profile_pic'] = utf8_encode(trim($uniqueName));
		}

		$row = $this->Manage_Users_Model->UpdateUsersData($data);
		//$updated = $this->Manage_Users_Model->updateData('user_addressmaster',$userAddress,array('user_master_id'=>$id));	

		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', ' Users details has been Updated Successfully.'));
			redirect('admin/Users/');
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
			redirect('admin/Users/');
		}
	}

	public function delete_user($user_id)
	{
		$this->db->where('id', $user_id);
		$row = $this->db->delete('user_master');

		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', ' User Deleted Successfully.'));
			redirect('admin/Users/');
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
			redirect('admin/Users/');
		}

	}




	public function get_city_by_id($state_id)
	{
		$Data = $this->db->get_where('cities_list', array('state_id' => $state_id))->result_array();
		$html = '';
		$html .= '<option value ="">Select City</option>';
		foreach ($Data as $value)
		{

			$html .= '<option value ="' . $value['id'] . '"  >' . $value['name'] . '</option>';
		}
		echo $html;

	}






	public function UserTransaction($user = '')
	{
		$data['index'] = 'Users';
		$data['index2'] = '';
		$data['title'] = 'Manage Users';
		$this->db->order_by('id', 'desc');
		$data['getData'] = $this->db->get_where('transaction_history', array('user_master_id' => $user))->result_array();
		$data['user_id'] = $user;

		$this->load->view('include/header', $data);
		$this->load->view('Users/transaction');
		$this->load->view('include/footer');
	}
	public function creditWallet($userId = '')
	{

		$data['index'] = 'Users';
		$data['index2'] = '';
		$data['title'] = 'Manage Credit';
		$data['getData'] = $this->db->get_where('user_master', array('id' => $userId))->row_array();

		$this->load->view('include/header', $data);
		$this->load->view('Users/creditWallet');
		$this->load->view('include/footer');
	}
	public function creditAmountPost($userId = '')
	{

		$amount = $this->input->post('amount');

		$oldAmt = $this->db->get_where('user_master', array('id' => $userId))->row_array();
		$updateAmt = $oldAmt['wallet_amount'] + $amount;

		$array = array();
		$array['wallet_amount'] = $updateAmt;

		$this->db->where('id', $userId);
		$run = $this->db->update('user_master', $array);
		if ($run > 0)
		{
			$field = array();
			$field['type'] = '3';
			$field['amount'] = $amount;
			$field['user_master_id'] = $userId;
			$field['status'] = '2';
			$field['debit_credit'] = "2";
			$field['remark'] = "You have received Rs." . $amount . " in your wallet by" . PROJECT_tit . ".";
			$field['add_date'] = time();
			$this->db->insert('transaction_history', $field);

			$mobile = urlencode($oldAmt['phone_no']);
			$message = urlencode("Dear customer, You have received Rs." . $amount . " in your wallet by " . PROJECT_tit . ".\r\nThanks\r\n" . PROJECT_tit . ".");
			$this->SendUserSMS($mobile, $message);

			$this->session->set_flashdata('activate', getCustomAlert('S', 'Amount has been added Successfully.'));
			redirect('admin/Users/');

		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
			redirect('admin/Users/');
		}
	}

	public function SendUserSMS($mobile, $message)
	{
		$url = "http://bulksms.megainfomatix.com/http-api.php?username=lalitmohan&password=123456&senderid=MRNMRS&route=2&number=" . $mobile . "&message=" . $message . "";


		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_exec($ch);
		return 1;

	}

	public function getaddressDetails()
	{
		$id = $this->input->post('id');
		$user_address = $this->Manage_Users_Model->GetData('user_addressmaster', array('id' => $id), '', $id);

		$state_list = $this->Manage_Users_Model->GetData('states_list', array('country_id' => $user_address['countery_id']), array('column' => 'name', 'columnData' => 'asc'), '');
		$html = '<option value="">Select State</option>';
		$sel = '';
		if (!empty($state_list))
		{
			foreach ($state_list as $key => $stateData)
			{
				if ($stateData['id'] == $user_address['state_list_id'])
				{
					$sel = 'selected';
				} else
				{
					$sel = '';
				}
				$html .= '<option value="' . $stateData['id'] . '" ' . $sel . ' >' . ucfirst($stateData['name']) . '</option>';
			}
		}
		$user_address['state_select'] = $html;

		// here get countery 
		$countries_list = $this->Manage_Users_Model->GetData('countries_list', array(), array('column' => 'name', 'columnData' => 'asc'), '');
		$html = '<option value="">Select Country</option>';
		$sel = '';
		if (!empty($countries_list))
		{
			foreach ($countries_list as $key => $countriesData)
			{
				if ($countriesData['id'] == $user_address['countery_id'])
				{
					$sel = 'selected';
				} else
				{
					$sel = '';
				}
				$html .= '<option value="' . $countriesData['id'] . '" ' . $sel . ' >' . ucfirst($countriesData['name']) . '</option>';
			}
		}
		$user_address['country_select'] = $html;
		echo json_encode($user_address);
	}

	public function updateAddress()
	{
		$data = $this->input->post();
		$save_arr = array(
			'name' => ucfirst($data['name']),
			'phone_no' => $data['mobile'],
			'alternative_phone_optional' => $data['alter_mobile'],
			'address2' => ucfirst($data['flat_no']),
			'address1' => $data['locality'],
			'district_city_town' => ucfirst($data['city']),
			'countery_id' => $data['country'],
			'state_list_id' => $data['state'],
			'pincode' => $data['pincode'],
			'landmark_optional' => ucfirst($data['landmark']),
			'modify_date' => time()
		);

		$save = $this->Manage_Users_Model->updateData('user_addressmaster', $save_arr, array('id' => $data['id']));
		if ($save > 0)
		{
			$this->session->set_flashdata('activate', AlertMSG('S', 'Address have been successfully updated.'));
		} else
		{
			$this->session->set_flashdata('activate', AlertMSG('W', 'Oops! Something wrong.'));
		}
	}


	public function myAccount($id = '')
	{
		$data = $this->input->post();
		$adminData = $this->session->userdata('adminData');
		// echo "<pre>";print_r($adminData);exit();
		if (empty($data))
		{
			$data['index'] = 'Vendor';
			$data['index2'] = '';
			$data['stateList'] = $this->db->get_where('states_list', array('country_id' => '101'))->result_array();
			if ($adminData['Type'] == '2')
			{

				$data['getData'] = $this->db->get_where('staff_master', array('id' => $adminData['Id']))->row_array();

			} else
			{

				$data['getData'] = $this->db->get_where('staff_master', array('id' => $id))->row_array();

			}
			//  echo "<pre>";print_r($data['getData']);exit();
			$data['title'] = 'My Account';
			$this->load->view('include/header', $data);
			$this->load->view('myAccount/updateProfile');
			$this->load->view('include/footer');
		} else
		{

			if (!empty($data['mobile_verify']))
			{
				$data['mobile_verify'] = '1';
			} else
			{
				// $data['mobile_verify']= '2';
			}

			if (!empty($data['email_verify']))
			{
				$data['email_verify'] = '1';
			} else
			{
				// $data['email_verify']= '2';
			}

			if (!empty($data['account_verify']))
			{
				$data['account_verify'] = '1';
			} else
			{
				// $data['account_verify']= '2';
			}


			if (!empty($data['kyc_verify']))
			{
				$data['kyc_verify'] = '1';
			} else
			{
				// $data['kyc_verify']= '2';
			}



			$fileName = $_FILES["uploadFileVendor"]["name"];
			$extension = explode('.', $fileName);
			$extension = strtolower(end($extension));
			$uniqueName = 'Vendor_' . uniqid() . '.' . $extension;
			$type = $_FILES["uploadFileVendor"]["type"];
			$size = $_FILES["uploadFileVendor"]["size"];
			$tmp_name = $_FILES['uploadFileVendor']['tmp_name'];
			$targetlocation = LOGO_DIRECTORY . $uniqueName;

			if (!empty($fileName))
			{
				move_uploaded_file($tmp_name, $targetlocation);
				$data['profile_pic'] = utf8_encode(trim($uniqueName));
			}
			$this->db->where('id', $id);
			$save = $this->db->update('staff_master', $data);

			if ($save > 0)
			{
				$this->session->set_flashdata('activate', AlertMSG('S', 'Data have been successfully updated.'));
				redirect('admin/Users/myAccount/' . $this->uri->segment('4'));
			} else
			{
				$this->session->set_flashdata('activate', AlertMSG('W', 'Oops! Something wrong.'));
			}

		}


	}


	public function sendSmsEmail($user_id)
	{
		$this->db->select('mobile,name,email');
		$Staff = $this->db->get_where('staff_master', array('id' => $user_id))->row_array();

		$message = 'Dear ' . $Staff['name'] . 'Your document has been verified and the registration process  is completed.RegardsDukekart Real Time Private Limited (www.dukekart.in)';

		$email_message = 'Dear ' . $Staff['name'] . ',

         Thank you for joining Dukekart. 

         Your document has been verified and registration process  is completed. Now you can list your product on our website. Just after you will finish the product listing process, we will verify the products and will send you the approval mail of product verification.';

		sendSMS($Staff['mobile'], $message, '1007876947797477828');//
		sentCommonEmail($Staff['email'], $email_message, 'Document Verification Successfully.');
		$this->session->set_flashdata('activate', getCustomAlert('S', 'Account Verification Alert Send  Successfully.'));
		redirect('admin/users/myAccount/' . $user_id);
	}


	public function SaveProfileDocument($staff_id)
	{
		$data = $this->input->post();
		$no_element = count($data['title']);

		for ($i = 0; $i < $no_element; $i++)
		{

			$fileName = $_FILES['document']["name"][$i];
			$extension = explode('.', $fileName);
			$extension = strtolower(end($extension));
			$uniqueName = 'Vendor_' . uniqid() . '.' . $extension;
			$fileName = $_FILES['document']["name"][$i];
			$type = $_FILES['document']["type"][$i];
			$size = $_FILES['document']["size"][$i];
			$tmp_name = $_FILES['document']['tmp_name'][$i];
			//   $targetlocation= PROFILE_DIRECTORY.$uniqueName;
			$targetlocation = $_SERVER['DOCUMENT_ROOT'] . '/assets/Website/img/' . $uniqueName;
			//   echo "<pre>";print_r($targetlocation);exit();
			if (!empty($fileName))
			{
				move_uploaded_file($tmp_name, $targetlocation);
				$request['document'] = utf8_encode(trim($uniqueName));
			}

			$fields['document'] = $request['document'];
			$fields['title'] = $data['title'][$i];
			$fields['serial_number'] = $data['serial_number'][$i];
			$fields['staff_id'] = $staff_id;
			$fields['add_date'] = time();
			$fields['modify_date'] = time();
			$fields['status'] = '1';

			$this->db->insert('staff_kyc_document', $fields);


		}

		$this->session->set_flashdata('activate', AlertMSG('S', 'Document have been successfully updated.'));
		redirect('admin/Users/myAccount/' . $this->uri->segment('4') . '?Type=2');



	}



	public function deleteDoc($id, $staff_id = '')
	{
		$this->db->where('id', $id);
		$row = $this->db->delete('staff_kyc_document');
		//   echo "<pre>";print_r($row);exit();
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', AlertMSG('S', 'Document have been successfully Deleted.'));
			redirect('admin/Users/myAccount/' . $staff_id . '?Type=2');

		} else
		{

			$this->session->set_flashdata('activate', AlertMSG('W', 'Oops! Something wrong.'));

		}

	}

	public function delete_seller($id)
	{

		$this->db->where('id', $id);
		$this->db->delete('staff_master');

		$this->db->where('vendor_id', $id);
		$row = $this->db->delete('shop_master');

		if ($row > 0)
		{
			$this->session->set_flashdata('activate', AlertMSG('S', 'Seller have been successfully Deleted.'));
			redirect('admin/Vendor/');

		} else
		{

			$this->session->set_flashdata('activate', AlertMSG('W', 'Oops! Something wrong.'));

		}

	}


	public function verify($id, $type, $staff_id)
	{
		if ($type == '1')
		{
			$field['verify_status'] = '1';
			$this->db->where('id', $id);
			$row = $this->db->update('staff_kyc_document', $field);

			if ($row > 0)
			{
				$this->session->set_flashdata('activate', AlertMSG('S', 'Document verify successfully.'));
				redirect('admin/Users/myAccount/' . $staff_id . '?Type=2');

			} else
			{

				$this->session->set_flashdata('activate', AlertMSG('W', 'Oops! Something wrong.'));

			}
		} else
		{

			$field['verify_status'] = '2';
			$this->db->where('id', $id);
			$row = $this->db->update('staff_kyc_document', $field);
			if ($row > 0)
			{
				$this->session->set_flashdata('activate', AlertMSG('S', 'Document Unverify successfully.'));
				redirect('admin/Users/myAccount/' . $staff_id . '?Type=2');

			} else
			{

				$this->session->set_flashdata('activate', AlertMSG('W', 'Oops! Something wrong.'));

			}
		}


	}

	public function verify_all($id, $type)
	{
		if ($type == '1')
		{
			$field['verify_status'] = '1';
			$this->db->where('staff_id', $id);
			$row = $this->db->update('staff_kyc_document', $field);
			if ($row > 0)
			{
				$this->session->set_flashdata('activate', AlertMSG('S', 'All Document Verify successfully.'));
				redirect('admin/Users/myAccount/' . $id . '?Type=2');

			} else
			{

				$this->session->set_flashdata('activate', AlertMSG('W', 'Oops! Something wrong.'));

			}

		} else if ($type == '2')
		{
			$field['verify_status'] = '2';
			$this->db->where('staff_id', $id);
			$row = $this->db->update('staff_kyc_document', $field);
			if ($row > 0)
			{
				$this->session->set_flashdata('activate', AlertMSG('S', 'All Document Unverify successfully.'));
				redirect('admin/Users/myAccount/' . $id . '?Type=2');

			} else
			{
				$this->session->set_flashdata('activate', AlertMSG('W', 'Oops! Something wrong.'));

			}
		} else
		{
			$this->db->where('staff_id', $id);
			$row = $this->db->delete('staff_kyc_document');
			if ($row > 0)
			{
				$this->session->set_flashdata('activate', AlertMSG('S', 'All Document Deleted successfully.'));
				redirect('admin/Users/myAccount/' . $id . '?Type=2');

			} else
			{
				$this->session->set_flashdata('activate', AlertMSG('W', 'Oops! Something wrong.'));

			}



		}



	}



	public function verify_email()
	{
		$id = $this->input->post('id');

		$user = $this->db->get_where('staff_master', array('id' => $id))->row_array();
		$otpSeller = rand(1000, 9999);
		$text = "Dear " . $user['name'] . " Your Email Verification OTP is: " . $otpSeller . " Please enter this OTP to verify your mobile number. From www.Dukekart.in RegardsDukekart Real Time Private Limited";

		sentCommonEmail($user['email'], $text, "Email Verification OTP");
		$data = array(
			'email_otp' => $otpSeller, // Replace $newOTP with the new OTP value
		);

		$this->db->where('id', $id);
		$this->db->update('staff_master', $data);

		$html = '';
		$html .= '<div class="row">
          <div class="col-md-12">
            <span>Please Enter OTP to Verify Email</span>
            <input type="number" class="form-control" id="email_otp_ver" name="email_otp">
          </div>
        </div>';
		echo $html;
		exit;
	}

	public function verify_email_otp()
	{
		$id = $this->input->post('id');
		$otp = $this->input->post('otp');

		$user = $this->db->get_where('staff_master', array('id' => $id))->row_array();

		if ($user && $user['email_otp'] == $otp)
		{

			$this->db->where('id', $id);
			$this->db->update('staff_master', array('email_verify' => 1));

			$response = array('status' => 'success', 'message' => 'OTP verification successful');
		} else
		{
			$response = array('status' => 'failure', 'message' => 'OTP verification failed');
		}

		echo json_encode($response);

	}




	public function verify_mobile()
	{
		$id = $this->input->post('id');

		$user = $this->db->get_where('staff_master', array('id' => $id))->row_array();
		$otpSeller = rand(1000, 9999);
		$text = "Dear " . $user['name'] . " Your Mobile Verification OTP is: " . $otpSeller . " Please enter this OTP to verify your mobile number. From www.Dukekart.inRegardsDukekart Real Time Private Limited";
		sendSMS($user['mobile'], $text, "1007086055987083292");

		$data = array(
			'mobile_otp' => $otpSeller,
		);

		$this->db->where('id', $id);
		$this->db->update('staff_master', $data);

		$html = '';
		$html .= '<div class="row">
          <div class="col-md-12">
            <span>Please Enter OTP to Verify Mobile Number</span>
            <input type="number" class="form-control" id="mobile_otp_ver" name="mobile_otp">
          </div>
        </div>';
		echo $html;
		exit;

	}

	public function verify_mobile_otp()
	{
		$id = $this->input->post('id');
		$otp = $this->input->post('otp');

		$user = $this->db->get_where('staff_master', array('id' => $id))->row_array();

		if ($user && $user['mobile_otp'] == $otp)
		{

			$this->db->where('id', $id);
			$this->db->update('staff_master', array('mobile_verify' => 1));

			$response = array('status' => 'success', 'message' => 'OTP verification successful');
		} else
		{
			$response = array('status' => 'failure', 'message' => 'OTP verification failed');
		}

		echo json_encode($response);

	}

	public function all_contact_list()
	{
		$data['index2'] = 'ContactUsList';
		$this->db->select('*');

		$this->db->from('user_messages');
		$this->db->order_by('id', 'DESC');

		$data['getData'] = $this->db->get()->result_array();

		$this->load->view('include/header');
		$this->load->view('Users/AllContactUsList', $data);
		$this->load->view('include/footer');
	}

	public function all_review_list()
	{
		$data['index2'] = 'AllCustomerRiview';
		$this->db->order_by('id', 'DESC');
		$data['getData'] = $this->db->get('customer_review')->result_array();

		$this->load->view('include/header');
		$this->load->view('Users/AllCustomerRiview', $data);
		$this->load->view('include/footer');
	}

	// Delete review
	public function delete_review($id)
	{
		$this->db->where('id', $id);
		$row = $this->db->delete('customer_review');
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', ' Customer Review has been deleted Successfully.'));
			redirect('admin/Users/all_review_list/');
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
			redirect('admin/Users/all_review_list/');
		}

	}



	// public function verify_mobile(){
//  $id = $this->input->post('id');
//   $html='';
//   $html.='<div class="row">
//           <div class="col-md-12">
//             <span>Please Enter OTP to Verify Mobile Number</span>
//             <input type="number" class="form-control" name="mobile_otp">
//           </div>
//         </div>';
// echo $html; exit;

	// }



	public function addMoreDoc()
	{

		$id = $this->input->post('id');
		$html = '';
		$html .= ' <div id="remove_' . $id . '" style="margin-top:10px;">
                   <div class="form-group">
                      <div class="col-md-12">
                       <span  class="btn btn-danger" style="float: right;" onclick="remove_row(' . $id . ')" >Remove</span>
                      </div>
                   </div>
                   <div class="row" style="margin-left: 10px;">
                           <div class="col-sm-4" >
                               <label>Document Title*</label>
                              <input type="text"  class="form-control" required="" name="title[]" placeholder="Document Title">
                            </div>

                            <div class="col-sm-4" >
                               <label>Serial No.*</label>
                               <input type="text"   class="form-control" required="" name="serial_number[]" placeholder="Serial No.">
                            </div>

                            <div class="col-sm-4" >
                               <label>Upload Soft Copy*</label>
                               <input type="file"  class="form-control" required="" name="document[]" placeholder="Pincode">

		                      <div id="add_more_' . $id . '" style="margin-top:10px;">
				                <button type="button" class="btn btn-info pull-right"  onclick="addMoreDoc(' . ($id + 1) . ');">Add More</button>
				              </div>
                            </div>
                        </div>
		                
                       </div>';


		echo $html;
		exit;
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


}