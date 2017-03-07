<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Email_wrapper
{
    protected $CI, $email_config;

    function __construct()
    {
        $this->CI = &get_instance();
        $this->email_config = array(
            'protocol'=> 'smtp',
            'mailtype' => 'html',
            'newline' => "\r\n",
            'crlf' => "\r\n",
            'charset' => 'utf-8',
            'smtp_crypto' => $this->CI->db_config->get('email', 'smtp_ssl'),
            'smtp_port' => intval($this->CI->db_config->get('email', 'smtp_port')),
            'smtp_user' => $this->CI->db_config->get('email', 'smtp_user'),
            'smtp_host' => $this->CI->db_config->get('email', 'smtp_hostname'),
            'smtp_pass' => $this->CI->db_config->get('email', 'smtp_password'),
        );
    }

    function send_mail($to, $subject, $html)
    {
        $this->CI->load->library('email');
        $this->CI->email->initialize($this->email_config);

        $this->CI->email->from($this->CI->db_config->get('email', 'smtp_address'), $this->CI->config->item('site_name'));
        $this->CI->email->to(array_column($to, 'email'));

        $this->CI->email->subject($subject);
        $this->CI->email->message($html);

        return $this->CI->email->send();
    }
}