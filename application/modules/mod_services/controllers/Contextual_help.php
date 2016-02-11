<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contextual_help extends MX_Controller
{
    function load_help()
    {
        $path = rawurldecode($this->input->post('path'));
        $items = explode('::', $path);
        $interface = $items[0];
        $sub_heading = $items[1];
        $sub_category = $items[2];
        $path = $interface . ($sub_heading != '' ? '/' . $sub_heading : '') . ($sub_category != '' ? '/' . $sub_category : '') . '.html';
        if (file_exists(APPPATH . 'help/' . $path))
        {
            $this->output->set_status_header(200);
            $this->output->set_output(file_get_contents(APPPATH . 'help/' . $path));
        }
        else
        {
            $this->output->set_status_header(500);
            $this->output->set_output('ERR_NOT_IMPLEMENTED - Tried to load non existing file: help/' . $path);
        }
    }
}