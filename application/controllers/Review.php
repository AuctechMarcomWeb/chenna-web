<?php
defined('BASEPATH') OR exit('No direct script access allowed');

define('REVIEW_DIRECTORY', $_SERVER['DOCUMENT_ROOT'] . '/waziwears-7-11-25/assets/customer_review/');

class Review extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Review_model');
        $this->load->library(['form_validation', 'upload']);
    }

    public function add()
    {
        $user = $this->session->userdata('User');
        if (!$user)
        {
            echo json_encode(['status' => 'error', 'message' => 'Please login to submit review']);
            return;
        }

        $user_id = $user['id'];
        $user_name = $user['username'];
        $product_id = (int) $this->input->post('product_id', TRUE);

        // Purchase check
        $purchased = $this->db->select('pm.id')
            ->from('purchase_master pm')
            ->join('order_master om', 'pm.order_master_id=om.id')
            ->where('om.user_master_id', $user_id)
            ->where('pm.product_master_id', $product_id)
            ->where('om.payment_status', 'Paid')
            ->where_in('pm.status', [3, 5])
            ->get()->row();

        if (!$purchased)
        {
            echo json_encode(['status' => 'error', 'message' => 'You can only review purchased products']);
            return;
        }


        $this->load->library('form_validation');
        $this->form_validation->set_rules('rating', 'Rating', 'required|numeric');
        $this->form_validation->set_rules('review_text', 'Review', 'required|max_length[2000]');

        if ($this->form_validation->run() === FALSE)
        {
            echo json_encode(['status' => 'error', 'message' => strip_tags(validation_errors())]);
            return;
        }

        $reviewData = [
            'product_id' => $product_id,
            'user_id' => $user_id,
            'user_name' => $user_name,
            'rating' => $this->input->post('rating'),
            'review_text' => $this->input->post('review_text', FALSE),
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('customer_review', $reviewData);

        $review_id = $this->db->insert_id();

        if (!$review_id)
        {
            echo json_encode(['status' => 'error', 'message' => 'Failed to submit review']);
            return;
        }


        $uploadedImages = [];

        if (!empty($_FILES['review_images']['name'][0]))
        {

            $files = $_FILES['review_images'];
            $count = count($files['name']);

            if ($count > 10)
            {
                echo json_encode(['status' => 'error', 'message' => 'Maximum 5 images allowed']);
                return;
            }

            for ($i = 0; $i < $count; $i++)
            {

                if ($files['error'][$i] != 0)
                    continue;

                $ext = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];

                if (!in_array(strtolower($ext), $allowed))
                    continue;

                $fileName = 'review_' . $review_id . '_' . time() . '_' . $i . '.' . $ext;
                $path = REVIEW_DIRECTORY . $fileName;

                if (move_uploaded_file($files['tmp_name'][$i], $path))
                {
                    $uploadedImages[] = $fileName;
                }
            }
        }

        if (!empty($uploadedImages))
        {
            $this->db->where('id', $review_id)
                ->update('customer_review', [
                    'image' => implode(',', $uploadedImages)
                ]);
        }

        echo json_encode(['status' => 'success', 'message' => 'Thanks for sharing your feedback!']);
    }

    public function reaction()
    {
        $user = $this->session->userdata('User');
        if (!$user)
        {
            echo json_encode(['status' => 'login']);
            return;
        }

        $user_id = $user['id'];
        $review_id = (int) $this->input->post('review_id');
        $product_id = (int) $this->input->post('product_id');
        $action = $this->input->post('action');

        $purchased = $this->db->select('pm.id')
            ->from('purchase_master pm')
            ->join('order_master om', 'pm.order_master_id = om.id')
            ->where('om.user_master_id', $user_id)
            ->where('pm.product_master_id', $product_id)
            ->where('om.payment_status', 'Paid')
            ->where_in('pm.status', [3, 5])
            ->get()->row();

        if (!$purchased)
        {
            echo json_encode(['status' => 'not_purchased']);
            return;
        }
        $exists = $this->db->get_where('review_like_dislike', [
            'review_id' => $review_id,
            'user_id' => $user_id
        ])->row();

        if ($exists)
        {
            $this->db->update(
                'review_like_dislike',
                ['action' => $action],
                ['id' => $exists->id]
            );
        } else
        {
            $this->db->insert('review_like_dislike', [
                'review_id' => $review_id,
                'user_id' => $user_id,
                'action' => $action
            ]);
        }

        $like = $this->db->where([
            'review_id' => $review_id,
            'action' => 'like'
        ])->count_all_results('review_like_dislike');

        $dislike = $this->db->where([
            'review_id' => $review_id,
            'action' => 'dislike'
        ])->count_all_results('review_like_dislike');

        echo json_encode([
            'status' => 'success',
            'like' => $like,
            'dislike' => $dislike
        ]);
    }

}
