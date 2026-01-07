<?php
class GetAllCategory extends CI_Controller
{
   public function __construct(){
        parent::__construct();
        $this->load->model('api/Api_model');  
    }


public function index() {     
          if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
          } 
          if($_SERVER['REQUEST_METHOD']=='GET'){ 
            $this->getAllCategory();
          }  
    }



public function getAllCategory() { 
        $this->Api_model->getAllCategory();

      }

}