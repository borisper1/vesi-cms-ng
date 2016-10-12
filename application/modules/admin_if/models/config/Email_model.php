<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_model extends CI_Model
{
    function get_data()
    {
        $data = array(
            'smtp_hostname' => $this->db_config->get('email', 'smtp_hostname'),
            'smtp_port' => $this->db_config->get('email', 'smtp_port'),
            'smtp_ssl' => (boolean)$this->db_config->get('email', 'smtp_ssl'),
            'smtp_auth' => (boolean)$this->db_config->get('email', 'smtp_auth'),
            'smtp_user' => $this->db_config->get('email', 'smtp_user'),
            'smtp_address' => $this->db_config->get('email', 'smtp_address'),
        );
        return $data;
    }
}