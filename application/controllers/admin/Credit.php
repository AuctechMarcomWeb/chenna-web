<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Credit extends CI_Controller {

	  public function __construct() {
      parent::__construct();
      $this->load->library('email');
      $this->load->library('session');
      $this->load->helper('message');
      $this->load->model('credit_model');
      $this->load->library('form_validation');
      // $this->load->library('GlobalClass');
      // $this->load->library('pagination');
    }

	public function index()
	{
		is_not_logged_in();
		$data['index']         = 'Credit';
		$data['index2']        = '';
     	$data['title']         = 'Manage Credit';
     	$data['getData']	   = allData('wallet_master','reason','6');

        //echo "<pre>";	print_r($data['getData']); exit;

		$this->load->view('include/header',$data);
		$this->load->view('Credit/index');
		$this->load->view('include/footer');
	}

	public function AddCredit()
	{
		$data['index']         = 'Credit';
		$data['index2']        = '';
     	$data['title']         = 'Manage Credit';

     	$this->form_validation->set_rules('mobileNumber', 'Mobile Number', 'required');
        $this->form_validation->set_rules('type', 'Credit/Debit', 'required');
        $this->form_validation->set_rules('pay_value', 'Payable Value', 'required');
        $this->form_validation->set_rules('remark', 'Remark', 'required');

        if ($this->form_validation->run() == FALSE)
            {

		     	$this->load->view('include/header',$data);
				$this->load->view('Credit/AddCredit');
				$this->load->view('include/footer');
			}else{

				$data2 = $this->input->post();
				$checkMobile = getCount12('user_master',$data2['mobileNumber']);
				if($checkMobile > 0 ){
					$GetUserDetail = allData2('user_master','phone_no',$data2['mobileNumber']);
					$data2['user_master_id'] = $GetUserDetail['id'];
					$AddWallet = $this->credit_model ->AddWallet($data2);
					if($AddWallet > 0)
	 					{
							$this->session->set_flashdata('activate', getCustomAlert('S','User Wallet has been updated Successfully.'));
						    redirect('admin/Credit/');
						   }else{
			     	        $this->session->set_flashdata('activate', getCustomAlert('W','Oops! somthing is worng please try again.'));
					        redirect('admin/Credit/');
					    }
					
				}else{

					$this->session->set_flashdata('activate', getCustomAlert('W','This User Dose NOt Exsist In Record'));
					redirect('admin/Credit/AddCredit');

				}
				
			}
	}

	 public function CheckMobileExsist()
	 {
	 
	 	$rows =$this->db->get_where('user_master', array('phone_no'=>$_POST['mobile']))->num_rows();
	 	if($rows == 0) {  echo "Note : This Number Dose not Exsist in our Record"; }
	 }

}