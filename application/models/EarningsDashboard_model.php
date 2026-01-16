<?php
class EarningsDashboard_model extends CI_Model
{
    /**
     * Apply filters for order_master table
     */
    private function applyOrderFilters($filters)
    {
        if (!empty($filters['month']))
        {
            $this->db->where("DATE_FORMAT(add_date,'%Y-%m') =", $filters['month']);
        }

        if (!empty($filters['from_date']) && !empty($filters['to_date']))
        {
            $this->db->where('DATE(add_date) >=', $filters['from_date']);
            $this->db->where('DATE(add_date) <=', $filters['to_date']);
        }

        if (!empty($filters['vendor_id']))
        {
            $this->db->where('vendor_id', $filters['vendor_id']);
        }

        if (!empty($filters['promoter_id']))
        {
            $this->db->where('promoter_id', $filters['promoter_id']);
        }
    }

    /**
     * Apply filters for sub_product_master table
     */
    private function applyProductFilters($filters)
    {
        if (!empty($filters['month']))
        {
            $this->db->where("DATE_FORMAT(add_date,'%Y-%m') =", $filters['month']);
        }

        if (!empty($filters['from_date']) && !empty($filters['to_date']))
        {
            $this->db->where('DATE(add_date) >=', $filters['from_date']);
            $this->db->where('DATE(add_date) <=', $filters['to_date']);
        }

        if (!empty($filters['vendor_id']))
        {
            $this->db->where('vendor_id', $filters['vendor_id']);
        }

        if (!empty($filters['promoter_id']))
        {
            $this->db->where('promoter_id', $filters['promoter_id']);
        }
    }

    /**
     * Get Earnings Dashboard Summary
     */
    public function getSummary($filters)
    {
        // ======= TOTAL EARNING =======
        $this->applyOrderFilters($filters);
        $totalEarning = $this->db->select('SUM(final_price) as total_earning')
            ->get('order_master')
            ->row()->total_earning ?? 0;

        // ======= TOTAL VENDOR EARNING =======
        $this->applyOrderFilters($filters);
        $vendorEarning = $this->db->select('SUM(vendor_earning) as vendor_earning')
            ->get('order_master')
            ->row()->vendor_earning ?? 0;

        // ======= TOTAL ADMIN EARNING =======
        $this->applyOrderFilters($filters);
        $adminEarning = $this->db->select('SUM(admin_earning) as admin_earning')
            ->get('order_master')
            ->row()->admin_earning ?? 0;

        // ======= TOTAL ORDERS =======
        $this->applyOrderFilters($filters);
        $totalOrders = $this->db->count_all_results('order_master') ?? 0;

        // ======= TOTAL VENDORS =======
        $totalVendorsQuery = $this->db->select('id')->from('vendors');

        if (!empty($filters['vendor_id']))
        {
            $totalVendorsQuery->where('id', $filters['vendor_id']);
        }

        // Apply month/date filter based on registration date (assuming vendors table has 'add_date')
        if (!empty($filters['month']))
        {
            $totalVendorsQuery->where("DATE_FORMAT(add_date,'%Y-%m') =", $filters['month']);
        } elseif (!empty($filters['from_date']) && !empty($filters['to_date']))
        {
            $totalVendorsQuery->where('DATE(add_date) >=', $filters['from_date']);
            $totalVendorsQuery->where('DATE(add_date) <=', $filters['to_date']);
        }

        $totalVendors = $totalVendorsQuery->count_all_results() ?? 0;


        // ======= TOTAL PRODUCTS =======
        $this->applyProductFilters($filters);
        $totalProducts = $this->db->count_all_results('sub_product_master') ?? 0;

        return [
            'total_earning' => $totalEarning,
            'vendor_earning' => $vendorEarning,
            'admin_earning' => $adminEarning,
            'total_orders' => $totalOrders,
            'total_vendors' => $totalVendors,
            'total_products' => $totalProducts
        ];
    }

    /**
     * Get vendors for dropdown
     */
    public function getVendors()
    {
        return $this->db->select('id, name')
            ->where('status', 1)
            ->get('vendors')
            ->result();
    }
}
