<?php
class ReferelAmount_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();	
	}
	
	
	public function GetUser()
	{
		$SQL = $this->db->query("SELECT *  FROM `user_master` where `verfiy_otp` = '2' AND `status` = '1' ")->result_array();
		return $SQL;
	}
	 
    public function getReferel($field_name='')
    {
      $SQL = "SELECT * from `settings` where id ='1'";
       
      $Query_exc = $this->db->query($SQL)->row_array();
      //print_r($Query_exc); exit;
      return $Query_exc[$field_name];
    }
	
	 
	
}