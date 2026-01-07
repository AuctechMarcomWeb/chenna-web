<?php
class GetUserDetail_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $this->load->database();  
  }
  
  public function GetUserDetail($user_id ='')
  {
    $SQL = $this->db->query("SELECT *  FROM `user_master` where id ='".$user_id."' ")->row_array();

      $arrayName = array();
      $arrayName['uuid']          = $SQL['uuid'];
      $arrayName['username']      = $SQL['username'];
      $arrayName['email_id']      = $SQL['email_id'];
      $arrayName['gender']        = $SQL['gender'];

      $arrayName['profile_pic']   = ($SQL['profile_pic']!='')? IMAGE_URL."profile_image/".$SQL['profile_pic'] : IMAGE_URL."profile_image/".$SQL['profile_pic'] ;
      $arrayName['phone_no']      = $SQL['phone_no'];
      $arrayName['status']        = $SQL['status'];
     $arr['user_detail']= $arrayName;
     return $arr;
    }

   

  

}