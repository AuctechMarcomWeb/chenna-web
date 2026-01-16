<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Subscription_model');
       
        $this->load->library('Email_send'); // your email library
    }

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

        $data['plans'] = $this->db
            ->where('status', 1)
            ->order_by('id', 'DESC')
            ->get('admin_subscription_plans_master')
            ->result_array();

        $data['title'] = 'Manage Plan';
        $this->load->view('include/header', $data);
        $this->load->view('Vendor/AddPlan', $data);
        $this->load->view('include/footer');
    }



    // Admin: List subscriptions
    public function subscription_list()
    {
        $data['subscriptions'] = $this->Subscription_model->getAllSubscriptions();
        $data['title'] = 'Subscription List';
        $this->load->view('include/header', $data);
        $this->load->view('Vendor/subscription_list', $data);
        $this->load->view('include/footer');
    }

    // Admin approves subscription

    public function check_vendor_subscription()
    {
        $vendor_id = $this->session->userdata('vendor_id');

        $sub = $this->db->get_where('vendor_subscriptions_master', [
            'vendor_id' => $vendor_id
        ])->row_array();

        if ($sub)
        {
            echo json_encode(['show_popup' => 0]); // Already purchased
        } else
        {
            echo json_encode(['show_popup' => 1]); // No plan yet
        }
    }

    public function aprrove_plan_status()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');

        $sub = $this->Subscription_model->getSubscription($id);
        if (!$sub)
        {
            echo json_encode(['status' => 'error', 'message' => 'Subscription not found']);
            return;
        }

        // ================= APPROVE =================
        if ($status == 1)
        {
            $update = [
                'approval_status' => 1,
                'status' => 1,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->Subscription_model->updateSubscription($id, $update);

            // Send email notification
            $vendor = $this->db->get_where('vendors', ['id' => $sub['vendor_id']])->row_array();
            if ($vendor)
            {
                $plan = $this->Subscription_model->getPlan($sub['plan_id']);
                $message = "Dear {$vendor['name']}, your subscription plan '{$plan['plan_name']}' is now ACTIVE!";
                $this->load->library('Email_send');
                $this->email_send->send_email($vendor['email'], $message, 'Subscription Approved');
            }

            echo json_encode(['status' => 'success', 'message' => 'Subscription approved & email sent']);
            return;
        }

        // ================= REJECT =================
        if ($status == 2)
        {
            $this->Subscription_model->updateSubscription($id, [
                'approval_status' => 2,
                'status' => 0,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            echo json_encode(['status' => 'success', 'message' => 'Subscription rejected']);
            return;
        }
    }


    // Vendor: submit subscription request (AJAX)
    public function create()
    {
        $vendor_id = $this->input->post('vendor_id');
        $plan_id = $this->input->post('plan_id');

        $this->load->model('Subscription_model');

        $existing = $this->Subscription_model->getPendingSubscriptionRequest($vendor_id);
        if ($existing)
        {
            echo json_encode(['status' => 'error', 'message' => 'You already submitted a subscription request']);
            return;
        }


        $plan = $this->Subscription_model->getPlan($plan_id);

        $data = [
            'vendor_id' => $vendor_id,
            'plan_id' => $plan_id,
            'price' => $plan['price'],
            'plan_type' => $plan['plan_type'],
            'product_limit' => ($plan['plan_type'] == 1) ? $plan['product_limit'] : null,
            'start_date' => date('Y-m-d'),
            'end_date' => ($plan['plan_type'] == 1) ? date('Y-m-d', strtotime('+1 month')) : null,
            'status' => 0,
            'approval_status' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->Subscription_model->createSubscription($data);
        echo json_encode(['status' => 'success', 'message' => 'Subscription request sent to Admin']);
    }




    public function UpdateaSubscriptionPlan($id)
    {
        $data['plan'] = $this->db
            ->get_where('admin_subscription_plans_master', ['id' => $id])
            ->row_array();

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

        if ($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('success', 'Subscription Plan Updated Successfully');
        } else
        {
            $this->session->set_flashdata('error', 'No Changes Made');
        }

        redirect('admin/Subscription/AddPlan');
    }



}
