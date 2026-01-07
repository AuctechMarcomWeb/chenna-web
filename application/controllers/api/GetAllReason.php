<?php
class GetAllReason extends CI_Controller
{
	 public function __construct(){
        parent::__construct();
        $this->load->model('api/Api_model');  
    }


public function index(){     
          if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
          } 
          if($_SERVER['REQUEST_METHOD']=='GET'){ 
            $this->getReason();
          }  
    }



public function getReason() {	
        $this->Api_model->getReason();

      }

}