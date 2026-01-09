<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_send {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('email');
    }

    public function send_email($email_id, $email_body, $subject)
    {
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'ratnaauctech@gmail.com',
            'smtp_pass' => 'sbxc jbig tnty qmrq',  // App password
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        );

        $this->CI->email->initialize($config);
        $this->CI->email->set_newline("\r\n");
        $this->CI->email->from('ratnaauctech@gmail.com', 'Chenna');
        $this->CI->email->to($email_id);
        $this->CI->email->subject($subject);
        $this->CI->email->message($email_body);

        if($this->CI->email->send()){
            return true;
        } else {
            echo $this->CI->email->print_debugger(); // error show karega
            return false;
        }
    }
}
