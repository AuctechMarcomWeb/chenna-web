<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription_model extends CI_Model
{

    public function subscription_list()
    {
        // ================== VENDOR ==================
        $vendor = $this->db
            ->select("
                vs.id,
                'Vendor' AS user_type,
                v.name AS user_name,
                v.email,
                v.shop_name,
                vs.plan_id,
                vs.plan_type,
                vs.product_limit,
                vs.products_used,
                vs.status,
                vs.approval_status,
                ap.plan_name
            ")
            ->from('vendor_subscriptions_master vs')
            ->join('vendors v', 'v.id = vs.vendor_id', 'left')
            ->join('admin_subscription_plans_master ap', 'ap.id = vs.plan_id', 'left')
            ->get_compiled_select();

        // ================== PROMOTER ==================
        $promoter = $this->db
            ->select("
                ps.id,
                'Promoter' AS user_type,
                p.name AS user_name,
                p.email,
                '' AS shop_name,
                ps.plan_id,
                ps.plan_type,
                ps.product_limit,
                ps.products_used,
                ps.status,
                ps.approval_status,
                ap.plan_name
            ")
            ->from('promoter_subscriptions_master ps')
            ->join('promoters p', 'p.id = ps.promoter_id', 'left')
            ->join('admin_subscription_plans_master ap', 'ap.id = ps.plan_id', 'left')
            ->get_compiled_select();

        // ================== UNION ==================
        $query = $this->db->query("
            ($vendor)
            UNION ALL
            ($promoter)
            ORDER BY id DESC
        ");

        return $query->result_array();
    }

    // Get subscription by ID + type

// Get subscription by ID and type
public function getSubscriptionByType($id, $user_type)
{
    if ($user_type == 'vendor') {
        return $this->db->get_where('vendor_subscriptions_master', ['id'=>$id])->row_array();
    } else {
        return $this->db->get_where('promoter_subscriptions_master', ['id'=>$id])->row_array();
    }
}

// Update subscription
public function updateSubscription($id, $data, $user_type)
{
    if ($user_type == 'vendor') {
        return $this->db->where('id',$id)->update('vendor_subscriptions_master',$data);
    } else {
        return $this->db->where('id',$id)->update('promoter_subscriptions_master',$data);
    }
}

// Fetch plan details
public function getPlan($plan_id)
{
    return $this->db->get_where('admin_subscription_plans_master', ['id'=>$plan_id])->row_array();
}



    // Get subscription by ID (original, fallback)
    public function getSubscription($id)
    {
        $vendor = $this->db
            ->select("vs.*, 'vendor' as user_type")
            ->from('vendor_subscriptions_master vs')
            ->where('vs.id', $id)
            ->get()
            ->row_array();

        if ($vendor)
            return $vendor;

        $promoter = $this->db
            ->select("ps.*, 'promoter' as user_type")
            ->from('promoter_subscriptions_master ps')
            ->where('ps.id', $id)
            ->get()
            ->row_array();

        return $promoter;
    }

    // public function updateSubscription($id, $data, $user_type)
    // {
    //     if ($user_type == 'vendor')
    //     {
    //         return $this->db->where('id', $id)->update('vendor_subscriptions_master', $data);
    //     } else
    //     {
    //         return $this->db->where('id', $id)->update('promoter_subscriptions_master', $data);
    //     }
    // }

    public function getVendorSubscription($vendor_id)
    {
        return $this->db->where('vendor_id', $vendor_id)
            ->where('status !=', 2)
            ->get('vendor_subscriptions_master')
            ->row_array();
    }

    public function getActiveSubscription($user_id, $user_type = 'vendor')
    {
        $table = $user_type == 'vendor'
            ? 'vendor_subscriptions_master'
            : 'promoter_subscriptions_master';

        $col = $user_type == 'vendor' ? 'vendor_id' : 'promoter_id';

        return $this->db
            ->where([$col => $user_id, 'status' => 1, 'approval_status' => 1])
            ->get($table)
            ->row_array();
    }

    public function createVendorSubscription($data)
    {
        $this->db->insert('vendor_subscriptions_master', $data);
        return $this->db->insert_id();
    }

    public function createPromoterSubscription($data)
    {
        $this->db->insert('promoter_subscriptions_master', $data);
        return $this->db->insert_id();
    }

    public function getPendingSubscriptionRequest($user_id, $type)
    {
        $col = ($type == 'vendor') ? 'vendor_id' : 'promoter_id';
        $table = ($type == 'vendor') ? 'vendor_subscriptions_master' : 'promoter_subscriptions_master';
        $this->db->where($col, $user_id);
        $this->db->where('approval_status', 0); // pending
        return $this->db->get($table)->row_array();
    }

    public function getSingleVendorSubscription($vendor_id)
    {
        return $this->db
            ->select("
            vs.id,
            'Vendor' AS user_type,
            v.name AS user_name,
            v.email,
            v.shop_name,
            vs.plan_id,
            vs.plan_type,
            vs.product_limit,
            vs.products_used,
            vs.status,
            vs.approval_status,
            vs.end_date,
            ap.plan_name
        ")
            ->from('vendor_subscriptions_master vs')
            ->join('vendors v', 'v.id = vs.vendor_id', 'left')
            ->join('admin_subscription_plans_master ap', 'ap.id = vs.plan_id', 'left')
            ->where('vs.vendor_id', $vendor_id)
            ->get()
            ->result_array(); // table ke liye array
    }
    public function getSinglePromoterSubscription($promoter_id)
    {
        return $this->db
            ->select("
            ps.id,
            'Promoter' AS user_type,
            p.name AS user_name,
            p.email,
            '' AS shop_name,
            ps.plan_id,
            ps.plan_type,
            ps.product_limit,
            ps.products_used,
            ps.status,
            ps.approval_status,
            ps.end_date,
            ap.plan_name
        ")
            ->from('promoter_subscriptions_master ps')
            ->join('promoters p', 'p.id = ps.promoter_id', 'left')
            ->join('admin_subscription_plans_master ap', 'ap.id = ps.plan_id', 'left')
            ->where('ps.promoter_id', $promoter_id)
            ->get()
            ->result_array();
    }



}
