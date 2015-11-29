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

    function edit($id)
    {
        $this->load->library('interfaces_handler');
        if($id=='new')
        {
            $data['group_name']="";
            $data['is_new']=true;
        }
        else
        {

            $data['is_new']=false;
        }
        $data['permission_groups'] = $this->interfaces_handler->get_raw_array();
        $this->load->view('groups/edit',$data);
    }
}