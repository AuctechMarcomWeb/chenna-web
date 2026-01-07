<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Vendor extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('email');
		$this->load->library('session');
		$this->load->helper('message');
		$this->load->model('Vendor_model');
		$this->load->library('email');
		$this->load->library('session');
		$this->load->helper('api');
		$this->load->model('user_model');
		$this->load->library('form_validation');
		//$this->load->library('m_pdf');

	}


	// Registration
	public function registration()
	{
		$role = $this->input->post('role');

		// ================= VALIDATION =================
		$this->form_validation->set_rules('role', 'Role', 'required');
		$this->form_validation->set_rules('name', 'Full Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|regex_match[/^[0-9]{10}$/]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
		$this->form_validation->set_rules('pincode', 'Pincode', 'regex_match[/^[0-9]{6}$/]');

		if ($role == 'vendor')
		{
			$this->form_validation->set_rules('shop_name', 'Shop Name', 'required');
			$this->form_validation->set_rules('gst_number', 'GST Number', 'regex_match[/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/]');
		}

		if ($role == 'promoter')
		{
			$this->form_validation->set_rules('bank_name', 'Bank Name', 'required');
			$this->form_validation->set_rules('account_no', 'Account No', 'required');
			$this->form_validation->set_rules('ifsc_code', 'IFSC Code', 'required');
		}

		// if ($this->form_validation->run() == false)
		// {
		// 	$this->session->set_flashdata('error', validation_errors());
		// 	redirect($_SERVER['HTTP_REFERER']);
		// 	return;
		// }

		// ================= CHECK DUPLICATE =================
		$mobile = $this->input->post('mobile');
		$aadhar = $this->input->post('aadhar_card');
		$pan = $this->input->post('pan_card');

		// if ($this->Vendor_model->check_duplicate($mobile, $aadhar, $pan))
		// {
		// 	$this->session->set_flashdata('error', 'Already Registered! Approval Pending.');
		// 	redirect($_SERVER['HTTP_REFERER']);
		// 	return;
		// }

		// ================= FILE UPLOAD =================
		$profile_pic = $this->_upload_file('profile_pic', PROFILE_DIRECTORY);

		if ($role == 'vendor')
		{
			$aadhar_card = $this->_upload_file('aadhar_card', VENDOR_DOCUMENT_DIRECTORY);
			$pan_card = $this->_upload_file('pan_card', VENDOR_DOCUMENT_DIRECTORY);
			$vendor_logo = $this->_upload_file('vendor_logo', VENDOR_DOCUMENT_DIRECTORY);
		} else
		{
			$aadhar_card = $this->_upload_file('aadhar_card', PROMOTER_DOCUMENT_DIRECTORY);
			$pan_card = $this->_upload_file('pan_card', PROMOTER_DOCUMENT_DIRECTORY);
		}

		// ================= COMMON DATA =================
		$data = [
			'role' => $role,
			'name' => $this->input->post('name'),
			'email' => $this->input->post('email'),
			'mobile' => $mobile,
			'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
			'profile_pic' => $profile_pic,
			'address' => $this->input->post('address'),
			'locality' => $this->input->post('locality'),
			'city' => $this->input->post('city'),
			'state' => $this->input->post('state'),
			'pincode' => $this->input->post('pincode'),
			'status' => 0, // Pending approval
			'add_date' => date('Y-m-d H:i:s')
		];

		// ================= VENDOR DATA =================
		if ($role == 'vendor')
		{
			$data['shop_name'] = $this->input->post('shop_name');
			$data['gst_number'] = $this->input->post('gst_number');
			$data['vendor_logo'] = $vendor_logo;
			$data['aadhar_card'] = $aadhar_card;
			$data['pan_card'] = $pan_card;

			$code = $this->input->post('promoter_code_used');
			if (!empty($code))
			{
				$promoter = $this->Vendor_model->get_promoter_by_code($code);
				if ($promoter)
				{
					$data['promoter_id'] = $promoter->id;
					$data['promoter_code_used'] = $code;
				}
			}
		}

		// ================= PROMOTER DATA =================
		if ($role == 'promoter')
		{
			$data['bank_name'] = $this->input->post('bank_name');
			$data['account_no'] = $this->input->post('account_no');
			$data['ifsc_code'] = $this->input->post('ifsc_code');
			$data['aadhar_card'] = $aadhar_card;
			$data['pan_card'] = $pan_card;
			$data['promoter_code'] = strtoupper(substr($this->input->post('name'), 0, 3)) . rand(100, 999);
		}

		// ================= INSERT DATA =================
		$id = $this->Vendor_model->insert_user($data, $role);

		if ($id)
		{
			// Send email & SMS after registration (pending approval)
			$msg = "Hello {$data['name']},<br>Your registration is successful! Waiting for Admin Approval.";
			$this->email_send->send_email($data['email'], $msg, "Registration Received");

			$this->session->set_flashdata('success', 'Registered successfully! Waiting for admin approval.');
		} else
		{
			$this->session->set_flashdata('error', 'Something went wrong!');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}


	// ================= UPLOAD FUNCTION =================
	private function _upload_file($field_name, $upload_dir)
	{
		if (!empty($_FILES[$field_name]['name']))
		{
			if (!is_dir($upload_dir))
				mkdir($upload_dir, 0777, true);

			$config['upload_path'] = $upload_dir;
			$config['allowed_types'] = 'jpg|jpeg|png|pdf';
			$config['encrypt_name'] = TRUE;

			$this->load->library('upload', $config);

			if ($this->upload->do_upload($field_name))
			{
				$data = $this->upload->data();
				return str_replace(FCPATH, '', $upload_dir) . $data['file_name'];
			}
		}
		return null;
	}






	public function approveUser($id, $role)
{
    $this->Vendor_model->approve_user($id, $role);
    $user = $this->Vendor_model->get_user($id, $role);

    $msg = "Hello {$user->name},<br><br>
            Your account has been <b>Approved</b> by Admin.<br>
            Login ID: {$user->mobile}<br>
            Password: (Same as registered)<br><br>
            Team Chenna";

    $this->email_send->send_email($user->email, $msg, "Account Approved");
    // Optionally: send SMS here using your SMS API

    $this->session->set_flashdata('success', 'User Approved & Mail Sent');
    redirect('admin/Dashboard');
}







	// End Registration
	public function index()
	{
		$data['index'] = 'Vendor';
		$data['index2'] = '';
		$data['title'] = 'Manage Vendor';
		$data['getData'] = $this->user_model->getVendotList();

		$this->load->view('include/header', $data);
		$this->load->view('Vendor/VendorList');
		$this->load->view('include/footer');
	}

	public function AddVendor()
	{

		$data['index'] = 'addvendor';
		$data['index2'] = '';
		$data['title'] = 'Manage Vendor';
		$data['stateList'] = $this->db->get_where('states_list', array('country_id' => '101'))->result_array();

		$this->load->view('include/header', $data);
		$this->load->view('Vendor/AddVendor');
		$this->load->view('include/footer');
	}


	public function AddVendorData()
	{
		$data = $this->input->post();
		$email = $this->input->post('email');
		$checkEmail = $this->db->get_where('staff_master', array('email' => $email))->num_rows();
		if ($checkEmail > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('D', '!Opps Email Id Already Exists.Please try again.'));
			redirect('admin/Vendor/AddVendor/');
		} else
		{

			$row = $this->db->insert('staff_master', $data);
			if ($row > 0)
			{
				$this->session->set_flashdata('activate', getCustomAlert('S', 'Seller has been add Successfully.'));
				redirect('admin/Vendor/index/');
			} else
			{
				$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
				redirect('admin/Vendor/AddVendor/');
			}
		}

	}


	public function AddVendorDataOld()
	{
		$data = $this->input->post();
		/*	echo"<pre>";
			 print_r($data); exit;*/

		$fileName = $_FILES["uploadFileVendor"]["name"];
		$extension = explode('.', $fileName);
		$extension = strtolower(end($extension));
		$uniqueName = 'Vendor_' . uniqid() . '.' . $extension;
		$type = $_FILES["uploadFileVendor"]["type"];
		$size = $_FILES["uploadFileVendor"]["size"];
		$tmp_name = $_FILES['uploadFileVendor']['tmp_name'];
		$targetlocation = BOY_DIRECTORY . $uniqueName;

		if (!empty($fileName))
		{
			move_uploaded_file($tmp_name, $targetlocation);
			$data['profile_pic'] = utf8_encode(trim($uniqueName));
		}
		$check = $this->db->get_where('admin_master', array('email' => $data['VendorEmail']))->num_rows();
		if ($check == '0')
		{
			$row = $this->Vendor_model->AddVendorData($data);
			if ($row > 0)
			{
				$this->session->set_flashdata('activate', getCustomAlert('S', ' Vendor has been add Successfully.'));
				redirect('admin/Vendor/');
			}

		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('D', '!Opps Email Id Already Exists.Please try again.'));
			redirect('admin/Vendor/');
		}
	}



	public function CheckContact($num = '')
	{
		$query = $this->db->query("SELECT * FROM `admin_master` where phone_no = '" . $num . "'")->num_rows();
		/*echo $this->db->last_query();exit;*/
		echo ($query > 0) ? '1' : '';

	}

	public function VendorStatus($id)
	{
		$id = $this->uri->segment(4);
		$sql = $this->db->query("SELECT * from staff_master where id= '" . $id . "'")->row_array();

		$arrayName = array();
		$arrayName['status'] = ($sql['status'] == 0) ? '1' : '0';
		$this->db->where('id', $id);
		$this->db->update('staff_master', $arrayName);
		echo $arrayName['status'];

	}




	public function UpdateVendor()
	{
		$id = $this->uri->segment(4);
		$data['index'] = 'Updtvendor';
		$data['index2'] = '';
		$data['title'] = 'Update Vendor';
		$data['stateList'] = $this->db->get_where('states_list', array('country_id' => '101'))->result_array();
		$data['getData'] = $this->user_model->getSingleVendorData($id);
		$this->load->view('include/header', $data);
		$this->load->view('Vendor/UpdateVendor');
		$this->load->view('include/footer');
	}


	public function UpdateVendorData($id = '')
	{
		$data = $this->input->post();
		$data['id'] = $this->uri->segment(4);

		$check = $this->db->get_where('staff_master', array('email' => $data['email'], 'id !=' => $data['id']))->num_rows();
		if ($check == '0')
		{
			$this->db->select('password');
			$vendor = $this->db->get_where('staff_master', array('id' => $id))->row_array();
			if (!empty($data['password']))
			{
				$data['password'] = $data['password'];
			} else
			{
				$data['password'] = $vendor['password'];
			}

			$this->db->where('id', $id);
			$row = $this->db->update('staff_master', $data);
			if ($row > 0)
			{
				$this->session->set_flashdata('activate', getCustomAlert('S', ' Vendor has been Updated Successfully.'));
				redirect('admin/Vendor/');
			}

		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('D', '!Opps Email Id Already Exists.Please try again.'));
			redirect('admin/Vendor/');
		}
	}


	public function UpdateVendorProfile($id = '')
	{
		$data = $this->input->post();
		$data['id'] = $this->uri->segment(4);

		$fileName = $_FILES["photo"]["name"];
		$extension = explode('.', $fileName);
		$extension = strtolower(end($extension));
		$uniqueName = 'Boy_Profile_' . uniqid() . '.' . $extension;
		$type = $_FILES["photo"]["type"];
		$size = $_FILES["photo"]["size"];
		$tmp_name = $_FILES['photo']['tmp_name'];
		$targetlocation = BOY_DIRECTORY . $uniqueName;

		if (!empty($fileName))
		{
			move_uploaded_file($tmp_name, $targetlocation);
			$data['pre_image'] = utf8_encode(trim($uniqueName));
		} else
		{
			$data['pre_image'] = $this->input->post('pre_image');
		}
		$check = $this->db->get_where('staff_master', array('email' => $data['email'], 'id !=' => $data['id']))->num_rows();
		if ($check == '0')
		{
			$row = $this->user_model->UpdateVendorData($data);
			if ($row > 0)
			{
				$this->session->set_flashdata('activate', getCustomAlert('S', ' Profile has been Updated Successfully.'));
				redirect('admin/Dashboard/');
			}

		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('D', '!Opps Email Id Already Exists.Please try again.'));
			redirect('admin/Dashboard/');
		}
	}




	public function ForgetPassword()
	{
		$sql = $this->db->query(" SELECT * FROM `admin_master` where email ='" . $_POST['email'] . "'")->row_array();
		if ($sql > 0)
		{
			$smsmessage = "Your Password Is  :" . base64_decode($sql['password']);
			$sendmail = $this->sentEmailInfo($sql['email'], $smsmessage);

			/*echo $sendmail;
			 */
			//print_r($sendmail);
			// exit;
			echo 1;
		} else
		{
			echo 0;
		}
	}



	public function sentEmailInfo($email, $smsmessage)
	{
		// ++++++++++++++
		$to = $email;
		$subject = "Forget Password";
		$message = "Your Password For Vendor Panel\r\n";
		$message .= "\r\n";
		$message .= "&nbsp;" . $smsmessage . "\r\n";
		$message .= "Note - This is a System Generated Mail, please do not reply.\r\n";
		$headers = "From:" . "support@dukekart.in" . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";
		mail($to, $subject, '<pre style="font-size:14px;">' . $message . '</pre>', $headers);


	}


}