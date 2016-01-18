<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Plugins extends MX_Controller
{
    function index()
    {
        $this->load->view('plugins/main');
    }
}