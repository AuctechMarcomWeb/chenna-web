<?php
class AppVersion extends CI_Controller
{
	 public function __construct(){
        parent::__construct();
        $this->load->model('api/Api_model');
        $this->load->helper('api');
    }


public function index(){ 
      if($_SERVER['REQUEST_METHOD']== POST){
           $this->getSystemVersion();
      } 

     if($_SERVER['REQUEST_METHOD']==GET){
      $this->getSystemVersion();

      }  
    }
   
    public function getSystemVersion(){


      $this->Api_model->getVersions();
    }

}