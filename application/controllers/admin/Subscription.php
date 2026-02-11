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
                'spacial_offer' => $this->input->post('spacial_offer') ?? 0,
                'product_for_you' => $this->input->post('product_for_you') ?? 0,
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
            'spacial_offer' => isset($data['spacial_offer']) ? 1 : 0,
            'product_for_you' => isset($data['product_for_you']) ? 1 : 0,
            'banner' => isset($data['banner']) ? 1 : 0,
            'status' => $data['status'],
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->where('id', $data['id']);
        $this->db->update('admin_advertisement_plans_master', $updateData);

        $this->session->set_flashdata('message', 'Advertisement Plan Updated Successfully!');
        redirect('admin/Subscription/AdvertismentUpdatePlan');
    }

    private function checkVendorPromoter()
    {
        $adminData = $this->session->userdata('adminData');
        if (!$adminData)
        {
            redirect('admin/login');
        }
        return $adminData;
    }
    public function AdvertismentSelectPlan()
    {
        $adminData = $this->checkVendorPromoter();

        $userType = $adminData['Type'];   // 1=Admin, 2=Vendor, 3=Promoter
        $userId = $adminData['Id'];

        /*
        ==========================================
        LOGIN BASED FILTER
        ==========================================
        */
        $loginWhere = "";

        // Vendor login
        if ($userType == 2)
        {
            $loginWhere = " AND ap.vendor_id = '$userId' ";
        }
        // Promoter login
        elseif ($userType == 3)
        {
            $loginWhere = " AND ap.promoter_id = '$userId' ";
        }
        // Admin login → no filter (see all)

        /*
        ==========================================
        MAIN QUERY
        ==========================================
        */
        $sql = "
    SELECT 
        ap.id as purchase_id,
        ap.plan_id,
        ap.price as paid_price,
        ap.user_type,
        ap.user_id,
        ap.vendor_id,
        ap.promoter_id,
        ap.plan_product_limit,
        ap.products_used,
        ap.transaction_id,
        ap.payment_status,
        ap.status as status,
        ap.start_date,
        ap.end_date,
        ap.created_at,

        p.plan_name,
        p.duration_days,
        p.product_limit,
        p.hot_deal,
        p.spacial_offer,
        p.product_for_you,
        p.banner,

        GROUP_CONCAT(sp.product_name SEPARATOR '||') as product_names,
        GROUP_CONCAT(sp.main_image SEPARATOR '||') as product_images,

        CASE 
            WHEN ap.user_type = 2 THEN v.name 
            WHEN ap.user_type = 3 THEN pr.name 
        END as user_name

    FROM advertisement_purchases_master ap
    LEFT JOIN admin_advertisement_plans_master p ON p.id = ap.plan_id
    LEFT JOIN advertisement_products_master adp ON adp.purchase_id = ap.id
    LEFT JOIN sub_product_master sp ON sp.id = adp.product_id
    LEFT JOIN vendors v ON v.id = ap.vendor_id
    LEFT JOIN promoters pr ON pr.id = ap.promoter_id

    WHERE ap.payment_status = 'paid'
    $loginWhere

    GROUP BY ap.id
    ORDER BY ap.created_at DESC
    ";

        /*
        ==========================================
        PLAN LIST (FOR BUY)
        ==========================================
        */
        $plans = $this->db->where('status', 1)
            ->get('admin_advertisement_plans_master')
            ->result_array();

        $data['plans'] = $plans;
        $data['adminData'] = $adminData;
        $data['activePlans'] = $this->db->query($sql)->result_array();
        $data['title'] = 'Manage Advertisement Plan Request';

        $this->load->view('include/header', $data);
        $this->load->view('admin/AdvertismentSelectPlan', $data);
        $this->load->view('include/footer');
    }



    public function AdvertismentUserDetails($purchase_id)
    {
        $adminData = $this->checkVendorPromoter();

        $userType = $adminData['Type'];   // 1=Admin, 2=Vendor, 3=Promoter
        $userId = $adminData['Id'];

        /*
        =====================================
        LOGIN BASED ACCESS CHECK
        =====================================
        */
        $loginWhere = "";

        if ($userType == 2)
        { // Vendor
            $loginWhere = " AND ap.vendor_id = '$userId' AND ap.user_type = 2 ";
        } elseif ($userType == 3)
        { // Promoter
            $loginWhere = " AND ap.promoter_id = '$userId' AND ap.user_type = 3 ";
        }
        // Admin → no restriction


        /*
        =====================================
        PURCHASE + PLAN + USER
        =====================================
        */
        $sql = "
    SELECT 
        ap.*,
        p.plan_name, 
        p.duration_days, 
        p.product_limit,
        p.hot_deal, 
        p.spacial_offer, 
        p.product_for_you, 
        p.banner,

        CASE 
            WHEN ap.user_type = 2 THEN v.name 
            WHEN ap.user_type = 3 THEN pr.name 
        END as user_name

    FROM advertisement_purchases_master ap
    LEFT JOIN admin_advertisement_plans_master p ON p.id = ap.plan_id
    LEFT JOIN vendors v ON v.id = ap.vendor_id
    LEFT JOIN promoters pr ON pr.id = ap.promoter_id

    WHERE ap.id = '$purchase_id'
    $loginWhere
    ";

        $purchase = $this->db->query($sql)->row_array();

        /*
        =====================================
        IF NOT FOUND → UNAUTHORIZED
        =====================================
        */
        if (empty($purchase))
        {
            show_error('Unauthorized Access', 403);
        }

        $data['purchase'] = $purchase;


        /*
        =====================================
        PRODUCTS
        =====================================
        */
        $sql2 = "
    SELECT 
        adp.*,
        sp.product_name,
        sp.main_image
    FROM advertisement_products_master adp
    LEFT JOIN sub_product_master sp ON sp.id = adp.product_id
    WHERE adp.purchase_id = '$purchase_id'
    ";

        $data['products'] = $this->db->query($sql2)->result_array();

        $data['adminData'] = $adminData;
        $data['title'] = 'Advertisement Details';

        $this->load->view('include/header', $data);
        $this->load->view('admin/AdvertismentUserDetails', $data);
        $this->load->view('include/footer');
    }

    public function check_activead_plan()
    {
        $user_id = $this->input->post('user_id');
        $user_type = $this->input->post('user_type');

        $exists = $this->db
            ->where('user_id', $user_id)
            ->where('user_type', $user_type)
            ->where('payment_status', 'paid')
            ->where('status', 1)
            ->get('advertisement_purchases_master')
            ->num_rows();

        if ($exists > 0)
        {
            echo json_encode(['has_plan' => true]);
        } else
        {
            echo json_encode(['has_plan' => false]);
        }
    }


    public function create_advetisment_plan()
    {
        $this->checkVendorPromoter();

        $plan_id = $this->input->post('plan_id');

        $plan = $this->db->where('id', $plan_id)
            ->where('status', 1)
            ->get('admin_advertisement_plans_master')
            ->row_array();

        if (!$plan)
        {
            echo json_encode(['status' => 'error', 'message' => 'Invalid plan']);
            return;
        }

        $this->session->set_userdata('selected_ad_plan', [
            'plan_id' => $plan['id'],
            'plan_name' => $plan['plan_name'],
            'price' => $plan['price'],
            'duration_days' => $plan['duration_days'],
            'plan_product_limit' => $plan['product_limit'],
            'hot_deal' => $plan['hot_deal'],
            'spacial_offer' => $plan['spacial_offer'],
            'banner' => $plan['banner'],
            'product_for_you' => $plan['product_for_you']
        ]);

        echo json_encode(['status' => 'success']);
    }



    public function AdvertismentProducts()
    {
        $adminData = $this->checkVendorPromoter();
        $plan = $this->session->userdata('selected_ad_plan');

        if (!$plan)
        {
            redirect('admin/Subscription/AdvertismentSelectPlan');
        }

        $data['plan'] = $plan;
        $data['adminData'] = $adminData;

        $this->load->view('include/header', $data);
        $this->load->view('admin/AdvertismentProducts', $data);
        $this->load->view('include/footer');
    }

    public function select_ad_plan($planId)
    {
        $admin = $this->checkVendorPromoter();

        $plan = $this->db->where('id', $planId)
            ->where('status', 1)
            ->get('admin_advertisement_plans_master')
            ->row_array();

        if (!$plan)
        {
            show_error('Invalid plan');
        }

        $this->session->set_userdata('selected_ad_plan', [
            'plan_id' => $plan['id'],
            'price' => $plan['price'],
            'plan_name' => $plan['plan_name'],
            'duration_days' => $plan['duration_days'],
            'plan_product_limit' => $plan['product_limit'],
            'hot_deal' => $plan['hot_deal'],
            'spacial_offer' => $plan['spacial_offer'],
            'banner' => $plan['banner'],
            'product_for_you' => $plan['product_for_you'],
        ]);

        redirect('admin/advertisement-products');
    }


    public function save_ad_session()
    {
        $this->checkVendorPromoter();

        $products = $this->input->post('products');
        $plan = $this->session->userdata('selected_ad_plan');

        if (!$plan || empty($products))
        {
            echo json_encode(['status' => 'error', 'message' => 'Invalid selection']);
            return;
        }

        $uniqueProducts = array_unique($products);

        if (count($uniqueProducts) > $plan['plan_product_limit'])
        {
            echo json_encode([
                'status' => 'error',
                'message' => 'Product limit exceeded'
            ]);
            return;
        }

        $ad_session = [
            'plan_id' => $plan['plan_id'],
            'price' => $plan['price'],
            'duration_days' => $plan['duration_days'],
            'plan_product_limit' => $plan['plan_product_limit'],
            'hot_deal' => $plan['hot_deal'],
            'spacial_offer' => $plan['spacial_offer'],
            'banner' => $plan['banner'],
            'product_for_you' => $plan['product_for_you'],
            'selected_products' => $uniqueProducts
        ];

        // echo "<pre>";
        // print_r($ad_session);
        // echo "</pre>";
        // exit;

        $this->session->set_userdata('ad_full_session', $ad_session);

        echo json_encode(['status' => 'success']);
    }





    public function get_parent_category()
    {
        echo json_encode(
            $this->db->where('status', 1)->get('parent_category_master')->result_array()
        );
    }

    public function get_category()
    {
        $ids = $this->input->post('ids');

        echo json_encode(
            $this->db->where_in('mai_id', $ids)
                ->where('status', 1)
                ->get('category_master')
                ->result_array()
        );
    }

    public function get_sub_category()
    {
        $ids = $this->input->post('ids');

        echo json_encode(
            $this->db->where_in('category_master_id', $ids)
                ->where('status', 1)
                ->get('sub_category_master')
                ->result_array()
        );
    }


    public function get_products()
    {
        $ids = $this->input->post('ids');

        if (empty($ids))
        {
            echo json_encode([]);
            return;
        }

        $this->db->select('
        sku_code,
        product_name,
        size,
        main_image
    ');
        $this->db->from('sub_product_master');
        $this->db->where_in('sub_category_id', $ids);
        $this->db->where('status', 1);
        $this->db->where('seller_approve_status', 1);

        $rows = $this->db->get()->result_array();
        $final = [];

        foreach ($rows as $r)
        {

            $sku = $r['sku_code'];

            if (!isset($final[$sku]))
            {
                $final[$sku] = [
                    'sku_code' => $sku,
                    'product_name' => $r['product_name'],
                    'image' => $r['main_image'],
                    'sizes' => []
                ];
            }

            if (!in_array($r['size'], $final[$sku]['sizes']))
            {
                $final[$sku]['sizes'][] = $r['size'];
            }
        }

        foreach ($final as $k => $v)
        {
            $final[$k]['sizes'] = implode(',', $v['sizes']);
        }

        echo json_encode(array_values($final));
    }

    public function updatePlanStatus()
    {
        $admin = $this->session->userdata('adminData');

        if (!$admin || $admin['Type'] != 1)
        {
            echo json_encode(['status' => 0, 'msg' => 'Unauthorized']);
            return;
        }

        $id = $this->input->post('id');
        $status = $this->input->post('status');

        if (!$id)
        {
            echo json_encode(['status' => 0, 'msg' => 'Invalid ID']);
            return;
        }
        $update = $this->db->where('id', $id)
            ->update('advertisement_purchases_master', ['status' => $status]);
        $this->db->where('purchase_id', $id)
            ->update('advertisement_products_master', ['status' => $status]);

        echo json_encode(['status' => $update ? 1 : 0]);
    }





}
