<?php

class EarningsDashboard_model extends CI_Model {

    /* ================= DATE FILTER ================= */
    private function applyDateFilter($filters, $field = 'created_at')
    {
        if (!empty($filters['month'])) {
            // YYYY-MM
            $this->db->where("DATE_FORMAT($field,'%Y-%m') =", $filters['month']);
        } 
        elseif (!empty($filters['from_date']) && !empty($filters['to_date'])) {
            $this->db->where("DATE($field) >=", $filters['from_date']);
            $this->db->where("DATE($field) <=", $filters['to_date']);
        }
    }

    /* ================= DASHBOARD SUMMARY ================= */
    public function getSummary($filters)
    {
        /* ===== TOTAL / VENDOR / PROMOTER EARNING ===== */
        $this->db->reset_query();
        $this->db->select("
            IFNULL(SUM(earning_amount),0) AS total_earning,
            IFNULL(SUM(CASE 
                WHEN vendor_id IS NOT NULL AND vendor_id != 0 
                THEN earning_amount ELSE 0 END),0) AS vendor_earning,
            IFNULL(SUM(CASE 
                WHEN promoter_id IS NOT NULL AND promoter_id != 0 
                THEN earning_amount ELSE 0 END),0) AS promoter_earning
        ");

        if (!empty($filters['vendor_id'])) {
            $this->db->where('vendor_id', $filters['vendor_id']);
        }
        if (!empty($filters['promoter_id'])) {
            $this->db->where('promoter_id', $filters['promoter_id']);
        }

        $this->applyDateFilter($filters, 'created_at');
        $earningRow = $this->db->get('vendor_earnings_master')->row();

        /* ===== TOTAL ORDERS ===== */
        $this->db->reset_query();
        if (!empty($filters['vendor_id'])) {
            $this->db->where('vendor_id', $filters['vendor_id']);
        }
        if (!empty($filters['promoter_id'])) {
            $this->db->where('promoter_id', $filters['promoter_id']);
        }
        $this->applyDateFilter($filters, 'created_at');
        $total_orders = $this->db->count_all_results('vendor_earnings_master');

        /* ===== PENDING ORDERS ===== */
        // order_status column nahi hai → safe 0
        $pending_orders = 0;

        /* ===== TOTAL PRODUCTS (unique product_id) ===== */
        $this->db->reset_query();
        $this->db->select('COUNT(DISTINCT product_id) AS total_products');

        if (!empty($filters['vendor_id'])) {
            $this->db->where('vendor_id', $filters['vendor_id']);
        }
        if (!empty($filters['promoter_id'])) {
            $this->db->where('promoter_id', $filters['promoter_id']);
        }

        $this->applyDateFilter($filters, 'created_at');
        $total_products = $this->db->get('vendor_earnings_master')->row()->total_products ?? 0;

        /* ===== TOTAL VENDORS ===== */
        $this->db->reset_query();
        if (!empty($filters['promoter_id'])) {
            $this->db->where('promoter_id', $filters['promoter_id']);
        }
        $total_vendors = $this->db->count_all_results('vendors');

        /* ===== TOTAL PROMOTERS ===== */
        $this->db->reset_query();
        $total_promoters = $this->db->count_all_results('promoters');

        return [
            'total_earning'    => $earningRow->total_earning,
            'vendor_earning'   => $earningRow->vendor_earning,
            'promoter_earning' => $earningRow->promoter_earning,
            'total_orders'     => $total_orders,
            'pending_orders'   => $pending_orders,
            'total_products'   => $total_products,
            'total_vendors'    => $total_vendors,
            'total_promoters'  => $total_promoters
        ];
    }

    /* ================= DROPDOWNS ================= */
    public function getVendors()
    {
        return $this->db->get('vendors')->result();
    }

    public function getPromoters()
    {
        return $this->db->get('promoters')->result();
    }
}
