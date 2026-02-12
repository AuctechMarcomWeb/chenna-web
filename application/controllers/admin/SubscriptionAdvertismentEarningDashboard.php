<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubscriptionAdvertismentEarningDashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('SubscriptionAdvertismentEarningDashboard_model');
    }

    public function index()
    {
        $filters = [
            'month' => $this->input->get('month'),
            'from_date' => $this->input->get('from_date'),
            'to_date' => $this->input->get('to_date'),
            'vendor_id' => $this->input->get('vendor_id'),
            'promoter_id' => $this->input->get('promoter_id'),
            'type' => $this->input->get('type') // 'subscription', 'advertisement', or empty
        ];

        $data['summary'] = $this->SubscriptionAdvertismentEarningDashboard_model->getSummary($filters);
        $data['vendors'] = $this->SubscriptionAdvertismentEarningDashboard_model->getVendors();
        $data['promoters'] = $this->SubscriptionAdvertismentEarningDashboard_model->getPromoters();

        $this->load->view('include/header', $data);
        $this->load->view('admin/SubscAdvertismentEarning', $data);
        $this->load->view('include/footer');
    }

    // AJAX: fetch summary for filters
    public function getSummaryAjax()
    {
        $filters = [
            'month' => $this->input->post('month'),
            'from_date' => $this->input->post('from_date'),
            'to_date' => $this->input->post('to_date'),
            'type' => $this->input->post('type'),
            'subscription_type' => $this->input->post('subscription_type'),
            'vendor_id' => $this->input->post('vendor_id'),
            'promoter_id' => $this->input->post('promoter_id')
        ];

        $data = $this->SubscriptionAdvertismentEarningDashboard_model->getSummary($filters);

        echo json_encode($data);
    }


    // AJAX: fetch vendors by promoter
    public function getVendorsByPromoter()
    {
        $promoter_id = json_decode(file_get_contents('php://input'), true)['promoter_id'] ?? null;
        $vendors = $this->SubscriptionAdvertismentEarningDashboard_model->getVendorsByPromoter($promoter_id);
        echo json_encode($vendors);
    }
}
