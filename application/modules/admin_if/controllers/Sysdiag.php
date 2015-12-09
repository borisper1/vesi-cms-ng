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

    function rebase_site()
    {
        $url = $this->input->post('url');
        $mode = $this->input->post('mode');
        if(!in_array($mode, array('before', 'after')))
        {
            $this->output-> set_status_header(500);
            die('failed - invaild mode, probable MITM attack');
        }
        if(filter_var($url, FILTER_VALIDATE_URL) === false)
        {
            $this->output-> set_status_header(500);
            die('failed - invaild url');
        }
        if(!$this->endsWith($url, '/'))
        {
            $url = $url.'/';
        }
        $this->load->model('content_handler');
        $data['contents'] = $this->content_handler->rebase_website($mode, $url);
        $this->load->view('sysdiag/filter_html_results', $data);
    }

    private function  endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }
        return (substr($haystack, -$length) === $needle);
    }
}