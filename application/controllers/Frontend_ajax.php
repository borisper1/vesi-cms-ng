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

}