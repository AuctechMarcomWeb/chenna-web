<?php
class Membership_Model extends CI_Model {
	 public function __construct(){
		parent::__construct();
		$this->load->database();
	}


  public function getUserPlanList()
  {
    return $this->db->query('SELECT * FROM `member_plan`  order by id desc')->result_array();
  }

  public function getUserMembershipList()
  {
    return $this->db->query('SELECT * FROM `user_membership_plan`  order by id desc')->result_array();
  }

  public function getMembershipListUser($id)
  {
    return $this->db->query("SELECT * FROM `user_membership_plan`  where plan_id='$id'")->result_array();
  }


}