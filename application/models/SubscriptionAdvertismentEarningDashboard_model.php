<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubscriptionAdvertismentEarningDashboard_model extends CI_Model
{

    private function applyDateFilter($filters, $field)
    {
        if (!empty($filters['month'])) {
            $this->db->where("DATE_FORMAT($field,'%Y-%m')", $filters['month']);
        }

        if (!empty($filters['from_date'])) {
            $this->db->where("DATE($field) >=", $filters['from_date']);
        }

        if (!empty($filters['to_date'])) {
            $this->db->where("DATE($field) <=", $filters['to_date']);
        }
    }

    public function getSummary($filters)
    {

        /* =====================================================
           SUBSCRIPTIONS
        ===================================================== */

        $this->db->reset_query();
        $this->db->from('vendor_subscriptions_master');
        $this->db->where('payment_status', 'paid');

        if (!empty($filters['vendor_id']))
            $this->db->where('vendor_id', $filters['vendor_id']);

        if (!empty($filters['subscription_type'])) {
            if ($filters['subscription_type'] == 'subscription') 
                $this->db->where('plan_type', 1);
            if ($filters['subscription_type'] == 'advertisement')
                $this->db->where('plan_type', 2);
        }

        $this->applyDateFilter($filters, 'start_date');

        $subs = $this->db->get()->result();

        $total_subscriptions = count($subs);

        $monthly = 0;
        $perProduct = 0;
        $monthlyActive = 0;
        $perProductActive = 0;
        $total_sub_earning = 0;

        foreach ($subs as $s) {

            if ($s->plan_type == 1) {
                $monthly++;
                if ($s->status == 1) {
                    $monthlyActive++;
                    $total_sub_earning += $s->price;
                }
            }

            if ($s->plan_type == 2) {
                $perProduct++;
                if ($s->status == 1) {
                    $perProductActive++;
                    $total_sub_earning += $s->price;
                }
            }
        }


        /* =====================================================
           ADVERTISEMENTS
        ===================================================== */

        $this->db->reset_query();
        $this->db->from('advertisement_purchases_master');
        $this->db->where('payment_status', 'paid');

        if (!empty($filters['vendor_id']))
            $this->db->where('vendor_id', $filters['vendor_id']);

        if (!empty($filters['promoter_id']))
            $this->db->where('promoter_id', $filters['promoter_id']);

        $this->applyDateFilter($filters, 'start_date');

        $ads = $this->db->get()->result();

        $total_advertisements = count($ads);
        $activeAds = 0;
        $pendingAds = 0;
        $total_adv_earning = 0;

        foreach ($ads as $a) {
            if ($a->status == 1) {
                $activeAds++;
                $total_adv_earning += $a->price;
            } else {
                $pendingAds++;
            }
        }


        /* =====================================================
           PER PRODUCT COMMISSION
        ===================================================== */

        $this->db->reset_query();
        $this->db->select_sum('commission_amount');
        $this->db->from('admin_earnings_master');

        if (!empty($filters['vendor_id']))
            $this->db->where('vendor_id', $filters['vendor_id']);

        if (!empty($filters['promoter_id']))
            $this->db->where('promoter_id', $filters['promoter_id']);

        $commission = $this->db->get()->row()->commission_amount ?? 0;


        /* =====================================================
           TOTAL EARNING
        ===================================================== */

        $total_earning = $total_sub_earning + $total_adv_earning + $commission;


        /* =====================================================
           TOTAL VENDORS / PROMOTERS
        ===================================================== */

        $this->db->reset_query();
        if (!empty($filters['promoter_id']))
            $this->db->where('promoter_id', $filters['promoter_id']);
        $total_vendors = $this->db->count_all_results('vendors');


        $this->db->reset_query();
        $total_promoters = $this->db->count_all_results('promoters');


        return [
            'total_earning' => $total_earning,

            'total_subscriptions' => $total_subscriptions,
            'total_monthly_subscriptions' => $monthly,
            'total_per_product_subscriptions' => $perProduct,
            'total_monthly_active_subscriptions' => $monthlyActive,
            'total_per_product_active_subscriptions' => $perProductActive,
            'total_sub_earning' => $total_sub_earning,

            'total_advertisements' => $total_advertisements,
            'total_active_advertisements' => $activeAds,
            'total_pending_advertisements' => $pendingAds,
            'total_adv_earning' => $total_adv_earning,

            'total_vendors' => $total_vendors,
            'total_promoters' => $total_promoters
        ];
    }


    public function getVendors() {
        return $this->db->get('vendors')->result();
    }

    public function getPromoters() {
        return $this->db->get('promoters')->result();
    }

    public function getVendorsByPromoter($promoter_id)
    {
        if (!empty($promoter_id))
            $this->db->where('promoter_id', $promoter_id);

        return $this->db->get('vendors')->result();
    }
}
