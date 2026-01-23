<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Subscription_model');
        $this->load->library('Email_send'); // custom email library
    }

    // ----------------------
    // Vendor/Promoter subscription request (AJAX)
    // ----------------------
    public function create()
    {
        $user_id = $this->input->post('user_id');
        $plan_id = $this->input->post('plan_id');
        $type = $this->input->post('type');

        if (!$user_id || !$plan_id || !in_array($type, ['vendor', 'promoter']))
        {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Invalid request']));
        }

        if ($this->Subscription_model->getPendingSubscriptionRequest($user_id, $type))
        {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'You already submitted a subscription request']));
        }

        $plan = $this->Subscription_model->getPlan($plan_id);
        if (!$plan)
        {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Invalid plan selected']));
        }

        $data = [
            ($type == 'vendor') ? 'vendor_id' : 'promoter_id' => $user_id,
            'plan_id' => $plan_id,
            'plan_type' => $plan['plan_type'],
            'price' => $plan['price'],
            'commission_percent' => ($plan['plan_type'] == 2) ? $plan['commission_percent'] : null,
            'product_limit' => (int) $plan['product_limit'],
            'products_used' => 0,
            'start_date' => date('Y-m-d'),
            'end_date' => ($plan['plan_type'] == 1) ? date('Y-m-d', strtotime('+1 month')) : null,
            'status' => 0,
            'approval_status' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($type == 'vendor')
        {
            $id = $this->Subscription_model->createVendorSubscription($data);
        } else
        {
            $id = $this->Subscription_model->createPromoterSubscription($data);
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'success',
                'message' => 'Your subscription request has been sent successfully',
                'id' => $id
            ]));
    }

    // ----------------------
    // Admin approve/reject subscription
    // ----------------------
    public function approve_plan_status()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $user_type = $this->input->post('user_type');

        if (!$id || !in_array($status, [1, 2]) || !in_array($user_type, ['vendor', 'promoter']))
        {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
            return;
        }
        // Fetch subscription
        $sub = $this->Subscription_model->getSubscriptionByType($id, $user_type);
        if (!$sub)
        {
            echo json_encode(['status' => 'error', 'message' => 'Subscription not found']);
            return;
        }
        // Fetch plan details
        $plan = $this->Subscription_model->getPlan($sub['plan_id']);

        $update = [
            'approval_status' => $status,
            'status' => ($status == 1 ? 1 : 0),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        if ($status == 1)
        {
            $today = date('Y-m-d');
            $current_end = isset($sub['end_date']) && strtotime($sub['end_date']) >= strtotime($today)
                ? $sub['end_date']
                : $today;
            $update['end_date'] = date('Y-m-d', strtotime('+1 month', strtotime($current_end)));
        }

        $this->Subscription_model->updateSubscription($id, $update, $user_type);
        if ($user_type == 'vendor')
        {
            $user = $this->db->get_where('vendors', ['id' => $sub['vendor_id']])->row_array();
        } else
        {
            $user = $this->db->get_where('promoters', ['id' => $sub['promoter_id']])->row_array();
        }
        if ($user && $status == 1)
        {
            $message = "Dear {$user['name']}, your subscription plan '{$plan['plan_name']}' has been approved and is now ACTIVE. Your plan ends on " . $update['end_date'] . ".";
            $this->email_send->send_email($user['email'], $message, 'Subscription Approved');
        }

        echo json_encode([
            'status' => 'success',
            'message' => $status == 1 ? 'Subscription approved successfully' : 'Subscription rejected successfully',
            'end_date' => $update['end_date']
        ]);
    }



    // ----------------------
    // Check if vendor has subscription
    // ----------------------
    public function check_vendor_subscription()
    {
        $vendor_id = $this->session->userdata('vendor_id');
        $sub = $this->Subscription_model->getVendorSubscription($vendor_id);

        echo json_encode(['show_popup' => $sub ? 0 : 1]);
    }

    // ----------------------
    // Plan management (Add/Update)
    // ----------------------
    public function addPlan()
    {
        if ($this->input->post())
        {
            $data = [
                'plan_name' => $this->input->post('plan_name'),
                'plan_type' => $this->input->post('plan_type'),
                'price' => $this->input->post('price'),
                'product_limit' => $this->input->post('product_limit'),
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('admin_subscription_plans_master', $data);
        }

        $data['plans'] = $this->db->where('status', 1)->order_by('id', 'DESC')->get('admin_subscription_plans_master')->result_array();
        $data['title'] = 'Manage Plan';
        $this->load->view('include/header', $data);
        $this->load->view('Vendor/AddPlan', $data);
        $this->load->view('include/footer');
    }

    public function UpdateaSubscriptionPlan($id)
    {
        $data['plan'] = $this->db->get_where('admin_subscription_plans_master', ['id' => $id])->row_array();
        $data['title'] = 'Update Subscription Plan';
        $this->load->view('include/header', $data);
        $this->load->view('Vendor/UpdateaSubscriptionPlan', $data);
        $this->load->view('include/footer');
    }

    public function updatePlanProcess()
    {
        $id = $this->input->post('id');
        $plan_type = $this->input->post('plan_type');

        if (empty($id) || empty($plan_type))
        {
            $this->session->set_flashdata('error', 'Invalid Request');
            redirect('Vendor/AddPlan');
        }

        $updateData = [
            'plan_name' => $this->input->post('plan_name'),
            'status' => $this->input->post('status')
        ];

        if ($plan_type == 1)
        {
            $updateData['price'] = (float) $this->input->post('price');
            $updateData['product_limit'] = (int) $this->input->post('product_limit');
            $updateData['commission_percent'] = NULL;
        }
        if ($plan_type == 2)
        {
            $updateData['price'] = NULL;
            $updateData['product_limit'] = NULL;
            $updateData['commission_percent'] = (float) $this->input->post('commission_percent');
        }

        $this->db->where('id', $id);
        $this->db->update('admin_subscription_plans_master', $updateData);

        $this->session->set_flashdata('success', $this->db->affected_rows() > 0
            ? 'Subscription Plan Updated Successfully'
            : 'No Changes Made');

        redirect('admin/Subscription/AddPlan');
    }

    public function subscription_list()
    {
        $today = date('Y-m-d');

        // Auto expire vendor subscriptions
        $this->db->where('approval_status', 1);
        $this->db->where('end_date <', $today);
        $this->db->update('vendor_subscriptions_master', ['status' => 0]);

        // Auto expire promoter subscriptions
        $this->db->where('approval_status', 1);
        $this->db->where('end_date <', $today);
        $this->db->update('promoter_subscriptions_master', ['status' => 0]);

        $data['subscriptions'] = $this->Subscription_model->subscription_list();
        $data['title'] = 'Subscriptions Plan List';

        $this->load->view('include/header', $data);
        $this->load->view('Vendor/subscription_list', $data);
        $this->load->view('include/footer');
    }
}
