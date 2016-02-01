<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administration extends MX_Controller
{
    public function index()
    {
        $this->load_interface('dashboard');
    }

    public function load_interface($interface, $method = 'index', $arguments = null)
    {
        $this->redirect_if_no_login();
        $this->load->model('user_handler');
        $menu_data['user_fname'] = $this->user_handler->get_admin_full_name();
        $menu_data['structure'] = $this->modules_handler->get_interfaces_menu_structure();
        $base_data['menu']= $this->load->view('administration/main_menu',$menu_data , TRUE);

        if($this->user_handler->check_interface_permissions($interface)){
            $if_data = $this->execute_load_interface($interface, $method, $arguments);
            $base_data['content'] = $if_data['content'];
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
        if (isset($if_data) and file_exists(FCPATH . $if_data['js_path'])) {
            $base_data['urls']['aux_js_loader'][] = base_url($if_data['js_path']);
        }
        $this->load->view('administration/base', $base_data);
    }

    public function ajax_interface($interface,$method)
    {
        $this->load->model('user_handler');
        if(!$this->user_handler->check_admin_session())
        {
            echo 'failed - 403: User not authenticated';
            return;
        }
        if ($this->user_handler->check_interface_permissions($interface)) {
            echo $this->execute_load_interface($interface, $method)['content'];
        } else {
            echo 'failed - 403: The user does not have permissions to access this interface';
        }
    }

    protected function execute_load_interface($interface, $method = 'index', $arguments = null)
    {
        if ($interface === 'dashboard') {
            return array('content' => Modules::run('admin_if/' . $interface . '/' . $method, $arguments),
                'js_path' => 'assets/administration/interfaces/' . $interface . '.js',);
        }
        $interface_data = $this->modules_handler->get_interface_data($interface);
        if ($interface_data['builtin'] === true) {
            return array('content' => Modules::run('admin_if/' . $interface . '/' . $method, $arguments),
                'js_path' => 'assets/administration/interfaces/' . $interface . '.js',);
        } else {
            if ($interface_data['location'] === 'full_plugin') {
                $plugin_data = $this->modules_handler->get_plugin_data($interface);
                if ($plugin_data['type'] === 'full' and $plugin_data['enabled'] === true) {
                    $method = ($method === '') ? 'index' : $method;
                    return array('content' => Modules::run('mod_plugins/' . $interface . '/admin_' . $method, $arguments),
                        'js_path' => 'assets/plugins/' . $interface . '/admin_interface.js',);
                }
            } elseif ($interface_data['location'] === 'admin_interface_plugin') {
                $plugin_data = $this->modules_handler->get_plugin_data($interface);
                if ($plugin_data['type'] === 'admin_interface' and $plugin_data['enabled'] === 'true') {
                    return array('content' => Modules::run('admin_if/' . $interface . '/' . $method, $arguments),
                        'js_path' => 'assets/administration/interfaces/' . $interface . '.js',);
                }
            }
        }
        return false;
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