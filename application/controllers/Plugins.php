<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plugins extends MX_Controller
{

    public function execute_plugin($name, $option = null)
    {
        $option = $option === null ? '' : '/' . $option;
        if ($this->modules_handler->check_plugin(strtolower($name))) {
            echo Modules::run('mod_plugins/' . $name . $option);
        } else {
            $this->output->set_status_header(500);
            $this->output->set_output('The called plugin does not exists or is disabled');
        }
    }

}