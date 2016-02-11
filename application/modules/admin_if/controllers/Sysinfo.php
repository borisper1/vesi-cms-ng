<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sysinfo extends MX_Controller
{
    function index()
    {
        $data['components'] = $this->modules_handler->get_components_list();
        $data['services'] = $this->modules_handler->get_services_list();
        $data['config_interfaces'] = $this->modules_handler->get_config_interfaces_array();
        $this->load->view('sysinfo', $data);
    }
}