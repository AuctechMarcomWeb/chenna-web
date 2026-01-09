<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('email');
		$this->load->library('session');
		$this->load->helper('message');
		$this->load->helper('api');
		$this->load->model('user_model');
		$this->load->library('form_validation');
		// $this->load->library('GlobalClass');
		// $this->load->library('pagination');
		is_not_logged_in();
	}







	public function action2()
	{
		$this->load->view('getData');
	}

	public function OfferStatus($id = '')
	{
		$id = $this->uri->segment(4);

		$sql = $this->db->query("SELECT * from offer_master where id= '" . $id . "'")->row_array();
		$sql['status'];
		$arrayName = array();
		$arrayName['status'] = ($sql['status'] == '1') ? '2' : '1';
		$arrayName['modify_date'] = time();
		$this->db->where('id', $id);
		$this->db->update('offer_master', $arrayName);
		echo $arrayName['status'];

	}
	public function pincode()
	{
		//print_r($_SESSION['adminData']); exit;
		is_not_logged_in();
		//print_r($adminData); exit;
		$data['index'] = 'pin';
		$data['index2'] = '';
		$data['title'] = 'Manage pincode';
		$data['getData'] = $this->db->query("select * from pin_code_master order by id desc")->result_array();
		$this->load->view('include/header', $data);
		$this->load->view('pincode/pincode');
		$this->load->view('include/footer');
	}

	public function delete_pincode($id)
	{
		$query = "delete from pin_code_master where id =" . $id;
		$this->db->query($query);
		redirect(base_url() . "admin/Dashboard/pincode");
	}

	public function OrderQuery()
	{
		//print_r($_SESSION['adminData']); exit;
		is_not_logged_in();
		//print_r($adminData); exit;
		$data['index'] = 'pin';
		$data['index2'] = '';
		$data['title'] = 'Manage pincode';
		//$data['getData']       = $this->db->query("select * from ORDER_QUERY order by OQ_ID desc")->result_array();
		$data['getData'] = $this->db->query("SELECT ORDER_QUERY.*, sub_product_master.* FROM ORDER_QUERY JOIN sub_product_master ON ORDER_QUERY.PRODUCT_ID = sub_product_master.id ORDER BY ORDER_QUERY.OQ_ID DESC")->result_array();


		$this->load->view('include/header', $data);
		$this->load->view('pincode/order_query_list');
		$this->load->view('include/footer');
	}

	public function delete_OrderQuery($id)
	{
		$query = "delete from ORDER_QUERY where OQ_ID =" . $id;
		$this->db->query($query);
		redirect(base_url() . "admin/Dashboard/OrderQuery");
	}

	public function add_pincode()
	{
		//print_r($_SESSION['adminData']); exit;
		is_not_logged_in();
		//print_r($adminData); exit;
		$data['index'] = 'pin';
		$data['index2'] = '';
		$data['title'] = 'Manage pincode';
		$this->load->view('include/header', $data);
		$this->load->view('pincode/add_pincode');
		$this->load->view('include/footer');
	}
	public function edit_pincode($id)
	{
		//print_r($_SESSION['adminData']); exit;
		is_not_logged_in();
		//print_r($adminData); exit;
		$data['index'] = 'pin';
		$data['index2'] = '';
		$data['data'] = $this->db->get_where('pin_code_master', array('id' => $id))->row_array();
		$data['title'] = 'Manage pincode';
		$this->load->view('include/header', $data);
		$this->load->view('pincode/edit_pincode');
		$this->load->view('include/footer');
	}

	public function add_pincode_data()
	{
		$data = $this->input->post();
		$row = $this->user_model->add_pincode_data($data);
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', ' Pincode has been add Successfully.'));
			redirect('admin/Dashboard/pincode/');
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('w', '!Opps Something is worng.Please try again.'));
			redirect('admin/Dashboard/pincode/');
		}
	}


	public function edit_pincode_data($id)
	{
		$data = $this->input->post();
		$row = $this->user_model->edit_pincode_data($data, $id);
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', ' Pincode has been Update Successfully.'));
			redirect('admin/Dashboard/pincode/');
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('w', '!Opps Something is worng.Please try again.'));
			redirect('admin/Dashboard/pincode/');
		}
	}



	public function changeStatus()
	{
		$table = $this->input->post('table');
		$id = $this->input->post('id');
		$update_status = $this->changeStatuss($id, $table);
		echo $update_status;
		die();
	}

	public function changeStatuss($row_id, $table_name)
	{
		$qry = $this->db
			->select('*')
			->from($table_name)
			->where('id', $row_id)
			->get()
			->row_array();

		$cur_date = strtotime(date('d-m-Y'));

		if ($qry['status'] == '1')
		{

			$data = array(
				'status' => '2',
				'modify_date' => $cur_date
			);
			$update_data = $this->db->where('id', $row_id)->update($table_name, $data);
			return 2;

		} else if ($qry['status'] == '2')
		{

			$data = array(
				'status' => '1',
				'modify_date' => $cur_date
			);
			$update_data = $this->db->where('id', $row_id)->update($table_name, $data);
			return 1;

		}
	}

	// public function index($id = '')
	// {
	// 	is_not_logged_in();
	// 	$data['index'] = 'index';
	// 	$data['index2'] = '';
	// 	$data['title'] = 'Manage Dashboard';
	// 	$this->load->model('Order_model');
	// 	$data['title'] = 'Admin Dashboard';
	// 	$data['order_summary'] = $this->Order_model->getOrderSummary();
	// 	$this->load->view('include/header', $data);
	// 	$this->load->view('dashboard/index');
	// 	$this->load->view('include/footer');
	// }


	public function index($id = '')
	{
		
		is_not_logged_in();

	
		$user = $this->session->userdata('adminData');

		if (!$user)
		{
			redirect('admin/Welcome');
		}
		$data = [];

		if ($user['Type'] == 1)
		{
			// ---------------- ADMIN DASHBOARD ----------------
			$data['title'] = 'Admin Dashboard';
			$data['index'] = 'index';
			$this->load->model('Order_model');
			$data['order_summary'] = $this->Order_model->getOrderSummary();
			$this->load->view('include/header', $data);
			$this->load->view('dashboard/index');
			$this->load->view('include/footer');
		} else if ($user['Type'] == 2)
		{
			// ---------------- VENDOR DASHBOARD ----------------
			$data['title'] = 'Vendor Dashboard';
			$data['index'] = 'index';
			$this->load->model('Order_model');
			$data['order_summary'] = $this->Order_model->getOrderSummary(); 
			$this->load->view('include/header', $data);
			$this->load->view('dashboard/index');
			$this->load->view('include/footer');
		} else
		{
			redirect('admin/Welcome');
		}
	}

	public function change_password($id = '')
	{
		is_not_logged_in();
		$data['index'] = 'index';
		$data['index2'] = '';
		$data['title'] = 'Change Password';
		$this->load->view('include/header', $data);
		$this->load->view('dashboard/change_password');
		$this->load->view('include/footer');
	}


	public function transaction($id)
	{
		// print_r($this->session->userdata('adminData'));exit;
		is_not_logged_in();
		$data['index'] = 'boy';
		$data['index2'] = '';
		$data['title'] = 'Manage Transaction';
		$data['getData'] = $this->db->query("select * from delivery_boy_transaction where delivery_boy_id=" . $id . "")->result_array();
		$this->load->view('include/header', $data);
		$this->load->view('DeliveryBoy/transaction');
		$this->load->view('include/footer');
	}


	public function DeliveryBoyLocation($id)
	{
		$today = date("d-m-Y");
		$date = $this->input->post('date');
		$data['index'] = 'boy';
		$data['index2'] = '';
		$data['title'] = 'Devlivery Boy Location';
		if (empty($date))
		{
			$data['getData'] = $this->db->query("select * from delivery_boy_status where delivery_boy_id=" . $id . " and add_date='$today'")->result_array();
		} else
		{
			$data['getData'] = $this->db->query("select * from delivery_boy_status where delivery_boy_id=" . $id . " and add_date='$date'")->result_array();
		}
		$this->load->view('include/header', $data);
		$this->load->view('DeliveryBoy/delivery_boy_status', $data);
		$this->load->view('include/footer');
	}
	public function DeliveryBoyLogout($id)
	{
		$row = $this->db->query("update deliver_boy_master set login_status='2' where id=" . $id . "");
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', 'Delivery Boy has been Logout Successfully.'));
			redirect('admin/Dashboard/DeliveryBoy/');
		}
	}
	public function UpdateDeliveryBoy($id)
	{
		$data['index'] = 'boy';
		$data['index2'] = '';
		$data['title'] = 'Update Devlivery Boy';
		$data['getData'] = $this->db->query("select * from deliver_boy_master where id=" . $id . "")->row_array();
		$this->load->view('include/header', $data);
		$this->load->view('DeliveryBoy/UpdateDeliveryBoy');
		$this->load->view('include/footer');
	}
	public function UpdateBoyData($id)
	{
		$data = $this->input->post();
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
			$data['photo'] = utf8_encode(trim($uniqueName));
			$row = $this->user_model->UpdateBoyData($data, $id);
			if ($row > 0)
			{
				$this->session->set_flashdata('activate', getCustomAlert('S', 'Delivery Boy has been add Successfully.'));
				redirect('admin/Dashboard/DeliveryBoy/');
			} else
			{
				$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
				redirect('admin/Dashboard/DeliveryBoy/');
			}
		} else
		{
			$data['photo'] = $data['pre_image'];
			$row = $this->user_model->UpdateBoyData($data, $id);
			if ($row > 0)
			{
				$this->session->set_flashdata('activate', getCustomAlert('S', 'Delivery Boy has been add Successfully.'));
				redirect('admin/Dashboard/DeliveryBoy/');
			} else
			{
				$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
				redirect('admin/Dashboard/DeliveryBoy/');
			}
		}
	}

	public function rejected($id)
	{
		is_not_logged_in();
		$data['index'] = 'boy';
		$data['index2'] = '';
		$data['title'] = 'Manage Rejeced Items';
		$data['getData'] = $this->db->query("select * from assign_order,purchase_master where assign_order.order_id=purchase_master.order_master_id and purchase_master.status='2' and assign_order.deliverBoyId=" . $id . "")->result_array();
		$this->load->view('include/header', $data);
		$this->load->view('DeliveryBoy/rejected');
		$this->load->view('include/footer');
	}

	public function BoyRejectProduct($id, $user_id)
	{
		$row = $this->db->query("update purchase_master set reject_status='2' where id=" . $id . "");
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', 'Product Accepted Successfully.'));
			redirect(base_url() . "admin/Dashboard/rejected/" . $user_id);
		}
	}






	public function DeliveryStatus()
	{
		$id = $this->uri->segment(4);
		$sql = $this->db->query("SELECT * from deliver_boy_master where id= '" . $id . "'")->row_array();
		$sql['status'];
		$arrayName = array();
		$arrayName['status'] = ($sql['status'] == 1) ? '2' : '1';
		$this->db->where('id', $id);
		$this->db->update('deliver_boy_master', $arrayName);
		echo $arrayName['status'];

	}
	public function AddBoyData()
	{
		$data = $this->input->post();
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
			$data['photo'] = utf8_encode(trim($uniqueName));
			$row = $this->user_model->AddBoyData($data);
			if ($row > 0)
			{
				$this->session->set_flashdata('activate', getCustomAlert('S', 'Delivery Boy has been add Successfully.'));
				redirect('admin/Dashboard/DeliveryBoy/');
			} else
			{
				$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
				redirect('admin/Dashboard/DeliveryBoy/');
			}
		}
	}

	public function DeliveryBoy()
	{
		$data['index'] = 'boy';
		$data['index2'] = '';
		$data['title'] = 'Manage Devlivery Boy';
		$data['getData'] = $this->user_model->getDeliveryBoy();
		$this->load->view('include/header', $data);
		$this->load->view('DeliveryBoy/delivery_boy');
		$this->load->view('include/footer');
	}



	public function AddDeliveryBoy()
	{
		$data['index'] = 'boy';
		$data['index2'] = '';
		$data['title'] = 'Add Devlivery Boy';
		$this->load->view('include/header', $data);
		$this->load->view('DeliveryBoy/AddDeliveryBoy');
		$this->load->view('include/footer');
	}

	public function Category($id)
	{
		is_not_logged_in();
		$data['index'] = 'Catgy';
		$data['index2'] = '';
		$data['title'] = 'Manage Category';
		$data['result'] = $this->user_model->getCatgy_list($id);
		$this->load->view('include/header', $data);
		$this->load->view('category/index');
		$this->load->view('include/footer');
	}


	public function parentCategory()
	{
		is_not_logged_in();
		$data['index'] = 'Catgy';
		$data['index2'] = '';
		$data['title'] = 'Manage Parent Category';
		$data['result'] = $this->user_model->getParCatgy_list();
		$this->load->view('include/header', $data);
		$this->load->view('category/main_index');
		$this->load->view('include/footer');
	}


	public function addCategory()
	{
		is_not_logged_in();
		$data['index'] = 'addctgy';
		$data['index2'] = '';
		$data['title'] = 'Add Application';
		$data['getData'] = $this->db->get_where('parent_category_master', array('id' => $this->uri->segment(4)))->row_array();
		$this->load->view('include/header', $data);
		$this->load->view('category/add');
		$this->load->view('include/footer');
	}

	public function addParentCategory()
	{
		is_not_logged_in();
		$data = $this->input->post();
		if (empty($data))
		{

			$data['index'] = 'addctgy';
			$data['index2'] = '';
			$data['title'] = 'Add Application';
			$this->load->view('include/header', $data);
			$this->load->view('category/add_parent_category');
			$this->load->view('include/footer');

		} else
		{


			$row = $this->db->insert('parent_category_master', $data);

			if ($row > 0)
			{
				$this->session->set_flashdata('activate', getCustomAlert('S', 'Category has been add Successfully.'));
				redirect('admin/Dashboard/parentCategory/');
			} else
			{
				$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
				redirect('admin/Dashboard/parentCategory/');
			}


		}

	}




	public function addCategoryPost()
	{
		$data = $this->input->post();

		$fileName = $_FILES["uploadFileApp"]["name"];
		$extension = explode('.', $fileName);
		$extension = strtolower(end($extension));
		$uniqueName = uniqid() . '.' . $extension;
		$type = $_FILES["uploadFileApp"]["type"];
		$size = $_FILES["uploadFileApp"]["size"];
		$tmp_name = $_FILES['uploadFileApp']['tmp_name'];
		$targetlocation = IMAGE_DIRECTORY . $uniqueName;
		if (!empty($fileName))
		{
			move_uploaded_file($tmp_name, $targetlocation);
			$data['app_icon'] = utf8_encode(trim($uniqueName));
		}


		$row = $this->user_model->addCategoryData($data);
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', 'Category has been add Successfully.'));
			redirect('admin/Dashboard/Category/' . $data['mai_id']);
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
			redirect('admin/Dashboard/Category/' . $data['mai_id']);
		}
	}

	public function UpdateCategory()
	{
		is_not_logged_in();
		$id = $this->uri->segment(4);
		$data['index'] = 'UpdCatgy';
		$data['index2'] = '';
		$data['title'] = 'Update Category';
		$data['getData'] = $this->user_model->getCatgy_Data($id);
		// print_r($data['getData']); exit;
		$this->load->view('include/header', $data);
		$this->load->view('category/edit');
		$this->load->view('include/footer');


	}

	public function UpdateParenrCategory($id)
	{
		$data = $this->input->post();
		is_not_logged_in();
		$id = $this->uri->segment(4);

		if (empty($data))
		{
			$data['index'] = 'UpdCatgy';
			$data['index2'] = '';
			$data['title'] = 'Update Parent Category';
			$data['getData'] = $this->db->get_where('parent_category_master', array('id' => $id))->row_array();
			// print_r($data['getData']); exit;
			$this->load->view('include/header', $data);
			$this->load->view('category/edit_parent_category');
			$this->load->view('include/footer');

		} else
		{
			$this->db->where('id', $id);
			$row = $this->db->update('parent_category_master', $data);
			if ($row > 0)
			{
				$this->session->set_flashdata('activate', getCustomAlert('S', 'Category has been update Successfully.'));
				redirect('admin/Dashboard/parentCategory/');
			} else
			{
				$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
				redirect('admin/Dashboard/parentCategory/');
			}


		}


	}


	public function UpdateCategoryPost($id)
	{

		$data = $this->input->post();
		$data['id'] = $id;
		$fileName = $_FILES["uploadFileApp"]["name"];
		$extension = explode('.', $fileName);
		$extension = strtolower(end($extension));
		$uniqueName = uniqid() . '.' . $extension;
		$type = $_FILES["uploadFileApp"]["type"];
		$size = $_FILES["uploadFileApp"]["size"];
		$tmp_name = $_FILES['uploadFileApp']['tmp_name'];
		$targetlocation = IMAGE_DIRECTORY . $uniqueName;

		if (!empty($fileName))
		{
			move_uploaded_file($tmp_name, $targetlocation);
			$data['app_icon'] = utf8_encode(trim($uniqueName));
		}

		// GET UPLAOD VIDEO TIME AFTER UPLOAD VIDEO ON THE SERVER
		$row = $this->user_model->UpdateCategoryPost($data);
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', 'Category has been update Successfully.'));
			redirect('admin/Dashboard/Category/' . $data['parent_id']);
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('W', 'Oops! somthing is worng please try again.'));
			redirect('admin/Dashboard/Category/' . $data['parent_id']);
		}
	}


	public function ExsistMsg()
	{
		$query = "SELECT * From `sub_category_master`  Where `sub_category_name` = '" . $_POST["app_id"] . "' ";
		$result = $this->db->query($query)->num_rows();
		echo $result;
		//return $result;
	}

	public function deleteSubCatgy_new($catId, $id)
	{
		// 	$query  = "delete from sub_category_master" . $_POST["app_id"] . "' ";
		$this->db->where('id', $id)
			->update('sub_category_master', array('status' => 3));

		redirect(base_url() . "admin/Dashboard/subCatgy/" . $catId);
	}


	public function subCatgy($id = '')
	{

		$data['index'] = 'Catgy';
		$data['index2'] = '';
		$data['title'] = 'Manage Sub-Category';
		$data['result'] = $this->user_model->getSubCatgy_list($id);

		$this->load->view('include/header', $data);
		$this->load->view('category/SubcatgyList');
		$this->load->view('include/footer');

	}

	public function addSubCategory()
	{

		$data['index'] = 'Catgy';
		$data['index2'] = '';
		$data['title'] = 'Add Sub-Category';
		$data['getCatgy'] = $this->user_model->getALLcatgy();
		//$data['previous_site']  =  $_SERVER['HTTP_REFERER']; 
		$data['set_gst'] = $this->user_model->chk_set_gst();

		$this->load->view('include/header', $data);
		$this->load->view('category/Subadd');
		$this->load->view('include/footer');
	}

	public function addSubCatPost()
	{
		$data = $this->input->post();
		$Url = $this->input->post('Url');
		$data['Catid'] = $this->uri->segment(4);
		$fileName = $_FILES["uploadFileApp"]["name"];
		$extension = explode('.', $fileName);
		$extension = strtolower(end($extension));
		$uniqueName = 'sub_catgy_' . uniqid() . '.' . $extension;
		$type = $_FILES["uploadFileApp"]["type"];
		$size = $_FILES["uploadFileApp"]["size"];
		$tmp_name = $_FILES['uploadFileApp']['tmp_name'];
		$targetlocation = IMAGE_DIRECTORY . $uniqueName;
		if (!empty($fileName))
		{
			move_uploaded_file($tmp_name, $targetlocation);
			$data['app_icon'] = utf8_encode(trim($uniqueName));
		}
		/*
		// echo $data['app_icon']."</br>"; 
		$fileName  = $_FILES["uploadFileWeb"]["name"];
		$extension = explode('.',$fileName);
		$extension = strtolower(end($extension));
		$uniqueName= 'sub_catgy_'.uniqid().'.'.$extension;
		$type      = $_FILES["uploadFileWeb"]["type"];
		$size      = $_FILES["uploadFileWeb"]["size"];
		$tmp_name  = $_FILES['uploadFileWeb']['tmp_name'];
		$targetlocation= IMAGE_DIRECTORY.$uniqueName;
		if(!empty($fileName)){
		move_uploaded_file($tmp_name,$targetlocation);
		$data['web_icon'] = utf8_encode(trim($uniqueName));
		}*/
		$Url = base_url('admin/Dashboard/Category');
		$row = $this->user_model->addSubCatPostData($data);
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', 'Sub-Category has been add Successfully.'));

			redirect('admin/Dashboard/subCatgy/' . $data['Catid']);


		} else
		{

			$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
			redirect('admin/Dashboard/subCatgy/' . $data['Catid']);

		}
	}

	public function UpdateSubCategory()
	{

		$id = $this->uri->segment(4);

		$data['index'] = 'Catgy';
		$data['index2'] = '';
		$data['title'] = 'Update Sub-Category';
		$data['getData'] = $this->user_model->getSubCatgyData($id);
		$data['getCatgy'] = $this->user_model->getALLcatgy();
		$data['set_gst'] = $this->user_model->chk_set_gst();
		$this->load->view('include/header', $data);
		$this->load->view('category/SubCatgyedit');
		$this->load->view('include/footer');


	}
	public function AddOffer()
	{

		$data = $this->input->post();

		$check = $this->user_model->updateOffer($data);
		if ($check > 0)
		{
			echo '1';
		} else
		{
			echo '2';
		}
	}

	public function CatgyStatus()
	{

		$id = $this->uri->segment(4);
		$sql = $this->db->query("SELECT * from category_master where id= '" . $id . "'")->row_array();
		$sql['status'];
		$arrayName = array();
		$arrayName['status'] = ($sql['status'] == 1) ? '2' : '1';
		$arrayName['modify_date'] = time();
		$this->db->where('id', $id);
		$this->db->update('category_master', $arrayName);
		echo $arrayName['status'];

	}

	public function getCatOffer()
	{
		$id = $this->uri->segment(4);
		$SQL = "SELECT * FROM sub_category_master where id = '" . $id . "'";
		$query = $this->db->query($SQL)->row_array();
		print_r($query);
	}

	public function DeleteCatgy()
	{
		$id = $this->uri->segment(4);
		$check = $this->user_model->delCatgy($id);
		if ($check > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', 'Category Deleted Successfully.'));
			redirect('admin/Dashboard/subCatgy/');
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
			redirect('admin/Dashboard/subCatgy/');
		}
	}

	public function UpdateSubCatData()
	{
		$data = $this->input->post();
		// print_r($data); exit;
		$data['id'] = $this->uri->segment(4);
		$data['catId'] = $this->uri->segment(5);

		$fileName = $_FILES["uploadFileApp"]["name"];
		$extension = explode('.', $fileName);
		$extension = strtolower(end($extension));
		$uniqueName = 'sub_catgy_' . uniqid() . '.' . $extension;
		$type = $_FILES["uploadFileApp"]["type"];
		$size = $_FILES["uploadFileApp"]["size"];
		$tmp_name = $_FILES['uploadFileApp']['tmp_name'];
		$targetlocation = IMAGE_DIRECTORY . $uniqueName;

		if (!empty($fileName))
		{
			move_uploaded_file($tmp_name, $targetlocation);
			$data['app_icon'] = utf8_encode(trim($uniqueName));
		}

		/*
		// echo $data['app_icon']."</br>"; 
		$fileName  = $_FILES["uploadFileWeb"]["name"];
		$extension = explode('.',$fileName);
		$extension = strtolower(end($extension));
		$uniqueName= 'sub_catgy_'.uniqid().'.'.$extension;
		$type      = $_FILES["uploadFileWeb"]["type"];
		$size      = $_FILES["uploadFileWeb"]["size"];
		$tmp_name  = $_FILES['uploadFileWeb']['tmp_name'];
		$targetlocation= IMAGE_DIRECTORY.$uniqueName;
		if(!empty($fileName)){
		move_uploaded_file($tmp_name,$targetlocation);
		$data['web_icon'] = utf8_encode(trim($uniqueName));
		}*/

		$row = $this->user_model->UpdateSubCategoryData($data);
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', 'Sub-Category has been update Successfully.'));
			redirect('admin/Dashboard/subCatgy/' . $data['catId']);


		} elseif ($row == 2)
		{
			$this->session->set_flashdata('activate', getCustomAlert('W', 'Sub-Category Already Exsist.'));
			redirect('admin/Dashboard/subCatgy/' . $data['catId']);
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('W', 'Oops! somthing is worng please try again.'));
			redirect('admin/Dashboard/subCatgy/' . $data['catId']);
		}
	}



	public function SubCatgyStatus()
	{
		$id = $this->uri->segment(4);
		$sql = $this->db->query("SELECT * from sub_category_master where id= '" . $id . "'")->row_array();
		$sql['status'];
		$arrayName = array();
		$arrayName['status'] = ($sql['status'] == 1) ? '2' : '1';
		$this->db->where('id', $id);
		$this->db->update('sub_category_master', $arrayName);
		echo $arrayName['status'];
	}

	public function SubDeleteCatgy()
	{
		$id = $this->uri->segment(4);
		$check = $this->user_model->SubdelCatgy($id);
		if ($check > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', 'Sub-Category is Deleted Successfully.'));
			redirect('admin/Dashboard/subCatgy/');
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
			redirect('admin/Dashboard/subCatgy/');
		}
	}


	public function BrandList()
	{

		$data['index'] = 'brand';
		$data['index2'] = '';
		$data['title'] = 'Manage Brand';
		$data['getData'] = $this->user_model->getAllBrands();
		$this->load->view('include/header', $data);
		$this->load->view('Brand/brand');
		$this->load->view('include/footer');
	}

	public function addbrand()
	{
		is_not_logged_in();
		$data['index'] = 'addbrand';
		$data['index2'] = '';
		$data['title'] = 'Add Brand';
		$data['getCatgy'] = $this->user_model->getALLcatgy();
		/*$data['getSubCat']   = $this->user_model->getALLSubCat();*/
		// echo "<pre>";		print_r($data['getSubCat']);exit;

		$this->load->view('include/header', $data);
		$this->load->view('Brand/add');
		$this->load->view('include/footer');
	}


	public function addBrandData()
	{
		$data = $this->input->post();
		$fileName = $_FILES["uploadFileBrand"]["name"];
		$extension = explode('.', $fileName);
		$extension = strtolower(end($extension));
		$uniqueName = 'Brand_' . uniqid() . '.' . $extension;
		$type = $_FILES["uploadFileBrand"]["type"];
		$size = $_FILES["uploadFileBrand"]["size"];
		$tmp_name = $_FILES['uploadFileBrand']['tmp_name'];
		$targetlocation = BRAND_DIRECTORY . $uniqueName;
		if (!empty($fileName))
		{
			move_uploaded_file($tmp_name, $targetlocation);
			$data['brand_image'] = utf8_encode(trim($uniqueName));
		}

		$row = $this->user_model->addBrandData($data);
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', 'Brand has been add Successfully.'));
			redirect('admin/Dashboard/BrandList/');
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
			redirect('admin/Dashboard/BrandList/');
		}
	}


	public function UpdateBrand()
	{
		is_not_logged_in();
		$id = $this->uri->segment(4);

		$data['index'] = 'Updbrand';
		$data['index2'] = '';
		$data['title'] = 'Update Brands';
		$data['getData'] = $this->user_model->GetBrandDetail($id);
		$this->load->view('include/header', $data);
		$this->load->view('Brand/editbrand');
		$this->load->view('include/footer');


	}
	public function UpdateBrandData()
	{
		$data = $this->input->post();
		$data['id'] = $this->uri->segment(4);
		$fileName = $_FILES["uploadFileBrand"]["name"];
		$extension = explode('.', $fileName);
		$extension = strtolower(end($extension));
		$uniqueName = 'Brand_' . uniqid() . '.' . $extension;
		$type = $_FILES["uploadFileBrand"]["type"];
		$size = $_FILES["uploadFileBrand"]["size"];
		$tmp_name = $_FILES['uploadFileBrand']['tmp_name'];
		$targetlocation = BRAND_DIRECTORY . $uniqueName;
		if (!empty($fileName))
		{
			move_uploaded_file($tmp_name, $targetlocation);
			$data['brand_image'] = utf8_encode(trim($uniqueName));
		}

		$row = $this->user_model->UpdateBrandData($data);
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', 'Brand has been Update Successfully.'));
			redirect('admin/Dashboard/BrandList/');
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
			redirect('admin/Dashboard/BrandList/');
		}
	}

	public function brandStatus()
	{
		$id = $this->uri->segment(4);
		$sql = $this->db->query("SELECT * from brand_master where id= '" . $id . "'")->row_array();
		$sql['status'];
		$arrayName = array();
		$arrayName['status'] = ($sql['status'] == 1) ? '2' : '1';
		$arrayName['modify_date'] = time();
		$this->db->where('id', $id);
		$this->db->update('brand_master', $arrayName);
		echo $arrayName['status'];


	}
	public function UnitList()
	{

		$data['index'] = 'Unit';
		$data['index2'] = 'Unit2';
		$data['title'] = 'Manage Unit';
		$data['getData'] = $this->user_model->unitList();
		$this->load->view('include/header', $data);
		$this->load->view('Unit/Unit');
		$this->load->view('include/footer');
	}


	public function tagList()
	{

		$data['index'] = 'Tag';
		$data['index2'] = 'Tag';
		$data['title'] = 'Manage Tag';
		$data['getData'] = $this->db->get_where('tag_master')->result_array();
		;
		$this->load->view('include/header', $data);
		$this->load->view('manageTag/tagList');
		$this->load->view('include/footer');
	}



	public function addTag()
	{
		is_not_logged_in();
		$data = $this->input->post();

		if (empty($data))
		{
			$data['index'] = 'addTag';
			$data['index2'] = 'addTag';
			$data['title'] = 'Add Tag';

			// 🔹 Parent Categories
			$data['parentCategories'] = $this->db->get_where('parent_category_master', ['status' => 1])->result_array();

			// 🔹 Initially empty category & subcategory
			$data['getCatgy'] = [];
			$data['sub_cate_data'] = [];

			// 🔹 Products
			$this->db->select('id, product_name, sub_category_id');
			$data['productData'] = $this->db->get_where('sub_product_master', ['status' => 1])->result_array();

			$this->load->view('include/header', $data);
			$this->load->view('manageTag/addTag');
			$this->load->view('include/footer');

		} else
		{
			// 🔹 Insert Tag
			$fields = [
				'name' => $data['TagName'],
				'product_ids' => json_encode($data['product_id']),
				'status' => '1',
				'add_date' => time(),
				'modify_date' => time()
			];

			$row = $this->db->insert('tag_master', $fields);

			if ($row > 0)
			{
				$this->session->set_flashdata('activate', getCustomAlert('S', 'Tag has been added Successfully.'));
			} else
			{
				$this->session->set_flashdata('activate', getCustomAlert('D', 'Oops! Something went wrong. Please try again.'));
			}

			redirect('admin/Dashboard/tagList/');
		}
	}


	public function getCategoriesByParent()
	{
		$parent_id = $this->input->post('parent_id');
		$categories = $this->db->get_where('category_master', ['mai_id' => $parent_id, 'status' => 1])->result_array();
		foreach ($categories as $c)
		{
			echo '<option value="' . $c['id'] . '">' . ucfirst($c['category_name']) . '</option>';
		}
	}

	public function getSubCategoriesByCat()
	{
		$cat_id = $this->input->post('cat_id');

		$this->db->where_in('category_master_id', explode(",", $cat_id));
		$this->db->where('status', 1);
		$subcategories = $this->db->get('sub_category_master')->result_array();

		foreach ($subcategories as $s)
		{
			echo '<option value="' . $s['id'] . '">' . ucfirst($s['sub_category_name']) . '</option>';
		}
	}

	public function getProductsBySubCategory()
	{
		$sub_id = $this->input->post('sub_id');
		$preChecked = $this->input->post('preChecked');

		if (!$sub_id)
		{
			echo '<p>No subcategory selected.</p>';
			return;
		}

		$products = $this->db->get_where('sub_product_master', [
			'sub_category_id' => $sub_id,
			'status' => 1
		])->result_array();

		if (empty($products))
		{
			echo '<p>No products found for this subcategory.</p>';
			return;
		}

		foreach ($products as $p)
		{
			$checked = (is_array($preChecked) && in_array($p['id'], $preChecked)) ? 'checked' : '';
			echo '<div class="checkbox">
                <label style="display: flex; align-items: center; gap: 6px;">
                  <input type="checkbox" name="product_id[]" value="' . $p['id'] . '" ' . $checked . '>
                  ' . ucfirst($p['product_name']) . '
                </label>
              </div>';
		}
	}
	public function getProductsSubCategory()
	{
		$sub_ids = $this->input->post('sub_ids');
		$preChecked = $this->input->post('preChecked');

		if (!$sub_ids)
		{
			echo '<option value="">No subcategory selected</option>';
			return;
		}

		$sub_ids_array = explode(',', $sub_ids);

		$this->db->where_in('sub_category_id', $sub_ids_array);
		$this->db->where('status', 1);
		$products = $this->db->get('sub_product_master')->result_array();

		if (empty($products))
		{
			echo '<option value="">No products found</option>';
			return;
		}

		foreach ($products as $p)
		{
			$selected = (is_array($preChecked) && in_array($p['id'], $preChecked)) ? 'selected' : '';
			echo '<option value="' . $p['id'] . '" ' . $selected . '>' . ucfirst($p['product_name']) . '</option>';
		}
	}




	// Update coupon code 

	public function getCategorieByParent()
	{
		$parent_id = $this->input->post('parent_id');
		$preChecked = $this->input->post('preChecked') ?? [];

		$categories = $this->db->get_where('category_master', ['mai_id' => $parent_id, 'status' => 1])->result_array();

		foreach ($categories as $c)
		{
			$selected = in_array($c['id'], $preChecked) ? 'selected' : '';
			echo '<option value="' . $c['id'] . '" ' . $selected . '>' . ucfirst($c['category_name']) . '</option>';
		}
	}

	public function getSubCategorieByCat()
	{
		$cat_ids = $this->input->post('cat_ids');
		$preChecked = $this->input->post('preChecked') ?? [];

		if ($cat_ids)
		{
			$this->db->where_in('category_master_id', explode(",", $cat_ids));
			$this->db->where('status', 1);
			$subcategories = $this->db->get('sub_category_master')->result_array();

			foreach ($subcategories as $s)
			{
				$selected = in_array($s['id'], $preChecked) ? 'selected' : '';
				echo '<option value="' . $s['id'] . '" ' . $selected . '>' . ucfirst($s['sub_category_name']) . '</option>';
			}
		}
	}

	public function getProdBySubCategory()
	{
		$sub_ids = $this->input->post('sub_ids');
		$preChecked = $this->input->post('preChecked') ?? [];

		if ($sub_ids)
		{
			$this->db->where_in('sub_category_id', explode(',', $sub_ids));
			$this->db->where('status', 1);
			$products = $this->db->get('sub_product_master')->result_array();

			foreach ($products as $p)
			{
				$selected = in_array($p['id'], $preChecked) ? 'selected' : '';
				echo '<option value="' . $p['id'] . '" ' . $selected . '>' . ucfirst($p['product_name']) . '</option>';
			}
		}
	}


	public function UpdateTag()
	{
		is_not_logged_in();
		$id = $this->uri->segment(4);
		$data = $this->input->post();

		if (!$data)
		{

			$data['index'] = $data['index2'] = 'updateTag';
			$data['title'] = 'Update Tag';
			$data['getData'] = $this->db->get_where('tag_master', ['id' => $id])->row_array();
			$data['parentCategories'] = $this->db->get_where('parent_category_master', ['status' => 1])->result_array();
			$data['productData'] = $this->db->get_where('sub_product_master', ['status' => 1])->result_array();


			$firstProductId = !empty($data['getData']['product_ids']) ? json_decode($data['getData']['product_ids'], true)[0] : null;
			if ($firstProductId)
			{
				$firstProduct = $this->db->get_where('sub_product_master', ['id' => $firstProductId])->row_array();
				if ($firstProduct)
				{
					$sub = $this->db->get_where('sub_category_master', ['id' => $firstProduct['sub_category_id']])->row_array();
					if ($sub)
					{
						$cat = $this->db->get_where('category_master', ['id' => $sub['category_master_id']])->row_array();
						if ($cat)
						{
							$data['getCatgy'] = $this->db->get_where('category_master', ['mai_id' => $cat['mai_id'], 'status' => 1])->result_array();
							$data['sub_cate_data'] = $this->db->get_where('sub_category_master', ['category_master_id' => $cat['id'], 'status' => 1])->result_array();
						}
					}
				}
			}


			$this->load->view('include/header', $data);
			$this->load->view('manageTag/updateTag');
			$this->load->view('include/footer');

		} else
		{

			$existing_ids = json_decode($this->db->get_where('tag_master', ['id' => $id])->row('product_ids'), true) ?: [];
			$submitted_ids = $data['product_id'] ?? [];
			$final_ids = array_unique(array_merge($existing_ids, $submitted_ids));


			$fields = [
				'name' => $data['tagName'],
				'product_ids' => json_encode($final_ids),
				'status' => $data['status'],
				'modify_date' => time()
			];

			$this->db->where('id', $id);
			$row = $this->db->update('tag_master', $fields);

			$msg = $row ? 'Tag has been updated successfully.' : 'Oops! Something went wrong. Please try again.';
			$this->session->set_flashdata('activate', getCustomAlert($row ? 'S' : 'D', $msg));

			redirect('admin/Dashboard/tagList/');
		}
	}

	public function viewTagProducts($tag_id)
	{
		is_not_logged_in();


		$data['tag'] = $this->db->get_where('tag_master', ['id' => $tag_id])->row_array();
		if (!$data['tag'])
		{
			$this->session->set_flashdata('activate', getCustomAlert('D', 'Tag not found!'));
			redirect('admin/Dashboard/tagList');
		}


		$product_ids = json_decode($data['tag']['product_ids'], true) ?: [];

		if (!empty($product_ids))
		{
			$this->db->select('p.id as product_id, p.product_name, s.sub_category_name, c.category_name, pc.name as parent_category_name');
			$this->db->from('sub_product_master p');
			$this->db->join('sub_category_master s', 's.id = p.sub_category_id', 'left');
			$this->db->join('category_master c', 'c.id = s.category_master_id', 'left');
			$this->db->join('parent_category_master pc', 'pc.id = c.mai_id', 'left');
			$this->db->where_in('p.id', $product_ids);
			$data['products'] = $this->db->get()->result_array();
		} else
		{
			$data['products'] = [];
		}

		$data['title'] = $data['tag']['name'];

		$this->load->view('include/header', $data);
		$this->load->view('manageTag/viewTagProducts', $data);
		$this->load->view('include/footer');
	}


	public function deleteTag($id)
	{
		is_not_logged_in();

		if ($id)
		{
			$deleted = $this->db->delete('tag_master', ['id' => $id]);

			if ($deleted)
			{
				$this->session->set_flashdata('activate', '<div class="alert alert-success">Tag deleted successfully.</div>');
			} else
			{
				$this->session->set_flashdata('activate', '<div class="alert alert-danger">Something went wrong while deleting tag.</div>');
			}
		} else
		{
			$this->session->set_flashdata('activate', '<div class="alert alert-warning">Invalid tag ID.</div>');
		}

		redirect('admin/Dashboard/tagList');
	}


	public function addUnit()
	{
		is_not_logged_in();
		$data['index'] = 'Unit';
		$data['index2'] = 'addUnit';
		$data['title'] = 'Add Unit';

		$this->load->view('include/header', $data);
		$this->load->view('Unit/addUnit');
		$this->load->view('include/footer');
	}
	public function addUnitData()
	{
		$data = $this->input->post();
		$row = $this->user_model->AddUnitData($data);
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', 'Unit has been add Successfully.'));
			redirect('admin/Dashboard/UnitList/');
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
			redirect('admin/Dashboard/UnitList/');
		}
	}

	public function UpdateUnit()
	{
		is_not_logged_in();
		$id = $this->uri->segment(4);
		$data['index'] = 'Unit';
		$data['index2'] = 'UpdUnit';
		$data['title'] = 'Update Unit';
		$data['getData'] = $this->user_model->getUnit_Data($id);
		// print_r($data['getData']);exit;
		$this->load->view('include/header', $data);
		$this->load->view('Unit/updateunit');
		$this->load->view('include/footer');
	}





	public function UpdateUnitData()
	{
		$data = $this->input->post();
		$data['id'] = $this->uri->segment(4);
		$row = $this->user_model->updateUnitData($data);
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', 'Unit has been Updated Successfully.'));
			redirect('admin/Dashboard/UnitList/');
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
			redirect('admin/Dashboard/UnitList/');
		}
	}





	public function colorList()
	{
		$data['index'] = 'color';
		$data['index2'] = '';
		$data['title'] = 'Manage Color';
		$data['getData'] = $this->user_model->GetColor();
		$this->load->view('include/header', $data);
		$this->load->view('Unit/colorList');
		$this->load->view('include/footer');
	}

	public function AddColor()
	{
		$data['index'] = 'color';
		$data['index2'] = '';
		$data['title'] = 'Add Color';

		$this->load->view('include/header', $data);
		$this->load->view('Unit/addColor');
		$this->load->view('include/footer');
	}

	public function updateColor($id = '')
	{

		/*$id =$this->uri->segment(4);*/
		$data['index'] = 'color';
		$data['index2'] = '';
		$data['title'] = 'Update Color';
		$data['getData'] = $this->user_model->getColor_Data($id);
		// print_r($data['getData']);exit;
		$this->load->view('include/header', $data);
		$this->load->view('Unit/updateColor');
		$this->load->view('include/footer');
	}




	public function addColorData()
	{
		$data = $this->input->post();
		$fileName = $_FILES["ColorImage"]["name"];
		$extension = explode('.', $fileName);
		$extension = strtolower(end($extension));
		$uniqueName = 'Color_' . uniqid() . '.' . $extension;
		$type = $_FILES["ColorImage"]["type"];
		$size = $_FILES["ColorImage"]["size"];
		$tmp_name = $_FILES['ColorImage']['tmp_name'];
		$targetlocation = BOY_DIRECTORY . $uniqueName;
		if (!empty($fileName))
		{
			move_uploaded_file($tmp_name, $targetlocation);
			$data['image'] = utf8_encode(trim($uniqueName));
		}

		$row = $this->user_model->AddColorData($data);
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', 'Color has been add Successfully.'));
			redirect('admin/Dashboard/colorList/');
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
			redirect('admin/Dashboard/colorList/');
		}
	}
	public function updateColorData($id)
	{
		$data = $this->input->post();
		$fileName = $_FILES["ColorImage"]["name"];
		$extension = explode('.', $fileName);
		$extension = strtolower(end($extension));
		$uniqueName = 'Color_' . uniqid() . '.' . $extension;
		$type = $_FILES["ColorImage"]["type"];
		$size = $_FILES["ColorImage"]["size"];
		$tmp_name = $_FILES['ColorImage']['tmp_name'];
		$targetlocation = BOY_DIRECTORY . $uniqueName;
		if (!empty($fileName))
		{
			move_uploaded_file($tmp_name, $targetlocation);
			$data['image'] = utf8_encode(trim($uniqueName));
		}

		$row = $this->user_model->UpdateColorData($data, $id);
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', 'Color has been add Successfully.'));
			redirect('admin/Dashboard/colorList/');
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
			redirect('admin/Dashboard/colorList/');
		}
	}









	public function unitStatus()
	{
		$id = $this->uri->segment(4);
		$sql = $this->db->query("SELECT * from unit_master where id= '" . $id . "'")->row_array();
		$sql['status'];
		$arrayName = array();
		$arrayName['status'] = ($sql['status'] == 1) ? '2' : '1';
		$this->db->where('id', $id);
		$this->db->update('unit_master', $arrayName);
		echo $arrayName['status'];
	}

	public function contactStatus()
	{
		$id = $this->uri->segment(4);
		$sql = $this->db->query("SELECT * from enquiry_master where id= '" . $id . "'")->row_array();
		$sql['status'];
		$arrayName = array();
		$arrayName['status'] = ($sql['status'] == 1) ? '2' : '1';
		$this->db->where('id', $id);
		$this->db->update('enquiry_master', $arrayName);
		echo $arrayName['status'];
	}




	public function Distinguish()
	{
		$data['index'] = 'dist';
		$data['index2'] = 'dist2';
		$data['title'] = 'Manage Distinguish';
		$data['getData'] = $this->user_model->distinguish();
		// print_r($data['getData']); exit;

		$this->load->view('include/header', $data);
		$this->load->view('distinguish/distinguish_listing');
		$this->load->view('include/footer');
	}
	public function add_dist()
	{
		is_not_logged_in();

		$data['index'] = 'dist';
		$data['index2'] = 'adddist';
		$data['title'] = 'Add Distinguish';

		$this->load->view('include/header', $data);
		$this->load->view('distinguish/AddDist');
		$this->load->view('include/footer');
	}
	// Updatedist
	public function add_dist_Data()
	{
		$data = $this->input->post();
		$row = $this->user_model->add_distData($data);
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', ' Distinguish has been add Successfully.'));
			redirect('admin/Dashboard/Distinguish/');
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
			redirect('admin/Dashboard/Distinguish/');
		}
	}

	public function Updatedist()
	{
		is_not_logged_in();
		$id = $this->uri->segment(4);
		$data['index'] = 'dist';
		$data['index2'] = 'Upddist';
		$data['title'] = 'Update Distinguish';
		$data['getData'] = $this->user_model->getDist_Data($id);
		// print_r($data['getData']);exit;
		$this->load->view('include/header', $data);
		$this->load->view('distinguish/Upd_Dist');
		$this->load->view('include/footer');
	}

	public function UpdateDistData()
	{
		$data = $this->input->post();
		$data['id'] = $this->uri->segment(4);
		$row = $this->user_model->updateDistData($data);
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', 'Distinguish has been Updated Successfully.'));
			redirect('admin/Dashboard/Distinguish/');
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
			redirect('admin/Dashboard/Distinguish/');
		}


	}
	public function DistStatus()
	{
		$id = $this->uri->segment(4);
		$sql = $this->db->query("SELECT * from distinguish_master where id= '" . $id . "'")->row_array();
		$sql['status'];
		$arrayName = array();
		$arrayName['status'] = ($sql['status'] == 1) ? '2' : '1';
		$this->db->where('id', $id);
		$this->db->update('distinguish_master', $arrayName);
		echo $arrayName['status'];
	}

	public function filterList()
	{
		$data['index'] = 'filter';
		$data['index2'] = 'filter2';
		$data['title'] = 'Manage Filter';
		$data['getData'] = $this->user_model->filterList();
		// print_r($data['getData']); exit;

		$this->load->view('include/header', $data);
		$this->load->view('Filter/filterList');
		$this->load->view('include/footer');
	}

	public function filter()
	{
		$data['index'] = 'filter';
		$data['index2'] = 'Addfilter';
		$data['title'] = 'Manage Filter';
		$data['SubCat'] = $this->user_model->getSubCat();
		$data['unit'] = $this->user_model->getunit();
		$data['Dist'] = $this->user_model->getDist();


		$this->load->view('include/header', $data);
		$this->load->view('Filter/Add_Filter');
		$this->load->view('include/footer');
	}

	public function AddFilterData()
	{
		$data = $this->input->post();
		$row = $this->user_model->AddFilterData($data);
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', ' Filter has been add Successfully.'));
			redirect('admin/Dashboard/filterList/');
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
			redirect('admin/Dashboard/filterList/');
		}
	}

	public function filterStatus()
	{
		$id = $this->uri->segment(4);

		$sql = $this->db->query("SELECT * from filter_master where id= '" . $id . "'")->row_array();
		$sql['status'];
		$arrayName = array();
		$arrayName['status'] = ($sql['status'] == 1) ? '2' : '1';
		$this->db->where('id', $id);
		$this->db->update('filter_master', $arrayName);
		/*echo $this->db->last_query();*/
		echo $arrayName['status'];
	}

	public function UpdatedFilter()
	{

		$id = $this->uri->segment(4);
		$data['index'] = 'filter';
		$data['index2'] = 'Updfilter';
		$data['title'] = 'Update Distinguish';
		$data['getData'] = $this->user_model->getSingleFilterData($id);
		$data['SubCat'] = $this->user_model->getSubCat();
		$data['unit'] = $this->user_model->getunit();
		$data['Dist'] = $this->user_model->getDist();
		//print_r($data['getData']); exit;


		// print_r($data['getData']);exit;
		$this->load->view('include/header', $data);
		$this->load->view('Filter/update_filter');
		$this->load->view('include/footer');
	}

	public function UpdateFilterData()
	{
		$data = $this->input->post();

		$data['id'] = $this->uri->segment(4);
		//echo $data['id']; exit;
		$row = $this->user_model->UpdateFilterData($data);
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', ' Filter has been Updated Successfully.'));
			redirect('admin/Dashboard/filterList/');
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
			redirect('admin/Dashboard/filterList/');
		}
	}

	public function GetAdminProfile($id = '')
	{

		$data['index'] = 'index';
		$data['index2'] = '';
		$data['title'] = 'Update Profile';
		$data['getData'] = $this->user_model->GetAdminData($id);
		$this->load->view('include/header', $data);
		$this->load->view('admin/editedProfile');
		$this->load->view('include/footer');

	}

	public function UpdateAdminProfile($id = '')
	{
		$data = $this->input->post();
		/*$data['id'] = $this->uri->segment(4);*/
		$fileName = $_FILES["uploadFile"]["name"];
		$extension = explode('.', $fileName);
		$extension = strtolower(end($extension));
		$uniqueName = 'User_' . uniqid() . '.' . $extension;
		$type = $_FILES["uploadFile"]["type"];
		$size = $_FILES["uploadFile"]["size"];
		$tmp_name = $_FILES['uploadFile']['tmp_name'];
		$targetlocation = PROFILE_DIRECTORY . $uniqueName;

		if (!empty($fileName))
		{
			move_uploaded_file($tmp_name, $targetlocation);
			$data['profile_pic'] = utf8_encode(trim($uniqueName));
		}

		$data['id'] = $id;
		$check = $this->db->get_where('admin_master', array('email' => $data['email']))->num_rows();
		$checkk = $this->db->get_where('admin_master', array('id' => $id))->row_array();

		if ($check == '0')
		{
			$row = $this->user_model->UpdateAdminData($data);
			if ($row > 0)
			{
				$this->session->set_flashdata('activate', getCustomAlert('S', 'Profile Updated Successfully.'));
				redirect('admin/Dashboard/GetAdminProfile/' . $data['id']);
			}
		} else if ($checkk['email'] == $data['email'])
		{
			$row = $this->user_model->UpdateAdminData($data);
			if ($row > 0)
			{
				$this->session->set_flashdata('activate', getCustomAlert('S', 'Profile Updated Successfully.'));
				redirect('admin/Dashboard/GetAdminProfile/' . $data['id']);
			}

		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('D', '!Opps Email Id Already Exists.Please try again.'));
			redirect('admin/Dashboard/GetAdminProfile/' . $data['id']);

		}

	}

	public function OfferList()
	{
		$data['index'] = 'offer';
		$data['index2'] = '';
		$data['title'] = 'Manage Offer';
		$data['getData'] = $this->user_model->GetOffer();
		/*echo "<pre>";
		print_r($data['getData']); exit;*/
		$this->load->view('include/header', $data);
		$this->load->view('Offer/Offers');
		$this->load->view('include/footer');
	}


	public function AddNewOffers()
	{
		$data['index'] = 'offer';
		$data['index2'] = '';
		$data['title'] = 'Manage Offer';
		$data['getCatgy'] = $this->user_model->getALLcatgy();
		/*echo "<pre>";
		print_r($data['getData']); exit;*/
		$this->load->view('include/header', $data);
		$this->load->view('Offer/AddOffer');
		$this->load->view('include/footer');
	}

	public function getsubCatgy($id = '')
	{
		$Data = $this->db->get_where('sub_category_master', array('category_master_id' => $id))->result_array();
		$html = '';
		$html .= '<option value ="">Select Sub Category</option>';
		foreach ($Data as $value)
		{

			$html .= '<option value ="' . $value['id'] . '"  >' . $value['sub_category_name'] . '</option>';
		}
		echo $html;
	}
	public function getsubCatgy2($id = '', $subId = '')
	{
		$Data = $this->db->get_where('sub_category_master', array('category_master_id' => $id))->result_array();
		$html = '';
		$html .= '<option value ="">Select Sub Category</option>';
		foreach ($Data as $value)
		{
			if ($subId == $value['id'])
			{
				$html .= '<option value ="' . $value['id'] . '" Selected >' . $value['sub_category_name'] . '</option>';
			} else
			{
				$html .= '<option value ="' . $value['id'] . '" >' . $value['sub_category_name'] . '</option>';
			}
		}
		echo $html;
	}

	public function AddOfferData()
	{
		$data = $this->input->post();

		$SubCat = $data['SubCat'];
		$SubCatid = json_encode([$SubCat]);
		$check = $this->db->get_where('offer_master', array('sub_category_ids' => $SubCatid))->num_rows();
		if ($check == '0')
		{
			$row = $this->user_model->AddOfferData($data);
			if ($row > 0)
			{
				$this->session->set_flashdata('activate', getCustomAlert('S', ' Offers has been add Successfully.'));
				redirect('admin/Dashboard/OfferList/');
			}
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('W', ' Offers Already Added this Category.'));
			redirect('admin/Dashboard/OfferList/');

		}
	}

	public function UpdateOffer($id = '')
	{
		$data['index'] = 'UpdtOffer';
		$data['index2'] = '';
		$data['title'] = 'Update Offer';
		$data['getData'] = $this->user_model->GetOfferData($id);
		$data['getCatgy'] = $this->user_model->getALLcatgy();
		/*echo $data['getData']['sub_category_ids']; exit;*/
		$show = json_decode($data['getData']['sub_category_ids']);
		/*foreach ($show as $value) {
		$val = $value[0];
		} */
		// echo $show[0]; exit;
		$data['getCatgy2'] = $this->user_model->getCategoryOffer($show[0]);
		// echo $data['getCatgy2']; exit;
		$this->load->view('include/header', $data);
		$this->load->view('Offer/UpdateOffer');
		$this->load->view('include/footer');
	}
	public function UpdateOfferData($id = '')
	{
		$data = $this->input->post();
		$data['id'] = $id;
		$SubCat = $data['SubCat'];
		$SubCatid = json_encode([$SubCat]);
		$checked = $this->db->get_where('offer_master', array('id' => $id))->row_array();

		if ($SubCatid == $checked['sub_category_ids'])
		{
			$row = $this->user_model->UpdateOfferData($data);
			if ($row > 0)
			{
				$this->session->set_flashdata('activate', getCustomAlert('S', ' Offers has been Updated Successfully.'));
				redirect('admin/Dashboard/OfferList/');
			}
		} else
		{
			$check = $this->db->get_where('offer_master', array('sub_category_ids' => $SubCatid))->num_rows();
			if ($check == '0')
			{
				$row = $this->user_model->UpdateOfferData($data);
				if ($row > 0)
				{
					$this->session->set_flashdata('activate', getCustomAlert('S', ' Offers has been add Successfully.'));
					redirect('admin/Dashboard/OfferList/');
				}
			} else
			{
				$this->session->set_flashdata('activate', getCustomAlert('W', ' Offers Already Added this Category.'));
				redirect('admin/Dashboard/OfferList/');

			}

		}
	}



	public function BannerList()
	{
		$data['index'] = 'Banner';
		$data['index2'] = '';
		$data['title'] = 'Manage Banners';
		$data['getData'] = $this->user_model->GetBanners();

		$this->load->view('include/header', $data);
		$this->load->view('Banners/BannerList');
		$this->load->view('include/footer');
	}

	public function AddBanner()
	{
		$data['index'] = 'AddBanner';
		$data['index2'] = '';
		$data['title'] = 'Manage Banner';

		$this->load->view('include/header', $data);
		$this->load->view('Banners/AddBanner');
		$this->load->view('include/footer');
	}

	public function Get_SubCat_Product_list($type = '')
	{
		if ($type == 1)
		{
			$Data = $this->db->get_where('sub_category_master')->result_array();
			$html = '';
			$html .= '<option value ="">Select Sub Category/Product</option>';
			foreach ($Data as $value)
			{

				$html .= '<option value ="' . $value['id'] . '">' . $value['sub_category_name'] . '</option>';
			}
			echo $html;
		} else
		{
			$Data = $this->db->query("select * from product_master where reference = '0'")->result_array();
			$html = '';
			$html .= '<option value ="">Select Sub Category/Product</option>';
			foreach ($Data as $value)
			{

				$html .= '<option value ="' . $value['id'] . '">' . $value['product_name'] . '</option>';
			}
			echo $html;
		}
	}


	public function AddBannerData($value = '')
	{
		$data = $this->input->post();
		$fileName = $_FILES["uploadBanner"]["name"];
		$extension = explode('.', $fileName);
		$extension = strtolower(end($extension));
		$uniqueName = 'Banner_' . uniqid() . '.' . $extension;
		$type = $_FILES["uploadBanner"]["type"];
		$size = $_FILES["uploadBanner"]["size"];
		$tmp_name = $_FILES['uploadBanner']['tmp_name'];
		$targetlocation = BANNER_DIRECTORY . $uniqueName;


		if (!empty($fileName))
		{
			move_uploaded_file($tmp_name, $targetlocation);
			$data['banner_image'] = utf8_encode(trim($uniqueName));
		}
		$row = $this->user_model->AddBannerData($data);
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', ' Banner has been add Successfully.'));
			redirect('admin/Dashboard/AddBanner/');
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('w', '!Opps Something is worng.Please try again.'));
			redirect('admin/Dashboard/AddBanner/');
		}
	}

	public function UpdateBannerData($id = '')
	{
		$data['index'] = 'UpdtBanner';
		$data['index2'] = '';
		$data['title'] = 'Update Banner';
		$data['getData'] = $this->user_model->GetBannerData($id);
		/*print_r($data['getData']); exit;*/
		$this->load->view('include/header', $data);
		$this->load->view('Banners/UpdateBanner');
		$this->load->view('include/footer');
	}

	public function Get_SubCat_Product_list2($type = '', $id = "")
	{

		if ($type == 1)
		{

			$Data = $this->db->get_where('sub_category_master')->result_array();
			$html = '';

			foreach ($Data as $value)
			{


				if ($value['id'] == $id)
				{
					$html .= '<option value ="' . $value['id'] . '"  selected="Selected" >' . $value['sub_category_name'] . '</option>';
				} else
				{

					$html .= '<option value ="' . $value['id'] . '"   >' . $value['sub_category_name'] . '</option>';
				}

			}
			echo $html;
		} else
		{

			$Data = $this->db->get_where('product_master')->result_array();
			$html = '';

			foreach ($Data as $value)
			{
				if ($value['id'] == $id)
				{

					$html .= '<option value ="' . $value['id'] . '"  selected="Selected" >' . $value['product_name'] . '</option>';
				} else
				{

					$html .= '<option value ="' . $value['id'] . '"   >' . $value['product_name'] . '</option>';
				}
			}
			echo $html;
		}
	}

	public function UpdateBannerDataPost($id = '')
	{
		$data = $this->input->post();
		$fileName = $_FILES["uploadBanner"]["name"];
		$extension = explode('.', $fileName);
		$extension = strtolower(end($extension));
		$uniqueName = 'Banner_' . uniqid() . '.' . $extension;
		$type = $_FILES["uploadBanner"]["type"];
		$size = $_FILES["uploadBanner"]["size"];
		$tmp_name = $_FILES['uploadBanner']['tmp_name'];
		$targetlocation = BANNER_DIRECTORY . $uniqueName;

		if (!empty($fileName))
		{
			move_uploaded_file($tmp_name, $targetlocation);
			$data['banner_image'] = utf8_encode(trim($uniqueName));
		}
		$data['id'] = $id;
		$row = $this->user_model->UpdateBannerDataPost($data);
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', ' Banner has been Updated Successfully.'));
			redirect('admin/Dashboard/BannerList/');
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('w', '!Opps Something is worng.Please try again.'));
			redirect('admin/Dashboard/BannerList/');
		}
	}

	public function BannerStatus()
	{
		$id = $this->uri->segment(4);
		$sql = $this->db->query("SELECT * from banner_master where id= '" . $id . "'")->row_array();
		$sql['status'];
		$arrayName = array();
		$arrayName['status'] = ($sql['status'] == 1) ? '2' : '1';
		$this->db->where('id', $id);
		$this->db->update('banner_master', $arrayName);
		echo $arrayName['status'];

	}

	public function SortList()
	{
		$data['index'] = 'Sort';
		$data['index2'] = 'Sort2';
		$data['title'] = 'Manage Sort';
		$data['getData'] = $this->user_model->GetSort();

		$this->load->view('include/header', $data);
		$this->load->view('Sort/Sort');
		$this->load->view('include/footer');
	}


	public function UpdateSettingBanner()
	{
		$data = $this->input->post();
		$fileName = $_FILES["uploadBanner"]["name"];
		$extension = explode('.', $fileName);
		$extension = strtolower(end($extension));
		$uniqueName = 'Banner_' . uniqid() . '.' . $extension;
		$type = $_FILES["uploadBanner"]["type"];
		$size = $_FILES["uploadBanner"]["size"];
		$tmp_name = $_FILES['uploadBanner']['tmp_name'];
		$targetlocation = BANNER_DIRECTORY . $uniqueName;
		if (!empty($fileName))
		{
			move_uploaded_file($tmp_name, $targetlocation);
			$data['banner_image'] = utf8_encode(trim($uniqueName));
		}

		$row = $this->user_model->UpdateSettingBannerDataPost($data);
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', ' New Banner has been Added Successfully.'));
			redirect('admin/Dashboard/Settings/');
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('w', '!Opps Something is worng.Please try again.'));
			redirect('admin/Dashboard/Settings/');
		}
	}




	public function addSort()
	{

		$data['index'] = 'Sort';
		$data['index2'] = 'AddSort';
		$data['title'] = 'Add Sort';

		$this->load->view('include/header', $data);
		$this->load->view('Sort/AddSort');
		$this->load->view('include/footer');
	}


	public function addSortData()
	{
		$data = $this->input->post();
		$row = $this->user_model->AddSortData($data);
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', 'Unit has been add Successfully.'));
			redirect('admin/Dashboard/SortList/');
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
			redirect('admin/Dashboard/SortList/');
		}
	}

	public function UpdateSort()
	{

		$id = $this->uri->segment(4);
		$data['index'] = 'Sort';
		$data['index2'] = 'UpdSort';
		$data['title'] = 'Update Sort';
		$data['getData'] = $this->user_model->getSort_Data($id);
		// print_r($data['getData']);exit;
		$this->load->view('include/header', $data);
		$this->load->view('Sort/UpdateSort');
		$this->load->view('include/footer');
	}

	public function UpdateSortData()
	{
		$data = $this->input->post();
		$data['id'] = $this->uri->segment(4);
		$row = $this->user_model->updateSortData($data);
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', 'Sort has been Updated Successfully.'));
			redirect('admin/Dashboard/SortList/');
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
			redirect('admin/Dashboard/SortList/');
		}

	}
	public function SortStatus()
	{
		$id = $this->uri->segment(4);
		$sql = $this->db->query("SELECT * from sort_master where id= '" . $id . "'")->row_array();
		$sql['status'];
		$arrayName = array();
		$arrayName['status'] = ($sql['status'] == 1) ? '2' : '1';
		$this->db->where('id', $id);
		$this->db->update('sort_master', $arrayName);
		echo $arrayName['status'];
	}

	public function CouponList()
	{
		$data['index'] = 'Coupon';
		$data['index2'] = '';
		$data['title'] = 'Manage Coupon';
		$data['getData'] = $this->user_model->GetCoupan();

		$this->load->view('include/header', $data);
		$this->load->view('Coupon/CouponList');
		$this->load->view('include/footer');
	}
	public function AddCoupon()
	{
		$data['shops'] = $this->user_model->getShops();
		$data['parent_categories'] = $this->user_model->getParentCategories();
		$data['categories'] = $this->user_model->getCategories();
		$data['subcategories'] = $this->user_model->getSubCategory();
		$data['products'] = $this->user_model->getProducts();
		$data['auto_coupon_code'] = 'CUP' . rand(1000, 9999);
		$data['index'] = 'AddCoupon';
		$data['index2'] = '';
		$data['title'] = 'Manage Coupon';

		$this->load->view('include/header', $data);
		$this->load->view('Coupon/AddCoupon', $data);
		$this->load->view('include/footer');
	}


	// Handle form submission
	public function AddCouponData()
	{
		$post = $this->input->post();
		$row = $this->user_model->AddCouponData($post); // <-- lowercase 'user_model'

		if ($row > 0)
		{
			$this->session->set_flashdata('success', 'Coupon added successfully.');
		} else
		{
			$this->session->set_flashdata('error', 'Something went wrong. Try again.');
		}

		redirect('admin/Dashboard/CouponList/');
	}



	// public function AddCouponData()
	// {
	// 	$data = $this->input->post();
	// 	$row = $this->user_model->AddCouponData($data);
	// 	if ($row > 0)
	// 	{
	// 		$this->session->set_flashdata('activate', getCustomAlert('S', 'Coupon has been add Successfully.'));
	// 		redirect('admin/Dashboard/CouponList/');
	// 	} else
	// 	{
	// 		$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
	// 		redirect('admin/Dashboard/CouponList/');
	// 	}
	// }

	public function UpdateCoupon($id = '')
	{
		$data['index'] = 'UpdtCoupon';
		$data['index2'] = '';
		$data['title'] = 'Manage Coupon';
		$data['getData'] = $this->user_model->getCoupon_Data($id);

		$data['shops'] = $this->user_model->getShops();
		$data['parent_categories'] = $this->user_model->getParentCategories();
		$data['categories'] = $this->user_model->getCategories();
		$data['subcategories'] = $this->user_model->getSubCategory();
		$data['products'] = $this->user_model->getProducts();

		$this->load->view('include/header', $data);
		$this->load->view('Coupon/UpdateCoupan', $data);
		$this->load->view('include/footer');
	}


	public function UpdateCouponData()
	{
		$data = $this->input->post();
		$data['id'] = $this->uri->segment(4);
		$row = $this->user_model->UpdateCouponData($data);
		if ($row > 0)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', 'Coupon has been Updated Successfully.'));
			redirect('admin/Dashboard/CouponList/');
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', '!Opps Something is worng.Please try again.'));
			redirect('admin/Dashboard/CouponList/');
		}

	}



	public function CouponStatus()
	{
		$id = $this->uri->segment(4);
		$sql = $this->db->query("SELECT * from coupon_manager_master where id= '" . $id . "'")->row_array();
		$sql['status'];
		$arrayName = array();
		$arrayName['status'] = ($sql['status'] == 1) ? '0' : '1';
		$this->db->where('id', $id);
		$this->db->update('coupon_manager_master', $arrayName);
		echo $arrayName['status'];
	}


	public function Settings()
	{
		$data['index'] = 'Setting';
		$data['index2'] = '';
		$data['title'] = 'Manage Setting';

		$this->form_validation->set_rules('app_verison', 'App Verison', 'required');
		$this->form_validation->set_rules('type', 'Application Type', 'required');
		$this->form_validation->set_rules('min_order_bal', 'Min Order', 'required');

		$this->form_validation->set_rules('email_id', 'Email ID', 'required');
		$this->form_validation->set_rules('contact_no', 'Contact Number', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');

		//    $this->form_validation->set_rules('referel_to_pay', 'Referel Amount 1', 'required');
		//    $this->form_validation->set_rules('referel_to_get', 'Referel Amount 2', 'required');
		// 	  $this->form_validation->set_rules('shipping_amount', 'Shipping Amount', 'required');
		//    $this->form_validation->set_rules('min_first_purchase_amt', 'Min First Purchase Amount', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$data['getData'] = $this->db->get_where('settings', array('id' => '1'))->row_array();
			$this->load->view('include/header', $data);
			$this->load->view('admin/Setting');
			$this->load->view('include/footer');
		} else
		{

			$data2 = $this->input->post();
			$data2['modify_date'] = time();

			$data2 = array(
				'app_verison' => trim($data2['app_verison']),
				'type' => trim($data2['type']),
				'min_order_bal' => trim($data2['min_order_bal']),
				'shipping_amount' => trim($data2['shipping_amount']),

				'email' => trim($data2['email_id']),
				'contact_no' => trim($data2['contact_no']),
				'facebook' => trim($data2['facebook']),
				'twitter' => trim($data2['twitter']),
				'whats_app' => trim($data2['whats_app']),
				'instagram' => trim($data2['instagram']),
				'messenger' => trim($data2['messenger']),
				'gmail' => trim($data2['gmail_link']),
				'app_url' => trim($data2['app_link']),
				'apple_link' => trim($data2['apple_link']),
				'address' => trim(ucfirst($data2['address']))
			);

			$banner_img = $_FILES['logo']['name'];
			if (!empty($banner_img))
			{
				$logo_info = getimagesize($_FILES["logo"]["tmp_name"]);
				//print_r($logo_info); die();

				if ($logo_info[0] > 507 && $logo_info[1] > 505)
				{
					$this->session->set_flashdata('bnn_err', 'Logo size should be less than: 507 X 505 px.');
					$data['getData'] = $this->db->get_where('settings', array('id' => '1'))->row_array();
					$this->load->view('include/header', $data);
					$this->load->view('admin/Setting');
					$this->load->view('include/footer');
					return 1;
				} else
				{
					$logoimg = $this->upoad_files('logo');
					$data2['logo'] = $logoimg['file_names'];
					if (!empty($check_details['logo']))
					{
						unlink(LOGO_DIRECTORY . '/' . $check_details['logo']);
					}

				}
			}

			$check_details = $this->db->get_where('settings', array('id' => '1'))->row_array();
			$banner_img = $_FILES['fevicon']['name'];
			if (!empty($banner_img))
			{
				$logoimg = $this->upoad_files('fevicon');
				$data2['fevicon_icon'] = $logoimg['file_names'];
				if (!empty($check_details['logo']))
				{
					unlink(LOGO_DIRECTORY . '/' . $check_details['fevicon_icon']);
				}
			}


			$Setting = $this->user_model->Setting($data2);
			if ($Setting > 0)
			{
				$this->session->set_flashdata('activate', getCustomAlert('S', 'Setting has been updated Successfully.'));
				redirect('admin/Dashboard/Settings');
			} else
			{
				$this->session->set_flashdata('activate', getCustomAlert('W', 'Oops! somthing is worng please try again.'));
				redirect('admin/Dashboard/Settings');
			}
		}
	}


	/* code added by Sitaram Shreevastsava */
	public function developer_link()
	{
		$table = 'developer_link';
		if ($this->input->post())
		{
			$setdata['gst_allow'] = $this->input->post('gst_allow');
			$setdata['login_type'] = $this->input->post('login');
			$setdata['media_login'] = $this->input->post('media_login');
			$setdata['website_name'] = trim($this->input->post('website_name'));
			$setdata['copyright'] = trim($this->input->post('copyright'));

			$logo = $this->upoad_files('logo');
			if (!empty($logo))
			{
				$logo = $logo['file_names'];
			} else
			{
				$logo = $this->input->post('old_logo');
			}
			$setdata['logo'] = $logo;

			$favicon = $this->upoad_files('favicon');
			if (!empty($favicon))
			{
				$favicon = $favicon['file_names'];
			} else
			{
				$favicon = $this->input->post('old_favicon');
			}
			$setdata['favicon'] = $favicon;

			$this->db->where(array('id' => '1'))->update($table, $setdata);
			redirect('admin/Dashboard/developer_link');
		}
		$data['dev_links'] = $this->db->get_where($table, array('id' => 1))->row_array();

		$data['index'] = 'developer';
		$data['index2'] = '';
		$data['title'] = 'Manage Developer Links';

		$this->load->view('include/header', $data);
		$this->load->view('admin/developer_link');
		$this->load->view('include/footer');
	}

	/* upload files */
	public function upoad_files($file_n, $path = '')
	{
		$fileName = $_FILES[$file_n]["name"];
		$data = array();
		if (!empty($fileName))
		{

			$extension = explode('.', $fileName);
			$extension = strtolower(end($extension));
			$uniqueName = $file_n . uniqid() . '.' . $extension;
			$type = $_FILES[$file_n]["type"];
			$size = $_FILES[$file_n]["size"];
			$tmp_name = $_FILES[$file_n]['tmp_name'];
			if ($path == 'ABOUT_DIRECTORY')
			{
				$targetlocation = ABOUT_DIRECTORY . $uniqueName;
			} else
			{
				$targetlocation = LOGO_DIRECTORY . $uniqueName;
			}

			if (!empty($fileName))
			{
				move_uploaded_file($tmp_name, $targetlocation);
				$data['file_names'] = utf8_encode(trim($uniqueName));
			}
		}
		return $data;
	}


	/* HERE MANAGEMENT ABOUT US */
	public function ManageAbout()
	{
		$data['index'] = 'ManageAbout';
		$data['index2'] = 'ManageAbout';
		$data['title'] = 'Manage About Us';
		$data['page'] = 'manage_about/manageabout';

		$data['details'] = $this->user_model->getData('about_master', array('id' => 1), '1');

		if ($this->input->post())
		{
			$in_data = $this->input->post();
			$this->form_validation->set_rules('ab_title', 'Title', 'trim|required');
			$this->form_validation->set_rules('description', 'Description', 'required');

			if ($this->form_validation->run() == false)
			{
				$this->load->view('include/page', $data);
			} else
			{
				$save_arr = array(
					'title' => trim(ucfirst($in_data['ab_title'])),
					'sub_title' => trim(ucfirst($in_data['sb_title'])),
					'description' => trim(ucfirst($in_data['description'])),
					'status' => 1,
					'modify_date' => time()

				);

				$check_details = $this->user_model->getData('about_master', array('id' => 1), '1');

				$banner_img = $_FILES['userfile']['name'];
				if (!empty($banner_img))
				{
					$path = 'ABOUT_DIRECTORY';
					$bann_img = $this->upoad_files('userfile', $path);
					$save_arr['profile'] = $bann_img['file_names'];
					unlink('assets/profile_image/' . @$check_details['profile']);
				}

				if (!empty($check_details))
				{
					$save = $this->user_model->updateData('about_master', array('id' => @$check_details['id']), $save_arr);
				} else
				{
					$save_arr['add_date'] = time();
					$save = $this->user_model->DataSave('about_master', $save_arr);
				}

				if ($save > 0)
				{
					$this->session->set_flashdata('msg', AlertMSG('S', 'Data have been successfully updated.'));
					redirect('admin/Dashboard/ManageAbout');
				} else
				{
					$this->session->set_flashdata('msg', AlertMSG('W', 'Oops! Something wrong.'));
					$this->load->view('include/page', $data);
				}

			}

		} else
		{
			$this->load->view('include/page', $data);
		}
	}

	public function WhatWe()
	{
		$data['index'] = 'WhatWe';
		$data['index2'] = 'WhatWe';
		$data['title'] = 'What We Provide?';
		$data['page'] = 'manage_about/whatwe_provide';
		$data['details'] = $this->user_model->getData('whatwe_provide', array('id' => 1), '1');

		if ($this->input->post())
		{
			$in_data = $this->input->post();
			$this->form_validation->set_rules('title1', 'Title1 ', 'trim|required');
			$this->form_validation->set_rules('description1', 'Description', 'required');

			if ($this->form_validation->run() == false)
			{
				$this->load->view('include/page', $data);
			} else
			{
				$save_arr = array(
					'title1' => trim(ucfirst($in_data['title1'])),
					'description1' => trim(ucfirst($in_data['description1'])),
					'title2' => trim(ucfirst($in_data['title2'])),
					'description2' => trim(ucfirst($in_data['description2'])),
					'title3' => trim(ucfirst($in_data['title3'])),
					'description3' => trim(ucfirst($in_data['description3'])),
					'title4' => trim(ucfirst($in_data['title4'])),
					'description4' => trim(ucfirst($in_data['description4'])),
					'title5' => trim(ucfirst($in_data['title5'])),
					'description5' => trim(ucfirst($in_data['description5'])),
					'title6' => trim(ucfirst($in_data['title6'])),
					'description6' => trim(ucfirst($in_data['description6'])),
					'status' => 1,
					'modify_date' => time()

				);

				$check_details = $this->user_model->getData('whatwe_provide', array('id' => 1), '1');

				$seva_msg = '';
				if (!empty($check_details))
				{
					$save = $this->user_model->updateData('whatwe_provide', array('id' => @$check_details['id']), $save_arr);
					$seva_msg = 'updated';
				} else
				{
					$save_arr['add_date'] = time();
					$save = $this->user_model->DataSave('whatwe_provide', $save_arr);
					$seva_msg = 'saved';
				}

				if ($save > 0)
				{
					$this->session->set_flashdata('msg', AlertMSG('S', 'Data have been successfully ' . $seva_msg . '.'));
					redirect('admin/Dashboard/WhatWe');
				} else
				{
					$this->session->set_flashdata('msg', AlertMSG('W', 'Oops! Something wrong.'));
					$this->load->view('include/page', $data);
				}
			}
		} else
		{
			$this->load->view('include/page', $data);
		}
	}


	public function ManageTeam()
	{
		$data['index'] = 'ManageTeam';
		$data['index2'] = 'ManageTeam';
		$data['title'] = 'Manage Team';
		$data['page'] = 'team/list';
		$data['list'] = $this->user_model->getData('team_master', array(), '');
		// echo '<pre>';
		// print_r($data['list'] ); die();
		$this->load->view('include/page', $data);

	}


	public function AddTeam()
	{
		$data['index'] = 'ManageTeam';
		$data['index2'] = 'ManageTeam';
		$data['title'] = 'Add Team';
		$data['page'] = 'team/add';

		if ($this->input->post())
		{
			$in_data = $this->input->post();
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('post_name', 'Post', 'required');

			if ($this->form_validation->run() == false)
			{
				$this->load->view('include/page', $data);
			} else
			{
				$save_arr = array(
					'name' => trim(ucfirst($in_data['name'])),
					'post' => trim(ucfirst($in_data['post_name'])),
					'description' => '',//trim(ucfirst($in_data['description'])),
					'status' => 1,
					'modify_date' => time()

				);

				$banner_img = $_FILES['userfile']['name'];
				if (!empty($banner_img))
				{
					$path = 'ABOUT_DIRECTORY';
					$bann_img = $this->upoad_files('userfile', $path);
					$save_arr['profile'] = $bann_img['file_names'];
				}

				$save_arr['add_date'] = time();
				$save = $this->user_model->DataSave('team_master', $save_arr);

				if ($save > 0)
				{
					$this->session->set_flashdata('msg', AlertMSG('S', 'Data have been successfully saved.'));
					redirect('admin/Dashboard/ManageTeam');
				} else
				{
					$this->session->set_flashdata('msg', AlertMSG('W', 'Oops! Something wrong.'));
					$this->load->view('include/page', $data);
				}

			}

		} else
		{
			$this->load->view('include/page', $data);
		}
	}


	public function EditTeam($id)
	{
		$data['index'] = 'ManageTeam';
		$data['index2'] = 'ManageTeam';
		$data['title'] = 'Edit Team';
		$data['page'] = 'team/add';
		$id = base64_decode($id);
		$data['details'] = $this->user_model->getData('team_master', array('id' => $id), '1');

		if ($this->input->post())
		{
			$in_data = $this->input->post();
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('post_name', 'Post', 'required');

			if ($this->form_validation->run() == false)
			{
				$this->load->view('include/page', $data);
			} else
			{
				$save_arr = array(
					'name' => trim(ucfirst($in_data['name'])),
					'post' => trim(ucfirst($in_data['post_name'])),
					'description' => '',//trim(ucfirst($in_data['description'])),
					'status' => $in_data['status'],
					'modify_date' => time()

				);

				$banner_img = $_FILES['userfile']['name'];
				if (!empty($banner_img))
				{
					$path = 'ABOUT_DIRECTORY';
					$bann_img = $this->upoad_files('userfile', $path);
					$save_arr['profile'] = $bann_img['file_names'];
					unlink('assets/profile_image/' . $data['profile']);
				}

				$save_arr['add_date'] = time();
				$save = $this->user_model->updateData('team_master', array('id' => @$id), $save_arr);
				if ($save > 0)
				{
					$this->session->set_flashdata('msg', AlertMSG('S', 'Data have been successfully updated.'));
					redirect('admin/Dashboard/ManageTeam');
				} else
				{
					$this->session->set_flashdata('msg', AlertMSG('W', 'Oops! Something wrong.'));
					$this->load->view('include/page', $data);
				}
			}
		} else
		{
			$this->load->view('include/page', $data);
		}
	}

	//promotional
	public function PromotionTxt()
	{
		$data['index'] = 'PromotionTxt';
		$data['index2'] = 'PromotionTxt';
		$data['title'] = 'Manage Promotion Text';
		$data['page'] = 'manage_about/promotional';
		$data['details'] = $this->user_model->getData('promotional_text', array('id' => 1), '1');

		if ($this->input->post())
		{
			$in_data = $this->input->post();
			$this->form_validation->set_rules('title1', 'Title1 ', 'trim|required');
			$this->form_validation->set_rules('description1', 'Description', 'required');
			$this->form_validation->set_rules('title2', 'Title2 ', 'trim|required');
			$this->form_validation->set_rules('description2', 'Description', 'required');
			$this->form_validation->set_rules('title3', 'Title3 ', 'trim|required');
			$this->form_validation->set_rules('description3', 'Description', 'required');

			if ($this->form_validation->run() == false)
			{
				$this->load->view('include/page', $data);
			} else
			{
				$save_arr = array(
					'title1' => trim(ucfirst($in_data['title1'])),
					'description1' => trim(ucfirst($in_data['description1'])),
					'title2' => trim(ucfirst($in_data['title2'])),
					'description2' => trim(ucfirst($in_data['description2'])),
					'title3' => trim(ucfirst($in_data['title3'])),
					'description3' => trim(ucfirst($in_data['description3'])),
					'status' => 1,
					'modify_date' => time()

				);

				$check_details = $this->user_model->getData('promotional_text', array('id' => 1), '1');

				$seva_msg = '';
				if (!empty($check_details))
				{
					$save = $this->user_model->updateData('promotional_text', array('id' => @$check_details['id']), $save_arr);
					$seva_msg = 'updated';
				} else
				{
					$save_arr['add_date'] = time();
					$save = $this->user_model->DataSave('promotional_text', $save_arr);
					$seva_msg = 'saved';
				}

				if ($save > 0)
				{
					$this->session->set_flashdata('msg', AlertMSG('S', 'Data have been successfully ' . $seva_msg . '.'));
					redirect('admin/Dashboard/PromotionTxt');
				} else
				{
					$this->session->set_flashdata('msg', AlertMSG('W', 'Oops! Something wrong.'));
					$this->load->view('include/page', $data);
				}
			}
		} else
		{
			$this->load->view('include/page', $data);
		}
	}


	public function ManageFaQ()
	{
		$data['index'] = 'ManageFaQ';
		$data['index2'] = 'ManageFaQ';
		$data['title'] = 'Manage FAQ';
		$data['page'] = 'faq/list';
		$data['list'] = $this->user_model->getData('faq_master', array(), '');
		// echo '<pre>';
		// print_r($data['list'] ); die();
		$this->load->view('include/page', $data);

	}

	public function AddFAQ()
	{
		$data['index'] = 'ManageFaQ';
		$data['index2'] = 'ManageFaQ';
		$data['title'] = 'Add FAQ';
		$data['page'] = 'faq/add';
		$data['list'] = $this->user_model->getData('faq_master', array(), '');
		// echo '<pre>';
		// print_r($data['list'] ); die();
		if ($this->input->post())
		{
			$in_data = $this->input->post();
			$this->form_validation->set_rules('a_title', 'Title', 'trim|required');
			$this->form_validation->set_rules('description', 'Description', 'required');

			if ($this->form_validation->run() == false)
			{
				$this->load->view('include/page', $data);
			} else
			{
				$save_arr = array(
					'title' => trim(ucfirst($in_data['a_title'])),
					'description' => trim(ucfirst($in_data['description'])),
					'status' => 1,
					'modify_date' => time()

				);

				$save_arr['add_date'] = time();
				$save = $this->user_model->DataSave('faq_master', $save_arr);

				if ($save > 0)
				{
					$this->session->set_flashdata('msg', AlertMSG('S', 'Data have been successfully saved.'));
					redirect('admin/Dashboard/ManageFaQ');
				} else
				{
					$this->session->set_flashdata('msg', AlertMSG('W', 'Oops! Something wrong.'));
					$this->load->view('include/page', $data);
				}
			}
		} else
		{
			$this->load->view('include/page', $data);
		}
	}


	public function EditFAQ($id)
	{
		$data['index'] = 'ManageFaQ';
		$data['index2'] = 'ManageFaQ';
		$data['title'] = 'Edit FAQ';
		$data['page'] = 'faq/add';
		$id = base64_decode($id);
		$data['details'] = $this->user_model->getData('faq_master', array('id' => $id), '1');
		// echo '<pre>';
		// print_r($data['details'] ); die();
		if ($this->input->post())
		{
			$in_data = $this->input->post();
			$this->form_validation->set_rules('a_title', 'Title', 'trim|required');
			$this->form_validation->set_rules('description', 'Description', 'required');

			if ($this->form_validation->run() == false)
			{
				$this->load->view('include/page', $data);
			} else
			{
				$save_arr = array(
					'title' => trim(ucfirst($in_data['a_title'])),
					'description' => trim(ucfirst($in_data['description'])),
					'status' => $in_data['status'],
					'modify_date' => time()

				);

				// $save_arr['add_date'] = time();
				// $save =  $this->user_model->DataSave('faq_master',$save_arr);
				$save = $this->user_model->updateData('faq_master', array('id' => @$id), $save_arr);
				if ($save > 0)
				{
					$this->session->set_flashdata('msg', AlertMSG('S', 'Data have been successfully updated.'));
					redirect('admin/Dashboard/ManageFaQ');
				} else
				{
					$this->session->set_flashdata('msg', AlertMSG('W', 'Oops! Something wrong.'));
					$this->load->view('include/page', $data);
				}
			}
		} else
		{
			$this->load->view('include/page', $data);
		}
	}


	public function ContactUs()
	{
		$data['index'] = 'ContactUs';
		$data['index2'] = 'ContactUs';
		$data['title'] = 'Manage Contact Us';
		$data['page'] = 'manage_about/contact';
		$data['list'] = $this->user_model->getData('enquiry_master', array(), '');
		// echo '<pre>';
		// print_r($data['list'] ); die();
		$this->load->view('include/page', $data);
	}


	public function TermCondition()
	{
		$data['index'] = 'TermCondition';
		$data['index2'] = 'TermCondition';
		$data['title'] = 'Manage Term & Condition ';
		$data['page'] = 'manage_about/term_condition';
		$data['details'] = $this->user_model->getData('term_condition', array('type' => 1), '1');
		// echo '<pre>';
		// print_r($data['details'] ); die();
		if ($this->input->post())
		{
			$in_data = $this->input->post();
			$this->form_validation->set_rules('a_title', 'Title', 'trim|required');
			$this->form_validation->set_rules('description', 'Description', 'required');

			if ($this->form_validation->run() == false)
			{
				$this->load->view('include/page', $data);
			} else
			{
				$save_arr = array(
					'title' => trim(ucfirst($in_data['a_title'])),
					'description' => trim(ucfirst($in_data['description'])),
					'type' => 1,
					'status' => 1,
					'modify_date' => time()
				);


				$save_msg = '';
				if (!empty($data['details']))
				{
					$save = $this->user_model->updateData('term_condition', array('id' => @$data['details']['id']), $save_arr);
					$save_msg = 'updated';
				} else
				{
					$save_arr['add_date'] = time();
					$save = $this->user_model->DataSave('term_condition', $save_arr);
					$save_msg = 'saved';
				}

				if ($save > 0)
				{
					$this->session->set_flashdata('msg', AlertMSG('S', 'Data have been successfully ' . $save_msg . '.'));
					redirect('admin/Dashboard/TermCondition');
				} else
				{
					$this->session->set_flashdata('msg', AlertMSG('W', 'Oops! Something wrong.'));
					$this->load->view('include/page', $data);
				}
			}
		} else
		{
			$this->load->view('include/page', $data);
		}
	}


	public function PrivacyPolicy()
	{
		$data['index'] = 'PrivacyPolicy';
		$data['index2'] = 'PrivacyPolicy';
		$data['title'] = 'Manage Privacy Policy ';
		$data['page'] = 'manage_about/term_condition';
		$data['details'] = $this->user_model->getData('term_condition', array('type' => 2), '1');
		// echo '<pre>';
		// print_r($data['details'] ); die();
		if ($this->input->post())
		{
			$in_data = $this->input->post();
			$this->form_validation->set_rules('a_title', 'Title', 'trim|required');
			$this->form_validation->set_rules('description', 'Description', 'required');

			if ($this->form_validation->run() == false)
			{
				$this->load->view('include/page', $data);
			} else
			{
				$save_arr = array(
					'title' => trim(ucfirst($in_data['a_title'])),
					'description' => trim(ucfirst($in_data['description'])),
					'type' => 2,
					'status' => 1,
					'modify_date' => time()
				);


				$save_msg = '';
				if (!empty($data['details']))
				{
					$save = $this->user_model->updateData('term_condition', array('id' => @$data['details']['id']), $save_arr);
					$save_msg = 'updated';
				} else
				{
					$save_arr['add_date'] = time();
					$save = $this->user_model->DataSave('term_condition', $save_arr);
					$save_msg = 'saved';
				}

				if ($save > 0)
				{
					$this->session->set_flashdata('msg', AlertMSG('S', 'Data have been successfully ' . $save_msg . '.'));
					redirect('admin/Dashboard/PrivacyPolicy');
				} else
				{
					$this->session->set_flashdata('msg', AlertMSG('W', 'Oops! Something wrong.'));
					$this->load->view('include/page', $data);
				}
			}
		} else
		{
			$this->load->view('include/page', $data);
		}
	}

	//web popup start here

	public function web_popup()
	{
		$data['index'] = 'web popup';
		$data['index2'] = 'web popup';
		$data['title'] = 'Manage popup';

		$data['landingPopupData'] = $this->db->get('website_landing_page_popup')->row_array();

		$data['SellerPopupData'] = $this->db->get('seller_login_popup')->row_array();

		$this->load->view('include/header', $data);
		$this->load->view('admin/web_popup');
		$this->load->view('include/footer');
	}


	public function save_landing_page_popup()
	{


		$data = $this->input->post();

		$fileName = $_FILES["img"]["name"];

		$extension = explode('.', $fileName);

		$extension = strtolower(end($extension));

		$uniqueName = 'Popup_' . uniqid() . '.' . $extension;

		$type = $_FILES["img"]["type"];

		$size = $_FILES["img"]["size"];

		$tmp_name = $_FILES['img']['tmp_name'];

		$targetlocation = WEBSITE_DIRECTORY . $uniqueName;

		if (!empty($fileName))
		{

			move_uploaded_file($tmp_name, $targetlocation);

			$data['img'] = utf8_encode(trim($uniqueName));

		}
		$data['add_date'] = time();
		$websiteData = $this->db->get('website_landing_page_popup')->row_array();

		if ($websiteData)
		{
			$this->db->where('id', $websiteData['id']);
			$res = $this->db->update('website_landing_page_popup', $data);
		} else
		{
			$res = $this->db->insert('website_landing_page_popup', $data);
		}
		if ($res)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', 'Record has been updated Successfully.'));
			redirect('admin/Dashboard/web_popup');
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('W', 'Oops! somthing is worng please try again.'));
			redirect('admin/Dashboard/web_popup');
		}

	}




	public function save_seller_page_popup()
	{

		$data = $this->input->post();

		$fileName = $_FILES["img"]["name"];

		$extension = explode('.', $fileName);

		$extension = strtolower(end($extension));

		$uniqueName = 'SellerPopup_' . uniqid() . '.' . $extension;

		$type = $_FILES["img"]["type"];

		$size = $_FILES["img"]["size"];

		$tmp_name = $_FILES['img']['tmp_name'];

		$targetlocation = WEBSITE_DIRECTORY . $uniqueName;

		if (!empty($fileName))
		{

			move_uploaded_file($tmp_name, $targetlocation);

			$data['img'] = utf8_encode(trim($uniqueName));

		}
		$data['add_date'] = time();
		$SellerPopupData = $this->db->get('seller_login_popup')->row_array();

		if ($SellerPopupData)
		{
			$this->db->where('id', $SellerPopupData['id']);
			$res = $this->db->update('seller_login_popup', $data);
		} else
		{
			$res = $this->db->insert('seller_login_popup', $data);
		}
		if ($res)
		{
			$this->session->set_flashdata('activate', getCustomAlert('S', 'Record has been updated Successfully.'));
			redirect('admin/Dashboard/web_popup');
		} else
		{
			$this->session->set_flashdata('activate', getCustomAlert('W', 'Oops! somthing is worng please try again.'));
			redirect('admin/Dashboard/web_popup');
		}

	}






}

?>