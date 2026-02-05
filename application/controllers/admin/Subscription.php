<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Subscription_model');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function create_subscription()
    {
        $user_id = $this->input->post('user_id');
        $plan_id = $this->input->post('plan_id');
        $user_type = $this->input->post('user_type');

        if (!$user_id || !$plan_id)
        {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
            return;
        }

        if ($this->Subscription_model->getPendingSubscriptionRequest($user_id, $user_type))
        {
            echo json_encode(['status' => 'error', 'message' => 'You already have a pending request']);
            return;
        }

        $plan = $this->Subscription_model->getPlan($plan_id);
        if (!$plan)
        {
            echo json_encode(['status' => 'error', 'message' => 'Invalid plan selected']);
            return;
        }

        $merchant_txn_id = 'SUB' . date('YmdHis') . rand(1000, 9999);
        if ($plan['plan_type'] == 2)
        {
            $status = 1;
            $approval_status = 1;
            $payment_status = 'activated';
        } else
        {
            $status = 0;
            $approval_status = 0;
            $payment_status = 'pending';
        }

        $data = [
            ($user_type == 'vendor') ? 'vendor_id' : 'promoter_id' => $user_id,
            'plan_id' => $plan_id,
            'plan_type' => $plan['plan_type'],
            'price' => $plan['price'],
            'commission_percent' => $plan['plan_type'] == 2 ? $plan['commission_percent'] : null,
            'product_limit' => $plan['product_limit'],
            'products_used' => 0,
            'start_date' => date('Y-m-d'),
            'end_date' => $plan['plan_type'] == 1 ? date('Y-m-d', strtotime('+1 month')) : null,
            'status' => $status,
            'approval_status' => $approval_status,
            'transaction_id' => $merchant_txn_id,
            'payment_status' => $payment_status,
            'payment_type' => 2,
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($user_type == 'vendor')
        {
            $id = $this->Subscription_model->createVendorSubscription($data);
        } else
        {
            $id = $this->Subscription_model->createPromoterSubscription($data);
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Subscription initiated successfully',
            'merchant_txn_id' => $merchant_txn_id,
            'amount' => $plan['price']
        ]);
    }


    public function update_subscription()
    {
        $vendor_id = $this->input->post('user_id');
        $plan_id = $this->input->post('plan_id');
        $promoter_id = $this->input->post('promoter_id');
        $user_type = $this->input->post('user_type');

        if (!$vendor_id || !$plan_id || !$user_type)
        {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
            return;
        }

        $plan = $this->Subscription_model->getPlan($plan_id);
        if (!$plan)
        {
            echo json_encode(['status' => 'error', 'message' => 'Invalid plan']);
            return;
        }

        $txn_id = 'SUB' . time() . rand(100, 999);
        $start_date = date('Y-m-d');
        $end_date = ($plan['plan_type'] == 1) ? date('Y-m-d', strtotime('+1 month')) : null;

        $data = [
            'plan_id' => $plan_id,
            'plan_type' => $plan['plan_type'],
            'price' => $plan['price'],
            'commission_percent' => $plan['commission_percent'],
            'product_limit' => $plan['product_limit'],
            'products_used' => 0,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'status' => ($plan['plan_type'] == 1) ? 0 : 1,
            'approval_status' => ($plan['plan_type'] == 1) ? 0 : 1,
            'transaction_id' => $txn_id,
            'payment_status' => ($plan['plan_type'] == 1) ? 'pending' : 'activated',
            'payment_type' => 2,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Check if vendor already has a subscription
        $existing = $this->db->where('vendor_id', $vendor_id)->get('vendor_subscriptions_master')->row_array();

        if ($existing)
        {
            // Update existing subscription
            $this->db->where('vendor_id', $vendor_id)->update('vendor_subscriptions_master', $data);
        } else
        {
            // Create new subscription
            $data['vendor_id'] = $vendor_id;
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('vendor_subscriptions_master', $data);
        }

        echo json_encode([
            'status' => 'success',
            'merchant_txn_id' => $txn_id,
            'amount' => $plan['price']
        ]);
    }


    public function response()
    {
        $this->session->set_flashdata(
            'success',
            'Payment processed. Subscription will be activated shortly.'
        );

        redirect('admin/dashboard');
    }


    public function phonepe_callback()
    {
        $rawData = file_get_contents("php://input");
        $response = json_decode($rawData, true);

        log_message('error', 'PhonePe Callback: ' . $rawData);

        if (empty($response['data']['merchantTransactionId']))
        {
            return;
        }

        $merchantTxnId = $response['data']['merchantTransactionId'];
        $code = $response['code'];
        $state = $response['data']['state'];

        $isSuccess = ($code === 'PAYMENT_SUCCESS' && $state === 'COMPLETED');

        // ===== Vendor Subscription =====
        $vendor_sub = $this->db
            ->where('transaction_id', $merchantTxnId)
            ->get('vendor_subscriptions_master')
            ->row_array();

        if ($vendor_sub)
        {
            $updateData = [
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if ($isSuccess)
            {
                $updateData['status'] = 1;
                $updateData['payment_status'] = 'paid';
                $updateData['approval_status'] = 1;
            } else
            {
                $updateData['payment_status'] = 'failed';
            }

            $this->db->where('id', $vendor_sub['id'])
                ->update('vendor_subscriptions_master', $updateData);

            return;
        }

        // ===== Promoter Subscription =====
        $promoter_sub = $this->db
            ->where('transaction_id', $merchantTxnId)
            ->get('promoter_subscriptions_master')
            ->row_array();

        if ($promoter_sub)
        {
            $updateData = [
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if ($isSuccess)
            {
                $updateData['status'] = 1;
                $updateData['payment_status'] = 'paid';
                $updateData['approval_status'] = 1;
            } else
            {
                $updateData['payment_status'] = 'failed';
            }

            $this->db->where('id', $promoter_sub['id'])
                ->update('promoter_subscriptions_master', $updateData);
        }
        if (strpos($merchantTxnId, 'PERPROD') === 0)
        {
            $perProdSub = $this->db
                ->where('transaction_id', $merchantTxnId)
                ->get('vendor_subscriptions_master')
                ->row_array();

            if (!$perProdSub)
            {
                $perProdSub = $this->db
                    ->where('transaction_id', $merchantTxnId)
                    ->get('promoter_subscriptions_master')
                    ->row_array();
            }

            if ($perProdSub)
            {
                $this->db->where('id', $perProdSub['id'])
                    ->update(isset($perProdSub['vendor_id']) ? 'vendor_subscriptions_master' : 'promoter_subscriptions_master', [
                        'status' => 1,
                        'approval_status' => 1,
                        'payment_status' => 'activated',
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
            }
        }
    }


    // Agar payment fail ho jaye
    public function fail()
    {
        $this->session->set_flashdata('error', 'Payment failed. Please try again.');
        redirect('admin/dashboard');
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
    public function check_active_plan()
    {
        $user_id = $this->input->post('user_id');
        $user_type = $this->input->post('user_type');

        if ($user_type == 'vendor')
        {
            $plan = $this->db->where(['vendor_id' => $user_id, 'status' => 1])->get('vendor_subscriptions_master')->row_array();
        } else
        {
            $plan = $this->db->where(['promoter_id' => $user_id, 'status' => 1])->get('promoter_subscriptions_master')->row_array();
        }

        echo json_encode(['has_plan' => !empty($plan)]);
    }


    // Advertisment Plan
    public function AdvertismentUpdatePlan()
    {
        if ($this->input->post())
        {
            $data = [
                'plan_name' => $this->input->post('plan_name'),
                'price' => $this->input->post('price'),
                'duration_days' => $this->input->post('duration_days'),
                'product_limit' => $this->input->post('product_limit'),
                'hot_deal' => $this->input->post('hot_deal') ?? 0,
                'featured_product' => $this->input->post('featured_product') ?? 0,
                'banner' => $this->input->post('banner') ?? 0,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->db->insert('admin_advertisement_plans_master', $data);
            $this->session->set_flashdata('success', 'Plan added successfully.');
            redirect('admin/AdvertismentUpdatePlan'); // Reload page
        }

        // Fetch all active plans
        $data['plans'] = $this->db
            ->where('status', 1)
            ->order_by('id', 'DESC')
            ->get('admin_advertisement_plans_master')
            ->result_array();

        $data['title'] = 'Manage Advertisement Plans';
        $this->load->view('include/header', $data);
        $this->load->view('admin/AdvertismentUpdatePlan', $data);
        $this->load->view('include/footer');
    }

    public function UpdateadvertismentPlan($id)
    {
        $data['plan'] = $this->db->get_where('admin_advertisement_plans_master', ['id' => $id])->row_array();
        $data['title'] = 'Update Advertisement Plan';

        $this->load->view('include/header', $data);
        $this->load->view('admin/UpdateadvertismentPlan', $data);
        $this->load->view('include/footer');
    }

    public function updateadvertismentPlans()
    {
        $data = $this->input->post();

        $updateData = [
            'plan_name' => $data['plan_name'],
            'price' => $data['price'] ?? 0,
            'duration_days' => $data['duration_days'] ?? 0,
            'product_limit' => $data['product_limit'] ?? 0,
            'hot_deal' => isset($data['hot_deal']) ? 1 : 0,
            'featured_product' => isset($data['featured_product']) ? 1 : 0,
            'banner' => isset($data['banner']) ? 1 : 0,
            'status' => $data['status'],
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->where('id', $data['id']);
        $this->db->update('admin_advertisement_plans_master', $updateData);

        $this->session->set_flashdata('message', 'Advertisement Plan Updated Successfully!');
        redirect('admin/Subscription/AdvertismentUpdatePlan');
    }


    public function AdvertismentSelectPlan()
    {
        $adminData = $this->session->userdata('adminData');

        // Fetch all active plans
        $data['plans'] = $this->db
            ->where('status', 1)
            ->order_by('plan_type', 'ASC')
            ->get('admin_advertisement_plans_master')
            ->result_array();

        $data['adminData'] = $adminData; // needed for JS
        $data['title'] = 'Advertisement Plans';

        $this->load->view('include/header', $data);
        $this->load->view('admin/AdvertismentSelectPlan', $data);
        $this->load->view('include/footer');
    }


   public function check_user_plan()
{
    $user_id = $this->input->post('user_id');
    $user_type = $this->input->post('user_type');

    $this->db->where('user_id', $user_id);
    $this->db->where('user_type', $user_type);
    $this->db->where('status', 1);
    $this->db->where('end_date >=', date('Y-m-d'));
    $query = $this->db->get('advertisement_purchases_master');

    $has_plan = $query->num_rows() > 0 ? true : false;
    echo json_encode(['has_plan' => $has_plan]);
}

public function create_advetisment_plan()
{
    $user_id = $this->input->post('user_id');
    $user_type = $this->input->post('user_type');
    $plan_id = $this->input->post('plan_id');

    $plan = $this->db->get_where('admin_advertisement_plans_master', ['id'=>$plan_id])->row_array();
    if(!$plan){
        echo json_encode(['status'=>'error','message'=>'Plan not found']);
        return;
    }

    $start_date = date('Y-m-d');
    $end_date = date('Y-m-d', strtotime("+{$plan['duration_days']} days"));

    $insert = [
        'plan_id'=>$plan_id,
        'user_type'=>$user_type,
        'user_id'=>$user_id,
        'start_date'=>$start_date,
        'end_date'=>$end_date,
        'products_used'=>0,
        'payment_status'=>'paid', // or pending
        'status'=>1,
        'created_at'=>date('Y-m-d H:i:s')
    ];

    $this->db->insert('advertisement_purchases_master', $insert);

    echo json_encode(['status'=>'success']);
}



}
