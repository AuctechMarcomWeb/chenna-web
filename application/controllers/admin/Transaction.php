<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller {

	public function __construct() {
      parent::__construct();
      $this->load->library('email');
      $this->load->library('session');
      $this->load->helper('message');
      $this->load->model('transaction_model');
      $this->load->library('pagination');
    }

	public function TransactionList( $index='0', $check='1' )
	{
				
		  $data['index']         = 'Transaction';
		  $data['index2']        = '';
     	$data['title']         = 'Manage Transaction';
     	$data['getSchool']     = $this->transaction_model->GetAllSchool();	

     if ($check ==  1) {
        $this->session->unset_userdata('sdate');
        $this->session->unset_userdata('edate'); 
        $this->session->unset_userdata('filter');
      } 
        $searchData = $this->input->GET();
      if ($searchData) {
        $this->session->set_userdata('sdate',$searchData['sdate']);
        $this->session->set_userdata('edate',$searchData['edate']);
        $this->session->set_userdata('filter',$searchData['filter']);
      }
        $config                  = array();
        $config["base_url"]      = base_url()."admin/Transaction/TransactionList";
        $config['cur_tag_open']  = '&nbsp;<a class="current">';
        // Close tag for CURRENT link.
        $config['cur_tag_close'] = '</a>';
        $config['next_link']     = 'Next ';
        $config['prev_link']     = ' Previous ';
      
          $config["total_rows"]    = count($this->transaction_model->GetTransactionList());
          
       /*}*/ 
        /*print_r($config['total_rows']); exit;*/
        $config["per_page"]      = 10;
        $this->pagination->initialize($config);
        $str_links               = $this->pagination->create_links();
        $data['result']          = $this->transaction_model->FetchData($config["per_page"],$index);

       //
        $data["links"]           = explode('&nbsp;',$str_links ); 
		$this->load->view('include/header',$data);
		$this->load->view('Transaction/transaction_list');
		$this->load->view('include/footer');
	}


  public function SchoolTransaction($user_id='',$index='0', $check='1')
  {
    // print_r()
        
      $data['index']         = 'Transaction';
      $data['index2']        = '';
      $data['title']         = 'Manage Transaction';
      $data['getSchool']     = $this->transaction_model->GetAllSchool();  

     if ($check ==  1) {
        $this->session->unset_userdata('sdate');
        $this->session->unset_userdata('edate'); 
        $this->session->unset_userdata('filter');
      } 
        $searchData = $this->input->GET();
      if ($searchData) {
        $this->session->set_userdata('sdate',$searchData['sdate']);
        $this->session->set_userdata('edate',$searchData['edate']);
        $this->session->set_userdata('filter',$searchData['filter']);
      }
        $config                  = array();
        $config["base_url"]      = base_url()."admin/Transaction/SchoolTransaction/".$user_id;
        $config['cur_tag_open']  = '&nbsp;<a class="current">';
        // Close tag for CURRENT link.
        $config['cur_tag_close'] = '</a>';
        $config['next_link']     = 'Next ';
        $config['prev_link']     = ' Previous ';
    
          $config["total_rows"]    = count($this->transaction_model->GetSchoolTransactionList($user_id));

    
        /*echo($config['total_rows']); exit;*/
        $config["per_page"]      = 10;
        $this->pagination->initialize($config);
         $str_links              = $this->pagination->create_links();
        $data['result']          = $this->transaction_model->FetchSchoolTransactionList($config["per_page"],$index,$user_id);



        $data["links"]           = explode('&nbsp;',$str_links ); 
       
    $this->load->view('include/header',$data);
    $this->load->view('Transaction/transaction_list');
    $this->load->view('include/footer');
  }

   public function View($id ='')
   {
      $data['index']         = 'Transaction';
      $data['index2']        = '';
      $data['title']        = 'View Transaction';
      $data['getdata']  = $this->transaction_model->GetTransactionDetail($id,'');
      
      /* echo "<pre>";
      print_r($data['getdata']); */
      $this->load->view('include/header',$data);
      $this->load->view('Transaction/View');
      $this->load->view('include/footer');
   }

}