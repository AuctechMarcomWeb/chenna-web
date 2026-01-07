<?php
class Transaction_model extends CI_Model {
	 public function __construct(){
		parent::__construct();
		$this->load->database();
	}
  # Admin login here

  

  public function GetTransactionList(){
    /*$sdate   = $this->session->userdata('sdate');
    $edate   = $this->session->userdata('edate');
    $filter  = $this->session->userdata('filter');
     if (!empty($sdate) || !empty($edate))
     {
        $start_date  = strtotime($sdate);
        $start_date1 = date('d-M-Y 00:00:00',$start_date);
        $date_from   = strtotime($start_date1);
        $end_date    = strtotime($edate);
        $end_date1   = date('d-M-Y 23:59:59',$end_date);
        $date_to     = strtotime($end_date1);
      }*/
      $sql = "SELECT * FROM transaction_history as TH left join fee_master as Fm  ON TH.`txn_id` = Fm.`transaction_id` WHERE TH.`type`='5'  ";
     /* if (!empty($sdate) || !empty($edate)) {
              $sql .=" AND modify_date BETWEEN ".$date_from." AND ".$date_to;
      }
       if (!empty($filter)) {
              $sql .=" AND status =".$filter;
      }*/
              $sql .= " ORDER BY TH.`id` desc";
              $query = $this->db->query($sql);
      return $query->result_array();
  	}

    public function GetSchoolTransactionList($id){
    /*$sdate   = $this->session->userdata('sdate');
    $edate   = $this->session->userdata('edate');
    $filter  = $this->session->userdata('filter');
     if (!empty($sdate) || !empty($edate))
     {
        $start_date  = strtotime($sdate);
        $start_date1 = date('d-M-Y 00:00:00',$start_date);
        $date_from   = strtotime($start_date1);
        $end_date    = strtotime($edate);
        $end_date1   = date('d-M-Y 23:59:59',$end_date);
        $date_to     = strtotime($end_date1);
      }*/
      $sql = "SELECT * FROM transaction_history as TH left join fee_master as Fm  ON TH.`txn_id` = Fm.`transaction_id` WHERE TH.`type`='5' AND `Fm`.school_id ='".$id."' ";
     /* if (!empty($sdate) || !empty($edate)) {
              $sql .=" AND modify_date BETWEEN ".$date_from." AND ".$date_to;
      }
       if (!empty($filter)) {
              $sql .=" AND status =".$filter;
      }*/
              $sql .= " ORDER BY TH.`id` desc";

              $query = $this->db->query($sql);
      return $query->result_array();
    }


    public function FetchSchoolTransactionList($limit='',$row='', $user_id="")
    {
      //print_r($_SESSION); exit;
      $sql = "SELECT TH.`id` as Thid, TH.`txn_id`,TH.`amount`,TH.`txn_id`,TH.`status` as THstatus, TH.`wallet_used_amount`,TH.`payment_amount`,TH.`status`,  Fm.*  FROM transaction_history as TH left join fee_master as Fm  ON TH.`txn_id` = Fm.`transaction_id` WHERE TH.`type`='5' And Fm.`school_id`='".$_SESSION ['adminData']['Id']."'";
      $sql .= " ORDER BY TH.`id` Desc LIMIT ".$row.",".$limit."";
    
    $query = $this->db->query($sql);
  
      return $query->result_array();
    }


    public function GetAllSchool(){
    	return $this->db->query("SELECT * FROM `school_master` WHERE status='1' AND published ='1'")->result_array();
    }

    public function getFee($txn_id='')
    {
     	return $this->db->query("SELECT * FROM `fee_master` where `transaction_id`='".$txn_id."'")->row_array();
    }


    public function GetSingleData($table='', $fieldname='', $fieldname2='', $txn_id='')
    {
     	$Query = $this->db->query("SELECT * FROM ".$table." where ".$fieldname." ='".$txn_id."'")->row_array();
     	return $Query[$fieldname2];
    }


    public function FetchData($limit='',$row='')
    {
    	$sql = "SELECT TH.`id` as Thid, TH.`txn_id`,TH.`amount`,TH.`txn_id`,TH.`status` as THstatus, TH.`wallet_used_amount`,TH.`payment_amount`,TH.`status`,  Fm.*  FROM transaction_history as TH left join fee_master as Fm  ON TH.`txn_id` = Fm.`transaction_id` WHERE TH.`type`='5'";
      $sql .= " ORDER BY TH.`id` Desc LIMIT ".$row.",".$limit."";
		
		$query = $this->db->query($sql);
  
      return $query->result_array();
    }


    public function GetTransactionDetail($id='')
	{
     	$query = $this->db->query("SELECT * FROM `transaction_history` WHERE id ='".$id."'")->row_array();

     	 return $query;
    }

    public function GetDataFeeMaster($id='')
	{
     	$query = $this->db->query("SELECT * FROM `fee_master` WHERE transaction_id ='".$id."'")->row_array();
     	 return $query;
    }


     public function GetInstallment($fee_mode='',$inst_month='')
     {
       if($fee_mode == 1 && $inst_month==1)
        {
          return $inst_month = 'Apr-Mar';
        }
       if($fee_mode==2 && $inst_month==1)
        {
          return $inst_month = 'Apr-Sept ';

        }
        if($fee_mode == 2 && $inst_month==2)
        {
           return $inst_month = 'Oct-Mar';
        }
        if($fee_mode == 3 && $inst_month==1)
        {
           return $inst_month = 'Apr-Jun';
        }
         if($fee_mode == 3 && $inst_month==2)
        {
           return $inst_month = 'Jul-Sept ';
        }
        if($fee_mode == 3 && $inst_month==3)
        {
           return $inst_month = ' Oct-Dec ';
        }
        if($fee_mode == 3 && $inst_month==4)
        {
           return $inst_month = 'Jan-Mar';
        }
        if($fee_mode == 4 && $inst_month==1)
        {
           return $inst_month = 'Janruray ';
        }
        if($fee_mode == 4 && $inst_month==2)
        {
           return $inst_month = 'Februray ';
        }
        if($fee_mode == 4 && $inst_month==3)
        {
           return $inst_month = 'March';
        }
        if($fee_mode == 4 && $inst_month==4)
        {
           return $inst_month = 'April';
        }
        if($fee_mode == 4 && $inst_month==5)
        {
           return $inst_month = 'May';
        }
        if($fee_mode == 4 && $inst_month==6)
        {
           return $inst_month = 'June';
        }
        if($fee_mode == 4 && $inst_month==7)
        {
           return $inst_month = 'July';
        }
        if($fee_mode == 4 && $inst_month==8)
        {
           return $inst_month = 'August';
        }
        if($fee_mode == 4 && $inst_month==9)
        {
           return $inst_month = 'September';
        }
        if($fee_mode == 4 && $inst_month==10)
        {
           return $inst_month = 'October';
        }
        if($fee_mode == 4 && $inst_month==11)
        {
           return $inst_month = 'November';
        }
        if($fee_mode == 4 && $inst_month==12)
        {
           return $inst_month = 'December';
        }
         
     }
}