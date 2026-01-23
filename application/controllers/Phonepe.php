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
        $merchantOrderId = $this->input->get('oid');
        if (!$merchantOrderId)
        {
            show_error('Merchant Order ID missing');
        }
        $token = $this->getToken();
        if (!$token)
        {
            show_error('Token error');
        }
        $statusUrl = STATUS_URL . $merchantOrderId . '/status';
        $ch = curl_init($statusUrl);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
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

        if ($httpCode !== 200 || !$response)
        {
            show_error('Unable to verify payment');
        }

        $statusRes = json_decode($response, true);
        $paymentState = strtoupper($statusRes['state'] ?? 'FAILED');

        $successStates = ['COMPLETED', 'SUCCESS', 'CHARGED', 'AUTHORIZED', 'SUCCEEDED'];

        if (in_array($paymentState, $successStates))
        {

            $order = $this->db
                ->get_where('order_master2', [
                    'phonepe_merchant_txn_id' => $merchantOrderId
                ])->row_array();

            if (!$order)
            {
                show_error('Order not found');
            }
            $this->db->where('id', $order['id'])->update('order_master2', [
                'status' => 3,
                'payment_status' => 'SUCCESS',
                'phonepe_status' => $paymentState,
                'transaction_id' => $statusRes['transactionId'] ?? '',
                'modify_date' => date('Y-m-d H:i:s')
            ]);

            // 🧹 Cleanup
            $this->cart->destroy();
            $this->session->unset_userdata([
                'buy_now',
                'checkout_items',
                'applied_coupon'
            ]);
            redirect('web/order_success/' . base64_encode($order['id']));

        } else
        {
            $this->db->where('phonepe_merchant_txn_id', $merchantOrderId)
                ->update('order_master2', [
                    'status' => 2,
                    'payment_status' => 'FAILED',
                    'phonepe_status' => $paymentState,
                    'modify_date' => date('Y-m-d H:i:s')
                ]);

            redirect('phonepe/fail');
        }
    }
    public function fail()
    {
        $this->load->view('web/payment_failed');
    }
}
