<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sysevents extends MX_Controller
{
    function index()
    {
        $this->load->model('error_logger');
        $data['events'] = $this->error_logger->get_syserror_data();
        $this->load->view('sysevents', $data);
    }

    function mark_all_as_read()
    {
        $this->load->model('error_logger');
        $this->error_logger->mark_all_as_read();
    }

    function delete_all()
    {
        $this->load->model('error_logger');
        $this->error_logger->delete_all();
    }
}