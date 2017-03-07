<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication_handler extends CI_Model
{
    function authenticate($username, $password)
    {
        $this->load->model('local_user_handler');
        if (!$this->local_user_handler->load_user($username)) {
            return array('result' => false, 'status' => 'invalid_credentials');
        }
        $auth_type = $this->local_user_handler->get_auth_type();
        if ($auth_type === 0) {
            if (!$this->local_user_handler->check_credentials($password)) {
                return array('result' => false, 'status' => 'invalid_credentials');
            }
        } elseif ($auth_type === 1) {
            //Check if LDAP is enabled
            if ($this->db_config->get('authentication', 'enable_ldap')) {
                $this->load->model('ldap_user_handler');
                $result = $this->ldap_user_handler->ldap_bind_connect($username, $password);
                if (!$result) {
                    return array('result' => false, 'status' => 'ldap_no_bind');
                }
                $this->ldap_sync_user($username);
                $this->local_user_handler->complete_login($username);
            } else {
                return array('result' => false, 'status' => 'ldap_off');
            }
        }
        $active = $this->local_user_handler->is_active();
        if ($active === 1) {
            return array('result' => false, 'status' => 'user_revoked');
        }
        if ($active === 2) {
            return array('result' => false, 'status' => 'user_locked');
        }
        return array(
            'result' =>true,
            'user' => $username,
            'admin_group' => $this->local_user_handler->get_admin_group(),
            'frontend_group' =>$this->local_user_handler->get_frontend_group(),
        );
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
                $this->session->frontend_group = $this->local_user_handler->get_frontend_group();
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
        $ldap_groups =[];
        if ($ldap_enabled) {
            $ldap_failed = !$this->ldap_user_handler->ldap_admin_connect();
            if(!$ldap_failed)
            {
                $ldap_groups = $this->ldap_user_handler->get_all_groups();
            }
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
            'frontend_users' => $frontend_users,
            'ldap_groups' => $ldap_groups,
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
            'last_login' => $user->last_login,
            'pending_pwd_reset' => $user->auth_method == 0 ? ($this->check_pending_pwd_requests($user->username) != false) : false
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
        $this->load->model('ldap_user_handler');
        $this->load->model('local_user_handler');
        $this->load->model('group_handler');
        $result = $this->ldap_user_handler->get_ldap_user_info($username);
        $sync_email = (bool)$this->db_config->get('authentication', 'ldap_sync_email');
        $write_array = [];
        $write_array['full_name'] = strip_tags($result['full_name']);
        if ($sync_email and $result['email']) {
            $write_array['email'] = strip_tags($result['email']);
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

    function request_password_reset($user, $new_user = false)
    {
        $this->load->model('local_user_handler');
        if (!$this->local_user_handler->load_user($user) ) {
            return false;
        }
        if($this->local_user_handler->get_auth_type() != 0)
        {
            return false;
        }
        if ($this->check_pending_pwd_requests($user)) {
            return false;
        }
        $token = bin2hex($this->security->get_random_bytes(32));
        $id = uniqid();
        $time = date('Y-m-d H:i:s');
        $expires = date('Y-m-d H:i:s', strtotime('+24 hours'));
        $this->lang->load('email_templates_lang');

        $website_name = $this->db_config->get('general', 'website_name');
        if ($new_user) {
            $template = trim($this->lang->line('email_templates_new_user_set_password'));
            $subject = 'Registrazione nuovo utente - ' . $website_name;
            $template = str_replace('[[user]]', $user, $template);
        } else {
            $template = trim($this->lang->line('email_templates_password_reset'));
            $subject = 'Richiesta reset password - ' . $website_name;
        }
        $email = str_replace('[[website]]', $website_name, $template);
        $email = str_replace('[[url]]', base_url('system/pwd_reset/' . $id . '/' . $token), $email);
        $this->load->library('email_wrapper');
        $to = [];
        $to[] = array(
            'name' => $this->local_user_handler->get_full_name(),
            'email' => $this->local_user_handler->get_email()
        );
        $result = $this->email_wrapper->send_mail($to, $subject, $email);
        if ($result) {
            $data = array(
                'token' => $token,
                'user' => $user,
            );
            $data = json_encode($data);
            $this->load->model('pending_operations_handler');
            $result2 = $this->pending_operations_handler->register_new_operation($id, $time, $expires, 'authentication', 'pwd_reset', $data);
            if ($result2) {
                return true;
            }
        }
        return false;
    }

    function check_pending_pwd_requests($user)
    {
        $this->load->model('pending_operations_handler');
        $ops = $this->pending_operations_handler->get_pending_operations('authentication', 'pwd_reset');
        foreach ($ops as $op) {
            $op_data = json_decode($op['data']);
            if ($op_data->user == $user and new DateTime() < new DateTime($op['expires'])) {
                return true;
            }
        }
        return false;
    }

    function check_pwd_reset_request($id, $token)
    {
        $this->load->model('pending_operations_handler');
        $op = $this->pending_operations_handler->get_operation_by_id($id);
        if ($op == false) {
            return false;
        }
        if (!($op['module'] === 'authentication' and $op['operation'] === 'pwd_reset')) {
            return false;
        }
        if ($op['data']->token === $token) {
            return $op['data']->user;
        }
        return false;
    }

    function execute_password_change($request_id, $token, $password)
    {
        $user = $this->check_pwd_reset_request($request_id, $token);
        if ($user == false or strlen($password) < 8) {
            return false;
        }
        $this->load->model('pending_operations_handler');
        $this->load->model('local_user_handler');
        $result = $this->local_user_handler->set_new_password($user, $password);
        $this->pending_operations_handler->remove_operation_by_id($request_id);
        return $result;
    }

    function reset_pending_pwd_reset_request($user)
    {
        $this->load->model('pending_operations_handler');
        $ops = $this->pending_operations_handler->get_pending_operations('authentication', 'pwd_reset');
        $result = true;
        foreach ($ops as $op) {
            $op_data = json_decode($op['data']);
            if ($op_data->user == $user) {
                $part_result = $this->pending_operations_handler->remove_operation_by_id($op['id']);
                if(!$part_result)
                {
                    $result = false;
                }
            }
        }
        return $result;
    }

    function add_users_from_ldap($users)
    {
        $this->load->model('local_user_handler');
        $result = true;
        foreach($users as $user){
            if(!$this->local_user_handler->load_user($user))
            {
                $data = array(
                    'username' => $user,
                    'auth_method' => 1,
                    'password' => null,
                    'admin_group' => 'ldap::',
                    'frontend_group' => 'ldap::',
                    'full_name' => null,
                    'email' => null,
                    'active' => 0,
                    'failed_access' => 0
                );
                $part_result = $this->local_user_handler->create_new($data);
                if(!$part_result)
                {
                    $result = false;
                }
            }
        }
        return $result;
    }

    function ldap_manual_bind($user, $password)
    {
        $this->load->model('ldap_user_handler');
        $result = $this->ldap_user_handler->ldap_bind_connect($user, $password);
        if($result)
        {
            return $this->add_users_from_ldap(array($user));
        }
        return false;
    }

    function admin_password_change($user, $password)
    {
        if ($user == false or strlen($password) < 8) {
            return false;
        }
        $this->load->model('local_user_handler');
        return $this->local_user_handler->set_new_password($user, $password);
    }

    function check_frontend_session()
    {
        if ($this->session->type !== 'administrative' and $this->session->type !== 'frontend') {
            return false;
        }
        $this->load->model('local_user_handler');
        if ($this->local_user_handler->load_user($this->session->username)) {
            if ($this->local_user_handler->is_active() === 0) {
                $this->session->admin_group = $this->local_user_handler->get_admin_group();
                $this->session->frontend_group = $this->local_user_handler->get_frontend_group();
                return true;
            }
        }
        return false;
    }

    function request_frontend_permission($permission)
    {
        $this->load->model('group_handler');
        if ($this->check_frontend_session()) {
            $group_data = $this->group_handler->parse_frontend_group($this->session->frontend_group);
            if ($group_data !== false) {
                return in_array($permission, $group_data['allowed_permission']);
            }
        }
        return false;
    }
}