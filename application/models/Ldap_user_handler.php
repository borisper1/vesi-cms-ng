<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ldap_user_handler extends CI_Model
{
    protected $ldap_settings, $connection;

    function __construct()
    {
        $this->ldap_settings = array(
            'ssl' => intval($this->CI->db_config->get('authentication', 'ldap_ssl')),
            'mode' => intval($this->CI->db_config->get('authentication', 'ldap_mode')),
            'port' => intval($this->CI->db_config->get('authentication', 'ldap_port')),
            'user' => $this->CI->db_config->get('authentication', 'ldap_user'),
            'base_dn' => $this->CI->db_config->get('authentication', 'ldap_base_dn'),
            'hostname' => $this->CI->db_config->get('authentication', 'ldap_hostname'),
            'password' => $this->CI->db_config->get('authentication', 'ldap_password'),
        );
        parent::__construct();
    }

    private function generate_conn_url()
    {
        if ($this->ldap_settings['ssl']) {
            return 'ldaps://' . $this->ldap_settings['hostname'];
        }
        return 'ldap://' . $this->ldap_settings['hostname'];
    }

    function ldap_admin_connect()
    {
        $this->connection = ldap_connect($this->generate_conn_url(), $this->ldap_settings['port']);
        ldap_set_option($this->connection, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->connection, LDAP_OPT_REFERRALS, 0);
        return ldap_bind($this->connection, $this->ldap_settings['user'], $this->ldap_settings['password']);
    }

    function ldap_bind_connect($username, $password)
    {
        $this->connection = ldap_connect($this->generate_conn_url(), $this->ldap_settings['port']);
        ldap_set_option($this->connection, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->connection, LDAP_OPT_REFERRALS, 0);
        return ldap_bind($this->connection, $username, $password);
    }

    function get_ldap_user_info($username)
    {
        $return_array = [];
        $result = ldap_search($this->connection, $this->ldap_settings['base_dn'], '(userPrincipalName=' . $username . ')');
        if (!$result) {
            return false;
        }
        $entries = ldap_count_entries($this->connection, $result);
        if ($entries['count'] === 1) {
            $return_array['full_name'] = isset($entries[0]['displayName']) ? $entries[0]['displayName'] : null;
            $return_array['given_name'] = isset($entries[0]['givenName']) ? $entries[0]['givenName'] : null;
            $return_array['cn'] = isset($entries[0]['cn']) ? $entries[0]['cn'] : null;
            $return_array['sn'] = isset($entries[0]['sn']) ? $entries[0]['sn'] : null;
            $return_array['name'] = isset($entries[0]['name']) ? $entries[0]['name'] : null;
            $return_array['email'] = isset($entries[0]['mail']) ? $entries[0]['mail'] : null;
            $return_array['title'] = isset($entries[0]['title']) ? $entries[0]['title'] : null;
            $return_array['groups'] = isset($entries[0]['memberOf']) ? $entries[0]['memberOf'] : null;
        } else {
            return false;
        }
        return $return_array;
    }


    function ldap_clear()
    {
        ldap_unbind($this->connection);
    }


}