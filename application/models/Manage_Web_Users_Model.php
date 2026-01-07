<?php
class Manage_Web_Users_Model extends CI_Model {
	 public function __construct(){
		parent::__construct();
		$this->load->database();
	}


   public function addUserAddress($request){
    $arrayName = array();
    $arrayName['user_master_id']                     = $request['user_master_id'];
    $arrayName['name']                               = $request['name'];
    $arrayName['phone_no']                           = $request['phone_no'];
    $arrayName['pincode']                            = $request['pincode'];
    $arrayName['locality']                           = $request['landmark_optional'];
    $arrayName['area_streat_address']                = $request['area_streat_address'];
    $arrayName['district_city_town']                 = $request['district_city_town'];
    $arrayName['state_name']                         = $request['state_name'];
    $arrayName['landmark_optional']                  = $request['landmark_optional'];
    $arrayName['alternative_phone_optional']         = $request['alternative_phone_optional'];
    $arrayName['locality']                           = $request['locality'];
    $user_address_id                                 = $request['user_address_id'];
    $arrayName['status']                             = '1';
    $arrayName['add_date']                           = time();
    $arrayName['modify_date']                        = time();
    if(empty($user_address_id)):
     return $this->db->insert('user_address_master',$arrayName);
    else:
      $this->db->where('id',$user_address_id);
      return $this->db->update('user_address_master',$arrayName);
    endif;
  }
  


  public function UpdateUsersData($request){
    $arrayName = array();
    $arrayName['username']       = $request['nome'];
    $arrayName['email_id']       = $request['email'];
    $arrayName['dob']            = $request['dob'];
    $arrayName['gender']         = $request['gender'];
    if (!empty($request['profile_pic'])) {
      $arrayName['profile_pic']    = $request['profile_pic'];
    }
      
     $arrayName['modify_date'] = time();
    $this->db->where('phone_no',$request['mobile']);
   return $this->db->update('user_master',$arrayName);

  }
 
  


}