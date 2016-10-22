<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends MX_Controller
{
    function index()
    {
        $this->load->model('group_handler');
        $data['admin_super_users'] = $this->group_handler->get_admin_group_users('super-users');
        $data['admin_groups'] = $this->group_handler->get_admin_group_list();
        $data['frontend_super_users'] = $this->group_handler->get_frontend_group_users('super-users');
        $data['frontend_groups'] = $this->group_handler->get_frontend_group_list();
        $data['ldap_enabled'] = (boolean)$this->db_config->get('authentication', 'enable_ldap');
        $this->load->view('groups/list', $data);
    }

    function edit($id)
    {
        $this->load->model('page_handler');
        if($id=='new')
        {
            $data['group_name']='';
            $data['description']='';
            $data['allowed_interfaces_csv']='';
            $data['use_content_filter']=false;
            $data['content_filter_mode']='whitelist';
            $data['content_filter_directives'] = '';
            $data['is_new']=true;
        }
        else
        {
            $this->load->model('group_handler');
            $data = $this->group_handler->get_group_data($id);
            $data['group_name']=$id;
            $data['is_new']=false;
        }
        $data['permission_groups'] = $this->modules_handler->get_interfaces_raw_array();
        $data['containers']=$this->page_handler->get_containers_list();
        $this->load->view('groups/edit',$data);
    }

    function get_pages()
    {
        $this->load->model('page_handler');
        $pages = $this->page_handler->get_pages_in_container($this->input->post('container'));
        //Upload data in CSV fromat, js generates the DOM <option> elements
        if($pages){
            echo implode(',', $pages);
        }
        else
        {
            echo "failed - 500";
        }
    }

    function save()
    {
        $name = $this->input->post('name');
        $description = rawurldecode($this->input->post('description'));
        $code = rawurldecode($this->input->post('code'));
        $this->load->model('group_handler');
        $response = $this->group_handler->save($name, $description, $code);
        if($response)
        {
            echo 'success';
        }
        else
        {
            echo 'failed - 500';
        }
    }

    function delete(){
        $groups = explode(',', $this->input->post('groups'));
        $this->load->model('group_handler');
        $result = $this->group_handler->delete_groups($groups);
        if($result)
        {
            echo 'success';
        }
        else
        {
            echo 'failed - 500';
        }
    }

    function enable(){
        $groups = explode(',', $this->input->post('groups'));
        $this->load->model('group_handler');
        $result = $this->group_handler->enable_groups($groups);
        if($result)
        {
            echo 'success';
        }
        else
        {
            echo 'failed - 500';
        }
    }

    function disable(){
        $groups = explode(',', $this->input->post('groups'));
        $this->load->model('group_handler');
        $result = $this->group_handler->disable_groups($groups);
        if($result)
        {
            echo 'success';
        }
        else
        {
            echo 'failed - 500';
        }
    }
}