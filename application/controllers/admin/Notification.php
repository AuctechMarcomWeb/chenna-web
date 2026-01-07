<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller {

	  public function __construct() {
      parent::__construct();
      $this->load->library('email');
      $this->load->library('session');
      $this->load->helper('message');
      $this->load->model('notification_model');
      // $this->load->library('GlobalClass');
      // $this->load->library('pagination');
    }

    public function index($value='')
    {
    	$data['index']     = 'Push';
		  $data['index2']    = '';
     	$data['title']     = 'Manage Push Notification';
     	$data['getData']   = $this->notification_model->GetAllNotification();
      /*echo "<pre>";*/
      /*print_r($data['getData']);
      exit;*/
     	
  		$this->load->view('include/header',$data);
  		$this->load->view('notification/listing');
  		$this->load->view('include/footer');
    	
    }

     public function Notification()
    {
      $data['index']     = 'Push';
      $data['index2']    = '';
      $data['title']     = 'Manage Push Notification';
      $data['getData']   = $this->notification_model->GetAllNotification();
      /*echo "<pre>";*/
      /*print_r($data['getData']);
      exit;*/
      
      $this->load->view('include/header',$data);
      $this->load->view('notification/notification');
      $this->load->view('include/footer');
      
    }

public function sentNotification( $id =''){
	$data = $this->input->post();
if($data['Notification_On']=='1'){
      $image='';
      $fileName  = $_FILES["uploadImage"]["name"];
      $extension = explode('.',$fileName);
      $extension = strtolower(end($extension));
      $uniqueName= 'notif_'.uniqid().'.'.$extension;
      $type      = $_FILES["uploadImage"]["type"];
      $size      = $_FILES["uploadImage"]["size"];
      $tmp_name  = $_FILES['uploadImage']['tmp_name'];
      $targetlocation= NOTIFICATION_URL.$uniqueName;
    if(!empty($fileName)){
      move_uploaded_file($tmp_name,$targetlocation);
      $image = utf8_encode(trim($uniqueName));
     }
      $data['image'] = ($image!='') ? $image :'';
  }else{
	 $image='';
      $fileName  = $_FILES["uploadImage1"]["name"];
      $extension = explode('.',$fileName);
      $extension = strtolower(end($extension));
      $uniqueName= 'notif_'.uniqid().'.'.$extension;
      $type      = $_FILES["uploadImage1"]["type"];
      $size      = $_FILES["uploadImage1"]["size"];
      $tmp_name  = $_FILES['uploadImage1']['tmp_name'];
      $targetlocation= NOTIFICATION_URL.$uniqueName;
    if(!empty($fileName)){
      move_uploaded_file($tmp_name,$targetlocation);
      $image = utf8_encode(trim($uniqueName));
     }
      $data['image'] = ($image!='') ? $image :'';   
  }


     if($data['Notification_On']=='1'){

      //echo '<pre>'; print_r($data);die();
       $check = $this->notification_model->pushNotificationSend($data);
       if ($check > 0) {
        $this->session->set_flashdata('activate', getCustomAlert('S','Push Notification has ben sent Successfully.'));
            redirect('admin/Notification'); 
       }
    }else if($data['Notification_On']=='2'){
		$check = $this->notification_model->pushSmsSend($data);
       if ($check > 0) {
        $this->session->set_flashdata('activate', getCustomAlert('S','Push SMS has ben sent Successfully.'));
            redirect('admin/Notification'); 
       }
	}else{
		$this->notification_model->pushSmsWithNotification($data);
	    $check = $this->notification_model->pushNotificationAndSms($data);
       if ($check > 0) {
        $this->session->set_flashdata('activate', getCustomAlert('S','Push Notification And SMS has ben sent Successfully.'));
            redirect('admin/Notification'); 
       }	
	}
	
}



    public function ResendNotification( $id ='12'){
       
      $data            = $this->db->query("SELECT * FROM `push_messge`  where  id = '".$id."'")->row_array();
      $data['message'] = $data['push_msg'];

       $check = $this->notification_model->pushNotificationSend($data);

       if ($check > 0) {
        $this->session->set_flashdata('activate', getCustomAlert('S','Push Notification has ben sent Successfully.'));
            /*redirect('admin/Notification');*/ 
       }else{
        $this->session->set_flashdata('activate', getCustomAlert('S','!Opps Something is worng.'));
            /*redirect('admin/Notification');*/
       }
    }



    public function View($id)
    {
      /*$sql =$this->db->query("SELECT * from `push_messge` where id= '".$id."'")->row_array();*/

      $data['index']     = 'Push';
      $data['index2']    = '';
      $data['title']     = 'View Notification';
      $data['getData']   = $this->notification_model->GetSingleNotification($id);
           
      $this->load->view('include/header',$data);
      $this->load->view('notification/ViewDetail');
      $this->load->view('include/footer');

    }

     public function changeStatus($id='')
     {
         
        $sql =$this->db->query("SELECT * from `push_messge` where id= '".$id."'")->row_array();
        $sql['status'];
        $arrayName=  array();
        $arrayName['status'] = ($sql['status']==1) ? '2' : '1'; 
        $this->db->where('id',$id);
        $this->db->update('push_messge',$arrayName);
        echo $arrayName['status'];
     }

}