<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription_model extends CI_Model
{



    // Get all subscriptions for admin
    public function getAllSubscriptions()
    {
        return $this->db
            ->select('
            vs.*,
            v.name,
            v.email,
            v.shop_name,
            ap.plan_name,
            ap.plan_type,
            ap.price AS plan_price,
            ap.product_limit AS plan_product_limit,
            ap.commission_percent
        ')
            ->from('vendor_subscriptions_master vs')
            ->join('vendors v', 'v.id = vs.vendor_id', 'left')
            ->join('admin_subscription_plans_master ap', 'ap.id = vs.plan_id', 'left')
            ->order_by('vs.id', 'desc')
            ->get()
            ->result_array();
    }


    // Get subscription by ID
    public function getVendorSubscription($vendor_id)
    {
        return $this->db->where('vendor_id', $vendor_id)
            ->where('status !=', 2) // optional: ignore rejected/blocked
            ->get('vendor_subscriptions_master')
            ->row_array();
    }

    // Other methods...
    public function getSubscription($id)
    {
        return $this->db->get_where('vendor_subscriptions_master', ['id' => $id])->row_array();
    }

    public function updateSubscription($id, $data)
    {
        return $this->db->where('id', $id)->update('vendor_subscriptions_master', $data);
    }

    public function getActiveSubscription($vendor_id)
    {
        return $this->db->where(['vendor_id' => $vendor_id, 'status' => 1, 'approval_status' => 1])
            ->get('vendor_subscriptions_master')->row_array();
    }

    public function getPlan($plan_id)
    {
        return $this->db->get_where('admin_subscription_plans_master', ['id' => $plan_id])->row_array();
    }

    public function createSubscription($data)
    {
        $this->db->insert('vendor_subscriptions_master', $data);
        return $this->db->insert_id();
    }
    // Get any pending subscription request for a vendor (not rejected)
    public function getPendingSubscriptionRequest($vendor_id)
    {
        return $this->db->where('vendor_id', $vendor_id)
            ->where('status !=', 2) // 2 = rejected
            ->get('vendor_subscriptions_master')
            ->row_array();
    }

}
