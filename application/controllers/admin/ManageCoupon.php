<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');
	//require_once(APPPATH.'controllers/Admin.php');
	class ManageCoupon extends Ci_controller {
		public function __construct() {
	        parent::__construct();
	        
    			//$this->is_not_logged_in();
    			$this->load->model('admin/coupon_modal', 'coupon');
    			global $alphas,$count;
    			$count=0;
    			$alphas = range('A', 'Z');
                $this->load->library('email');
                $this->load->library('session');
                $this->load->helper('message');
                $this->load->helper('api');
                $this->load->model('user_model');
                $this->load->library('form_validation');
	    }

        /*Manage Coupon*/
        public function getCoupons(){
            $con = array('status !=' => 3);
            $order_by = 'desc';
            $sel_col  = '*';
            $data['couponData'] = $this->coupon->getData('coupon_master', $con, $order_by, $sel_col);
            $data['index']         = 'Coupon';
            $data['index2']        = '';    
            $data['title']         = 'Manage Coupons';
            $this->load->view('include/header', $data);       
            $this->load->view('admin/coupons/coupon_list', $data);
            $this->load->view('include/footer');
        }

      
	    /*Add Coupon*/
	    public function addCoupon(){

            $data['index']         = 'AddCoupan';
            $data['index2']        = '';    
            $data['title'] = "Add Coupon";
            
            $table    = 'ecom_coupon_order_type';
            $con      = array('status' => 1);
            $order_by = 'desc';
            $sel_col  = '*';

            $data['couponData'] = $this->coupon->getData('coupon_master', $con, $order_by, $sel_col);

            if($this->input->post()){ 
                $data = $this->input->post();

                $couponApply = @$data['apply_coupon'];
                // echo $couponApply;
                // echo '<pre>';
                // print_r($couponApply); die;
                $couponApplyOn = json_encode($couponApply);

                $table = 'coupon_master';
                $save_data = array( 
                    'offer_type'            => $data['offer_type'],
                    'min_dis_val'            => $data['min_dis_val'],
                    'product_price_range'   => $data['product_price_range'],
                    'applicable_payment_mode' => $data['applicable_payment_mode'],
                    'max_total_usage'        => $data['max_total_usage'],
                    'apply_discount'        => $data['apply_discount'],
                    'apply_coupon'          => $couponApplyOn,
                    'coupon_code'           => trim($data['coupon_code']),
                    'title'                 => trim($data['title']),
                    'coupon_discount_type'  => $data['coupon_discount_type'],
                    'coupon_type'           => $data['coupon_type'],
                    'coupon_message'        => $data['coupon_message'],
                    'coupn_discount_val'    => trim($data['value_amt']),
                    'minimum_applicable_amount'=> trim($data['min_amt']),
                    'start_date'            => strtotime($data['start_date']),
                    'end_date'              => strtotime($data['end_date']),
                    'add_date'              => time(),
                    'modify_date'           => time(),
                    'status'                => 1,
                ); 
                $save_data = $this->coupon->saveData($table, $save_data);

                $this->session->set_flashdata('activate',getCustomAlert("S","Coupon has been add Successfully."));
                redirect(site_url('admin/ManageCoupon/getCoupons'), 'refresh');  
                }else{
                $data['catData'] = $this->db->get('category_master')->result_array();

                $this->db->group_by('product_name'); 
                $data['proData'] = $this->db->get('sub_product_master')->result_array();

                $data['userData'] = $this->db->get('user_master')->result_array();

                $data['subCatData'] = $this->db->get('sub_category_master')->result_array();

                $this->load->view('include/header', $data);       
                $this->load->view('admin/coupons/add_coupon', $data);
                $this->load->view('include/footer');
            }
	    }




        /*Edit coupon*/
        public function editCoupon(){
            $data['index']         = 'EditCoupon';
            $data['index2']        = '';   
            $data['title'] = "Edit Coupon";
            $c_id          = base64_decode($this->uri->segment(4));  
            $table         = 'coupon_master';
            $con           = array('status' => 1);
            $order_by      = 'desc';
            $sel_col       = '*';

            // $data['couponData'] = $this->coupon->getData('coupon_master', $con, $order_by, $sel_col);

            $data['c_id'] = $c_id;

            if($this->input->post()){
            $data = $this->input->post();
           // echo '<pre>';
           // print_r($data); die;
            if(@$data['apply_coupon']){   
            $couponApply = $data['apply_coupon'];
            $couponApplyOn = json_encode($couponApply);
            }else{
            $couponApplyOn = json_encode('overall'); 
            }

             $save_data = array( 
            'offer_type'            => $data['offer_type'],
            'min_dis_val'            => $data['min_dis_val'],
            'product_price_range'   => $data['product_price_range'],
            'applicable_payment_mode'=>$data['applicable_payment_mode'],
            'max_total_usage'        =>$data['max_total_usage'],
            'apply_discount'        => $data['apply_discount'],
            'apply_coupon'          => $couponApplyOn,
            'coupon_code'           => trim($data['coupon_code']),
            'title'                 => trim($data['title']),
            'coupon_discount_type'  => $data['coupon_discount_type'],
            'coupon_type'           => $data['coupon_type'],
            'coupon_message'        => $data['coupon_message'],
            'coupn_discount_val'    => trim($data['value_amt']),
            'minimum_applicable_amount'=> trim($data['min_amt']),
            'start_date'            => strtotime($data['start_date']),
            'end_date'              => strtotime($data['end_date']),
            'modify_date'           => time(),
            'status'                => $data['status']
            );
           
                $save_data = $this->coupon->updateData($table, $save_data, $c_id);
                $this->session->set_flashdata('activate',getCustomAlert("S","Coupon has been updated Successfully."));
                redirect(site_url('admin/ManageCoupon/getCoupons'), 'refresh');  
               }else{
                $con = array('status !=' => 3, 'id' => $c_id);
                $data['coupons'] = $this->coupon->getData($table, $con, $order_by, $sel_col, $c_id);
                // echo '<pre>';
                // print_r($data['coupons']); die;
                $data['catData'] = $this->db->get('category_master')->result_array();
                // echo '<pre>';
                // print_r($data['catData']); die;
                $this->db->group_by('product_name'); 
                $data['proData'] = $this->db->get('sub_product_master')->result_array();

                $data['userData'] = $this->db->get('user_master')->result_array();

                $data['subCatData'] = $this->db->get('sub_category_master')->result_array();
                $this->load->view('include/header', $data);       
                $this->load->view('admin/coupons/edit_coupon1', $data);
                $this->load->view('include/footer');
            }
        }


         public function deleteCoupon($param){
         $this->db->where('id',base64_decode($param));
         $this->db->delete('coupon_master');
         redirect(site_url('admin/ManageCoupon/getCoupons'), 'refresh'); 
         }


         public function uploadCouponExcel(){
         $data['index']         = 'EditCoupon';
         $data['index2']        = '';   
         $data['title'] = "Upload Coupon Excel";

         $this->load->view('include/header',$data);       
         $this->load->view('admin/coupons/AddBulkCoupon');
         $this->load->view('include/footer');
         }



    public function uploadCouponExcelData(){
    $adminData = $this->session->userdata('adminData'); 
    $data = $this->input->post();

    if(isset($_POST["Upload"])) {

    $filename = $_FILES["file"]["tmp_name"];

    $userfile_extn = explode(".", strtolower($_FILES['file']['name'])); 

    if($userfile_extn['1']!=='csv') {
    $this->session->set_flashdata('activate', getCustomAlert('D','Please  Upload  CSV File.'));
    redirect('admin/Product/AddBulkProduct/');
    } else {

    if($_FILES["file"]["size"] > 0)
    {
    $row = 1;
    $file = fopen($filename, "r");

    while (($importdata = fgetcsv($file, 10000, ",")) !== FALSE) {

    if( $row > 1) { 
    // $keywords = $importdata['0'];
    // $sub_cate = $this->db->query("SELECT id,category_master_id FROM sub_category_master where  sub_category_name LIKE '%$keywords%'")->row_array();

    // $sku_code = explode("_",$importdata['2']);
    // $product_code = explode("_",$importdata['1']);

    $fields['offer_type']               = $importdata['0'];
    $fields['applicable_payment_mode']  = $importdata['1'];
    $fields['max_total_usage']          = $importdata['2'];
    $fields['product_price_range']      = $importdata['3'];
    $fields['apply_discount']           = $importdata['4'];
    $fields['apply_coupon']             = $importdata['5'];

    $fields['coupon_code']              = $importdata['6'];
    $fields['title']                    = $importdata['7'];

    $start_date                         = $importdata['8'];

    $StDate                             = date("d-m-Y 00:00:00",strtotime($start_date));

    $fields['start_date']               = strtotime($StDate);

    $end_date                           = $importdata['9'];

    $endDate                            = date("d-m-Y 00:00:00",strtotime($end_date));

    $fields['end_date']                 = strtotime($endDate);

    $fields['coupon_type']              = $importdata['10'];
    $fields['coupon_discount_type']     = $importdata['11'];
    $fields['coupon_message']           = $importdata['12'];
    $fields['coupn_discount_val']       = $importdata['13'];
    $fields['minimum_applicable_amount']= $importdata['14'];   
    $fields['min_dis_val']              = $importdata['15'];   
    $fields['status']                   = '1';
  
    $fields['add_date']                    = time();
    $fields['modify_date']                 = time();

   $this->db->insert('coupon_master',$fields);
    // if(!empty($sku_code['0'])){
    // $this->db->insert('sub_product_master',$fields);
    // }

    // if(empty($sku_code['0'])){
    // fclose($file);
    // }

    }   

    $row++;
    } 
    fclose($file);

    $this->session->set_flashdata('activate', getCustomAlert('S','Product  Uploaded successfully.'));
    // redirect('admin/Product/AddBulkProduct/');
     redirect(site_url('admin/ManageCoupon/getCoupons'), 'refresh'); 
    } 
    }  
    }
         }




         //****manage voucher***//


           public function getvoucher(){
            $table    = 'voucher_master';
            $order_by = 'desc';
            $sel_col  = '*';
            $data['vouchers'] = $this->coupon->getVoucherData($table, $order_by, $sel_col);
            $data['index']         = 'Voucher';
            $data['index2']        = '';    
            $data['title']         = 'Manage Voucher';
            $this->load->view('include/header',$data);       
            $this->load->view('admin/coupons/voucher_list',$data);
            $this->load->view('include/footer');
            }



                /*Add Coupon*/
        public function addVoucher(){
            $data['index']         = 'addVoucher';
            $data['index2']        = '';    
            $data['title'] = "Add Voucher";
            
            $table    = 'voucher_master';
            $con      = array('status' => 1);
            $order_by = 'desc';
            $sel_col  = '*';

            $data['coupon_order_types'] = $this->coupon->getData($table, $con, $order_by, $sel_col);

            if($this->input->post()){ 
                $data = $this->input->post();

                // $table = 'coupon_master';
                $save_data = array(
                'voucher_code'           => trim($data['voucher_code']),
                'voucher_value'           => trim($data['value_amt']),
                'min_cart_value'           => trim($data['min_cart_value']),
                'no_of_uses'           => trim($data['no_of_uses']),
                'add_date'              => time(),
                'status'                => 1,
                ); 
             
                $save_data = $this->coupon->saveData($table, $save_data);

                $this->session->set_flashdata('activate',getCustomAlert("S","Voucher has been add Successfully."));
                redirect(site_url('admin/ManageCoupon/getvoucher'), 'refresh');  
            } else{
                $this->load->view('include/header', $data);       
                $this->load->view('admin/coupons/add_voucher', $data);
                $this->load->view('include/footer');
            }
        }


     /*Edit voucher*/
        public function editVoucher(){

            $data['index']         = 'EditVoucher';
            $data['index2']        = '';   
            $data['title'] = "Edit Voucher";
            $c_id          = base64_decode($this->uri->segment(4));  
            $table         = 'voucher_master';
            // $con           = array('status' => 1);
            $order_by      = 'desc';
            $sel_col       = '*';

            // $data['coupon_order_types'] = $this->coupon->getData('voucher_master', $con, $order_by, $sel_col);
            $data['c_id'] = $c_id;

            if($this->input->post()){
            $data = $this->input->post();

            $table = 'voucher_master';
            $save_data = array(
            'voucher_code'    => trim($data['voucher_code']),
            'voucher_value'   => trim($data['value_amt']),
            'min_cart_value'  => trim($data['min_cart_value']),
            'no_of_uses'      => trim($data['no_of_uses']),
            'add_date'        => time(),
            'status'          => '1'
            ); 
            $this->db->where('id',$c_id);
            $updateData = $this->db->update('voucher_master',$save_data);
            $this->session->set_flashdata('activate',getCustomAlert("S","Voucher has been updated Successfully."));
            redirect(site_url('admin/ManageCoupon/getvoucher'), 'refresh');  
            }else{
            $con = array('id' => $c_id);
            $data['voucher'] = $this->coupon->getData($table, $con, $order_by, $sel_col, $c_id);
            $this->load->view('include/header', $data);       
            $this->load->view('admin/coupons/edit_voucher', $data);
            $this->load->view('include/footer');
          }
        }


        public function deleteVoucher($param){
        $this->db->where('id',base64_decode($param));
        $this->db->delete('voucher_master');
        redirect(site_url('admin/ManageCoupon/getvoucher'), 'refresh'); 
        }




        /* check entered coupon is unique */
        public function couponExist() {
            if ($this->input->post()) {
                $chk_code = $this->coupon->coupon_code_is_unique();
                echo json_encode($chk_code);
                exit;
            }
        }
	}
?>