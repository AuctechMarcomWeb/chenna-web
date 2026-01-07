

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_send {
    function send_email($email_id, $email_body, $subject)
    {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'ratnaauctech@gmail.com',
            'smtp_pass' => 'your-app-password',
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        );

        $this->CI =& get_instance();
        $this->CI->load->library('email', $config);
        $this->CI->email->from('ratnaauctech@gmail.com', 'Chenna');
        $this->CI->email->to($email_id);
        $this->CI->email->subject($subject);
        $this->CI->email->message($email_body);
        $this->CI->email->send();
    }
}



