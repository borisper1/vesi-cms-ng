<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sysdiag extends MX_Controller
{
    function index()
    {
        $this->load->view('sysdiag/sysdiag');
    }

    function filter_html()
    {
        $this->load->model('content_handler');
        $data['contents'] = $this->content_handler->filter_all();
        $this->load->view('sysdiag/filter_html_results', $data);
    }
}