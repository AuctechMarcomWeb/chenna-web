<?php
class EarningsDashboard_model extends CI_Model
{

    private function applyDateFilter($filters, $field = 'add_date')
    {
        if (!empty($filters['month']))
        {
            $this->db->where("DATE_FORMAT($field,'%Y-%m')", $filters['month']);
        } elseif (!empty($filters['from_date']) && !empty($filters['to_date']))
        {
            $this->db->where("DATE($field) >= ", $filters['from_date']);
            $this->db->where("DATE($field) <= ", $filters['to_date']);
        }
    }

    public function getSummary($filters)
    {
        $tables = ['purchase_master', 'purchase_master2'];
        $earning_total = $vendor_total = $promoter_total = 0;
        $total_orders = $pending_orders = $total_products = 0;

        foreach ($tables as $table)
        {
            $this->db->reset_query();
            $this->db->select('SUM(final_price) as total, SUM(final_price*0.1) as vendor_earn, SUM(final_price*0.05) as promoter_earn');
            if (!empty($filters['vendor_id']))
                $this->db->where('vendor_id', $filters['vendor_id']);
            if (!empty($filters['promoter_id']))
                $this->db->where('promoter_id', $filters['promoter_id']);
            $this->applyDateFilter($filters);
            $res = $this->db->get($table)->row();
            $earning_total += $res->total ?? 0;
            $vendor_total += $res->vendor_earn ?? 0;
            $promoter_total += $res->promoter_earn ?? 0;

            // Orders
            $this->db->reset_query();
            if (!empty($filters['vendor_id']))
                $this->db->where('vendor_id', $filters['vendor_id']);
            if (!empty($filters['promoter_id']))
                $this->db->where('promoter_id', $filters['promoter_id']);
            $this->applyDateFilter($filters);
            $total_orders += $this->db->count_all_results($table);

            // Pending Orders
            $this->db->reset_query();
            $this->db->where('status', 1);
            if (!empty($filters['vendor_id']))
                $this->db->where('vendor_id', $filters['vendor_id']);
            if (!empty($filters['promoter_id']))
                $this->db->where('promoter_id', $filters['promoter_id']);
            $this->applyDateFilter($filters);
            $pending_orders += $this->db->count_all_results($table);

            // Products
            $this->db->reset_query();
            if (!empty($filters['vendor_id']))
                $this->db->where('vendor_id', $filters['vendor_id']);
            if (!empty($filters['promoter_id']))
                $this->db->where('promoter_id', $filters['promoter_id']);
            $this->applyDateFilter($filters, 'add_date');
            $total_products += $this->db->count_all_results('sub_product_master');
        }

        $total_vendors = $this->db->count_all_results('vendors');
        $total_promoters = $this->db->count_all_results('promoters');

        return [
            'total_earning' => $earning_total,
            'vendor_earning' => $vendor_total,
            'promoter_earning' => $promoter_total,
            'total_orders' => $total_orders,
            'pending_orders' => $pending_orders,
            'total_products' => $total_products,
            'total_vendors' => $total_vendors,
            'total_promoters' => $total_promoters
        ];
    }

    public function getVendors()
    {
        return $this->db->where('status', 1)->get('vendors')->result();
    }
    public function getPromoters()
    {
        return $this->db->where('status', 1)->get('promoters')->result();
    }
}
