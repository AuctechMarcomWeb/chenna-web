<?php
class Web_Dashboard_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();	
	}

	 public function getBanners()
	 {
	 	$statement = "SELECT bm.* FROM `banner_master` as bm ";
	 	$where = "Where bm.`status` = '1' ";	 	
         $where .= " ORDER BY bm.`id` ASC ";   /* LIMIT ".($pageindex == '' ? 0 : $pageindex ).", 10*/ 
	 	 return $this->db->query($statement.$where)->result_array();          
	 	 //echo $this->db->last_query();
	 }

	public function getDealOfDay()
	 {
	 		 
	 	$stat = "SELECT * FROM product_master WHERE status = 1 AND approving_status = 1 AND DATE(FROM_UNIXTIME(`deal_of_day_start`)) <= date(NOW()) AND DATE(FROM_UNIXTIME(`deal_of_day_end`)) >= date(NOW()) ORDER BY RAND() LIMIT 4  ";
        return $this->db->query($stat)->result_array();
		//echo $this->db->last_query();exit;
	 }
	 public function getDealOfDayList()
	 {
	 		 
	 	$stat = "SELECT * FROM product_master WHERE status = 1 AND DATE(FROM_UNIXTIME(`deal_of_day_start`)) <= date(NOW()) AND DATE(FROM_UNIXTIME(`deal_of_day_end`)) >= date(NOW()) ";
        return $this->db->query($stat)->result_array();
		//echo $this->db->last_query();exit;
	 }
	
	public function getOfferCategory()
	{
		$stat = "SELECT offer_name,sub_category_ids FROM offer_master WHERE status = 1 AND DATE(FROM_UNIXTIME(`start_date`)) <= date(NOW()) AND DATE(FROM_UNIXTIME(`end_date`)) >= date(NOW()) ORDER BY RAND() ";
        return $this->db->query($stat)->result_array();
        
		//$stat = "SELECT * FROM sub_category_master WHERE status = 1 AND DATE(FROM_UNIXTIME(`offer_sub_cateorgy_start_date`)) <= date(NOW()) AND DATE(FROM_UNIXTIME(`offer_sub_cateorgy_end_date`)) >= date(NOW()) ORDER BY RAND() ";
       // return $this->db->query($stat)->result_array();
       
	}

	public function getProduct($sub_category_master_id)
	{
		$this->db->order_by('id', 'RANDOM');		
		$this->db->limit(12);
        return $this->db->get_where('product_master', array('status' => 1,'sub_category_master_id' => $sub_category_master_id))->result_array();
	}


	public function checkWishCounting($product_id,$user_id){
	 return $this->db->query("select id from wishlist_master where user_master_id='$user_id' and product_master_id='$product_id'")->num_rows();
	}
	public function checkWishCondition($product_id,$user_id){
	 return $this->db->query("select id from wishlist_master where user_master_id='$user_id' and product_master_id='$product_id'")->row_array();
	}
	public function checkDealOfDay($product_id,$time){
	 return $this->db->query("select * from product_master where id='$product_id' and deal_of_day_end >=$time and status='1'")->row_array();
	}
	public function checOfferCondition($sub_category_id,$time){
	 return $this->db->query("select deal_type,deal_amount,offerType from offer_master where sub_category_ids='$sub_category_id' and end_date >=$time and status='1'")->row_array();
	}
	public function GetProductWeb($sub_cat_id){
		$this->db->select('id,reference,quantity,product_name,sub_category_master_id,price,product_discount_type,product_discount_amount,final_price');    
		$this->db->order_by('id', 'RANDOM');    
        $this->db->limit(9);
	 return $this->db->get_where('product_master', array('status' => 1,'approving_status'=>1,'sub_category_master_id' => $sub_cat_id,'reference'=>'0'))->result_array(); 
	}

	public function GetLevelBanner($level){
		$this->db->select('id,banner_on,banner_image,sub_category_product_master_id');
	 return $this->db->get_where('banner_master',array('status'=>'1', 'bannerType'=>'2','featured_banner'=>'2','level'=>$level))->result_array(); 
	}

	public function GetData($table,$condition,$order,$id){
		if(!empty($id)){
			$data = $this->db->get_where($table,$condition)->row_array();
		}else{
			if(!empty($order)){
			  $this->db->order_by($order['column'],$order['columnData']);
			}
			
			$data = $this->db->get_where($table,$condition)->result_array();
		}
		return $data;
	}


	public function Getaddress($condition='',$id=''){
			$this->db->select('user_addressmaster.*,states_list.name as statename,countries_list.name as cuntry_name');
			$this->db->join('states_list','states_list.id=user_addressmaster.state_list_id','left');
			$this->db->join('countries_list','countries_list.id=user_addressmaster.countery_id','left');
			
			if(!empty($id)){
				$this->db->where($condition);
				$data = $this->db->get('user_addressmaster')->row_array();
			}else{
				$this->db->where('user_addressmaster.status',1);
				$this->db->order_by('user_addressmaster.id','desc');
				$data = $this->db->get_where('user_addressmaster',$condition)->result_array();
				
			}
			return $data;

	}

	 public function updateData($table_name,$condition,$input_data){
        $update_data = $this->db->where($condition)->update($table_name, $input_data);
        return true;
      }


}