<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ldap_user_handler extends CI_Model
{
    protected $ldap_settings, $connection;

    function __construct()
    {
        $this->ldap_settings = array(
            'ssl' => intval($this->db_config->get('authentication', 'ldap_ssl')),
            'port' => intval($this->db_config->get('authentication', 'ldap_port')),
            'user' => $this->db_config->get('authentication', 'ldap_user'),
            'base_dn' => $this->db_config->get('authentication', 'ldap_base_dn'),
            'hostname' => $this->db_config->get('authentication', 'ldap_hostname'),
            'password' => $this->encryption->decrypt($this->db_config->get('authentication', 'ldap_password')),
        );
        parent::__construct();
    }

    private function test_connection()
    {
        $fp = @fsockopen($this->ldap_settings['hostname'], $this->ldap_settings['port'], $errCode, $errStr, 1);
        $result = (bool)$fp;
        if ($result) {
            fclose($fp);
        }
        return $result;
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
        if (!$this->test_connection()) {
            return false;
        }
        $this->connection = ldap_connect($this->generate_conn_url(), $this->ldap_settings['port']);
        ldap_set_option($this->connection, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->connection, LDAP_OPT_REFERRALS, 0);
        return @ldap_bind($this->connection, $this->ldap_settings['user'], $this->ldap_settings['password']);
    }

    function ldap_bind_connect($username, $password)
    {
        if (!$this->test_connection()) {
            return false;
        }
        $this->connection = ldap_connect($this->generate_conn_url(), $this->ldap_settings['port']);
        ldap_set_option($this->connection, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->connection, LDAP_OPT_REFERRALS, 0);
        return @ldap_bind($this->connection, $username, $password);
    }

    function get_ldap_user_info($username)
    {
        $return_array = [];
        $result = ldap_search($this->connection, $this->ldap_settings['base_dn'], "(userPrincipalName=$username)");
        if (!$result) {
            return false;
        }
        $entries = ldap_get_entries($this->connection, $result);
        if ($entries['count'] === 1) {
            $return_array['full_name'] = isset($entries[0]['displayname'][0]) ? $entries[0]['displayname'][0] : null;
            $return_array['given_name'] = isset($entries[0]['givenname'][0]) ? $entries[0]['givenname'][0] : null;
            $return_array['cn'] = isset($entries[0]['cn'][0]) ? $entries[0]['cn'][0] : null;
            $return_array['sn'] = isset($entries[0]['sn'][0]) ? $entries[0]['sn'][0] : null;
            $return_array['name'] = isset($entries[0]['name'][0]) ? $entries[0]['name'][0] : null;
            $return_array['email'] = isset($entries[0]['mail'][0]) ? $entries[0]['mail'][0] : null;
            $return_array['title'] = isset($entries[0]['title'][0]) ? $entries[0]['title'][0] : null;
            $return_array['groups'] = isset($entries[0]['memberof']) ? $entries[0]['memberof'] : null;
        } else {
            return false;
        }
        return $return_array;
    }

    function get_all_groups()
    {
        $return_array = [];
        //Change to objectCategory for better performance on AD if this is an issue
        $result = ldap_search($this->connection, $this->ldap_settings['base_dn'], "(objectClass=group)");
        if (!$result) {
            return false;
        }
        $entries = ldap_get_entries($this->connection, $result);
        if ($entries['count'] > 0) {
            for ($i = 0; $i < $entries['count']; $i++) {
                $return_array[] = array(
                    'dn' => $entries[$i]['distinguishedname'][0],
                    'cn' => $entries[$i]['cn'][0],
                );
            }
        }
        return $return_array;
    }


    function ldap_clear()
    {
        ldap_unbind($this->connection);
    }

    function search_user($query)
    {
        $query = ldap_escape($query, null, LDAP_ESCAPE_FILTER);
        $result = ldap_search($this->connection, $this->ldap_settings['base_dn'], "(& (objectCategory=person) (objectClass=user) (userPrincipalName=$query*))");
        if (!$result) {
            return false;
        }
        $entries = ldap_get_entries($this->connection, $result);
        return $this->process_results($entries);
    }

    function search_users_group($group)
    {
        $group = ldap_escape($group, null, LDAP_ESCAPE_FILTER);
        $result = ldap_search($this->connection, $this->ldap_settings['base_dn'], "(& (objectCategory=person) (objectClass=user) (memberOf=$group))");
        if (!$result) {
            return false;
        }
        $entries = ldap_get_entries($this->connection, $result);
        return $this->process_results($entries);
    }

    private function process_results($entries)
    {
        $return_array = [];
        for($i=0; $i<$entries['count']; $i++)
        {
            $entry_array = array(
                'username' => isset($entries[$i]['userprincipalname'][0]) ? $entries[$i]['userprincipalname'][0] : null,
                'full_name' => isset($entries[$i]['displayname'][0]) ? $entries[$i]['displayname'][0] : null,
                'given_name' => isset($entries[$i]['givenname'][0]) ? $entries[$i]['givenname'][0] : null,
                'cn' => isset($entries[$i]['cn'][0]) ? $entries[$i]['cn'][0] : null,
                'sn' => isset($entries[$i]['sn'][0]) ? $entries[$i]['sn'][0] : null,
                'name' => isset($entries[$i]['name'][0]) ? $entries[$i]['name'][0] : null,
                'email' => isset($entries[$i]['mail'][0]) ? $entries[$i]['mail'][0] : null,
                'title' => isset($entries[$i]['title'][0]) ? $entries[$i]['title'][0] : null,
                'groups' => isset($entries[$i]['memberof']) ? $entries[$i]['memberof'] : null,
            );
            if(isset($entry_array['groups']['count']))
            {
                unset($entry_array['groups']['count']);
            }
            $return_array[] = $entry_array;
        }
        return $return_array;
    }
}