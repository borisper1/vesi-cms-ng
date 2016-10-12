<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication_model extends CI_Model
{
    function get_data()
    {
        $data = array(
            'enable_ldap' => (boolean)$this->db_config->get('authentication', 'enable_ldap'),
            'ldap_mode' => $this->db_config->get('authentication', 'ldap_mode'),
            'ldap_hostname' => $this->db_config->get('authentication', 'ldap_hostname'),
            'ldap_port' => $this->db_config->get('authentication', 'ldap_port'),
            'ldap_ssl' => (boolean)$this->db_config->get('authentication', 'ldap_ssl'),
            'ldap_user' => $this->db_config->get('authentication', 'ldap_user'),
            'ldap_base_dn' => $this->db_config->get('authentication', 'ldap_base_dn'),
        );
        return $data;
    }
}