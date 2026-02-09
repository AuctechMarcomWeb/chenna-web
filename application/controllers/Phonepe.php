<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'config/phonepe.php');

class Phonepe extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url']);
        $this->load->library(['cart', 'session']);
        $this->load->database();
    }

    /* ================= GET ACCESS TOKEN ================= */
    private function getToken()
    {
        $params = [
            'client_id' => PHONEPE_CLIENT_ID,
            'client_secret' => PHONEPE_CLIENT_SECRET,
            'grant_type' => 'client_credentials',
            'client_version' => PHONEPE_CLIENT_VERSION ?? '1'
        ];

        $ch = curl_init(TOKEN_URL);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded',
                'Accept: application/json'
            ],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 30
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200 || !$response)
        {
            log_message('error', 'PhonePe Token Error: ' . $response);
            return false;
        }

        $res = json_decode($response, true);
        return $res['access_token'] ?? false;
    }

    /* ================= INITIATE PAYMENT ================= */
    public function pay()
    {
        $orderId = $this->input->post('order_id') ?? $this->input->post('subscription_id');
        $amount = (float) $this->input->post('amount');

        if (!$orderId || $amount <= 0)
        {
            show_error('Invalid payment request');
        }

        $token = $this->getToken();
        if (!$token)
            show_error('PhonePe token error');

        $payload = [
            "merchantOrderId" => $orderId,
            "amount" => (int) round($amount * 100),
            "paymentFlow" => [
                "type" => "PG_CHECKOUT",
                "merchantUrls" => [
                    "redirectUrl" => base_url('phonepe/response?oid=' . $orderId),
                    "redirectMode" => "GET"
                ]
            ]
        ];

        $ch = curl_init(PAY_URL);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: O-Bearer ' . $token
            ],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 30
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200)
        {
            log_message('error', 'PhonePe Pay Error: ' . $response);
            show_error('Payment initiation failed');
        }

        $res = json_decode($response, true);

        if (empty($res['redirectUrl']))
        {
            show_error('Invalid PhonePe response');
        }

        redirect($res['redirectUrl']);
    }

    /* ================= PAYMENT RESPONSE ================= */
    // public function response()
    // {
    //     $merchantTxnId = $this->input->get('oid');
    //     if (!$merchantTxnId) show_error('Transaction ID missing');

    //     $token = $this->getToken();
    //     if (!$token) show_error('Token error');

    //     // Check payment status from PhonePe
    //     $statusUrl = STATUS_URL . $merchantTxnId . '/status';
    //     $ch = curl_init($statusUrl);
    //     curl_setopt_array($ch, [
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_HTTPHEADER => [
    //             'Authorization: O-Bearer ' . $token
    //         ],
    //         CURLOPT_SSL_VERIFYPEER => false
    //     ]);

    //     $response = curl_exec($ch);
    //     curl_close($ch);

    //     $res = json_decode($response, true);
    //     $state = strtoupper($res['state'] ?? 'FAILED');
    //     $isSuccess = in_array($state, ['COMPLETED', 'SUCCESS', 'CHARGED']);

    //     /* ================= ORDER PAYMENT ================= */
    //     if (strpos($merchantTxnId, 'ORD') === 0 || strpos($merchantTxnId, 'DN') === 0) {
    //         $order = $this->db->where('phonepe_merchant_txn_id', $merchantTxnId)
    //                           ->get('order_master2')->row_array();
    //         if (!$order) show_error('Order not found');

    //         if ($isSuccess) {
    //             $this->db->where('id', $order['id'])->update('order_master2', [
    //                 'payment_status' => 'SUCCESS',
    //                 'phonepe_status' => $state,
    //                 'transaction_id' => $res['transactionId'] ?? '',
    //                 'modify_date' => date('Y-m-d H:i:s')
    //             ]);

    //             $this->session->set_flashdata('success', 'Payment successful! Your order has been placed.');
    //             redirect('web/order_success/' . base64_encode($order['id']));
    //         } else {
    //             $this->db->where('id', $order['id'])->update('order_master2', [
    //                 'payment_status' => 'FAILED'
    //             ]);
    //             $this->session->set_flashdata('error', 'Payment failed! Please try again.');
    //             redirect('phonepe/fail');
    //         }
    //         return;
    //     }

    //     /* ================= SUBSCRIPTION PAYMENT ================= */
    //     if (strpos($merchantTxnId, 'SUB') === 0 || strpos($merchantTxnId, 'PERPROD') === 0) {
    //         // Vendor
    //         $sub = $this->db->where('transaction_id', $merchantTxnId)
    //                         ->get('vendor_subscriptions_master')->row_array();
    //         $table = 'vendor_subscriptions_master';

    //         // Promoter fallback
    //         if (!$sub) {
    //             $sub = $this->db->where('transaction_id', $merchantTxnId)
    //                             ->get('promoter_subscriptions_master')->row_array();
    //             $table = 'promoter_subscriptions_master';
    //         }

    //         if (!$sub) show_error('Subscription not found');

    //         if ($sub['plan_type'] == 2 || strpos($merchantTxnId, 'PERPROD') === 0) {
    //             $this->db->where('id', $sub['id'])->update($table, [
    //                 'status' => 1,
    //                 'approval_status' => 1,
    //                 'payment_status' => 'activated',
    //                 'updated_at' => date('Y-m-d H:i:s')
    //             ]);
    //         } elseif ($isSuccess) {
    //             $this->db->where('id', $sub['id'])->update($table, [
    //                 'status' => 1,
    //                 'approval_status' => 1,
    //                 'payment_status' => 'paid',
    //                 'updated_at' => date('Y-m-d H:i:s')
    //             ]);
    //         } else {
    //             $this->db->where('id', $sub['id'])->update($table, [
    //                 'payment_status' => 'failed',
    //                 'updated_at' => date('Y-m-d H:i:s')
    //             ]);
    //         }

    //         $this->session->set_flashdata('success', 'Payment processed. Subscription will be activated shortly.');
    //         redirect('admin/dashboard');
    //         return;
    //     }

    //     show_error('Invalid transaction type');
    // }

    public function response()
    {
        $merchantTxnId = $this->input->get('oid');
        if (!$merchantTxnId)
            show_error('Transaction ID missing');

        $token = $this->getToken();
        if (!$token)
            show_error('Token error');

        /* ================= CHECK STATUS ================= */
        $statusUrl = STATUS_URL . $merchantTxnId . '/status';
        $ch = curl_init($statusUrl);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: O-Bearer ' . $token
            ],
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $res = json_decode($response, true);
        $state = strtoupper($res['state'] ?? 'FAILED');
        $isSuccess = in_array($state, ['COMPLETED', 'SUCCESS', 'CHARGED']);

        /* ================= ORDER PAYMENT ================= */
        if (strpos($merchantTxnId, 'ORD') === 0 || strpos($merchantTxnId, 'DN') === 0)
        {
            $order = $this->db->where('phonepe_merchant_txn_id', $merchantTxnId)
                ->get('order_master2')
                ->row_array();

            if (!$order)
                show_error('Order not found');

            if ($isSuccess)
            {
                // update order
                $this->db->where('id', $order['id'])->update('order_master2', [
                    'payment_status' => 'SUCCESS',
                    'phonepe_status' => $state,
                    'transaction_id' => $res['transactionId'] ?? '',
                    'status' => 1,
                    'action_payment' => 'Yes',
                    'modify_date' => date('Y-m-d H:i:s')
                ]);

                /* ✅ CART CLEAR ONLY AFTER PAYMENT SUCCESS */
                $this->cart->destroy();
                $this->session->unset_userdata(['buy_now', 'applied_coupon']);

                $this->session->set_flashdata(
                    'success',
                    'Payment successful! Your order has been placed.'
                );

                redirect('web/order_success/' . base64_encode($order['id']));
            } else
            {
                $this->db->where('id', $order['id'])->update('order_master2', [
                    'payment_status' => 'FAILED',
                    'phonepe_status' => $state,
                    'modify_date' => date('Y-m-d H:i:s')
                ]);

                $this->session->set_flashdata(
                    'error',
                    'Payment failed! Please try again.'
                );

                redirect('phonepe/fail');
            }
            return;
        }

        /* ================= SUBSCRIPTION PAYMENT ================= */
        if (strpos($merchantTxnId, 'SUB') === 0 || strpos($merchantTxnId, 'PERPROD') === 0)
        {
            $sub = $this->db->where('transaction_id', $merchantTxnId)
                ->get('vendor_subscriptions_master')
                ->row_array();
            $table = 'vendor_subscriptions_master';

            if (!$sub)
            {
                $sub = $this->db->where('transaction_id', $merchantTxnId)
                    ->get('promoter_subscriptions_master')
                    ->row_array();
                $table = 'promoter_subscriptions_master';
            }

            if (!$sub)
                show_error('Subscription not found');

            if ($isSuccess)
            {
                $this->db->where('id', $sub['id'])->update($table, [
                    'status' => 1,
                    'approval_status' => 1,
                    'payment_status' => 'paid',
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } else
            {
                $this->db->where('id', $sub['id'])->update($table, [
                    'payment_status' => 'failed',
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }

            $this->session->set_flashdata(
                'success',
                'Payment processed. Subscription will be activated shortly.'
            );
            redirect('admin/dashboard');
            return;
        }
        /* ================= ADVERTISEMENT PAYMENT ================= */
        if (strpos($merchantTxnId, 'AD') === 0)
        {
            $adminData = $this->checkVendorPromoter();

            $plan = $this->session->userdata('selected_ad_plan');
            $products = $this->session->userdata('selected_ad_products');

            if (!$plan || !$products)
                show_error('Advertisement data missing');

            if ($isSuccess)
            {
                // insert purchase
                $purchase = [
                    'plan_id' => $plan['plan_id'],
                    'user_type' => $adminData['Type'],
                    'user_id' => $adminData['Id'],
                    'plan_product_limit' => $plan['plan_product_limit'],
                    'products_used' => count($products),
                    'payment_status' => 'paid',
                    'transaction_id' => $merchantTxnId,
                    'start_date' => date('Y-m-d'),
                    'end_date' => date('Y-m-d', strtotime("+{$plan['duration_days']} days")),
                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $this->db->insert('advertisement_purchases_master', $purchase);
                $purchaseId = $this->db->insert_id();

                // insert products
                foreach ($products as $pid)
                {
                    $this->db->insert('advertisement_products_master', [
                        'purchase_id' => $purchaseId,
                        'product_id' => $pid,
                        'ad_type' => $plan['ad_type'], // banner / featured / hot
                        'start_date' => $purchase['start_date'],
                        'end_date' => $purchase['end_date'],
                        'status' => 1
                    ]);
                }

                // clear session
                $this->session->unset_userdata([
                    'selected_ad_plan',
                    'selected_ad_products',
                    'ad_txn_id'
                ]);

                $this->session->set_flashdata('success', 'Advertisement activated successfully');
                redirect('admin/dashboard');
            } else
            {
                $this->session->set_flashdata('error', 'Advertisement payment failed');
                redirect('admin/dashboard');
            }
            return;
        }


        show_error('Invalid transaction type');
    }

    public function fail()
    {
        $this->session->set_flashdata('error', 'Payment failed. Please try again.');
        redirect('admin/dashboard');
    }

    public function ad_pay()
    {
        $adData = $this->session->userdata('ad_full_session');

        if (!$adData)
        {
            show_error('Advertisement session expired');
        }

        // transaction id
        $txnId = 'AD' . time();
        $amount = (float) $adData['price'];

        $this->session->set_userdata('ad_txn_id', $txnId);

        $token = $this->getToken();
        if (!$token)
        {
            show_error('PhonePe token error');
        }

        $payload = [
            "merchantOrderId" => $txnId,
            "amount" => (int) ($amount * 100),
            "paymentFlow" => [
                "type" => "PG_CHECKOUT",
                "merchantUrls" => [
                    "redirectUrl" => base_url('phonepe/response_ad?oid=' . $txnId),
                    "redirectMode" => "GET"
                ]
            ]
        ];

        $ch = curl_init(PAY_URL);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: O-Bearer ' . $token
            ],
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if (empty($res['redirectUrl']))
        {
            show_error('Payment failed');
        }

        redirect($res['redirectUrl']);
    }



    public function response_ad()
    {
        $txnId = $this->input->get('oid');

        if (!$txnId || strpos($txnId, 'AD') !== 0)
        {
            show_error('Invalid transaction');
        }

        $token = $this->getToken();
        if (!$token)
        {
            show_error('Token error');
        }

        $ch = curl_init(STATUS_URL . $txnId . '/status');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Authorization: O-Bearer ' . $token],
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);

        $success = in_array(strtoupper($res['state'] ?? ''), ['COMPLETED', 'SUCCESS', 'CHARGED']);

        if (!$success)
        {
            $this->session->set_flashdata('error', 'Advertisement payment failed');
            redirect('admin/Subscription/AdvertismentSelectPlan');
        }

        $admin = $this->checkVendorPromoter();
        $adData = $this->session->userdata('ad_full_session');

        if (!$adData)
        {
            show_error('Advertisement data missing');
        }

        $products = $adData['selected_products'];

        $this->db->trans_start();

        $purchase = [
            'plan_id' => $adData['plan_id'],
            'price' => $adData['price'],
            'user_type' => $admin['Type'],
            'user_id' => $admin['Id'],
            'vendor_id' => ($admin['Type'] == 2) ? $admin['Id'] : 0,
            'promoter_id' => ($admin['Type'] == 3) ? $admin['Id'] : 0,
            'plan_product_limit' => $adData['plan_product_limit'],
            'products_used' => count($products),
            'transaction_id' => $txnId,
            'payment_status' => 'paid',
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d', strtotime("+{$adData['duration_days']} days")),
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('advertisement_purchases_master', $purchase);
        $purchaseId = $this->db->insert_id();

        $benefits = [];

        if (!empty($adData['hot_deal']))
            $benefits[] = 'hot_deal';
        if (!empty($adData['spacial_offer']))
            $benefits[] = 'spacial_offer';
        if (!empty($adData['banner']))
            $benefits[] = 'banner';
        if (!empty($adData['product_for_you']))
            $benefits[] = 'product_for_you';

        $benefitString = implode(',', $benefits);

        foreach ($products as $sku)
        {
          
            $product = $this->db
                ->select('id')
                ->where('sku_code', $sku)
                ->where('status', 1)
                ->where('seller_approve_status', 1)
                ->order_by('id', 'ASC') 
                ->limit(1)              
                ->get('sub_product_master')
                ->row_array();

            if (!empty($product))
            {
                // extra safety → duplicate prevent
                $exists = $this->db
                    ->where('purchase_id', $purchaseId)
                    ->where('product_id', $product['id'])
                    ->count_all_results('advertisement_products_master');

                if ($exists == 0)
                {
                    $this->db->insert('advertisement_products_master', [
                        'purchase_id' => $purchaseId,
                        'product_id' => $product['id'],
                        'ad_type' => $benefitString,
                        'start_date' => $purchase['start_date'],
                        'end_date' => $purchase['end_date'],
                        'status' => 0,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }
        $this->db->trans_complete();
        $this->session->unset_userdata(['ad_full_session', 'ad_txn_id']);

        $this->session->set_flashdata('success', 'Advertisement purchased successfully');
        redirect('admin/Subscription/AdvertismentSelectPlan');
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
}

