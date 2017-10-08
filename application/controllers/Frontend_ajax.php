<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend_ajax extends MX_Controller
{
    public function change_password()
    {
        $this->load->model('authentication_handler');
        $password = $this->input->post('password');
        $token = $this->input->post('token');
        $request_id = $this->input->post('request-id');
        $result = $this->authentication_handler->execute_password_change($request_id, $token, $password);
        if($result)
        {
            $this->output->set_status_header(200);
            $this->output->set_output('success');
        }
        else
        {
            $this->output->set_status_header(500);
            $this->output->set_output('failed');
        }
    }

    public function ajax_login()
    {
        $this->load->model('authentication_handler');
        if(!$this->db_config->get('authentication', 'enable_frontend'))
        {
            $this->lang->load('admin_login_lang');
            $json['result'] = false;
            $json['error_message']=$this->lang->line('admin_login_frontend_disabled');
            $this->output->set_status_header(200);
            $this->output->set_output(json_encode($json));
        }
        if ($this->authentication_handler->check_frontend_session())
        {
            $this->output->set_status_header(200);
            $json['result'] = true;
            $this->output->set_output(json_encode($json));
        }
        $result = $this->authentication_handler->authenticate($this->input->post('username'), $this->input->post('password'));
        if($result['result'])
        {
            $this->session->type = 'frontend';
            $this->session->username = $result['user'];
            $this->session->frontend_group = $result['frontend_group'];
			if(!$this->authentication_handler->check_frontend_group_active($this->session->frontend_group))
			{
				$this->session->frontend_group = '';
			}
            $this->output->set_status_header(200);
            $json['result'] = true;
            $this->output->set_output(json_encode($json));
        }
        else
        {
            $this->lang->load('admin_login_lang');
            $json['result'] = false;
            $json['error_message']=$this->lang->line('admin_login_'.$result['status']);
            $this->output->set_status_header(200);
            $this->output->set_output(json_encode($json));
        }
    }

    public function ajax_psk_login()
	{
		$this->load->model('authentication_handler');
		if(!$this->db_config->get('authentication', 'enable_frontend') or !$this->db_config->get('authentication', 'enable_psk'))
		{
			$this->lang->load('admin_login_lang');
			$json['result'] = false;
			$json['error_message']=$this->lang->line('admin_login_frontend_disabled');
			$this->output->set_status_header(200);
			$this->output->set_output(json_encode($json));
		}
		if ($this->authentication_handler->check_frontend_session())
		{
			$this->output->set_status_header(200);
			$json['result'] = true;
			$this->output->set_output(json_encode($json));
		}
		$result = $this->authentication_handler->authenticate_psk($this->input->post('key'));
		if($result['result'])
		{
			$this->session->type = 'frontend';
			$this->session->username = $result['user'];
			$this->session->frontend_group = $result['frontend_group'];
			if(!$this->authentication_handler->check_frontend_group_active($this->session->frontend_group))
			{
				$this->session->frontend_group = '';
			}
			$this->output->set_status_header(200);
			$json['result'] = true;
			$this->output->set_output(json_encode($json));
		}
		else
		{
			$this->lang->load('admin_login_lang');
			$json['result'] = false;
			$json['error_message']=$this->lang->line('admin_login_'.$result['status']);
			$this->output->set_status_header(200);
			$this->output->set_output(json_encode($json));
		}
	}

    function request_pwd_reset()
    {
        $this->load->model('authentication_handler');
        $this->load->model('local_user_handler');
        $user = $this->input->post('username');
        $email = $this->input->post('email');
        if((!$this->local_user_handler->load_user($user)) or ($email !== $this->local_user_handler->get_email()))
        {
            $json['result'] = false;
            $json['error_message']='invalid_data';
            $this->output->set_status_header(200);
            $this->output->set_output(json_encode($json));
            return;
        }
        $result = $this->authentication_handler->request_password_reset($user);
        if($result)
        {
            $this->output->set_status_header(200);
            $json['result'] = true;
            $this->output->set_output(json_encode($json));
        }
        else
        {
            $json['result'] = false;
            $json['error_message']='refused';
            $this->output->set_status_header(200);
            $this->output->set_output(json_encode($json));
        }
    }

    function update_user()
    {
        $this->load->model('authentication_handler');
        if (!$this->authentication_handler->check_frontend_session())
        {
            $this->output->set_status_header(403);
            $this->output->set_output('not_authorized');
        }
        $this->load->model('local_user_handler');
        $this->local_user_handler->load_user($this->session->username);
        if($this->local_user_handler->get_auth_type() == 1)
        {
            $email = $this->input->post('email');
            if($email!='' and $this->local_user_handler->save_edit($this->session->username, array('email' => $email)))
            {
                $this->output->set_status_header(200);
                $this->output->set_output('success');
                return;
            }
        }
        else
        {
            $email = $this->input->post('email');
            if($email !='' and $this->local_user_handler->save_edit($this->session->username, array('email' => $email)))
            {

                $this->output->set_status_header(200);
                $this->output->set_output('success');
                return;
            }
            $fullname = $this->input->post('fullname');
            if($fullname !='' and $this->local_user_handler->save_edit($this->session->username, array('full_name' => $fullname)))
            {
                $this->output->set_status_header(200);
                $this->output->set_output('success');
                return;
            }
        }
        $this->output->set_status_header(500);
        $this->output->set_output('failed');
    }

}