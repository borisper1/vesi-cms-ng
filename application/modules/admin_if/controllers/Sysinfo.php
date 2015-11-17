<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sysinfo extends MX_Controller
{
    function index()
    {
        $this->load->view('sysinfo');
    }
}