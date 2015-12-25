<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends MX_Controller
{

    public function execute_service($name, $option = null)
    {
        $option = $option===null ? '' : '/'.$option;
        Modules::run('mod_services/'.$name.$option);
    }

}