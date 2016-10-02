<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_legacy extends MX_Controller
{

    function index()
    {
        //Display users list
        $this->load->model('user_handler');
        $view_data = [];
        $view_data['userlist'] = $this->user_handler->get_users_list();
        $this->load->view('users_legacy/list', $view_data);
    }

    function edit($user)
    {
        $this->load->model('group_handler');
        if ($user === 'new') {
            $data['groups'] = $this->group_handler->get_group_list();
            $this->load->view('users_legacy/new', $data);
        } else {
            $this->load->model('user_handler');
            $data = $this->user_handler->get_user_data($user);
            $data['groups'] = $this->group_handler->get_group_list();
            $this->load->view('users_legacy/edit', $data);
        }
    }

    function save()
    {
        $this->load->model('user_handler');
        $result = $this->user_handler->save_user(
            $this->input->post('username'),
            $this->input->post('fullname'),
            $this->input->post('email'),
            $this->input->post('password'),
            $this->input->post('group'),
            $this->input->post('active')
        );
        if ($result) {
            echo 'success';
        } else {
            echo 'failed - 500';
        }
    }

    function delete()
    {
        $users = explode(',', $this->input->post('users'));
        $this->load->model('user_handler');
        $result = $this->user_handler->delete_users($users);
        if ($result) {
            echo 'success';
        } else {
            echo 'failed - 500';
        }
    }

    function enable()
    {
        $users = explode(',', $this->input->post('users'));
        $this->load->model('user_handler');
        $result = $this->user_handler->enable_users($users);
        if ($result) {
            echo 'success';
        } else {
            echo 'failed - 500';
        }
    }

    function disable()
    {
        $users = explode(',', $this->input->post('users'));
        $this->load->model('user_handler');
        $result = $this->user_handler->disable_users($users);
        if ($result) {
            echo 'success';
        } else {
            echo 'failed - 500';
        }
    }

    function check_pass()
    {
        $password = $this->input->post('password');
        $result = $this->user_handler->check_admin_login($this->session->username, $password);
        echo $result[0] ? 'success' : 'failed';
    }

    function user_profile()
    {
        $user = $this->session->username;
        $this->load->model('user_handler');
        $data = $this->user_handler->get_user_data($user);
        $this->load->view('users_legacy/self_edit', $data);
    }

    function save_self()
    {
        $this->load->model('user_handler');
        $user = $this->session->username;
        $data = $this->user_handler->get_user_data($user);
        $result = $this->user_handler->save_user(
            $user,
            $data['fullname'],
            $this->input->post('email'),
            $this->input->post('password'),
            $data['group'],
            $data['active']
        );
        if ($result) {
            echo 'success';
        } else {
            echo 'failed - 500';
        }
    }
}