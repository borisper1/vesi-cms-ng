<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MX_Controller
{
    function index()
    {
        //Display users list
        $this->load->model('authentication_handler');
        $this->load->view('users/list_all', $this->authentication_handler->prepare_users_list());
    }

    function edit($user)
    {
        $user = rawurldecode($user);
        $this->load->model('group_handler');
        if ($user === 'new') {
            $this->load->view('users/new');
        } else {
            $this->load->model('authentication_handler');
            $user_data = $this->authentication_handler->get_user_data($user);
            $data = array(
                    'admin_groups' => $this->group_handler->get_admin_group_list(),
                    'frontend_groups' => $this->group_handler->get_frontend_group_list(),
                ) + $user_data;
            if ($data['type'] == 1) {
                $this->load->view('users/edit_ldap', $data);
            } else {
                $this->load->view('users/edit_local', $data);
            }
        }
    }

    function save_edit()
    {
        $this->load->model('authentication_handler');
        $type = $this->input->post('type');
        $data_string = $this->input->post('data_string');
        $result = $this->authentication_handler->save_user_data($type, $data_string);
        echo $result ? 'success' : 'failed - 500';
    }

    function unlock_user()
    {
        $this->load->model('local_user_handler');
        $this->local_user_handler->load_user($this->input->post('username'));
        $result = $this->local_user_handler->unlock_user();
        echo $result ? 'success' : 'failed - 500';
    }

    function request_password_reset()
    {
        $this->load->model('authentication_handler');
        $user = $this->input->post('user');
        $result = $this->authentication_handler->request_password_reset($user);
        echo $result ? 'success' : 'failed - 500';
    }

    function new_local()
    {
        $this->load->model('local_user_handler');
        $this->load->model('authentication_handler');
        $username = $this->input->post('username');
        $full_name = $this->input->post('full_name');
        $email = $this->input->post('email');
        $mode = $this->input->post('mode');
        $temp_pwd = password_hash(base64_encode($this->security->get_random_bytes(16)), PASSWORD_DEFAULT);
        $data = array(
            'username' => $username,
            'auth_method' => 0,
            'password' => $temp_pwd,
            'full_name' => $full_name,
            'email' => $email,
            'active' => 0,
            'failed_access' => 0
        );
        $result = $this->local_user_handler->create_new($data);
        if (!$result) {
            $this->output->set_status_header(500);
            $this->output->set_output('failed user creation');
            return;
        }
        if ($mode === 'emailpwd') {
            $result2 = $this->authentication_handler->request_password_reset($username, true);
            if (!$result2) {
                $this->output->set_status_header(500);
                $this->output->set_output('failed send password reset email');
                return;
            }
        }
        $this->output->set_status_header(200);
        $this->output->set_output('success');
    }

    function enable()
    {
        $users = explode(',', rawurldecode($this->input->post('users')));
        $this->load->model('local_user_handler');
        $result = $this->local_user_handler->enable_disable_users($users, 1);
        if ($result) {
            echo 'success';
        } else {
            echo 'failed - 500';
        }
    }

    function disable()
    {
        $users = explode(',', rawurldecode($this->input->post('users')));
        $this->load->model('local_user_handler');
        $result = $this->local_user_handler->enable_disable_users($users, 0);
        if ($result) {
            echo 'success';
        } else {
            echo 'failed - 500';
        }
    }

    function delete()
    {
        $users = explode(',', rawurldecode($this->input->post('users')));
        $this->load->model('local_user_handler');
        $result = $this->local_user_handler->delete_users($users);
        if ($result) {
            echo 'success';
        } else {
            echo 'failed - 500';
        }
    }

    function ldap_search_user()
    {
        $query = $this->input->post('query');
        $this->load->model('ldap_user_handler');

    }
}
