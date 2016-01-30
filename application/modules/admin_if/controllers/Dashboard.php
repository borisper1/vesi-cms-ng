<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller
{
    function index()
    {
        $this->load->model('dashboard_model');
        $data = $this->dashboard_model->get_data();
        $this->load->view('dashboard/main', $data);
    }
}