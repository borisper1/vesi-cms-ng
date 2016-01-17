<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administration extends MX_Controller
{
    public function index()
    {
        $this->redirect_if_no_login();
        $this->load->model('user_handler');
        $this->load->library('interfaces_handler');
        $menu_data['user_fname'] = $this->user_handler->get_admin_full_name();
        $menu_data['structure'] = $this->interfaces_handler->get_admin_menu_structure();
        $base_data['menu']= $this->load->view('administration/main_menu',$menu_data , TRUE);

        $base_data['content'] = null;

        $base_data['system_dom'] = $this->load->view('administration/system_reauth',null , TRUE);
        $base_data['system_dom'] .= $this->load->view('administration/code_editor', null, TRUE);
        $base_data['system_dom'] .= $this->load->view('file_conversion_service', null , TRUE);

        $base_data['title']='Dashboard - Vesi-CMS';
        $base_data['urls']=$this->resources->get_administration_urls();
        $this->load->view('administration/base', $base_data);
    }

    public function load_interface($interface,$method,$arguments=null)
    {
        $this->redirect_if_no_login();
        $this->load->model('user_handler');
        $this->load->library('interfaces_handler');
        $menu_data['user_fname'] = $this->user_handler->get_admin_full_name();
        $menu_data['structure'] = $this->interfaces_handler->get_admin_menu_structure();
        $base_data['menu']= $this->load->view('administration/main_menu',$menu_data , TRUE);
        if($this->user_handler->check_interface_permissions($interface)){
            $base_data['content'] = Modules::run('admin_if/'.$interface.'/'.$method,$arguments);
        }
        else
        {
            $base_data['content'] = $this->load->view('administration/not_authorized', array('interface' => $interface), TRUE);
        }
        $base_data['system_dom'] = $this->load->view('administration/system_reauth', null , TRUE);
        $base_data['system_dom'] .= $this->load->view('administration/code_editor', null, TRUE);
        $base_data['system_dom'] .= $this->load->view('file_conversion_service', null , TRUE);

        $base_data['title']='Amministrazione - Vesi-CMS';
        $base_data['urls']=$this->resources->get_administration_urls();
        //Load js file (same name as interface):
        $base_data['urls']['aux_js_loader'][]=base_url('assets/administration/interfaces/'.$interface.'.js');
        $this->load->view('administration/base', $base_data);
    }

    public function ajax_interface($interface,$method)
    {
        $this->load->model('user_handler');
        if(!$this->user_handler->check_admin_session())
        {
            echo 'failed - 403';
            return;
        }
        echo Modules::run('admin_if/'.$interface.'/'.$method);
    }

    public function login()
    {
        $this->load->model('user_handler');
        if($this->user_handler->check_admin_session())
        {
            redirect('admin/index');
        }
        $username=$this->input->post('username');
        $login_data=[];
        if($username!==null){
            $result = $this->user_handler->check_admin_login($username,$this->input->post('password'));
            if($result[0]){
                $this->session->type='administrative';
                $this->session->username = $result[1];
                redirect('admin');
            }
            else
            {
                $this->lang->load('admin_login_lang');

                $login_data['form_class']='has-error';
                $login_data['error_message']=$this->lang->line('admin_login_'.$result[1]);
            }
        }
        else
        {
            $login_data['form_class']='';
            $login_data['error_message']='';
        }
        $base_data=[];
        $login_data['csrf']=array('name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash());
        $base_data['menu']=null;
        $base_data['system_dom']=null;
        $base_data['content']= $this->load->view('administration/login',$login_data , TRUE);

        $base_data['title']='Login - Vesi-CMS';
        $base_data['urls']=$this->resources->get_administration_urls();
        $base_data['urls']['aux_css_loader']=array(base_url('assets/administration/login.css'));
        $this->load->view('administration/base', $base_data);
    }

    protected function redirect_if_no_login()
    {
        $this->load->model('user_handler');
        if(!$this->user_handler->check_admin_session())
        {
            redirect('admin/login');
        }
    }

    public function logout()
    {
        $this->redirect_if_no_login();
        $this->session->sess_destroy();
        redirect('admin');
    }

}