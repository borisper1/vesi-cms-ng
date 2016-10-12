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
        $this->load->model('group_handler');
        if ($user === 'new') {
            $this->load->view('users/new');
        } else {
            $this->load->model('authentication_handler');
            $user_data = $this->authentication_handler->get_user_data($user);
            $data = array(
                    'admin_groups' => $this->group_handler->get_group_list(),
                    'frontend_groups' => [],
                ) + $user_data;
            if ($data['type'] == 1) {
                $this->load->view('users/edit_ldap', $data);
            } else {
                $this->load->view('users/edit_local', $data);
            }
        }
    }

}
