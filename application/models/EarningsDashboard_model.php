<?php
class EarningsDashboard_model extends CI_Model
{

    private function applyDateFilter($filters, $field = 'created_at')
    {
        if (!empty($filters['month']))
        {
            $this->db->where("DATE_FORMAT($field,'%Y-%m') =", $filters['month']);
        } elseif (!empty($filters['from_date']) && !empty($filters['to_date']))
        {
            $this->db->where("DATE($field) >=", $filters['from_date']);
            $this->db->where("DATE($field) <=", $filters['to_date']);
        }
    }

    public function getSummary($filters)
    {
        $applyFilters = function ($tableAlias = '') use ($filters) {
            if (!empty($filters['vendor_id']))
            {
                $this->db->where(($tableAlias ? "$tableAlias." : '') . 'vendor_id', $filters['vendor_id']);
            }
            if (!empty($filters['promoter_id']))
            {
                $this->db->where(($tableAlias ? "$tableAlias." : '') . 'promoter_id', $filters['promoter_id']);
            }
            $field = $tableAlias ? "$tableAlias.created_at" : 'created_at';
            $this->applyDateFilter($filters, $field);
        };

        $this->db->reset_query();
        $this->db->select("
            IFNULL(SUM(CASE WHEN status = 1 THEN earning_amount ELSE 0 END),0) AS total_earning,
            IFNULL(SUM(CASE WHEN vendor_id != 0 AND status = 1 THEN earning_amount ELSE 0 END),0) AS vendor_earning,
            IFNULL(SUM(CASE WHEN promoter_id != 0 AND status = 1 THEN earning_amount ELSE 0 END),0) AS promoter_earning
        ");
        $applyFilters();
        $earningRow = $this->db->get('vendor_earnings_master')->row();


        $this->db->reset_query();
        $applyFilters();
        $this->db->where('status', 1);
        $total_orders = $this->db->count_all_results('vendor_earnings_master');

        $this->db->reset_query();
        $applyFilters();
        $this->db->where('status', 0);
        $pending_orders = $this->db->count_all_results('vendor_earnings_master');


        $this->db->reset_query();
        $this->db->select('COUNT(DISTINCT id) AS total_products');
        if (!empty($filters['vendor_id']))
            $this->db->where('vendor_id', $filters['vendor_id']);
        if (!empty($filters['promoter_id']))
            $this->db->where('promoter_id', $filters['promoter_id']);
        $this->applyDateFilter($filters, 'add_date');
        $total_products = $this->db->get('sub_product_master')->row()->total_products ?? 0;


        $this->db->reset_query();
        $this->db->from('vendors v');


        if (!empty($filters['promoter_id']))
        {
            $this->db->where('v.promoter_id', $filters['promoter_id']);
        }


        if (!empty($filters['vendor_id']))
        {
            $this->db->where('v.id', $filters['vendor_id']);
        }

        $total_vendors = $this->db->count_all_results();


        $vendor_earning_to_show = $total_vendors > 0 ? $earningRow->vendor_earning : 0;


        $this->db->reset_query();
        $this->db->from('promoters p');
        $this->db->join('vendor_earnings_master ve', 've.promoter_id = p.id', 'inner');
        $applyFilters('ve');
        $total_promoters = $this->db->count_all_results();

        return [
            'total_earning' => $earningRow->total_earning,
            'vendor_earning' => $vendor_earning_to_show,
            'promoter_earning' => $earningRow->promoter_earning,
            'total_orders' => $total_orders,
            'pending_orders' => $pending_orders,
            'total_products' => $total_products,
            'total_vendors' => $total_vendors,
            'total_promoters' => $total_promoters
        ];
    }


    public function getVendors()
    {
        return $this->db->get('vendors')->result();
    }

    public function getPromoters()
    {
        return $this->db->get('promoters')->result();
    }

    public function getVendorsByPromoter($promoter_id)
    {
        if (!empty($promoter_id))
        {
            $this->db->where('promoter_id', $promoter_id);
        }
        return $this->db->get('vendors')->result();
    }
}
