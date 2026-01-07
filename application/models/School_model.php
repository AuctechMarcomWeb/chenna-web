<?php
class School_model extends CI_Model {
	 public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function SchoolLogin($username,$password,$loginType) {
  		# 1 for Admin
	   //echo "aaa"; exit;
	    $query = $this->db->get_where('school_master', array(EMAIL => $username,PASSWORD=>$password,STATUS=>'1'))->row_array();
	    /* echo $this->db->last_query();
	    print_r($query);exit;*/
	    return $query;

	}

	public function GetSchoolName($id='')
	{
		$query = $this->db->query("SELECT * FROM `school_master` Where  id = '".$id."'")->row_array();
		return $query['school_name'];

	}
	public function CheckFeeInserted($branch_id='',$class_id='')
	{
		return $this->db->query("SELECT * FROM class_fee_master Where branch_master_id='".$branch_id."' And class_master_id ='".$class_id."' ")->num_rows();
	}

	public function GetAllUserSchool($school_master_id)
	{
	 	return $this->db->query("SELECT * FROM `branch_master` where school_master_id = '".$school_master_id."' ")->result_array();
	}

	public function GetAdminData($id='')
	{
	return  $this->db->get_where('school_master', array('id'=>$id))->row_array();
	}

	/*public function GetSingleFieldData($id = '')
	{
	 $SQL = "SELECT * FROM `bar` "
	}*/


	public function UpdateProfile($data)
	{
		$arrayName = array();
	 	
		$arrayName['contact_person'] 	= $data['person_name'];
		$arrayName['phone_no']    		= $data['phone_no'];
		if (!empty($data['profile_pic'])) {
        $arrayName['profile_pic']    = $data['profile_pic'];
      }
		
		$arrayName['modify_date']		= time();
		//print_r($data); exit;

		$this->db->where('id',$data['id']);
		$insert = $this->db->update('school_master',$arrayName);
		return $insert;
	}


	public function GetSingleClassData($id='')
	{
		return $this->db->query("SELECT * FROM `class_master` Where `id`='".$id."'")->row_array();
	}

	public function GetClassSections($id='')
	{
		return $this->db->query("SELECT * FROM `section_master` WHERE class_master_id ='".$id."'")->result_array();
	}


	public function getAllSchool()
	{
	   return  $this->db->query("SELECT * FROM `school_master` order by id desc ")->result_array();
	}

	public function GetSchoolALlBranch($id='')
	{
		return $this->db->query("SELECT * FROM `branch_master` Where school_master_id='".$id."'")->result_array();
	}

	public function GetAllClassSection($class_id='')
	{
		$SQL = $this->db->query("SELECT * FROM `section_master` where class_master_id='".$class_id."'")->result_array();

		foreach ($SQL as $value) {
			echo $value['sections'].", ";
		}
	}

	public function GetBranchClass($id='')
	{
		return $this->db->query("SELECT * FROM `class_master` Where branch_master_id='".$id."'")->result_array();
	}


	public function GetSchoolALlBranch2($id='')
	{
		return  $this->db->query("SELECT bm.`id`, bm.`school_address`,sm.`school_name` FROM `branch_master` as bm left join `school_master` as sm On bm.`school_master_id`= sm.`id` Where bm.`school_master_id` ='".$id."'")->result_array();
		
	}

	public function GetSchoolAddress($id='')
	{
		$SQL = $this->db->query("SELECT  bm.`school_address`  FROM `branch_master` as bm left join `school_master` as sm On bm.`school_master_id`= sm.`id` Where bm.`id` ='".$id."'")->row_array();
		
		return $SQL['school_address'];
	}

	public function AddClassFee($data,$branch_id,$class_id)
	{
		//print_r($data); exit;
		
	 	$arrayName = array();
	 	$arrayName['branch_master_id'] = $branch_id;
	 	$arrayName['class_master_id']  = $class_id;
	 	
	 	if(array_key_exists("fee_amount",$data)){
	 		$arrayName['yearly_fee'] = $data['fee_amount'];
 	    	$arrayName['yearly_dis'] = $data['yealy_discount'];
 	    	$arrayName['type1'] = '1';
	 	}
	 	
 	    
	 	if(array_key_exists("half_first_inst",$data)){
	 	    $arrayName['half_yearly_first_inst']  = $data['half_first_inst'];
	 	    $arrayName['half_yearly_first_dis']   = $data['half_first_inst_dis'];
	 	    $arrayName['half_yearly_second_inst'] = $data['half_second_inst'];
	 	    $arrayName['half_yearly_second_dis']  = $data['half_second_inst_dis'];
	 	    $arrayName['type2'] = '1';

 	    }

 	    if(array_key_exists("quaterly_first_inst",$data)){
 	    $arrayName['quat_yearly_first_inst']  = $data['quaterly_first_inst'];
 	    $arrayName['quat_yearly_first_dis']   = $data['quaterly_first_inst_dis'];

 	    $arrayName['quat_yearly_second_inst'] = $data['quaterly_second_inst'];
 	    $arrayName['quat_yearly_second_dis']  = $data['quaterly_second_inst_dis'];

 	    $arrayName['quat_yearly_third_inst']  = $data['quaterly_third_inst'];
 	    $arrayName['quat_yearly_third_dis']   = $data['quaterly_third_inst_dis'];

 	    $arrayName['quat_yearly_fourth_inst']  = $data['quaterly_fourth_inst'];
 	    $arrayName['quat_yearly_fourth_dis']   = $data['quaterly_fourth_inst_dis'];
 	    $arrayName['type3'] = '1';

 		}


		if(array_key_exists("jan_fee",$data)){
 	    $arrayName['jan_fee']  		= $data['jan_fee'];
 	    $arrayName['jan_dis']  		= $data['jan_dis'];

 	    $arrayName['feb_fee']  		= $data['feb_fee'];
 	    $arrayName['feb_dis']  		= $data['feb_dis'];

 	    $arrayName['mar_fee']  		= $data['mar_fee'];
 	    $arrayName['mar_dis']  		= $data['mar_dis'];

 	    $arrayName['apr_fee']  		= $data['apr_fee'];
 	    $arrayName['apr_dis']  		= $data['apr_dis'];

 	    $arrayName['may_fee']  		= $data['may_fee'];
 	    $arrayName['may_dis']  		= $data['may_dis'];

 	    $arrayName['jun_fee']  		= $data['jun_fee'];
 	    $arrayName['jun_dis']  		= $data['jun_dis'];

		$arrayName['jul_fee']  		= $data['jul_fee'];
		$arrayName['jul_dis']  		= $data['jul_dis'];

		$arrayName['aug_fee']  		= $data['aug_fee'];
		$arrayName['aug_dis']  		= $data['aug_dis'];

		$arrayName['sept_fee']  	= $data['sept_fee'];
 	    $arrayName['sept_dis']  	= $data['sept_dis'];

		$arrayName['oct_fee']  		= $data['oct_fee'];
		$arrayName['oct_dis']  		= $data['oct_dis'];

		$arrayName['nov_fee']  		= $data['nov_fee'];
		$arrayName['nov_dis']  		= $data['nov_dis'];

		$arrayName['dec_fee']  		= $data['dec_fee'];
		$arrayName['dec_dis']  		= $data['dec_dis'];
		$arrayName['type1']  		= '1';
		}


 		$arrayName['add_date'] 		= time();
 		$arrayName['modify_date'] 	= time();

 	 	$insert = $this->db->insert('class_fee_master', $arrayName);


 	 	return $insert;
	 	
	}

	public function UpdateClassFee($data,$branch_id,$class_id)
	{
		$arrayName = array();
	 	$arrayName['branch_master_id'] = $branch_id;
	 	$arrayName['class_master_id']  = $class_id;


	 	//print_r($data); exit;

	 	 if(array_key_exists("year",$data)){
	 	 	$arrayName['yearly_fee'] = $data['fee_amount'];
 	    	$arrayName['yearly_dis'] = $data['yealy_discount'];
 	    	$arrayName['type1'] = '1';
	 	 }else{
	 	 	$arrayName['yearly_fee'] = '';
 	    	$arrayName['yearly_dis'] = '';
 	    	$arrayName['type1'] = '';
	 	 } 

	 	 if(array_key_exists("half",$data)){
	 	 	$arrayName['half_yearly_first_inst']  = $data['half_first_inst'];
	 	    $arrayName['half_yearly_first_dis']   = $data['half_first_inst_dis'];
	 	    $arrayName['half_yearly_second_inst'] = $data['half_second_inst'];
	 	    $arrayName['half_yearly_second_dis']  = $data['half_second_inst_dis'];
	 	    $arrayName['type2'] = '1';
	 	 }else{
	 	 	$arrayName['half_yearly_first_inst']  = '';
	 	    $arrayName['half_yearly_first_dis']   = '';
	 	    $arrayName['half_yearly_second_inst'] = '';
	 	    $arrayName['half_yearly_second_dis']  = '';
	 	    $arrayName['type2'] = '';
	 	 }

	 	  if(array_key_exists("quarter",$data)){
	 	 	$arrayName['quat_yearly_first_inst']  = $data['quaterly_first_inst'];
	 	    $arrayName['quat_yearly_first_dis']   = $data['quaterly_first_inst_dis'];

	 	    $arrayName['quat_yearly_second_inst'] = $data['quaterly_second_inst'];
	 	    $arrayName['quat_yearly_second_dis']  = $data['quaterly_second_inst_dis'];

	 	    $arrayName['quat_yearly_third_inst']  = $data['quaterly_third_inst'];
	 	    $arrayName['quat_yearly_third_dis']   = $data['quaterly_third_inst_dis'];
	 	    
	 	    $arrayName['quat_yearly_fourth_inst']  = $data['quaterly_fourth_inst'];
	 	    $arrayName['quat_yearly_fourth_dis']   = $data['quaterly_fourth_inst_dis'];
	 	    $arrayName['type3'] = '1';
	 	 	
	 	 }else{
	 	 	$arrayName['quat_yearly_first_inst']  = '';
	 	    $arrayName['quat_yearly_first_dis']   = '';

	 	    $arrayName['quat_yearly_second_inst'] = '';
	 	    $arrayName['quat_yearly_second_dis']  = '';

	 	    $arrayName['quat_yearly_third_inst']  = '';
	 	    $arrayName['quat_yearly_third_dis']   = '';
	 	    
	 	    $arrayName['quat_yearly_fourth_inst']  = '';
	 	    $arrayName['quat_yearly_fourth_dis']   = '';
	 	    $arrayName['type3'] = '';
	 	 }


	 	  if(array_key_exists("Monthly",$data)){
	 	 	$arrayName['jan_fee']  		= $data['jan_fee'];
	 	    $arrayName['jan_dis']  		= $data['jan_dis'];

	 	    $arrayName['feb_fee']  		= $data['feb_fee'];
	 	    $arrayName['feb_dis']  		= $data['feb_dis'];

	 	    $arrayName['mar_fee']  		= $data['mar_fee'];
	 	    $arrayName['mar_dis']  		= $data['mar_dis'];

	 	    $arrayName['apr_fee']  		= $data['apr_fee'];
	 	    $arrayName['apr_dis']  		= $data['apr_dis'];

	 	    $arrayName['may_fee']  		= $data['may_fee'];
	 	    $arrayName['may_dis']  		= $data['may_dis'];

	 	    $arrayName['jun_fee']  		= $data['jun_fee'];
	 	    $arrayName['jun_dis']  		= $data['jun_dis'];

			$arrayName['jul_fee']  		= $data['jul_fee'];
			$arrayName['jul_dis']  		= $data['jul_dis'];

			$arrayName['aug_fee']  		= $data['aug_fee'];
			$arrayName['aug_dis']  		= $data['aug_dis'];

			$arrayName['sept_fee']  	= $data['sept_fee'];
	 	    $arrayName['sept_dis']  	= $data['sept_dis'];

			$arrayName['oct_fee']  		= $data['oct_fee'];
			$arrayName['oct_dis']  		= $data['oct_dis'];

			$arrayName['nov_fee']  		= $data['nov_fee'];
			$arrayName['nov_dis']  		= $data['nov_dis'];

			$arrayName['dec_fee']  		= $data['dec_fee'];
			$arrayName['dec_dis']  		= $data['dec_dis'];
			$arrayName['type4']  		= '1';
			
	 	 }else{
	 	 	$arrayName['jan_fee']  		= '';
	 	    $arrayName['jan_dis']  		='';

	 	    $arrayName['feb_fee']  		= '';
	 	    $arrayName['feb_dis']  		= '';

	 	    $arrayName['mar_fee']  		= '';
	 	    $arrayName['mar_dis']  		= '';

	 	    $arrayName['apr_fee']  		= '';
	 	    $arrayName['apr_dis']  		= '';

	 	    $arrayName['may_fee']  		= '';
	 	    $arrayName['may_dis']  		= '';

	 	    $arrayName['jun_fee']  		= '';
	 	    $arrayName['jun_dis']  		= '';

			$arrayName['jul_fee']  		= '';
			$arrayName['jul_dis']  		= '';

			$arrayName['aug_fee']  		= '';
			$arrayName['aug_dis']  		= '';

			$arrayName['sept_fee']  	= '';
	 	    $arrayName['sept_dis']  	= '';

			$arrayName['oct_fee']  		= '';
			$arrayName['oct_dis']  		= '';

			$arrayName['nov_fee']  		= '';
			$arrayName['nov_dis']  		= '';

			$arrayName['dec_fee']  		= '';
			$arrayName['dec_dis']  		= '';
			$arrayName['type4'] = '';
	 	 }

	 	


 		/*$arrayName['add_date'] 		= time();*/

 		/*print_r($arrayName); exit;*/
 		$arrayName['modify_date'] 	= time();
 		
 		$where = array('branch_master_id'=> $branch_id, 'class_master_id' => $class_id);
 		$this->db->where($where);
 	 	$update = $this->db->update('class_fee_master', $arrayName);
 	 	return $update;
	}

	public function GetSingleData($id='', $table ='', $feildname ='')
	{
		$SQL = $this->db->query(" SELECT * FROM ".$table." where id = '".$id."' ")->row_array();
		 return $SQL[$feildname];
	}

	public function CheckFeeAdded($branch_id='', $class_id='')
	{
	 	return $this->db->query("SELECT * From `class_fee_master` where `branch_master_id` = '".$branch_id."' AND `class_master_id` = '".$class_id."' ")->num_rows();

	}


	public function GetFeeDetail($branch_id='', $class_id='')
	{
		return $this->db->query("SELECT * From `class_fee_master` where `branch_master_id` = '".$branch_id."' AND `class_master_id` = '".$class_id."' ")->row_array();
	}
 
	public function AddNewSchoolData($data)
	{

		$arrayName  =  array();
		$arrayName['school_name'] 		= $data['school_name'];
		$arrayName['contact_person'] 	= $data['person_name'];
		$arrayName['phone_no']    		= $data['phone_no'];
		$arrayName['email'] 	   		= $data['school_email'];
		$arrayName['password']			= base64_encode($data['password']);
		$arrayName['add_date'] 	   		= time();
		$arrayName['modify_date']		= time();
		$checkEmail = $this->CheckEmailExsist($arrayName['email']);
		if($checkEmail == 0)
		{
			$insert = $this->db->insert('school_master',$arrayName);
			if($insert>0) { return 1; } else { return 0 ;}

		}else{
			return 2;
		}
	}

	public function updateSchoolData($data)
	{

		$arrayName  =  array();
		$arrayName['school_name'] 		= $data['school_name'];
		$arrayName['contact_person'] 	= $data['person_name'];
		$arrayName['phone_no']    		= $data['phone_no'];
		$arrayName['password']    		= base64_encode($data['password']);
		
		$arrayName['modify_date']		= time();
		 $this->db->where('id',$data['id']);
		$insert = $this->db->update('school_master',$arrayName);
		if($insert>0) { return 1; } else { return 0 ;}

	}

	public function AddNewBranch($data)
	{
		/*print_r($data); exit;*/
		$arrayName  =  array();
		$arrayName['school_master_id'] 	= $data['school_master_id'];
		$arrayName['school_address'] 	= $data['address'];
		$arrayName['school_phone_no']   = $data['phone1'];
		$arrayName['landline_no']    	= $data['phone2'];
		$arrayName['state']    			= $data['state'];
		$arrayName['city']    			= $data['city'];
		$arrayName['pincode']    		= $data['pincode'];
		$arrayName['country']        	= $data['country'];
		$arrayName['add_date']			= time();
		$arrayName['modify_date']		= time();
		// print_r($arrayName); exit;
		$row = $this->db->insert('branch_master',$arrayName);
		return $row;

	}


	public function CheckEmailExsist($value)
	{
		$SQL = $this->db->query("SELECT * FROM `school_master` where email = '".$value."'")->num_rows();
	 	return ($SQL>0) ? '1' :'0';
	}

	public function SingleSchoolData($id)
	{	
		return $this->db->query("SELECT * FROM `school_master` WHERE id = '".$id."' ")->row_array();

	}
	public function SingleBranchData($id)
	{	
		return $this->db->query("SELECT * FROM `branch_master` WHERE id = '".$id."' ")->row_array();

	}
	public function UpdateBranchData($data)
	{
		$arrayName = array();
		$arrayName['school_address'] = $data['address'];
		$arrayName['school_phone_no']= $data['phone1'];
		$arrayName['landline_no'] 	 = $data['phone2'];
		$arrayName['pincode'] 		 = $data['pincode'];
		$arrayName['state'] 		 = $data['state'];
		$arrayName['city'] 			 = $data['city'];
		$arrayName['modify_date'] 	 = time();

		$this->db->where('id',$data['id']);
		$row = $this->db->update('branch_master',$arrayName);
		return $row;

	}

	public function AddClassBranchData($data)
	{ 
		
		$section = $data['section'];
		
		$arrayName = array();
		$arrayName['branch_master_id']  = $data['branch'];
		$arrayName['class']				= $data['class_no'];
		
		$arrayName['status'] 	 		= '1';
		$arrayName['add_date'] 	 		= time();
		$arrayName['modify_date'] 	 	= time();
		$row =$this->db->insert('class_master',$arrayName);
		 /*echo $this->db->last_query();
		  exit;*/
		  $last_id = $this->db->insert_id();


		    foreach ($section as  $value ) {
		    	$array = array();
		    	$array['class_master_id'] 	= $last_id;
		    	$array['sections'] 			= $value;
		    	$array['add_date'] 	 		= time();
		    	$array['modify_date'] 		= time();
		    	 $this->db->insert('section_master',$array);
			}		
		return $row;
	}

	public function UpdateClassBranchData($data)
	{

		$section     =  $data['section'];
		
		$arrayName   =  array();
		
		$arrayName['class']				= $data['class_no'];
		
		$arrayName['status'] 	 		= '1';
		$arrayName['modify_date'] 	 	= time();
		$this->db->where('id',$data['id']);
		$row = $this->db->update('class_master',$arrayName);

		$this->db->where('class_master_id', $data['id']);
      	$this->db->delete('section_master'); 

		    foreach ($section as  $value ) {
		    	$array = array();
		    	$array['class_master_id'] 	= $data['id'];
		    	$array['sections'] 			= $value;
		    	$array['add_date'] 	 		= time();
		    	$array['modify_date'] 		= time();
		    	 $this->db->insert('section_master',$array);
			}		
		return $row;
	}

} 
?>