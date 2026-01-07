<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Coupon_modal extends CI_Model {
	    public function __construct(){
	        parent::__construct();
	    }


	    /* ----------------------------------------------------------- */
	    /* get data from db
	    /* ----------------------------------------------------------- */

	    public function getVoucherData($table, $order, $sel_col, $id = false) {
		if (!empty($id)) {
			$query = $this->db->select($sel_col)->from($table)->get()->row_array();
		} else {
			$query = $this->db->select($sel_col)->from($table)->get()->result_array();
		}
		return $query;
	    }

	    public function getData($table, $con = array(), $order, $sel_col, $id = false) {
		if(!empty($id)){
			$query = $this->db->select($sel_col)->from($table)->where($con)->get()->row_array();
		} else {
			$query = $this->db->select($sel_col)->from($table)->where($con)->get()->result_array();
		}
		return $query;
	   }


	    /* ----------------------------------------------------------- */
	    /* insert data into db
	    /* ----------------------------------------------------------- */
	    public function saveData($table, $data = array()) {
	    	$this->db->insert($table, $data);
	    	return $this->db->insert_id();
	    }

	    /* ----------------------------------------------------------- */
	    /* update data into db
	    /* ----------------------------------------------------------- */
	    public function updateData($table, $data = array(), $id) {
	    	$this->db->where('id', $id)->update($table, $data);
	    	return 1;
	    }


	    /* ----------------------------------------------------------- */
	    /* check coupon code is unique 
	    /* ----------------------------------------------------------- */
	    public function coupon_code_is_unique () {
	    	$code = trim(GetPostData('coupon_code'));
	    	$call_id = trim(GetPostData('call_id'));

	    	if (!empty($call_id)) {
	    		$query = $this->db->select('coupon_code, id')->from('ecom_couponcode_master')->where(array('coupon_code' => $code, 'status' => 1, 'id !=' => $call_id))->get()->row_array();
	    	} else {
	    		$query = $this->db->select('coupon_code, id')->from('ecom_couponcode_master')->where(array('coupon_code' => $code,'status' => 1))->get()->row_array();
    		}

	    	if (!empty($query)) : return 404; 
	    	else : return 200; endif;
	    }
	}
?>