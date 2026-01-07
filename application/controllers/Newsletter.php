<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Newsletter extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Newsletter_model');
        $this->load->library('session');
    }

    public function subscribe_user() {
        $email = $this->input->post('email', TRUE);

        // Email validate
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status'  => 'error',
                    'message' => 'Invalid email address.'
                ]));
        }

        // Duplicate check
        if ($this->Newsletter_model->is_already_subscribed($email)) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status'  => 'info',
                    'message' => 'This email is already subscribed.'
                ]));
        }

        $user_id = NULL;
        $user = $this->session->userdata('User'); 
        if (!empty($user['id'])) {
            $user_id = $user['id'];
        }

        // Insert new subscriber
        if ($this->Newsletter_model->subscribe_user($email, $user_id)) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status'  => 'success',
                    'message' => 'You have successfully subscribed.'
                ]));
        } else {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status'  => 'error',
                    'message' => 'Subscription failed. Please try again.'
                ]));
        }
    }
}
