<?php
class SchoolBranch_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();	
	}
	
	public function GetSchool()
	{
		$SQL=  $this->db->query(" SELECT * FROM school_branch_master where parent_id = '0' ")->result_array();
		 return $SQL;
	}
	public function GetSchoolBranch($School_id='')
	{
		$SQL=  $this->db->query("SELECT * FROM school_branch_master where parent_id = '".$School_id."' ")->result_array();

		$array = array();	
		foreach ($SQL as $value) {

		 	$array['branch_id']   = $value['id'];
		 	$array['branch_name'] = $value['school_branch_name'];
		 	$hold['branch']= $array;
		 }
		return $hold;  
    }

	 

	

}