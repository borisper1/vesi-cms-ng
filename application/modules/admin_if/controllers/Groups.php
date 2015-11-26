<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends MX_Controller
{
    function index()
    {
        $this->load->model('group_handler');
        $data['super_users']= $this->group_handler->get_group_users('super-users');
        $data['groups']=$this->group_handler->get_group_list();
        $this->load->view('groups/list', $data);
    }
}