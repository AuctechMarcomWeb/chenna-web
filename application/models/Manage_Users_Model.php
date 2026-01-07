<?php
class Manage_Users_Model extends CI_Model {
	 public function __construct(){
		parent::__construct();
		$this->load->database();
	}


  public function getUserList(){
    $this->db->order_by('id','desc');
    return $this->db->query('SELECT * FROM `user_master`  order by id desc ')->result_array();
  }

  public function getSingleUsersData($id)
    {
     
      return $this->db->get_where('user_master',array('id'=>$id))->row_array();
    }


  public function UpdateUsersData($request){

    $arrayName = array();
  
    $arrayName['status']                    = $request['status'];
    $arrayName['username']                  = $request['username'];
    $arrayName['email_id']                  = $request['email_id'];
    $arrayName['mobile']                    = $request['mobile'];
    $arrayName['whatsaap_number']           = $request['whatsaap_number'];
    $arrayName['alternate_number']          = $request['alternate_number'];
    $arrayName['address']                   = $request['address'];
    $arrayName['locality']                  = $request['locality'];
    $arrayName['city']                      = $request['city'];
    $arrayName['state']                     = $request['state'];
    $arrayName['pincode']                   = $request['pincode'];
  
      
    if (!empty($request['profile_pic'])) {
      $arrayName['profile_pic']    = $request['profile_pic'];
    }
      
     $arrayName['modify_date'] = time();
    
    /*print_r($arrayName); exit;*/

    /*print_r($arrayName); exit;*/
    $this->db->where('id',$request['id']);
    $this->db->update('user_master',$arrayName);

    return $this->db->affected_rows();
  }
 public function GetUserAddress($user_id ='') {
    return $this->db->query('SELECT * FROM `user_address_master` WHERE `user_master_id` = "'.$user_id.'" ORDER BY id DESC')->result_array();
}

  public function getSingleData($id ='',$table='',$field ='')
  {
     // echo "SELECT * FROM `user_address_master`  where `user_master_id` = ".$id." order by id desc" ; 
    $query =  $this->db->query('SELECT * FROM `'.$table.'`  where `id` = '.$id.' ')->row_array();
    return $query[$field];
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

    public function updateData($table,$data,$condition){
      $this->db->where($condition);
      $this->db->update($table,$data);   
      return 1;
  }


  //ratna code 
  public function getTotalOrders($user_id) {
    $this->db->from('order_master');
    $this->db->where('user_master_id', $user_id);
    return $this->db->count_all_results();
}
public function getTotalAmountSpent($user_id) {
    $this->db->select_sum('final_price'); // or 'total_price' if that's preferred
    $this->db->where('user_master_id', $user_id);
    $result = $this->db->get('order_master')->row();
    return $result->final_price ?? 0;
}


}