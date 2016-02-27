<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends MX_Controller
{

    public function execute_service($name, $option = null)
    {
        $option = $option===null ? '' : '/'.$option;
        if($this->modules_handler->check_service(strtolower($name)))
        {
            echo Modules::run('mod_services/' . $name . $option);
        }
        else
        {
            $this->output->set_status_header(500);
            $this->output->set_output('The called service does not exists or is disabled');
        }
    }

}