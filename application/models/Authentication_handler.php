<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication_handler extends CI_Model
{
    function authenticate_admin($username, $password)
    {
        $this->load->model('local_user_handler');
        if (!$this->local_user_handler->load_user($username)) {
            return array(false, 'invalid_credentials');
        }
        $auth_type = $this->local_user_handler->get_auth_type();
        if ($auth_type === 0) {
            //Standard local user
            if (!$this->local_user_handler->check_credentials($password)) {
                return array(false, 'invalid_credentials');
            }
        } elseif ($auth_type === 1) {
            //TODO: Check LDAP User password and Sync LDAP user (handled by Ldap_user_handler)
        }

        $active = $this->local_user_handler->is_active();
        if ($active === 1) {
            return array(false, 'user_revoked');
        }
        if ($active === 2) {
            return array(false, 'user_locked');
        }
        //WARNING LDAP group synchronization happens only ONCE AT LOGIN, to enforce new groups all sessions must be revoked!
        $admin_group = $this->local_user_handler->get_admin_group();
        return array(true, $username, $admin_group);
    }

    function check_admin_session()
    {
        if ($this->session->type !== 'administrative') {
            return false;
        }
        $this->load->model('local_user_handler');
        if ($this->local_user_handler->load_user($this->session->username)) {
            if ($this->local_user_handler->is_active() === 0) {
                $this->session->admin_group = $this->local_user_handler->get_admin_group();
                return true;
            }
        }
        return false;
    }

    function get_full_name($username)
    {
        $this->load->model('local_user_handler');
        if (!$this->local_user_handler->load_user($username)) {
            return false;
        }
        return $this->local_user_handler->get_full_name();
    }

    function prepare_users_list()
    {
        $this->load->model('local_user_handler');
        $local_db = $this->local_user_handler->get_full_user_db_list();
        $ldap_enabled = (boolean)$this->db_config->get('authentication', 'enable_ldap');
        if ($ldap_enabled) {
            //TODO: DO A LDAP test HERE
            $ldap_failed = false;
        } else {
            $ldap_failed = false;
        }
        $ldap_users_deleted = false;
        $ldap_users_obsolete_sync = false;
        $ldap_leftovers = false;
        $admin_users = [];
        $frontend_users = [];
        foreach ($local_db as $user) {
            $result = $this->process_user_data($user, $ldap_enabled, $ldap_failed);
            $ldap_users_deleted = $result['ldap_error'] == 3 ? true : $ldap_users_deleted;
            $ldap_users_obsolete_sync = $result['ldap_error'] == 2 ? true : $ldap_users_obsolete_sync;
            $ldap_leftovers = $result['ldap_leftovers'] ? true : $ldap_leftovers;
            if ($user->admin_group != '') {
                $admin_users[] = $result['user_data'];
            } else {
                $frontend_users[] = $result['user_data'];
            }

        }
        return array(
            'ldap_enabled' => $ldap_enabled,
            'ldap_failed' => $ldap_failed,
            'ldap_leftovers' => $ldap_leftovers,
            'ldap_users_deleted' => $ldap_users_deleted,
            'ldap_users_obsolete_sync' => $ldap_users_obsolete_sync,
            'admin_users' => $admin_users,
            'frontend_users' => $frontend_users
        );
    }

    private function process_user_data($user_row, $ldap_enabled, $ldap_failed)
    {
        $user = $user_row;
        $result = [];
        if (intval($user->auth_method) === 0) {
            //Local user, disable all LDAP flags
            $ldap_array = array(
                'ldap_error' => 0,
                'ldap_no_local_group' => false,
                'admin_group_from_ldap' => false,
                'frontend_group_from_ldap' => false
            );
        } elseif (intval($user->auth_method) === 1) {
            $result['ldap_leftovers'] = !$ldap_enabled;
            if (!$ldap_enabled or $ldap_failed) {
                $ldap_array = array(
                    'ldap_error' => 1,
                    'ldap_no_local_group' => false,
                    'admin_group_from_ldap' => false,
                    'frontend_group_from_ldap' => false
                );
            } else {
                $ldap_array = [];
                //TODO: Check LDAP USER exists
                $ldap_array['admin_group_from_ldap'] = true;
                $ldap_array['ldap_no_local_group'] = ($user->frontend_group == 'ldap::' and $user->admin_group == 'ldap::');
                if (strpos($user->admin_group, 'ldap::') === 0) {
                    //LDAP derived group
                    $ldap_array['admin_group_from_ldap'] = true;
                    $user->admin_group = substr($user->admin_group, 6);
                }
                if (strpos($user->frontend_group, 'ldap::') === 0) {
                    //LDAP derived group
                    $ldap_array['frontend_group_from_ldap'] = true;
                    $user->frontend_group = substr($user->frontend_group, 6);
                }
                $ldap_array['ldap_error'] = 0;
                if (strtotime($user->last_login) <= strtotime("-7 days")) {
                    $ldap_array['ldap_error'] = 2;
                }
            }

        }
        $result['user_data'] = array(
            'username' => $user->username,
            'type' => intval($user->auth_method),
            'admin_group' => $user->admin_group,
            'frontend_group' => $user->frontend_group,
            'full_name' => $user->full_name,
            'email' => $user->email,
            'active' => intval($user->active),
            'status' => intval($user->active) === 1 ? (intval($user->failed_access) < 5 ? 1 : 2) : 0,
        );
        $result['user_data'] += $ldap_array;
        return $result;
    }

    function get_user_data($username)
    {
        $this->load->model('local_user_handler');
        $ldap_enabled = (boolean)$this->db_config->get('authentication', 'enable_ldap');

        if (!$this->local_user_handler->load_user($username)) {
            return false;
        }
        $user = $this->local_user_handler->get_full_user_data();
        if ($ldap_enabled) {
            //TODO: DO A LDAP test HERE
            $ldap_failed = false;
        } else {
            $ldap_failed = false;
        }
        $result = $this->process_user_data($user, $ldap_enabled, $ldap_failed);
        return $result['user_data'];

    }


}