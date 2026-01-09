<?php
function is_not_logged_in()
{
    $CI =& get_instance();
    if (!$CI->session->userdata('adminData')) {
        redirect('admin/Welcome');
    }
}
?>