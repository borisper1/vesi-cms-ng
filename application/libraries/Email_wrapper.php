<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Email_wrapper
{
    protected $CI, $smtp_data;

    function __construct()
    {
        $this->CI = &get_instance();
        $this->smtp_data = array(
            'ssl' => $this->CI->db_config->get('email', 'smtp_ssl'),
            'auth' => $this->CI->db_config->get('email', 'smtp_auth'),
            'port' => $this->CI->db_config->get('email', 'smtp_port'),
            'user' => $this->CI->db_config->get('email', 'smtp_user'),
            'address' => $this->CI->db_config->get('email', 'smtp_address'),
            'hostname' => $this->CI->db_config->get('email', 'smtp_hostname'),
            'password' => $this->CI->db_config->get('email', 'smtp_password'),
        );
        require_once(APPPATH . 'third_party/PHPMailer/PHPMailerAutoload.php');
    }

    function send_mail($to, $subject, $html)
    {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = $this->smtp_data['hostname'];
        $mail->SMTPAuth = $this->smtp_data['auth'];
        $mail->Username = $this->smtp_data['user'];
        $mail->Password = $this->smtp_data['password'];
        $mail->SMTPSecure = $this->smtp_data['ssl'];
        $mail->Port = $this->smtp_data['port'];
        $mail->setFrom($this->smtp_data['address'], $this->CI->config->item('site_name'));
        foreach ($to as $recipient) {
            $mail->addAddress($recipient['email'], $recipient['name']);
        }
        $mail->Subject = $subject;
        $mail->msgHTML($html);
        $mail->send();
    }
}