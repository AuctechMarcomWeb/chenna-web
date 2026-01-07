<?php
class GetAllTag extends CI_Controller
{
	 public function __construct(){
        parent::__construct();
        $this->load->model('api/Api_model');  
    }


public function index(){     
          if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
          } 
          if($_SERVER['REQUEST_METHOD']=='GET'){ 
            $this->getTag();
          }  
    }



public function getTag() {	
        $this->Api_model->getTag();

      }

}