<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Newsletter_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function is_already_subscribed($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('newsletter_subscribers');
        return $query->num_rows() > 0;
    }

    public function subscribe_user($email, $user_id = NULL) {
        $data = [
            'user_id'    => $user_id,
            'email'      => $email,
            'created_at' => date('Y-m-d H:i:s')
        ];
        return $this->db->insert('newsletter_subscribers', $data);
    }
}
