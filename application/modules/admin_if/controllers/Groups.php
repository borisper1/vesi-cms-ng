<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends MX_Controller
{
    function index()
    {
        $data= [];
        $this->load->view('groups/list', $data);
    }
}