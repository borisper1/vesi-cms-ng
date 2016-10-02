<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MX_Controller
{
    function index()
    {
        //Display users list
        $this->load->view('users/list_all');
    }

}
