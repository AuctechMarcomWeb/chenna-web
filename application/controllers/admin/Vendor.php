<?php defined('BASEPATH') or exit('No direct script access allowed');
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
		$this->load->library('pagination');
		$this->load->model('Order_model');
		//$this->load->library('m_pdf');

	}


	// Registration
	// public function vendor_registration()
	// {
	// 	if (!$this->input->is_ajax_request())
	// 	{
	// 		show_404();
	// 	}

	// 	/* ================= VALIDATION ================= */
	// 	$this->form_validation->set_rules('name', 'Full Name', 'required');
	// 	$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
	// 	$this->form_validation->set_rules('mobile', 'Mobile', 'required|regex_match[/^[0-9]{10}$/]');
	// 	$this->form_validation->set_rules('pincode', 'Pincode', 'required|regex_match[/^[0-9]{6}$/]');

	// 	if ($this->input->post('has_gst') === 'yes')
	// 	{
	// 		$this->form_validation->set_rules(
	// 			'gst_number',
	// 			'GST Number',
	// 			'required|regex_match[/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/]',
	// 			['regex_match' => 'Invalid GST number']
	// 		);
	// 	}

	// 	if ($this->form_validation->run() == false)
	// 	{
	// 		echo json_encode([
	// 			'status' => 'error',
	// 			'msg' => strip_tags(validation_errors())
	// 		]);
	// 		return;
	// 	}

	// 	$email = $this->input->post('email');
	// 	$mobile = $this->input->post('mobile');

	// 	/* ================= CHECK VERIFIED EMAIL ================= */
	// 	$vendor = $this->db
	// 		->where('email', $email)
	// 		->where('verify_otp', 1)
	// 		->get('vendors')
	// 		->row();

	// 	if (!$vendor)
	// 	{
	// 		echo json_encode([
	// 			'status' => 'error',
	// 			'msg' => 'Please verify your email first'
	// 		]);
	// 		return;
	// 	}

	// 	/* ================= FILE UPLOAD ================= */
	// 	$profile_pic = $this->_upload_file('profile_pic', VENDOR_PROFILE_DIRECTORY);
	// 	$vendor_logo = $this->_upload_file('vendor_logo', VENDOR_DOCUMENT_DIRECTORY);
	// 	$aadhar_card = $this->_upload_file('aadhar_card', VENDOR_DOCUMENT_DIRECTORY);
	// 	$pan_card = $this->_upload_file('pan_card', VENDOR_DOCUMENT_DIRECTORY);

	// 	/* ================= GST ================= */
	// 	$gst_number = null;
	// 	if ($this->input->post('has_gst') === 'yes')
	// 	{
	// 		$gst_number = $this->input->post('gst_number');
	// 	}

	// 	/* ================= UPDATE DATA ================= */
	// 	$data = [
	// 		'role' => 'vendor',
	// 		'name' => $this->input->post('name'),
	// 		'shop_name' => $this->input->post('shop_name'),
	// 		'mobile' => $mobile,
	// 		'profile_pic' => $profile_pic ?: $vendor->profile_pic,
	// 		'vendor_logo' => $vendor_logo ?: $vendor->vendor_logo,
	// 		'aadhar_card' => $aadhar_card ?: $vendor->aadhar_card,
	// 		'pan_card' => $pan_card ?: $vendor->pan_card,
	// 		'address' => $this->input->post('address'),
	// 		'city' => $this->input->post('city'),
	// 		'state' => $this->input->post('state'),
	// 		'pincode' => $this->input->post('pincode'),
	// 		'gst_number' => $gst_number,
	// 		'promoter_code_used' => $this->input->post('promoter_code_used'),
	// 		'status' => 0,
	// 		'modify_date' => date('Y-m-d H:i:s')
	// 	];

	// 	$this->db->where('email', $email);
	// 	$update = $this->db->update('vendors', $data);

	// 	if ($update)
	// 	{
	// 		/* ================= EMAIL ================= */
	// 		$mail_data = [
	// 			'vendor_random_number' => $vendor->vendor_random_number,
	// 			'name' => $data['name'],
	// 			'shop_name' => $data['shop_name'],
	// 			'mobile' => $mobile,
	// 			'email' => $email,
	// 			'address' => $data['address'],
	// 			'city' => $data['city'],
	// 			'state' => $data['state'],
	// 			'pincode' => $data['pincode'],
	// 			'gst_number' => $gst_number
	// 		];

	// 		$email_body = $this->load->view(
	// 			'web/email/vendor_registration_mail',
	// 			$mail_data,
	// 			true
	// 		);

	// 		$this->email_send->send_email(
	// 			$email,
	// 			$email_body,
	// 			"Vendor Registration - Chenna"
	// 		);

	// 		echo json_encode([
	// 			'status' => 'success',
	// 			'msg' => 'Registration successful! Waiting for approval.'
	// 		]);
	// 	} else
	// 	{
	// 		echo json_encode([
	// 			'status' => 'error',
	// 			'msg' => 'Something went wrong!'
	// 		]);
	// 	}
	// }

	public function vendor_registration()
	{
		if (!$this->input->is_ajax_request())
		{
			show_404();
		}

		/* ================= VALIDATION ================= */
		$this->form_validation->set_rules('name', 'Full Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|regex_match[/^[0-9]{10}$/]');
		$this->form_validation->set_rules('pincode', 'Pincode', 'required|regex_match[/^[0-9]{6}$/]');

		if ($this->input->post('has_gst') === 'yes')
		{
			$this->form_validation->set_rules(
				'gst_number',
				'GST Number',
				'required|regex_match[/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/]',
				['regex_match' => 'Invalid GST number']
			);
		}

		if ($this->form_validation->run() == false)
		{
			echo json_encode([
				'status' => 'error',
				'msg' => strip_tags(validation_errors())
			]);
			return;
		}

		$email = $this->input->post('email');
		$mobile = $this->input->post('mobile');

		/* ================= CHECK EMAIL VERIFIED ================= */
		$vendor = $this->db
			->where('email', $email)
			->where('verify_otp', 1)
			->get('vendors')
			->row();

		if (!$vendor)
		{
			echo json_encode([
				'status' => 'error',
				'msg' => 'Please verify your email first'
			]);
			return;
		}

		/* ================= FILE UPLOAD ================= */
		$profile_pic = $this->_upload_file('profile_pic', VENDOR_PROFILE_DIRECTORY);
		$vendor_logo = $this->_upload_file('vendor_logo', VENDOR_DOCUMENT_DIRECTORY);
		$aadhar_card = $this->_upload_file('aadhar_card', VENDOR_DOCUMENT_DIRECTORY);
		$pan_card = $this->_upload_file('pan_card', VENDOR_DOCUMENT_DIRECTORY);

		/* ================= GST ================= */
		$gst_number = null;
		if ($this->input->post('has_gst') === 'yes')
		{
			$gst_number = $this->input->post('gst_number');
		}

		/* ================= PROMOTER REFERRAL LOGIC ================= */
		$promoter_code = trim($this->input->post('promoter_code_used'));
		$promoter_id = null;
		$referred_by = null;

		if (!empty($promoter_code))
		{
			$promoter = $this->db
				->where('reference_code', $promoter_code)
				->where('status', 1)
				->get('promoters')
				->row();

			if ($promoter)
			{
				$promoter_id = $promoter->id;
				$referred_by = 'promoter';
			} else
			{
				// invalid code → ignore safely
				$promoter_code = null;
			}
		}

		/* ================= UPDATE DATA ================= */
		$data = [
			'role' => 'vendor',
			'name' => $this->input->post('name'),
			'shop_name' => $this->input->post('shop_name'),
			'mobile' => $mobile,
			'profile_pic' => $profile_pic ?: $vendor->profile_pic,
			'vendor_logo' => $vendor_logo ?: $vendor->vendor_logo,
			'aadhar_card' => $aadhar_card ?: $vendor->aadhar_card,
			'pan_card' => $pan_card ?: $vendor->pan_card,
			'address' => $this->input->post('address'),
			'city' => $this->input->post('city'),
			'state' => $this->input->post('state'),
			'pincode' => $this->input->post('pincode'),
			'gst_number' => $gst_number,
			'promoter_id' => $promoter_id,
			'referred_by' => $referred_by,
			'promoter_code_used' => $promoter_code,
			'status' => 0,
			'modify_date' => date('Y-m-d H:i:s')
		];

		$this->db->where('email', $email);
		$update = $this->db->update('vendors', $data);

		if ($update)
		{
			/* ================= EMAIL ================= */
			$mail_data = [
				'vendor_random_number' => $vendor->vendor_random_number,
				'name' => $data['name'],
				'shop_name' => $data['shop_name'],
				'mobile' => $mobile,
				'email' => $email,
				'address' => $data['address'],
				'city' => $data['city'],
				'state' => $data['state'],
				'pincode' => $data['pincode'],
				'gst_number' => $gst_number
			];

			$email_body = $this->load->view(
				'web/email/vendor_registration_mail',
				$mail_data,
				true
			);

			$this->email_send->send_email(
				$email,
				$email_body,
				"Vendor Registration - Chenna"
			);

			echo json_encode([
				'status' => 'success',
				'msg' => 'Registration successful! Waiting for approval.'
			]);

		} else
		{
			echo json_encode([
				'status' => 'error',
				'msg' => 'Something went wrong!'
			]);
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

			$config['upload_path'] = $upload_dir;
			$config['allowed_types'] = 'jpg|jpeg|png|pdf';
			$config['max_size'] = 2048;
			$config['encrypt_name'] = TRUE;

			$this->load->library('upload');
			$this->upload->initialize($config);

			if ($this->upload->do_upload($field_name))
			{

				$file = $this->upload->data();

				// ✅ Convert absolute path → relative path
				$relative_path = str_replace(FCPATH, '', $upload_dir);

				return $relative_path . $file['file_name'];
			} else
			{
				echo json_encode([
					'status' => 'error',
					'msg' => strip_tags($this->upload->display_errors())
				]);
				exit;
			}
		}

		return null;
	}

	public function vendor_send_email_otp()
	{
		$email = $this->input->post('email');

		if (!$email)
		{
			echo json_encode(['status' => 'error', 'msg' => 'Email required']);
			return;
		}

		$vendor = $this->db->get_where('vendors', ['email' => $email])->row();

		if ($vendor && $vendor->verify_otp == 1)
		{
			echo json_encode(['status' => 'error', 'msg' => 'Email already verified']);
			return;
		}

		$otp = rand(100000, 999999);

		if ($vendor)
		{
			$this->db->where('email', $email)->update('vendors', ['otp' => $otp]);
			$vendor_random_number = $vendor->vendor_random_number;
			$name = $vendor->name ?: 'Vendor';
		} else
		{
			$vendor_random_number = 'VENRGTS' . date('Y') . rand(100000, 999999);

			$this->db->insert('vendors', [
				'email' => $email,
				'otp' => $otp,
				'verify_otp' => 0,
				'vendor_random_number' => $vendor_random_number,
				'add_date' => date('Y-m-d H:i:s')
			]);

			$name = 'Vendor';
		}

		$message = $this->load->view(
			'web/email/vendor_otp_verification',
			['name' => $name, 'otp' => $otp],
			true
		);

		if ($this->email_send->send_email($email, $message, 'OTP Verification - Chenna'))
		{
			echo json_encode(['status' => 'success']);
		} else
		{
			echo json_encode(['status' => 'error', 'msg' => 'OTP send failed']);
		}
	}


	// Verify OTP
	public function vendor_verify_email_otp()
	{
		$email = $this->input->post('email');
		$otp = $this->input->post('otp');

		if (!$email || !$otp)
		{
			echo json_encode(['status' => 'error', 'msg' => 'Email & OTP required']);
			return;
		}

		$vendor = $this->db->get_where('vendors', ['email' => $email])->row();

		if (!$vendor)
		{
			echo json_encode(['status' => 'error', 'msg' => 'Email not found']);
			return;
		}

		if ($vendor->otp == $otp)
		{
			$this->db->where('email', $email)->update('vendors', [
				'verify_otp' => 1
			]);

			echo json_encode(['status' => 'success']);
		} else
		{
			echo json_encode(['status' => 'error', 'msg' => 'Invalid OTP']);
		}
	}

	public function vendor_list()
	{
		$data['index2'] = 'AllVendorList';

		$data['vendors'] = $this->Vendor_model->get_all_vendors();
		$data['title'] = 'Vendor List';
		$this->load->view('include/header', $data);
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


	// public function VendorOrderList()
	// {
	// 	is_not_logged_in();
	// 	$this->load->library('pagination');

	// 	$limit = 10;
	// 	$pageNo = $this->input->get('per_page');
	// 	$pageNo = (!empty($pageNo) && $pageNo > 0) ? $pageNo : 1;
	// 	$offset = ($pageNo - 1) * $limit;

	// 	// ================= FILTERS =================
	// 	$keywords = $this->input->post('keywords');
	// 	$fromDate = $this->input->post('fromDate');
	// 	$toDate = $this->input->post('toDate');
	// 	$order_status = $this->input->post('order_status');
	// 	$delete_status = $this->input->post('delete_status');
	// 	$customer_name = $this->input->post('customer_name');

	// 	$vendor_id = $this->session->userdata('adminData')['Id'];

	// 	// ================= BASE QUERY =================
	// 	$this->db->select('o.*, u.username, u.mobile');
	// 	$this->db->from('order_master o');
	// 	$this->db->join('purchase_master p', 'p.order_master_id = o.id', 'inner');
	// 	$this->db->join('user_master u', 'u.id = o.user_master_id', 'left');
	// 	$this->db->where('p.vendor_id', $vendor_id);
	// 	$this->db->group_by('o.id');

	// 	// ================= APPLY FILTERS =================

	// 	// 1️⃣ Keywords (Order Number)
	// 	if (!empty($keywords))
	// 	{
	// 		$this->db->like('o.order_number', $keywords);
	// 	}
	// 	// 2️⃣ Customer Name
	// 	elseif (!empty($customer_name))
	// 	{
	// 		$this->db->like('u.username', $customer_name);
	// 	}
	// 	// 3️⃣ Order Status
	// 	elseif (!empty($order_status))
	// 	{
	// 		$this->db->where('o.status', $order_status);
	// 	}
	// 	// 4️⃣ Delete Status
	// 	elseif (!empty($delete_status) && $delete_status == 'delete')
	// 	{
	// 		$this->db->where('o.action_payment', 'delete');
	// 	}
	// 	// 5️⃣ Date Range (apply only if BOTH dates are selected)
	// 	elseif (!empty($fromDate) && !empty($toDate))
	// 	{
	// 		$this->db->where("DATE(FROM_UNIXTIME(o.add_date)) >=", $fromDate);
	// 		$this->db->where("DATE(FROM_UNIXTIME(o.add_date)) <=", $toDate);
	// 	} else
	// 	{
	// 		// Default: only active orders
	// 		$this->db->where('o.action_payment', 'Yes');
	// 	}

	// 	// ================= TOTAL RECORDS =================
	// 	$clone = clone $this->db;
	// 	$totalRecords = $clone->count_all_results();

	// 	// ================= FETCH DATA =================
	// 	$this->db->order_by('o.id', 'DESC');
	// 	$this->db->limit($limit, $offset);
	// 	$AllRecord = $this->db->get()->result_array();

	// 	// ================= PAGINATION =================
	// 	$config['base_url'] = base_url('admin/Vendor/VendorOrderList');
	// 	$config['total_rows'] = $totalRecords;
	// 	$config['per_page'] = $limit;
	// 	$config['use_page_numbers'] = TRUE;
	// 	$config['page_query_string'] = TRUE;
	// 	$config['num_links'] = 3;
	// 	$this->pagination->initialize($config);

	// 	$entries = 'Showing ' . ($offset + 1) . ' to ' . ($offset + count($AllRecord)) . ' of ' . $totalRecords . ' entries';

	// 	$data = [
	// 		'results' => $AllRecord,
	// 		'links' => $this->pagination->create_links(),
	// 		'entries' => $entries,
	// 		'index' => 'VendorOrder',
	// 		'title' => 'Sales Report'
	// 	];

	// 	$this->load->view('include/header', $data);
	// 	$this->load->view('Vendor/VendorOrderList', $data);
	// 	$this->load->view('include/footer');
	// }


	public function VendorOrderList()
	{
		is_not_logged_in();
		$this->load->library('pagination');

		$limit = 10;
		$pageNo = $this->input->get('per_page');
		$pageNo = (!empty($pageNo) && $pageNo > 0) ? $pageNo : 1;
		$offset = ($pageNo - 1) * $limit;

		// ========= FILTERS =========
		$keywords = $this->input->post('keywords');
		$fromDate = $this->input->post('fromDate');
		$toDate = $this->input->post('toDate');
		$order_status = $this->input->post('order_status');
		$delete_status = $this->input->post('delete_status');
		$customer_name = $this->input->post('customer_name');

		$vendor_id = $this->session->userdata('adminData')['Id'];

		// ========= DATE FILTERS TO TIMESTAMP =========
		$fromTimestamp = '';
		$toTimestamp = '';

		if (!empty($fromDate) && !empty($toDate))
		{
			$fromTimestamp = strtotime($fromDate . ' 00:00:00');
			$toTimestamp = strtotime($toDate . ' 23:59:59');
		}

		// ========= COMMON WHERE =========
		$whereCod = " WHERE p.vendor_id = '$vendor_id' ";
		$whereOnline = " WHERE p.vendor_id = '$vendor_id' ";

		// Filters
		if (!empty($keywords))
		{
			$whereCod .= " AND o.order_number LIKE '%$keywords%' ";
			$whereOnline .= " AND o.order_number LIKE '%$keywords%' ";
		}

		if (!empty($customer_name))
		{
			$whereCod .= " AND u.username LIKE '%$customer_name%' ";
			$whereOnline .= " AND u.username LIKE '%$customer_name%' ";
		}

		if (!empty($order_status))
		{
			$whereCod .= " AND o.status = '$order_status' ";
			$whereOnline .= " AND o.status = '$order_status' ";
		}

		if (!empty($delete_status) && $delete_status == 'delete')
		{
			$whereCod .= " AND o.action_payment = 'delete' ";
			$whereOnline .= " AND o.action_payment = 'delete' ";
		} else
		{
			$whereCod .= " AND o.action_payment = 'Yes' ";
			$whereOnline .= " AND o.action_payment = 'Yes' ";
		}

		if (!empty($fromTimestamp) && !empty($toTimestamp))
		{
			// COD (UNIX TIMESTAMP)
			$whereCod .= " AND o.add_date BETWEEN $fromTimestamp AND $toTimestamp ";
			// ONLINE (DATETIME)
			$whereOnline .= " AND o.add_date BETWEEN FROM_UNIXTIME($fromTimestamp) AND FROM_UNIXTIME($toTimestamp) ";
		}

		// ========= COD ORDERS =========
		$codQuery = "
        SELECT 
            o.id,
            o.order_number,
            o.final_price,
            o.payment_type,
            o.payment_status,
            o.status,
            o.add_date,
            u.username,
            u.mobile
        FROM order_master o
        INNER JOIN purchase_master p ON p.order_master_id = o.id
        LEFT JOIN user_master u ON u.id = o.user_master_id
        $whereCod
        GROUP BY o.id
    ";

		// ========= ONLINE ORDERS =========
		$onlineQuery = "
        SELECT 
            o.id,
            o.order_number,
            o.final_price,
            o.payment_type,
            o.payment_status,
            o.status,
            UNIX_TIMESTAMP(o.add_date) AS add_date,
            u.username,
            u.mobile
        FROM order_master2 o
        INNER JOIN purchase_master2 p ON p.order_master_id = o.id
        LEFT JOIN user_master u ON u.id = o.user_master_id
        $whereOnline
        GROUP BY o.id
    ";

		// ========= FINAL UNION =========
		$finalQuery = "
        ($codQuery)
        UNION ALL
        ($onlineQuery)
        ORDER BY add_date DESC
        LIMIT $limit OFFSET $offset
    ";

		$AllRecord = $this->db->query($finalQuery)->result_array();

		// ========= TOTAL COUNT =========
		$countQuery = "
        SELECT COUNT(*) as total FROM (
            ($codQuery)
            UNION ALL
            ($onlineQuery)
        ) as total_orders
    ";
		$totalRecords = $this->db->query($countQuery)->row()->total;

		// ========= PAGINATION =========
		$config['base_url'] = base_url('admin/Vendor/VendorOrderList');
		$config['total_rows'] = $totalRecords;
		$config['per_page'] = $limit;
		$config['use_page_numbers'] = TRUE;
		$config['page_query_string'] = TRUE;
		$config['num_links'] = 3;
		$this->pagination->initialize($config);

		$entries = 'Showing ' . ($offset + 1) . ' to ' . ($offset + count($AllRecord)) . ' of ' . $totalRecords . ' entries';

		$data = [
			'results' => $AllRecord,
			'links' => $this->pagination->create_links(),
			'entries' => $entries,
			'index' => 'VendorOrder',
			'title' => 'Manage Order'
		];

		$this->load->view('include/header', $data);
		$this->load->view('Vendor/VendorOrderList', $data);
		$this->load->view('include/footer');
	}
	public function VendorViewOrderDetails($id = '', $payment_type = '')
	{
		is_not_logged_in();
		$vendorData = $this->session->userdata('adminData');
		$vendor_id = $vendorData['Id'];

		$data['title'] = 'Manage Order';

		// Determine table by payment type
		if ($payment_type == 1)
		{
			$orderTbl = 'order_master';
			$purchaseTbl = 'purchase_master';
			$addressTbl = 'order_address_master';
			$orderType = 'offline';
		} elseif ($payment_type == 2)
		{
			$orderTbl = 'order_master2';
			$purchaseTbl = 'purchase_master2';
			$addressTbl = 'order_address_master2';
			$orderType = 'online';
		} else
		{
			show_404();
		}

		$order = $this->db->get_where($orderTbl, ['id' => $id])->row_array();
		if (empty($order))
			show_404();

		$data['getData'] = $order;
		$data['orderType'] = $orderType;

		// Fetch purchase data
		$purchaseData = $this->db->where('order_master_id', $id)->get($purchaseTbl)->result_array();
		$data['purchaseData'] = $purchaseData;
		$data['product_ids'] = array_column($purchaseData, 'product_master_id');

		// Fetch shipping address
		$address_data = $this->db->where('order_master_id', $id)->get($addressTbl)->row_array();
		$data['address_data'] = $address_data;

		$this->load->view('include/header', $data);
		$this->load->view('Vendor/VendorViewOrderDetails', $data);
		$this->load->view('include/footer');
	}

	public function PromoterOrderList()
	{
		is_not_logged_in();
		$this->load->library('pagination');

		$limit = 10;
		$pageNo = $this->input->get('per_page');
		$pageNo = (!empty($pageNo) && $pageNo > 0) ? $pageNo : 1;
		$offset = ($pageNo - 1) * $limit;

		/* ================= FILTERS ================= */
		$keywords = $this->input->post('keywords');
		$fromDate = $this->input->post('fromDate');
		$toDate = $this->input->post('toDate');
		$order_status = $this->input->post('order_status');
		$delete_status = $this->input->post('delete_status');
		$customer_name = $this->input->post('customer_name');

		/* ================= PROMOTER ID ================= */
		$promoter_id = $this->session->userdata('adminData')['Id'];

		/* ================= DATE TO TIMESTAMP ================= */
		$fromTimestamp = '';
		$toTimestamp = '';

		if (!empty($fromDate) && !empty($toDate))
		{
			$fromTimestamp = strtotime($fromDate . ' 00:00:00');
			$toTimestamp = strtotime($toDate . ' 23:59:59');
		}

		/* ================= COMMON WHERE ================= */
		$whereCod = " WHERE p.promoter_id = '$promoter_id' ";
		$whereOnline = " WHERE p.promoter_id = '$promoter_id' ";

		if (!empty($keywords))
		{
			$whereCod .= " AND o.order_number LIKE '%$keywords%' ";
			$whereOnline .= " AND o.order_number LIKE '%$keywords%' ";
		}

		if (!empty($customer_name))
		{
			$whereCod .= " AND u.username LIKE '%$customer_name%' ";
			$whereOnline .= " AND u.username LIKE '%$customer_name%' ";
		}

		if (!empty($order_status))
		{
			$whereCod .= " AND o.status = '$order_status' ";
			$whereOnline .= " AND o.status = '$order_status' ";
		}

		if (!empty($delete_status) && $delete_status == 'delete')
		{
			$whereCod .= " AND o.action_payment = 'delete' ";
			$whereOnline .= " AND o.action_payment = 'delete' ";
		} else
		{
			$whereCod .= " AND o.action_payment = 'Yes' ";
			$whereOnline .= " AND o.action_payment = 'Yes' ";
		}

		if (!empty($fromTimestamp) && !empty($toTimestamp))
		{
			// COD (UNIX)
			$whereCod .= " AND o.add_date BETWEEN $fromTimestamp AND $toTimestamp ";
			// ONLINE (DATETIME)
			$whereOnline .= " AND o.add_date BETWEEN FROM_UNIXTIME($fromTimestamp) 
                          AND FROM_UNIXTIME($toTimestamp) ";
		}

		/* ================= COD ORDERS ================= */
		$codQuery = "
        SELECT 
            o.id,
            o.order_number,
            o.final_price,
            o.payment_type,
            o.payment_status,
            o.status,
            o.add_date,
            u.username,
            u.mobile
        FROM order_master o
        INNER JOIN purchase_master p ON p.order_master_id = o.id
        LEFT JOIN user_master u ON u.id = o.user_master_id
        $whereCod
        GROUP BY o.id
    ";

		/* ================= ONLINE ORDERS ================= */
		$onlineQuery = "
        SELECT 
            o.id,
            o.order_number,
            o.final_price,
            o.payment_type,
            o.payment_status,
            o.status,
            UNIX_TIMESTAMP(o.add_date) AS add_date,
            u.username,
            u.mobile
        FROM order_master2 o
        INNER JOIN purchase_master2 p ON p.order_master_id = o.id
        LEFT JOIN user_master u ON u.id = o.user_master_id
        $whereOnline
        GROUP BY o.id
    ";

		/* ================= FINAL UNION ================= */
		$finalQuery = "
        ($codQuery)
        UNION ALL
        ($onlineQuery)
        ORDER BY add_date DESC
        LIMIT $limit OFFSET $offset
    ";

		$AllRecord = $this->db->query($finalQuery)->result_array();

		/* ================= TOTAL COUNT ================= */
		$countQuery = "
        SELECT COUNT(*) AS total FROM (
            ($codQuery)
            UNION ALL
            ($onlineQuery)
        ) AS total_orders
    ";

		$totalRecords = $this->db->query($countQuery)->row()->total;

		/* ================= PAGINATION ================= */
		$config['base_url'] = base_url('admin/Vendor/PromoterOrderList');
		$config['total_rows'] = $totalRecords;
		$config['per_page'] = $limit;
		$config['use_page_numbers'] = TRUE;
		$config['page_query_string'] = TRUE;
		$config['num_links'] = 3;

		$this->pagination->initialize($config);

		$entries = 'Showing ' . ($offset + 1) . ' to ' .
			($offset + count($AllRecord)) . ' of ' . $totalRecords . ' entries';

		$data = [
			'results' => $AllRecord,
			'links' => $this->pagination->create_links(),
			'entries' => $entries,
			'index' => 'PromoterOrder',
			'title' => 'Manage Orders'
		];

		$this->load->view('include/header', $data);
		$this->load->view('Promoter/PromoterOrderList', $data);
		$this->load->view('include/footer');
	}


	public function PromoterViewOrderDetails($id = '', $payment_type = '')
	{
		is_not_logged_in();
		$promoterData = $this->session->userdata('adminData');
		$promoter_id = $promoterData['Id'];

		$data['title'] = 'Manage Order';

		// Determine table by payment type
		if ($payment_type == 1)
		{
			$orderTbl = 'order_master';
			$purchaseTbl = 'purchase_master';
			$addressTbl = 'order_address_master';
			$orderType = 'offline';
		} elseif ($payment_type == 2)
		{
			$orderTbl = 'order_master2';
			$purchaseTbl = 'purchase_master2';
			$addressTbl = 'order_address_master2';
			$orderType = 'online';
		} else
		{
			show_404();
		}

		// Fetch order
		$order = $this->db->get_where($orderTbl, ['id' => $id])->row_array();
		if (empty($order))
			show_404();

		// Fetch purchase data
		$purchaseData = $this->db->where('order_master_id', $id)->get($purchaseTbl)->result_array();
		$product_ids = array_column($purchaseData, 'product_master_id');

		// Fetch shipping address
		$address_data = $this->db->where('order_master_id', $id)->get($addressTbl)->row_array();

		$data['getData'] = $order;
		$data['purchaseData'] = $purchaseData;
		$data['address_data'] = $address_data;
		$data['orderType'] = $orderType;
		$data['product_ids'] = $product_ids;

		$this->load->view('include/header', $data);
		$this->load->view('Promoter/PromoterViewOrderDetails', $data);
		$this->load->view('include/footer');
	}

	public function promoter_registration()
	{
		if (!$this->input->is_ajax_request())
		{
			show_404();
		}

		/* ================= VALIDATION ================= */
		$this->form_validation->set_rules('name', 'Full Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|regex_match[/^[0-9]{10}$/]');
		$this->form_validation->set_rules('pincode', 'Pincode', 'required|regex_match[/^[0-9]{6}$/]');

		$this->form_validation->set_rules(
			'account_no',
			'Account Number',
			'trim|regex_match[/^[0-9]{9,18}$/]'
		);

		$this->form_validation->set_rules(
			'ifsc_code',
			'IFSC Code',
			'trim|regex_match[/^[A-Z]{4}0[A-Z0-9]{6}$/]'
		);

		if ($this->form_validation->run() == false)
		{
			echo json_encode([
				'status' => 'error',
				'msg' => strip_tags(validation_errors())
			]);
			return;
		}

		$email = $this->input->post('email');
		$mobile = $this->input->post('mobile');

		/* ================= CHECK OTP VERIFIED ================= */
		$promoter = $this->db
			->where('email', $email)
			->where('verify_otp', 1)
			->get('promoters')
			->row();

		if (!$promoter)
		{
			echo json_encode([
				'status' => 'error',
				'msg' => 'Please verify your email first'
			]);
			return;
		}

		/* ================= FILE UPLOAD ================= */
		$profile_pic = $this->_promoter_upload_file('profile_pic', PROMOTER_PROFILE_DIRECTORY);
		$promoter_logo = $this->_promoter_upload_file('promoter_logo', PROMOTER_DOCUMENT_DIRECTORY);
		$aadhar_card = $this->_promoter_upload_file('aadhar_card', PROMOTER_DOCUMENT_DIRECTORY);
		$pan_card = $this->_promoter_upload_file('pan_card', PROMOTER_DOCUMENT_DIRECTORY);

		/* ================= UPDATE DATA ================= */
		$update_data = [
			'role' => 'promoter',
			'name' => $this->input->post('name'),
			'shop_name' => $this->input->post('shop_name'),
			'mobile' => $mobile,
			'gst_number' => $this->input->post('gst_number'), // ✅ CORRECT COLUMN
			'profile_pic' => $profile_pic ?: $promoter->profile_pic,
			'promoter_logo' => $promoter_logo ?: $promoter->promoter_logo,
			'aadhar_card' => $aadhar_card ?: $promoter->aadhar_card,
			'pan_card' => $pan_card ?: $promoter->pan_card,
			'address' => $this->input->post('address'),
			'city' => $this->input->post('city'),
			'state' => $this->input->post('state'),
			'pincode' => $this->input->post('pincode'),
			'bank_name' => $this->input->post('bank_name'),
			'account_no' => $this->input->post('account_no'),
			'ifsc_code' => $this->input->post('ifsc_code'),
			'referred_by' => $this->input->post('promoter_code_used'),
			'status' => 0,
			'modify_date' => date('Y-m-d H:i:s')
		];

		$this->db->where('email', $email);
		$update = $this->db->update('promoters', $update_data);

		if ($update)
		{

			/* ================= EMAIL ================= */
			$mail_data = [
				'promoter_id' => $promoter->promoter_random_number,
				'name' => $update_data['name'],
				'mobile' => $mobile,
				'email' => $email,
				'address' => $update_data['address'],
				'city' => $update_data['city'],
				'state' => $update_data['state'],
				'pincode' => $update_data['pincode'],
				'gst_number' => $update_data['gst_number']
			];

			$email_body = $this->load->view(
				'web/email/promoter_registration_mail',
				$mail_data,
				true
			);

			$this->email_send->send_email(
				$email,
				$email_body,
				'Promoter Registration - Chenna'
			);

			echo json_encode([
				'status' => 'success',
				'msg' => 'Registration successful! Waiting for approval.'
			]);
		} else
		{
			echo json_encode([
				'status' => 'error',
				'msg' => 'Something went wrong!'
			]);
		}
	}


	// ================= UPLOAD FUNCTION =================
	private function _promoter_upload_file($field_name, $upload_dir)
	{
		if (!empty($_FILES[$field_name]['name']))
		{

			if (!is_dir($upload_dir))
			{
				mkdir($upload_dir, 0777, true);
			}

			$config['upload_path'] = $upload_dir;
			$config['allowed_types'] = 'jpg|jpeg|png|pdf';
			$config['max_size'] = 2048;
			$config['encrypt_name'] = TRUE;

			$this->load->library('upload');
			$this->upload->initialize($config);

			if ($this->upload->do_upload($field_name))
			{

				$file = $this->upload->data();
				$relative_path = str_replace(FCPATH, '', $upload_dir);

				return $relative_path . $file['file_name'];
			} else
			{
				echo json_encode([
					'status' => 'error',
					'msg' => strip_tags($this->upload->display_errors())
				]);
				exit;
			}
		}

		return null;
	}
	public function promoter_send_email_otp()
	{
		$email = $this->input->post('email');

		if (!$email)
		{
			echo json_encode(['status' => 'error', 'msg' => 'Email required']);
			return;
		}

		$promoter = $this->db->get_where('promoters', ['email' => $email])->row();

		if ($promoter && $promoter->verify_otp == 1)
		{
			echo json_encode(['status' => 'error', 'msg' => 'Email already verified']);
			return;
		}

		$otp = rand(100000, 999999);

		if ($promoter)
		{
			$this->db->where('email', $email)->update('promoters', ['otp' => $otp]);
			$promoter_random_number = $promoter->promoter_random_number;
			$name = $promoter->name ?: 'promoters';
		} else
		{
			$promoter_random_number = 'VENRGTS' . date('Y') . rand(100000, 999999);

			$this->db->insert('promoters', [
				'email' => $email,
				'otp' => $otp,
				'verify_otp' => 0,
				'promoter_random_number' => $promoter_random_number,
				'add_date' => date('Y-m-d H:i:s')
			]);

			$name = 'Promoter';
		}

		$message = $this->load->view(
			'web/email/promoter_otp_verification',
			['name' => $name, 'otp' => $otp],
			true
		);

		if ($this->email_send->send_email($email, $message, 'OTP Verification - Chenna'))
		{
			echo json_encode(['status' => 'success']);
		} else
		{
			echo json_encode(['status' => 'error', 'msg' => 'OTP send failed']);
		}
	}


	// Verify OTP
	public function promoter_verify_email_otp()
	{
		$email = $this->input->post('email');
		$otp = $this->input->post('otp');

		if (!$email || !$otp)
		{
			echo json_encode(['status' => 'error', 'msg' => 'Email & OTP required']);
			return;
		}

		$promoter = $this->db->get_where('promoters', ['email' => $email])->row();

		if (!$promoter)
		{
			echo json_encode(['status' => 'error', 'msg' => 'Email not found']);
			return;
		}

		if ($promoter->otp == $otp)
		{
			$this->db->where('email', $email)->update('promoters', [
				'verify_otp' => 1
			]);

			echo json_encode(['status' => 'success']);
		} else
		{
			echo json_encode(['status' => 'error', 'msg' => 'Invalid OTP']);
		}
	}


	public function promoter_list()
	{
		$data['index2'] = 'AllPromoterList';

		$data['promoters'] = $this->Vendor_model->get_all_promoters();
		$data['title'] = 'Promoter List';
		$this->load->view('include/header', $data);
		$this->load->view('Promoter/AllPromoterList', $data);
		$this->load->view('include/footer');
	}
	public function admin_appro_promoter_users()
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

			// 🔑 Generate referral code (unique)
			$ref_code = 'PROMO' . strtoupper(substr(md5(time() . $id), 0, 6));

			// Password
			$plain_password = str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);
			$hashed_password = password_hash($plain_password, PASSWORD_BCRYPT);

			// Update promoter
			$this->db->where('id', $id)->update('promoters', [
				'password' => $hashed_password,
				'reference_code' => $ref_code,
				'status' => 1
			]);

			// Send mail
			$user = $this->db->get_where('promoters', ['id' => $id])->row();

			$data = [
				'name' => $user->name,
				'mobile' => $user->mobile,
				'password' => $plain_password,
				'ref_code' => $ref_code
			];

			$msg = $this->load->view('web/email/promoter_approved_mail', $data, true);
			$this->email_send->send_email(
				$user->email,
				$msg,
				"Your Promoter Account Approved - Chenna"
			);

			echo json_encode(['status' => 'success', 'msg' => 'Promoter approved & referral code generated']);
		}
	}


	public function PromoteViewDetails($id)
	{
		$data['promoter'] = $this->Vendor_model->get_admin_promoter_by_id($id);

		if (empty($data['promoter']))
		{
			show_404();
		}

		$data['title'] = 'Promoter List';
		$this->load->view('include/header', $data);
		$this->load->view('Promoter/PromoteViewDetails', $data);
		$this->load->view('include/footer');
	}

	public function admin_delete_promoter()
	{
		$id = $this->input->post('id');
		$this->Vendor_model->admin_delete_promoter($id);
		echo 'success';
	}

	public function VendorsByPromoter()
	{
		is_not_logged_in();
		$adminData = $this->session->userdata('adminData');
		if ($adminData['Type'] != 3)
		{
			redirect('admin/Welcome');
		}

		$promoter_id = $adminData['Id'];

		$data['total_vendors'] = $this->Vendor_model->total_vendors_by_promoter($promoter_id);
		$data['vendors'] = $this->Vendor_model->vendors_with_plan_status($promoter_id);

		$data['title'] = 'My Vendors';
		$data['index'] = 'VendorListByPromoter';

		$this->load->view('include/header', $data);
		$this->load->view('Promoter/VendorsByPromoter', $data);
		$this->load->view('include/footer');
	}

	// Renew vendor plan by promoter
	public function renew_vendor_plan()
	{
		$vendor_id = $this->input->post('vendor_id');
		$promoter_id = $this->session->userdata('adminData')['Id'];

		// Example: Extend subscription 1 month from today
		$new_end_date = date('Y-m-d', strtotime('+1 month'));
		$this->db->where('vendor_id', $vendor_id)->update('vendor_subscriptions_master', [
			'end_date' => $new_end_date,
			'status' => 1,
			'updated_at' => date('Y-m-d H:i:s')
		]);

		// Assign vendor to current promoter
		$this->Vendor_model->assign_vendor_to_promoter($vendor_id, $promoter_id);

		echo json_encode(['status' => 'success', 'message' => 'Plan renewed successfully']);
	}



	public function accept($purchase_id)
	{
		$vendor_id = $this->session->userdata('adminData')['Id'];

		$this->db->where([
			'id' => $purchase_id,
			'vendor_id' => $vendor_id,
			'status' => 1
		])->update('purchase_master', ['status' => 3]);

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function cancel($purchase_id)
	{
		$vendor_id = $this->session->userdata('adminData')['Id'];

		$this->db->where([
			'id' => $purchase_id,
			'vendor_id' => $vendor_id,
			'status' => 1
		])->update('purchase_master', ['status' => 2]);

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function ship($purchase_id)
	{
		$vendor_id = $this->session->userdata('adminData')['Id'];

		$this->db->where([
			'id' => $purchase_id,
			'vendor_id' => $vendor_id,
			'status' => 3
		])->update('purchase_master', ['status' => 4]);

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function PromoterUpdateProfile($id)
	{
		$this->load->model('Vendor_model');

		$data['getData'] = $this->Vendor_model->getSinglePromoterData($id);
		$data['title'] = 'Update Promoter Profile';

		$this->load->view('include/header', $data);
		$this->load->view('Promoter/PromoterUpdateProfile', $data);
		$this->load->view('include/footer');
	}
	public function SavePromoterProfile($id)
	{
		$post = $this->input->post();
		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|exact_length[10]|numeric');
		$this->form_validation->set_rules('pincode', 'Pincode', 'exact_length[6]|numeric');
		$this->form_validation->set_rules('gst_number', 'GST Number', 'max_length[15]');
		$this->form_validation->set_rules('account_no', 'Account Number', 'max_length[20]');
		$this->form_validation->set_rules('ifsc_code', 'IFSC Code', 'max_length[20]');

		if ($this->form_validation->run() == FALSE)
		{
			$this->PromoterUpdateProfile($id);
			return;
		}
		// ---------------- Prepare data array ----------------
		$data = [
			'name' => $post['name'],
			'email' => $post['email'],
			'mobile' => $post['mobile'],
			'role' => $post['role'],
			'promoter_random_number' => $post['promoter_random_number'],
			'shop_name' => $post['shop_name'],
			'gst_number' => $post['gst_number'],
			'wallet_amount' => $post['wallet_amount'],
			'address' => $post['address'],
			'city' => $post['city'],
			'state' => $post['state'],
			'pincode' => $post['pincode'],
			'bank_name' => $post['bank_name'],
			'aadhar_card' => $post['aadhar_card'] ?? null,
			'pan_card' => $post['pan_card'] ?? null,
			'account_no' => $post['account_no'],
			'ifsc_code' => $post['ifsc_code'],
			'reference_code' => $post['reference_code'],
			'referred_by' => $post['referred_by'],
			'status' => $post['status'],
			'modify_date' => date('Y-m-d H:i:s')
		];

		// ---------------- Password update if entered ----------------
		if (!empty($post['password']))
		{
			$data['password'] = password_hash($post['password'], PASSWORD_BCRYPT);
		}

		// ---------------- Handle file uploads ----------------
		$files = [
			'profile_pic' => PROMOTER_PROFILE_DIRECTORY,
			'promoter_logo' => PROMOTER_PROFILE_DIRECTORY,
			'aadhar_card' => PROMOTER_DOCUMENT_DIRECTORY,
			'pan_card' => PROMOTER_DOCUMENT_DIRECTORY
		];

		foreach ($files as $inputName => $uploadDir)
		{
			if (isset($_FILES[$inputName]) && $_FILES[$inputName]['name'] != '')
			{
				if (!is_dir($uploadDir))
					mkdir($uploadDir, 0777, true);

				$filename = time() . '_' . basename($_FILES[$inputName]['name']);
				$targetPath = $uploadDir . $filename;

				if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $targetPath))
				{
					$relativePath = str_replace(FCPATH, '', $targetPath);
					$data[$inputName] = $relativePath;
				}
			}
		}

		// ---------------- Update promoter in DB ----------------
		$this->db->where('id', $id);
		$this->db->update('promoters', $data);

		$this->session->set_flashdata('success', 'Promoter profile updated successfully.');
		redirect('admin/Vendor/PromoterUpdateProfile/' . $id);
	}

	public function VendorPromoterPlans()
	{
		is_not_logged_in();
		$user = $this->session->userdata('adminData');
		if (!$user)
			redirect('admin/Welcome');

		$this->load->model('Subscription_model');

		if ($user['Type'] == 1)
		{
			$data['subscriptions'] = $this->Subscription_model->subscription_list();
			$data['title'] = 'All Subscription Plans';
		} else if ($user['Type'] == 2)
		{
			$data['subscriptions'] = $this->Subscription_model
				->getSingleVendorSubscription($user['Id']);
			$data['title'] = 'Vendor Subscription Plan';
		} else if ($user['Type'] == 3)
		{
			$data['subscriptions'] = $this->Subscription_model
				->getSinglePromoterSubscription($user['Id']);
			$data['title'] = 'Promoter Subscription Plan';
		}

		$this->load->view('include/header', $data);
		$this->load->view('Vendor/VendorPromoterPlans', $data);
		$this->load->view('include/footer');
	}









	// End Registration
	// public function index()
	// {
	// 	$data['index'] = 'Vendor';
	// 	$data['index2'] = '';
	// 	$data['title'] = 'Manage Vendor';
	// 	$data['getData'] = $this->Vendor_model->getVendotList();

	// 	$this->load->view('include/header', $data);
	// 	$this->load->view('Vendor/VendorList');
	// 	$this->load->view('include/footer');
	// }

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
		$this->load->view('Vendor/UpdateVendorProfile', $data);
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
