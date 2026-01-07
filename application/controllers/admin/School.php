<?php defined('BASEPATH') OR exit('No direct script access allowed');

class School extends CI_Controller {

	  public function __construct() {
      parent::__construct();
      $this->load->library('email');
      $this->load->library('session');
      $this->load->helper('message');
      $this->load->model('school_model');
      // $this->load->library('GlobalClass');
      // $this->load->library('pagination');
    }

    public function index()
    {
    	$this->load->view('/admin/login');
    }

    public function GetAdminProfile($id='')
	{

    	$data['index']      = 'index';
    	$data['index2']     = '';
		$data['title']      = 'Update Profile';
    	$data['getData'] 	= $this->school_model->GetAdminData($id);
    	$this->load->view('include/header',$data);      
		$this->load->view('School/update_profile'); 
		$this->load->view('include/footer');

	}


	public function AddFee()
	{  
		$data['index']      = 'index';
    	$data['index2']     = '';
		$data['title']      = 'Add Fee';
		$data['class_id']  	=  $this->uri->segment('5');
    	$this->load->view('include/header',$data);      
		$this->load->view('School/add_fee'); 
		$this->load->view('include/footer');


	 	# code...
	}

	public function ForgetPassword()
	{
		$sql=  $this->db->query(" SELECT * FROM `school_master` where email ='".$_POST['email']."'")->row_array();
		if($sql>0)
		{
			$smsmessage = "Your Password Is  :".base64_decode($sql['password']);
 			$sendmail = $this->sentEmailInfo($sql['email'],$smsmessage);

 			/*echo $sendmail;
 			print_r($sendmail);
 			 exit;*/
 			echo  1 ;
		}else{
			echo  0 ;
		}
	}

	public function publishedStatus($id='')
	{
		//echo $id;
		$id = $this->uri->segment(4);
	  	$sql =$this->db->query("SELECT * from `school_master` where id= '".$id."'")->row_array();
		//$sql['published'];
		$arrayName=  array();
		$arrayName['published'] = ($sql['published']==1) ? '2' : '1'; 
	  	$this->db->where('id',$id);
	    $this->db->update('school_master',$arrayName);
	    echo $arrayName['published'];
	}

	public function sentEmailInfo($email,$smsmessage){
                // ++++++++++++++
              $to      = $email;
              $subject = "Forget Password";
              $message ="Your Password For School Panel\r\n";
              $message.="\r\n";
              $message.="&nbsp;".$smsmessage."\r\n";
              $message .="Note - This is a System Generated Mail, please do not reply.\r\n";
              $headers = "From:"."support@dukekart.in"."\r\n";
              $headers .= "MIME-Version: 1.0\r\n";
              $headers .= "Content-type: text/html; charset=utf-8\r\n";
              mail($to,$subject,'<pre style="font-size:14px;">'.$message.'</pre>',$headers);

             
      }

	public function ClassFee($branch_id='',$class_id="")
	{
	 	$data = $this->input->post();
	 	
		 if(count($data)>0)
		 {
			$row  = $this->school_model->AddClassFee($data,$branch_id,$class_id);
		 } else {
		 $this->session->set_flashdata('activate',getCustomAlert('D','Invaild entry.'));
         redirect('admin/school/AddFee/'.$branch_id.'/'.$class_id);
		 }
      	if($row >0 ){
      		$this->session->set_flashdata('activate', getCustomAlert('S',' Class Fee Added Successfully.'));
          redirect('admin/school/AddClassSection/'.$branch_id);
      	}else{

      	 $this->session->set_flashdata('activate', getCustomAlert('W','!Opps Something is worng.Please try again.'));
         redirect('admin/school/AddClassSection/'.$branch_id);
      	}
	}


	public function UpdateClassFee($branch_id='',$class_id='')
	{
		$data = $this->input->post();
		 echo "<pre>";
		/* print_r($data);exit;*/

		 if(count($data)>0)
		 {
			$row  = $this->school_model->UpdateClassFee($data,$branch_id,$class_id);
		 } else {
		 $this->session->set_flashdata('activate',getCustomAlert('D','Invaild entry.'));
         redirect('admin/school/ViewFee/'.$branch_id.'/'.$class_id);
		 }
    	
      	if($row >0 ){
      		$this->session->set_flashdata('activate', getCustomAlert('S','Fee Detail Updated Successfully.'));
          redirect('admin/school/AddClassSection/'.$branch_id);
      	}else{

      	 $this->session->set_flashdata('activate', getCustomAlert('W','!Opps Something is worng.Please try again.'));
         redirect('admin/school/AddClassSection/'.$branch_id);
      	}
	}


	public function ViewFee($branch_id ='', $class_id='')
	{
	 
		$data['index']      = ($_SESSION['adminData']['Type']=='3') ? 'index' :'School';
    	$data['index2']     = '';
		$data['title']      = 'View Fee';
		$data['branch_id']  =  $this->uri->segment('4');
		$data['class_id']  	=  $this->uri->segment('5');
		$data['getdata']    = $this->school_model->GetFeeDetail($data['branch_id'],$data['class_id']);
		 //print_r($data['getdata']); exit;
    	$this->load->view('include/header',$data);      
		$this->load->view('School/view_fee'); 
		$this->load->view('include/footer');


	}
	
    public function UpdateProfile($id)
	{
		$data = $this->input->post();

		$data['id'] = $id;

		$fileName  = $_FILES["uploadFile"]["name"];
		$extension = explode('.',$fileName);
		$extension = strtolower(end($extension));
		$uniqueName= 'User_'.uniqid().'.'.$extension;
		$type      = $_FILES["uploadFile"]["type"];
		$size      = $_FILES["uploadFile"]["size"];
		$tmp_name  = $_FILES['uploadFile']['tmp_name'];
		$targetlocation= PROFILE_DIRECTORY.$uniqueName;

		if(!empty($fileName)){
		move_uploaded_file($tmp_name,$targetlocation);
		$data['profile_pic'] = utf8_encode(trim($uniqueName));
		}

    	$row  = $this->school_model->UpdateProfile($data);
      	if($row >0 ){
      		$this->session->set_flashdata('activate', getCustomAlert('S','Profile Updated.'));
          redirect('admin/school/GetAdminProfile/'.$data['id']);
      	}else{

      	 $this->session->set_flashdata('activate', getCustomAlert('W','!Opps Something is worng.Please try again.'));
         redirect('admin/school/GetAdminProfile/'.$data['id']);
      	}
    }


    public function AddClassSection($branch_id)
    {
    	 
    	$data['index']         = ($_SESSION['adminData']['Type']=='3') ? 'index' :'School';
		$data['index2']        = '';
     	$data['title']         = 'Manage Class & Section';
     	$data['getdata']	   =  $this->school_model->GetBranchClass($branch_id);

     	$data['school_name']   =  $this->GetSchoolName($_SESSION['adminData']['Id']);
     	
          	
		$this->load->view('include/header',$data);
		$this->load->view('School/class_list');
		$this->load->view('include/footer');
    }
     public function GetSchoolName($sch_id='')
     {
      	$Sql = $this->db->query("SELECT * FROM `school_master` Where id='".$sch_id."'")->row_array();
      	return $Sql['school_name'];
     }

    public function AddClass($id ="")
    {
    	
    	$data['index']        	 = 'index';
		$data['index2']        	 = '';
     	$data['title']         	 = 'Add Class & Section';
     	//$data['branch_list']   	 =  $this->school_model->GetSchoolALlBranch2($id);
     	
		$this->load->view('include/header',$data);
		$this->load->view('School/addclass');
		$this->load->view('include/footer');
    }

    public function UpdateClass($id ="")
    {
    	
    	$data['index']        	 = 'index';
		$data['index2']        	 = '';
     	$data['title']         	 = 'Add Class & Section';
     	$data['getData']   	 	 = $this->school_model->GetSingleClassData($id);
     	$data['section']         = $this->school_model->GetClassSections($id);
     /*	echo "<pre>";
     	print_r($data['section']); exit;*/
     	
		$this->load->view('include/header',$data);
		$this->load->view('School/update_class');
		$this->load->view('include/footer');
    }

    public function AddClassBranch($id ="")
    {
    	
    	$data = $this->input->post();
    	$row  = $this->school_model->AddClassBranchData($data);
	      	if($row >0 ){
	      		$this->session->set_flashdata('activate', getCustomAlert('S','Class Added Successfully.'));
	          redirect($data['site']);
	      	}else{

	      	 $this->session->set_flashdata('activate', getCustomAlert('W','!Opps Something is worng.Please try again.'));
	         redirect($data['site']);
	      	}
    }

    public function UpdateClassBranch($id='')
    {
    	$data = $this->input->post();
    	$data['id'] = $id;

    	$row  = $this->school_model->UpdateClassBranchData($data);
	      	if($row >0 ){
	      		$this->session->set_flashdata('activate', getCustomAlert('S','Class Details Updated Successfully.'));
	          redirect($data['site']);
	      	}else{

	      	 $this->session->set_flashdata('activate', getCustomAlert('W','!Opps Something is worng.Please try again.'));
	         redirect($data['site']);
	      	}

    	
    }

	public function listing()
	{
		is_not_logged_in();
		
		$data['index']         = 'School';
		$data['index2']        = '';
     	$data['title']         = 'Manage School';
     	$data['getdata']	   = $this->school_model->getAllSchool();
     	//echo "<pre>"; print_r($data['getdata']); exit;
		$this->load->view('include/header',$data);
		$this->load->view('School/school_list');
		$this->load->view('include/footer');
	}

	public function AddSchool()
	{
		
		$data['index']         = 'School';
		$data['index2']        = '';
     	$data['title']         = 'Manage School';	
		$this->load->view('include/header',$data);
		$this->load->view('School/add_school');
		$this->load->view('include/footer');
	}


	public function AddNewSchool()
	{
	    $data = $this->input->post();

	    $row  = $this->school_model->AddNewSchoolData($data);
	      if($row !='2'){
	      	if($row >0 ){
	      		
	         $this->session->set_flashdata('activate', getCustomAlert('S',' School added Successfully.'));
	          redirect('admin/School/listing');
	      	}else{

	      		
	      	 $this->session->set_flashdata('activate', getCustomAlert('W','!Opps Something is worng.Please try again.'));
	         redirect('admin/School/listing');
	      	}
	        }else {
	        	
	        $this->session->set_flashdata('activate', getCustomAlert('W','!Opps This Email-id Alresdy Exsist , please use another Email-id .'));
	         redirect('admin/School/listing');
	        }
		
	}

	 public function ViewSchool($id)
	 {
	 	$data['index']         = 'School';
		$data['index2']        = '';
     	$data['title']         = 'Manage School';
     	$data['getdata']	   = $this->school_model->SingleSchoolData($id);
     	
		$this->load->view('include/header',$data);
		$this->load->view('School/update_school');
		$this->load->view('include/footer');
	}



	public function UpdateSchool($id)
	{

		$data = $this->input->post();
	    $data['id'] = $id;

	    $row  = $this->school_model->updateSchoolData($data);
	     
	      	if($row >0 ){
	      		
	         $this->session->set_flashdata('activate', getCustomAlert('S',' School detail has been Updated.'));
	          redirect('admin/School/listing');
	      	}else{

	      	 $this->session->set_flashdata('activate', getCustomAlert('W','!Opps Something is worng.Please try again.'));
	         redirect('admin/School/listing');
	      	}
	        
	}

	public function BranchList($id)
	 {
	 	$data['index']         = 'School';
		$data['index2']        = '';
     	$data['title']         = 'Manage School';
     	$data['getdata']	   = $this->school_model->GetSchoolALlBranch($id);

     	//print_r($data['getdata']); exit;
     	
		$this->load->view('include/header',$data);
		$this->load->view('School/branch_list');
		$this->load->view('include/footer');
	 }

	 public function AddBranch()
	 {
	 	$data['index']         = 'School';
		$data['index2']        = '';
     	$data['title']         = 'Manage School';
     	//$data['getdata']	   = $this->school_model->SingleSchoolData($id);
     	
		$this->load->view('include/header',$data);
		$this->load->view('School/add_branch');
		$this->load->view('include/footer');
	 }


	public function CheckEmailExist()
	 {
		//echo $value;
		 		 
	 	$SQL = $this->db->query("SELECT * FROM `school_master` where email = '".$_POST['email']."'")->num_rows();
	 	echo  	 $SQL;
	 	
	 	 // echo  ($SQL > 0 ) ? '1' :' 0';

	 } 

	public function NumberOfBranches($value)
	{
		return $this->db->query("SELECT * FROM `branch_master` Where school_master_id='".$value."' AND status = '1' ")->num_rows();
	}
	

	 public function changeStatus($id)
	 {
	 	$id = $this->uri->segment(4);
	  	$sql =$this->db->query("SELECT * from `school_master` where id= '".$id."'")->row_array();
		$sql['status'];
		$arrayName=  array();
		$arrayName['status'] = ($sql['status']==1) ? '2' : '1'; 
	  	$this->db->where('id',$id);
	    $this->db->update('school_master',$arrayName);
	    echo $arrayName['status'];

	 }

 	public function BranchStatus($id)
	{
	 	$id = $this->uri->segment(4);
	  	$sql =$this->db->query("SELECT * from `branch_master` where id= '".$id."'")->row_array();
		$sql['status'];
		$arrayName=  array();
		$arrayName['status'] = ($sql['status']==1) ? '2' : '1'; 
	  	$this->db->where('id',$id);
	    $this->db->update('branch_master',$arrayName);
	    echo $arrayName['status'];

	}

	public function AddNewBranch($schoolid)
	{
		$data= $this->input->post();
		$data['school_master_id'] = $schoolid;
		$row = $this->school_model->AddNewBranch($data);
		if($row > 0 )
		{
			$this->session->set_flashdata('activate', getCustomAlert('S',' School Branch added Successfully.'));
			redirect('admin/School/listing');
		}else{

			$this->session->set_flashdata('activate', getCustomAlert('W','!Opps Something is worng.Please try again.'));
			redirect('admin/School/listing');
		}

	}


	public function UpdateBranch()
	{
	 	$data['index']         = 'School';
		$data['index2']        = '';
     	$data['title']         = 'Update Branch';

     	$data['getdata']	   = $this->school_model->SingleBranchData($this->uri->segment('5'));
     	 /*print_r($data['getdata']);
     	*/
		$this->load->view('include/header',$data);
		$this->load->view('School/update_branch');
		$this->load->view('include/footer');
	}

	 public function ClassStatus($id)
	 {
	 	
	  	$sql =$this->db->query("SELECT * from `class_master` where id= '".$id."'")->row_array();
		$sql['status'];
		$arrayName=  array();
		$arrayName['status'] = ($sql['status']==1) ? '2' : '1'; 
	  	$this->db->where('id',$id);
	    $this->db->update('class_master',$arrayName);
	    echo $arrayName['status'];

	 }


	public function UpdateBranchData()
	{
		$data= $this->input->post();
		/*print_r($data); exit;
		$pre_site = $data['pre_site'];
		echo $pre_site; exit;*/
		$data['id'] = $this->uri->segment('5');

		/*print_r($data); exit;*/
		$row = $this->school_model->UpdateBranchData($data);
		if($row > 0 )
		{
			$this->session->set_flashdata('activate', getCustomAlert('S',' School Branch has been Updated Successfully.'));
			redirect('admin/School/listing');
		}else{

			$this->session->set_flashdata('activate', getCustomAlert('W','!Opps Something is worng.Please try again.'));
			redirect('admin/School/listing');
		}

	}


}