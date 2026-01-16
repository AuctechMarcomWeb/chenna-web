<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EarningsDashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('EarningsDashboard_model');
        $this->load->library('session');
    }

    public function index()
    {
        $data['title'] = 'Earnings Dashboard';
        $adminData = $this->session->userdata('adminData');
        $data['adminData'] = $adminData;

        $filters = [
            'month'      => $this->input->get('month'),
            'from_date'  => $this->input->get('from_date'),
            'to_date'    => $this->input->get('to_date'),
         
            'promoter_id'=> $this->input->get('promoter_id'),
        ];

        $data['summary'] = $this->EarningsDashboard_model->getSummary($filters);
        $data['vendors'] = $this->EarningsDashboard_model->getVendors();

        $this->load->view('include/header', $data);
        $this->load->view('admin/earnings_dashboard', $data);
        $this->load->view('include/footer');
    }
}
