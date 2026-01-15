<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends CI_Controller {

	  public function __construct() {
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

 	
	public function index(){
		$adminData= $this->session->userdata('adminData');
		is_not_logged_in();
		$data['index']         = 'shop';
		$data['index2']        = '';
     	$data['title']         = 'Manage Shop';

     	if($adminData['Type']=='1') {
     		$this->db->order_by('id','DESC');
           $data['getData']       = $this->db->get_where('shop_master')->result_array();
     	} else {
     	   $this->db->order_by('id','DESC');
           $data['getData']       = $this->db->get_where('shop_master',array('type'=>'2','addedBy'=>$adminData['Id']))->result_array();
     	}
	    
		$this->load->view('include/header',$data);
		$this->load->view('manage_shop/shopList');
		$this->load->view('include/footer');
	}


public function addShop() {
	   $adminData = $this->session->userdata('adminData');
		is_not_logged_in();
		$data = $this->input->post();
		if(empty($data)){
	        $data['index']         = 'shop';
			$data['index2']        = '';
	     	$data['title']         = 'Manage pincode';			
	     	$data['VendorList']    = $this->db->get_where('staff_master',array('status'=>'1'))->result_array();	
	     	// $data['stateList']      = $this->db->get_where('states_list',array('country_id'=>'101'))->result_array();		
			$this->load->view('include/header',$data);
			$this->load->view('manage_shop/AddShop');
			$this->load->view('include/footer');
			
		} else {

			
			$data['add_date']        = time();
			$data['modify_date']     = time();

			if($adminData['Type']=='1') {
                $data['vendor_id']       = $data['vendor_id'];
                $data['verify_shop']     = '1';
			    $data['type']            = '2';
				$data['addedBy']         = $data['vendor_id'];

			} else {

                $data['vendor_id']       = $adminData['Id'];
                $data['verify_shop']     = '2';
	            $data['type']            = '2';
				$data['addedBy']         = $adminData['Id'];

			}

            
			$row = $this->db->insert('shop_master',$data);
			$last_id  = $this->db->insert_id();
			$this->createWarehouse($last_id);


          if($row > 0){
	         $this->session->set_flashdata('activate', getCustomAlert('S',' Shop has been add Successfully.'));
	          redirect('admin/Shop/');
	        }else {
	         $this->session->set_flashdata('activate', getCustomAlert('w','!Opps Something is worng.Please try again.'));
	          redirect('admin/shop/addShop/');
	        }
		}
		
	}


public function createWarehouse($shop_id) {
  $shop = $this->db->get_where('shop_master',array('id'=>$shop_id))->row_array();

  $fields['company_name']     = $shop['name'];
  $fields['address1']         = $shop['address'];
  $fields['address2']         = '';
  $fields['mobile']           = $shop['mobile'];
  $fields['pincode']          = $shop['pincode'];
  $fields['city_id']          = '4933';
  $fields['state_id']         = '38';
  $fields['country_id']       = '101';
  $fields['access_token']     = '28b4d9246917ac19f5f9cea9861bc731';
  $fields['secret_key']       = 'df1b745f66e9b39f81b70b8bc2ad4689';
 
   $array_data['data']           = $fields;
   $json_data   = json_encode($array_data);
   $curl = curl_init();
		      curl_setopt_array($curl, array(
		      CURLOPT_URL             => "https://manage.ithinklogistics.com/api_v3/warehouse/add.json",
		      CURLOPT_RETURNTRANSFER  => true,
		      CURLOPT_ENCODING        => "",
		      CURLOPT_MAXREDIRS       => 10,
		      CURLOPT_TIMEOUT         => 30,
		      CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
		      CURLOPT_CUSTOMREQUEST   => "POST",
		      CURLOPT_POSTFIELDS      => $json_data,
		      CURLOPT_HTTPHEADER      => array(
		          "cache-control: no-cache",
		          "content-type: application/json"
		      ),
		  ));

		  $response = curl_exec($curl);
		  $err      = curl_error($curl);
		  curl_close($curl);
		  if ($err) 
		  {
		     echo "cURL Error #:" . $err;
		  }
		  else
		  {
		     $res_array =json_decode($response,true);
		  }
    
   if(!empty($res_array['warehouse_id'])) {

   	 if(empty($shop['warehouse_id'])) {
	        $warehouse['warehouse_id']     =   $res_array['warehouse_id'];
			$this->db->where('id',$shop_id);
			$this->db->update('shop_master',$warehouse);
	   }

   }

}




public function delete_shop($id){
	$this->db->where('id',$id);
	$row = $this->db->delete('shop_master');

	if($row > 0){
	 $this->session->set_flashdata('activate', getCustomAlert('S',' Shop has been Deleted Successfully.'));
	  redirect('admin/Shop/');
	} else {
	 $this->session->set_flashdata('activate', getCustomAlert('w','!Opps Something is worng.Please try again.'));
	  redirect('admin/Shop/');
	}

}




	public function updateShop($id){
		is_not_logged_in();
		$data = $this->input->post();
		if(empty($data)){
	        $data['index']         = 'shop';
			$data['index2']        = '';
	     	$data['title']         = 'Manage pincode';			
	     	$data['getData']      = $this->db->get_where('shop_master',array('id'=>$id))->row_array();	
	     	$data['VendorList']    = $this->db->get_where('staff_master',array('status'=>'1'))->result_array();	
	     	// $data['stateList']      = $this->db->get_where('states_list',array('country_id'=>'101'))->result_array();		
	     	// $data['CityList']      = $this->db->get_where('cities_list',array('state_id'=>$data['getData']['state_id']))->result_array();		
			$this->load->view('include/header',$data);
			$this->load->view('manage_shop/updateShop');
			$this->load->view('include/footer');
		} else {

			$data['modify_date']  = time();
			$this->db->where('id',$id);
			$row = $this->db->update('shop_master',$data);
          $this->createWarehouse($id);
          if($row > 0){
	         $this->session->set_flashdata('activate', getCustomAlert('S',' Shop has been Update Successfully.'));
	          redirect('admin/Shop/');
	        } else {
	         $this->session->set_flashdata('activate', getCustomAlert('w','!Opps Something is worng.Please try again.'));
	          redirect('admin/shop/addShop/');
	        }
		}
		
	}
	

public function verify_shop(){
  $value = $this->input->post('value');
  $shop_id = $this->input->post('shop_id');

  if($value=='1'){
     $field['verify_shop']=  '2';
   } else {
     $field['verify_shop']=  '1';
   }
   
  $this->db->where('id',$shop_id);
  $this->db->update('shop_master',$field); 

}

public function verify_seller(){
  $value = $this->input->post('value');
  $seller_id = $this->input->post('seller_id');

  if($value=='1'){
     $field['account_verify']=  '2';
   } else {
     $field['account_verify']=  '1';
   }
       $this->db->where('id',$seller_id);
  echo $this->db->update('staff_master',$field); exit;

}

public function sendSmsEmail($shop_id) {
  $this->session->set_flashdata('activate', getCustomAlert('S',' Alert Send  Successfully.'));
  redirect('admin/Shop/');

}














}
?>