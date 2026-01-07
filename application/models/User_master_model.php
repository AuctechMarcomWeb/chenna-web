<?php
class User_master_model extends CI_Model {
	 public function __construct(){
		parent::__construct();
		$this->load->database();
	}


  // check user email already exist or not

    public function check_mobile($mobile)
    {
     return $this->db->get_where('user_master',array('mobile' => $mobile))->num_rows();


    }


public function add_wishlist_data($user_id, $pro_id)
{
    $check = $this->db->get_where('wish_list_master', [
        'user_id' => $user_id,
        'product_id' => $pro_id
    ])->num_rows();

    if ($check > 0) {
        return 'exists'; 
    } else {
        $data = [
            'user_id' => $user_id,
            'product_id' => $pro_id,
           
        ];
        $inserted = $this->db->insert('wish_list_master', $data);
        return $inserted ? 'added' : 'error';
    }
}














// check user email or password

    public function check_user($mobile)
    {
    	return $this->db->get_where('user_master',array('mobile' => $mobile))->row_array();
    }
    
   




}