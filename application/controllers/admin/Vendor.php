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
		$this->load->model('User_model');
		$this->load->library('form_validation');
		$this->load->library('email_send');
		//$this->load->library('m_pdf');

	}


	// Registration
	public function vendor_registration()
	{
		if (!$this->input->is_ajax_request())
		{
			show_404();
		}

		// ================= VALIDATION =================
		$this->form_validation->set_rules('name', 'Full Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|regex_match[/^[0-9]{10}$/]');
		$this->form_validation->set_rules('pincode', 'Mobile', 'required|regex_match[/^[0-9]{6}$/]');

		$this->form_validation->set_rules('shop_name', 'Shop Name', 'required');
		$this->form_validation->set_rules(
			'gst_number',
			'GST Number',
			'regex_match[/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/]',
			['regex_match' => 'Please enter a valid GST number.']
		);

		if ($this->form_validation->run() == false)
		{
			echo json_encode([
				'status' => 'error',
				'msg' => strip_tags(validation_errors())
			]);
			return;
		}

		// ================= CHECK DUPLICATE =================
		$mobile = $this->input->post('mobile');
		$aadhar = $_FILES['aadhar_card']['name'] ?? '';
		$pan = $_FILES['pan_card']['name'] ?? '';

		if ($this->Vendor_model->check_duplicate($mobile, $aadhar, $pan))
		{
			echo json_encode(['status' => 'error', 'msg' => 'Already Registered! Approval Pending.']);
			return;
		}

		// ================= FILE UPLOAD =================
		$profile_pic = $this->_upload_file('profile_pic', VENDOR_PROFILE_DIRECTORY);
		$vendor_logo = $this->_upload_file('vendor_logo', VENDOR_DOCUMENT_DIRECTORY);
		$aadhar_card = $this->_upload_file('aadhar_card', VENDOR_DOCUMENT_DIRECTORY);
		$pan_card = $this->_upload_file('pan_card', VENDOR_DOCUMENT_DIRECTORY);

		// ================= DATA ARRAY (ALL COLUMNS) =================
		$data = [
			'role' => 'vendor',
			'name' => $this->input->post('name'),
			'shop_name' => $this->input->post('shop_name'),
			'email' => $this->input->post('email'),

			'mobile' => $mobile,
			'otp' => null,
			'verify_otp' => 0,
			'profile_pic' => $profile_pic,
			'vendor_logo' => $vendor_logo,
			'aadhar_card' => $aadhar_card,
			'pan_card' => $pan_card,
			'address' => $this->input->post('address'),
			'locality' => $this->input->post('locality'),
			'city' => $this->input->post('city'),
			'state' => $this->input->post('state'),
			'pincode' => $this->input->post('pincode'),
			'gst_number' => $this->input->post('gst_number'),
			'promoter_id' => null,
			'promoter_code_used' => null,
			'wallet_amount' => 0.00,
			'status' => 0, // 0 = pending
			'add_date' => date('Y-m-d H:i:s'),
			'modify_date' => null
		];

		// ================= INSERT =================
		$id = $this->Vendor_model->insert_user($data, 'vendors');

		if ($id)
		{
			// ================= EMAIL DATA (PASSWORD NOT INCLUDED) =================
			$mail_data = [
				'name' => $data['name'],
				'shop_name' => $data['shop_name'],
				'mobile' => $data['mobile'],
				'email' => $data['email'],
				'address' => $data['address'],
				'city' => $data['city'],
				'state' => $data['state'],
				'pincode' => $data['pincode'],
				'gst_number' => $data['gst_number']
			];


			$email_body = $this->load->view(
				'web/email/vendor_registration_mail',
				$mail_data,
				true
			);


			$this->email_send->send_email(
				$data['email'],
				$email_body,
				"Vendor Registration - Chenna"
			);

			echo json_encode([
				'status' => 'success',
				'msg' => 'Registered successfully! Please check your email. Waiting for admin approval.'
			]);
		} else
		{
			echo json_encode(['status' => 'error', 'msg' => 'Something went wrong!']);
		}
	}


	// ================= UPLOAD FUNCTION =================
	private function _upload_file($field_name, $upload_dir)
	{
		if (!empty($_FILES[$field_name]['name']))
		{
			if (!is_dir($upload_dir))
			{
				mkdir($upload_dir, 0777, true);
			}

			$config = [];
			$config['upload_path'] = $upload_dir;
			$config['allowed_types'] = 'jpg|jpeg|png|pdf';
			$config['max_size'] = 2048; // 2MB
			$config['encrypt_name'] = TRUE;

			// IMPORTANT: re-initialize upload library
			$this->load->library('upload');
			$this->upload->initialize($config);

			if ($this->upload->do_upload($field_name))
			{
				$file = $this->upload->data();
				return 'assets/vendor_images/' . $file['file_name'];
			} else
			{
				// DEBUG ERROR
				echo json_encode([
					'status' => 'error',
					'msg' => $this->upload->display_errors()
				]);
				exit;
			}
		}
		return null;
	}


	public function vendor_list()
	{
		$data['index2'] = 'AllVendorList';

		$data['vendors'] = $this->Vendor_model->get_all_vendors();

		$this->load->view('include/header');
		$this->load->view('Vendor/AllVendorList', $data);
		$this->load->view('include/footer');
	}

	public function admin_appro_vendor_users()
	{
		$id = $this->input->post('id');
		$role = $this->input->post('role');
		$status = $this->input->post('status');

		if (!$id || !$role)
		{
			echo json_encode(['status' => 'error', 'msg' => 'Invalid request']);
			return;
		}
		if ($status == 1)
		{

			$plain_password = str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);
			$hashed_password = password_hash($plain_password, PASSWORD_BCRYPT);
			$this->Vendor_model->admin_approve_and_update_vendor_password($id, $role, $hashed_password);
			$user = $this->Vendor_model->get_user($id, $role);
			$data = [
				'name' => $user->name,
				'mobile' => $user->mobile,
				'password' => $plain_password
			];
			$msg = $this->load->view('web/email/vendor_approved_mail', $data, true);
			$this->email_send->send_email(
				$user->email,
				$msg,
				"Your Vendor Account Approved - Chenna"
			);

			echo json_encode(['status' => 'success', 'msg' => 'Vendor approved and credentials sent']);
		} else
		{

			$this->Vendor_model->admin_update_vendor_status($id, $role, 0);

			echo json_encode(['status' => 'success', 'msg' => 'Vendor moved to pending']);
		}
	}

	public function Vendor_view_details($id)
	{
		$data['vendor'] = $this->Vendor_model->get_admin_vendor_by_id($id);

		if (empty($data['vendor']))
		{
			show_404();
		}

		$this->load->view('include/header');
		$this->load->view('Vendor/Vendor_view_details', $data);
		$this->load->view('include/footer');
	}
	public function admin_delete_vendor()
	{
		$id = $this->input->post('id');
		$this->Vendor_model->admin_delete_vendor($id);
		echo 'success';
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

	public function UpdateVendorProfile($id)
	{
		$this->load->model('Vendor_model');

		$data['getData'] = $this->Vendor_model->getSingleVendorsData($id);
		$data['title'] = 'Update Vendor Profile';

		$this->load->view('include/header', $data);
		$this->load->view('vendor/UpdateVendorProfile', $data);
		$this->load->view('include/footer');
	}

	public function SaveVendorProfile($id)
	{
		$this->load->model('Vendor_model');
		$this->load->library('form_validation');
		$this->load->helper(['url', 'form']);

		$post = $this->input->post();

		/* ===========================
		   1️⃣ FORM VALIDATION
		============================*/
		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|numeric|exact_length[10]');
		$this->form_validation->set_rules('pincode', 'Pincode', 'numeric|exact_length[6]');
		$this->form_validation->set_rules(
			'gst_number',
			'GST Number',
			'regex_match[/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[A-Z0-9]{3}$/]'
		);

		if (!empty($post['password']))
		{
			$this->form_validation->set_rules('password', 'Password', 'min_length[8]');
		}

		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata(
				'activate',
				'<div class="alert alert-danger">' . validation_errors() . '</div>'
			);
			redirect('admin/Vendor/UpdateVendorProfile/' . $id);
			return;
		}

		/* ===========================
		   2️⃣ PROMOTER ID (FK SAFE)
		============================*/
		$promoter_id = $post['promoter_id'];

		if (empty($promoter_id))
		{
			$promoter_id = NULL;
		} else
		{
			$check = $this->db->get_where('promoters', ['id' => $promoter_id])->row();
			if (!$check)
			{
				$this->session->set_flashdata(
					'activate',
					'<div class="alert alert-danger">Invalid Promoter ID. This promoter does not exist.</div>'
				);
				redirect('admin/Vendor/UpdateVendorProfile/' . $id);
				return;
			}
		}

		/* ===========================
		   3️⃣ PREPARE UPDATE DATA
		============================*/
		$updateData = [
			'name' => $post['name'],
			'role' => $post['role'] ?? 'vendor',
			'shop_name' => $post['shop_name'],
			'email' => $post['email'],

			'mobile' => $post['mobile'],
			'address' => $post['address'],
			'locality' => $post['locality'],
			'city' => $post['city'],
			'state' => $post['state'],
			'pincode' => $post['pincode'],
			'gst_number' => strtoupper($post['gst_number']),
			'promoter_id' => $promoter_id,
			'promoter_code_used' => $post['promoter_code_used'],
			'wallet_amount' => $post['wallet_amount'],
			'status' => 1,
		];

		/* ===========================
		   4️⃣ PASSWORD HASHING
		============================*/
		if (!empty($post['password']))
		{
			$updateData['password'] = password_hash($post['password'], PASSWORD_BCRYPT);
		}

		/* ===========================
		   5️⃣ FILE UPLOAD SETUP
		============================*/
		$profilePath = FCPATH . 'assets/vendor_profile_image/';
		$docPath = FCPATH . 'assets/vendor_images/';

		// Ensure folders exist
		if (!is_dir($profilePath))
			mkdir($profilePath, 0755, true);
		if (!is_dir($docPath))
			mkdir($docPath, 0755, true);

		$files = [
			'profile_pic' => $profilePath,
			'vendor_logo' => $docPath,
			'aadhar_card' => $docPath,
			'pan_card' => $docPath
		];

		foreach ($files as $field => $dir)
		{

			if (!empty($_FILES[$field]['name']))
			{

				/* 🔎 File Type Validation */
				$allowed_types = ['jpg', 'jpeg', 'png'];
				if (in_array($field, ['aadhar_card', 'pan_card']))
				{
					$allowed_types[] = 'pdf';
				}

				$file_ext = pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION);
				if (!in_array(strtolower($file_ext), $allowed_types))
				{
					$this->session->set_flashdata(
						'activate',
						'<div class="alert alert-danger">Invalid file type for ' . ucfirst(str_replace('_', ' ', $field)) . '.</div>'
					);
					redirect('admin/Vendor/UpdateVendorProfile/' . $id);
					return;
				}

				/* ⚙ Upload Config */
				$config['upload_path'] = $dir;
				$config['allowed_types'] = implode('|', $allowed_types);
				$config['max_size'] = 2048; // 2MB
				$config['file_name'] = $field . '_' . $id . '_' . time();

				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if ($this->upload->do_upload($field))
				{

					$fileData = $this->upload->data();

					if ($field == 'profile_pic')
					{
						$updateData[$field] = 'assets/vendor_profile_image/' . $fileData['file_name'];
					} else
					{
						$updateData[$field] = 'assets/vendor_images/' . $fileData['file_name'];
					}

				} else
				{
					$this->session->set_flashdata(
						'activate',
						'<div class="alert alert-danger">' . $this->upload->display_errors() . '</div>'
					);
					redirect('admin/Vendor/UpdateVendorProfile/' . $id);
					return;
				}
			}
		}

		/* ===========================
		   6️⃣ DATABASE UPDATE
		============================*/
		$this->Vendor_model->updateVendor($id, $updateData);

		$this->session->set_flashdata(
			'activate',
			'<div class="alert alert-success">Vendor profile updated successfully!</div>'
		);

		redirect('admin/Vendor/UpdateVendorProfile/' . $id);
	}



	// public function UpdateVendorProfile($id = '')
	// {
	// 	$data = $this->input->post();
	// 	$data['id'] = $this->uri->segment(4);

	// 	$fileName = $_FILES["photo"]["name"];
	// 	$extension = explode('.', $fileName);
	// 	$extension = strtolower(end($extension));
	// 	$uniqueName = 'Boy_Profile_' . uniqid() . '.' . $extension;
	// 	$type = $_FILES["photo"]["type"];
	// 	$size = $_FILES["photo"]["size"];
	// 	$tmp_name = $_FILES['photo']['tmp_name'];
	// 	$targetlocation = BOY_DIRECTORY . $uniqueName;

	// 	if (!empty($fileName))
	// 	{
	// 		move_uploaded_file($tmp_name, $targetlocation);
	// 		$data['pre_image'] = utf8_encode(trim($uniqueName));
	// 	} else
	// 	{
	// 		$data['pre_image'] = $this->input->post('pre_image');
	// 	}
	// 	$check = $this->db->get_where('staff_master', array('email' => $data['email'], 'id !=' => $data['id']))->num_rows();
	// 	if ($check == '0')
	// 	{
	// 		$row = $this->User_model->UpdateVendorData($data);
	// 		if ($row > 0)
	// 		{
	// 			$this->session->set_flashdata('activate', getCustomAlert('S', ' Profile has been Updated Successfully.'));
	// 			redirect('admin/Dashboard/');
	// 		}

	// 	} else
	// 	{
	// 		$this->session->set_flashdata('activate', getCustomAlert('D', '!Opps Email Id Already Exists.Please try again.'));
	// 		redirect('admin/Dashboard/');
	// 	}
	// }




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