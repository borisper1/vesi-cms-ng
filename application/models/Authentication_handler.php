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
            if (!$this->local_user_handler->check_credentials($password)) {
                return array(false, 'invalid_credentials');
            }
        } elseif ($auth_type === 1) {
            //TODO: Check if LDAP is enabled
            $this->load->model('ldap_user_handler');
            $result = $this->ldap_user_handler->ldap_bind_connect($username, $password);
            if (!$result) {
                return array(false, 'ldap_no_bind');
            }
            $this->ldap_sync_user($username);
            $this->local_user_handler->complete_login($username);
        }
        $active = $this->local_user_handler->is_active();
        if ($active === 1) {
            return array(false, 'user_revoked');
        }
        if ($active === 2) {
            return array(false, 'user_locked');
        }
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
        $this->load->model('ldap_user_handler');
        $local_db = $this->local_user_handler->get_full_user_db_list();
        $ldap_enabled = (boolean)$this->db_config->get('authentication', 'enable_ldap');
        if ($ldap_enabled) {
            $ldap_failed = !$this->ldap_user_handler->ldap_admin_connect();
        } else {
            $ldap_failed = false;
        }
        $ldap_users_deleted = false;
        $ldap_leftovers = false;
        $admin_users = [];
        $frontend_users = [];
        foreach ($local_db as $user) {
            $result = $this->process_user_data($user, $ldap_enabled, $ldap_failed);
            $ldap_users_deleted = $result['user_data']['ldap_error'] == 2 ? true : $ldap_users_deleted;
            $ldap_leftovers = $result['ldap_leftovers'] ? true : $ldap_leftovers;
            if ($result['user_data']['admin_group'] != '') {
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
            'admin_users' => $admin_users,
            'frontend_users' => $frontend_users
        );
    }

    private function process_user_data($user, $ldap_enabled, $ldap_failed)
    {
        $result = [];
        if (intval($user->auth_method) === 0) {
            //Local user, disable all LDAP flags
            $ldap_array = array(
                'ldap_error' => 0,
                'no_local_group' => $user->admin_group == '' and $user->frontend_group == '',
                'admin_group_from_ldap' => false,
                'frontend_group_from_ldap' => false
            );
            $result['ldap_leftovers'] = false;
        } elseif (intval($user->auth_method) === 1) {
            $result['ldap_leftovers'] = !$ldap_enabled;
            $ldap_array = array(
                'admin_group_from_ldap' => false,
                'frontend_group_from_ldap' => false,
            );
            if (!$ldap_enabled or $ldap_failed) {
                $ldap_array['ldap_error'] = 1;
            } else {
                $ldap_result = $this->ldap_user_handler->get_ldap_user_info($user->username);
                if ($ldap_result) {
                    $ldap_array['ldap_error'] = 0;
                    $this->ldap_sync_user($user->username);
                    //Reload user data
                    $this->local_user_handler->load_user($user->username);
                    $user = $this->local_user_handler->get_full_user_data();
                } else {
                    $ldap_array['ldap_error'] = 2;
                }
            }
            $ldap_array['no_local_group'] = ($user->frontend_group == 'ldap::' and $user->admin_group == 'ldap::');
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
            'last_login' => $user->last_login
        );
        $result['user_data'] += $ldap_array;
        return $result;
    }

    function get_user_data($username)
    {
        $this->load->model('local_user_handler');
        $this->load->model('ldap_user_handler');
        $ldap_enabled = (boolean)$this->db_config->get('authentication', 'enable_ldap');

        if (!$this->local_user_handler->load_user($username)) {
            return false;
        }
        $user = $this->local_user_handler->get_full_user_data();
        if ($ldap_enabled) {
            $ldap_failed = !$this->ldap_user_handler->ldap_admin_connect();
        } else {
            $ldap_failed = false;
        }
        $result = $this->process_user_data($user, $ldap_enabled, $ldap_failed)['user_data'];
        $result['ldap_failed'] = $ldap_failed;
        $result['ldap_enabled'] = $ldap_enabled;
        return $result;
    }

    function save_user_data($user_type, $data_string)
    {
        $this->load->model('local_user_handler');
        $user_object = json_decode($data_string);
        $username = $user_object->username;
        $write_array = [];
        if ($user_type == 'ldap') {
            if ($user_object->admin_local_group) {
                $write_array['admin_group'] = $user_object->admin_group !== 'none' ? $user_object->admin_group : '';
            } else {
                //Updated on next sync
                $write_array['admin_group'] = 'ldap::';
            }
            if ($user_object->frontend_local_group) {
                $write_array['frontend_group'] = $user_object->frontend_group !== 'none' ? $user_object->frontend_group : '';
            } else {
                //Updated on next sync
                $write_array['frontend_group'] = 'ldap::';
            }
        } else {
            //The user is a local user
            $write_array['admin_group'] = $user_object->admin_group !== 'none' ? $user_object->admin_group : '';
            $write_array['frontend_group'] = $user_object->frontend_group !== 'none' ? $user_object->frontend_group : '';
            $write_array['full_name'] = $user_object->full_name;
            $write_array['email'] = $user_object->email;
        }
        $write_array['active'] = $user_object->active;
        return $this->local_user_handler->save_edit($username, $write_array);
    }

    function ldap_sync_user($username)
    {
        //Check if specific attribute import is enabled
        $this->load->model('ldap_user_handler');
        $this->load->model('local_user_handler');
        $this->load->model('group_handler');
        $result = $this->ldap_user_handler->get_ldap_user_info($username);
        $sync_full_name = true;
        $sync_email = true;
        $write_array = [];
        if ($sync_full_name and $result['full_name']) {
            $write_array['full_name'] = $result['full_name'];
        }
        if ($sync_email and $result['email']) {
            $write_array['email'] = $result['email'];
        }
        //Calculate LDAP Groups if required
        $this->local_user_handler->load_user($username);
        $local_user_obj = $this->local_user_handler->get_full_user_data();
        if (strpos($local_user_obj->admin_group, 'ldap::') === 0) {
            //GET Admin group from  LDAP
            $admin_group_list = (array)$this->group_handler->get_admin_group_list();
            $current_group = array(
                'name' => '',
                'permission_count' => 0
            );
            foreach ($admin_group_list as $admin_group) {
                $ldap_groups = $admin_group['ldap_groups'];
                if (count(array_intersect($ldap_groups, $result['groups'])) > 0) {
                    $admin_group['permission_count'] = count($admin_group['permissions']);
                    if ($admin_group['permission_count'] > $current_group['permission_count']) {
                        $current_group = $admin_group;
                    }
                }
            }
            $write_array['admin_group'] = 'ldap::' . $current_group['name'];
        }
        if (strpos($local_user_obj->frontend_group, 'ldap::') === 0) {
            //GET Frontend group from  LDAP
            $frontend_group_list = (array)$this->group_handler->get_frontend_group_list();
            $current_group = array(
                'name' => '',
                'permission_count' => 0
            );
            foreach ($frontend_group_list as $frontend_group) {
                $ldap_groups = $frontend_group['ldap_groups'];
                if (count(array_intersect($ldap_groups, $result['groups'])) > 0) {
                    $frontend_group['permission_count'] = count($frontend_group['permissions']);
                    if ($frontend_group['permission_count'] > $current_group['permission_count']) {
                        $current_group = $frontend_group;
                    }
                }
            }
            $write_array['frontend_group'] = 'ldap::' . $current_group['name'];
        }
        $this->local_user_handler->save_edit($username, $write_array);
    }
}