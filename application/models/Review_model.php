<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review_model extends CI_Model {

    public function add_review($data)
    {
        $this->db->insert('customer_review', $data);
        return $this->db->insert_id();
    }

    public function get_reviews_by_product($product_id)
    {
        $this->db->select('cr.*, um.username, um.photo_file');
        $this->db->from('customer_review cr');
        $this->db->join('user_master um', 'um.id = cr.user_id', 'left');
        $this->db->where('cr.product_id', $product_id);
        $this->db->where('cr.status',3);
        $this->db->order_by('cr.created_at','DESC');
        return $this->db->get()->result();
    }

    public function get_average_rating($product_id)
    {
        $this->db->select_avg('rating');
        $this->db->where('product_id', $product_id);
        $row = $this->db->get('customer_review')->row();
        return $row ? round($row->rating ?: 0, 1) : 0;
    }

    public function delete_review($id)
    {
        return $this->db->delete('customer_review',['id'=>$id]);
    }
}
