<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Files extends MX_Controller
{
    function index()
    {
        $this->load->library('file_handler');
        $path_array = $this->file_handler->get_path_array('files');
        $data = array('files' => $path_array);
        $this->load->view('files/base');
        $this->load->view('files/files', $data);
    }
}
