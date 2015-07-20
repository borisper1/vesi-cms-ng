<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MX_Controller
{

    function index()
    {
        //Display users list
        $this->load->model('user_handler');
        $view_data=[];
        $view_data['userlist']=$this->user_handler->get_users_list();
        $this->load->view('users/list',$view_data);
    }

    function edit($user)
    {
        $this->load->model('group_handler');
        if($user==='new')
        {
            $data['groups']=$this->group_handler->get_group_list();
            $this->load->view('users/new',$data);
        }
        else
        {
            $this->load->model('user_handler');
            $data = $this->user_handler->get_user_data($user);
            $data['groups']=$this->group_handler->get_group_list();
            $this->load->view('users/edit',$data);
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
        if($result)
        {
            echo "success";
        }
        else
        {
            echo "failed - 500";
        }
    }

    function delete(){
        $users = explode(',', $this->input->post('users'));
        $this->load->model('user_handler');
        $result = $this->user_handler->delete_users($users);
        if($result)
        {
            echo "success";
        }
        else
        {
            echo "failed - 500";
        }
    }

    function enable(){
        $users = explode(',', $this->input->post('users'));
        $this->load->model('user_handler');
        $result = $this->user_handler->enable_users($users);
        if($result)
        {
            echo "success";
        }
        else
        {
            echo "failed - 500";
        }
    }

    function disable(){
        $users = explode(',', $this->input->post('users'));
        $this->load->model('user_handler');
        $result = $this->user_handler->disable_users($users);
        if($result)
        {
            echo "success";
        }
        else
        {
            echo "failed - 500";
        }
    }
}