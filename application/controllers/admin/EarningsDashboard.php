<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EarningsDashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('EarningsDashboard_model');
        $this->load->library('session');
    }

    public function index()
    {
        $adminData = $this->session->userdata('adminData');

        $filters = [
            'month'       => $this->input->get('month'),
            'from_date'   => $this->input->get('from_date'),
            'to_date'     => $this->input->get('to_date'),
            'vendor_id'   => $this->input->get('vendor_id'),
            'promoter_id' => $this->input->get('promoter_id'),
        ];

        $data['summary']   = $this->EarningsDashboard_model->getSummary($filters);
        $data['vendors']   = $this->EarningsDashboard_model->getVendors();
        $data['promoters'] = $this->EarningsDashboard_model->getPromoters();
        $data['adminData'] = $adminData;

        $this->load->view('include/header', $data);
        $this->load->view('admin/earnings_dashboard', $data);
        $this->load->view('include/footer');
    }

    /* ===== AJAX ===== */
    public function getSummaryAjax()
{
    $filters = $this->input->post();
    $data = $this->EarningsDashboard_model->getSummary($filters);
    echo json_encode($data);
}


    public function getVendorsByPromoter()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $promoter_id = $input['promoter_id'] ?? 0;

        $vendors = $this->db
            ->where('promoter_id', $promoter_id)
            ->get('vendors')
            ->result();

        echo json_encode($vendors);
    }
}
