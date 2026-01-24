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
        $orderId = $this->input->post('order_id');
        $amount = (float) $this->input->post('amount');

        if (!$orderId || $amount <= 0)
        {
            show_error('Invalid payment request');
        }
        $this->session->set_userdata('phonepe_order_id', $orderId);

        $token = $this->getToken();
        if (!$token)
        {
            show_error('PhonePe token error');
        }

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

    
public function response()
{
    $merchantTxnId = $this->input->get('oid');
    if (!$merchantTxnId) {
        show_error('Transaction ID missing');
    }

    $token = $this->getToken();
    if (!$token) show_error('Token error');

    // 🔎 Check payment status from PhonePe
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

    $isSuccess = in_array($state, ['COMPLETED','SUCCESS','CHARGED']);

    /* ================= ORDER PAYMENT ================= */
    if (strpos($merchantTxnId, 'ORD') === 0)
    {
        $order = $this->db
            ->where('phonepe_merchant_txn_id', $merchantTxnId)
            ->get('order_master2')
            ->row_array();

        if (!$order) show_error('Order not found');

        if ($isSuccess) {
            $this->db->where('id', $order['id'])->update('order_master2', [
                'payment_status' => 'SUCCESS',
                'phonepe_status' => $state,
                'transaction_id' => $res['transactionId'] ?? '',
                'modify_date' => date('Y-m-d H:i:s')
            ]);

            $this->session->set_flashdata('success', 'Payment successful! Your order has been placed.');
            redirect('web/order_success/' . base64_encode($order['id']));
        } else {
            $this->db->where('id', $order['id'])->update('order_master2', [
                'payment_status' => 'FAILED'
            ]);

            $this->session->set_flashdata('error', 'Payment failed! Please try again.');
            redirect('phonepe/fail');
        }
    }

    /* ================= SUBSCRIPTION PAYMENT ================= */
    /* ================= SUBSCRIPTION PAYMENT ================= */
if (strpos($merchantTxnId, 'SUB') === 0)
{
    // vendor subscription
    $sub = $this->db
        ->where('transaction_id', $merchantTxnId)
        ->get('vendor_subscriptions_master')
        ->row_array();

    // promoter fallback
    if (!$sub) {
        $sub = $this->db
            ->where('transaction_id', $merchantTxnId)
            ->get('promoter_subscriptions_master')
            ->row_array();
    }

    if (!$sub) show_error('Subscription not found');

    $table = isset($sub['vendor_id']) ? 'vendor_subscriptions_master' : 'promoter_subscriptions_master';

    // Check plan type: 1 = monthly, 2 = per-product
    if ($sub['plan_type'] == 2) {
        // ✅ Per-product plan: activate immediately
        $this->db->where('id', $sub['id'])->update($table, [
            'status' => 1,
            'approval_status' => 1,   // active immediately
            'payment_status' => 'activated',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $this->session->set_flashdata('success', 'Per-product plan activated! You can now add products.');
        redirect('admin/Product/AddProduct');
        return;
    }

    // Otherwise, monthly subscription → check payment success
    if ($isSuccess) {
        $this->db->where('id', $sub['id'])->update($table, [
            'status' => 1,
            'payment_status' => 'paid',
            'approval_status' => 1,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $this->session->set_flashdata('success', 'Subscription activated successfully!');
        redirect('admin/dashboard');
    } else {
        $this->session->set_flashdata('error', 'Subscription payment failed. Please try again.');
        redirect('phonepe/fail');
    }
}


    show_error('Invalid transaction type');
}


    public function fail()
    {
        $this->load->view('web/payment_failed');
    }
}
