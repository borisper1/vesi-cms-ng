<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Files extends MX_Controller
{
    function index()
    {
        $this->load->library('file_handler');
        $data = array('files' => $this->file_handler->get_path_array('files'));
        $indicator_data = array('segments' => $this->file_handler->get_path_indicator_array('files'));
        $this->load->view('files/base');
        $this->load->view('files/path_indicator', $indicator_data);
        $this->load->view('files/files', $data);
    }

    function get_path_body()
    {
        $path = $this->input->post('path');
        if(!in_array(explode('/', $path)[0], array('files', 'img')))
        {
            $this->output->set_status_header(403);
            $this->output->set_output('The path indicated is reserved to the system');
            return;
        }
        $this->load->library('file_handler');
        $data = array('files' => $this->file_handler->get_path_array($path));
        $this->load->view('files/files', $data);
    }

    function get_path_indicator()
    {
        $path = $this->input->post('path');
        if(!in_array(explode('/', $path)[0], array('files', 'img')))
        {
            $this->output->set_status_header(403);
            $this->output->set_output('The path indicated is reserved to the system');
            return;
        }
        $this->load->library('file_handler');
        $indicator_data = array('segments' => $this->file_handler->get_path_indicator_array($path));
        $this->load->view('files/path_indicator', $indicator_data);
    }

    function rename()
    {
        $path = $this->input->post('path');
        $new_name = $this->input->post('new_name');
    }

}
