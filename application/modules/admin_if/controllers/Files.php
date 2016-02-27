<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Files extends MX_Controller
{
    function index()
    {
        $this->resources->load_aux_js_file('assets/third_party/jquery-file-upload/jquery.fileupload.min.js');
        $this->load->library('file_handler');
        $data = array('files' => $this->file_handler->get_path_array('files'));
        $indicator_data = array('segments' => $this->file_handler->get_path_indicator_array('files'));
        $this->load->view('files/base');
        $this->load->view('files/path_indicator', $indicator_data);
        $this->load->view('files/files', $data);
    }

    function get_path_body()
    {
        $path = rawurldecode($this->input->post('path'));
        if($this->is_path_unsafe($path))
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
        $path = rawurldecode($this->input->post('path'));
        if($this->is_path_unsafe($path))
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
        $path = rawurldecode($this->input->post('path'));
        $new_name = rawurldecode($this->input->post('new_name'));
        if($this->is_path_unsafe($path))
        {
            $this->output->set_status_header(403);
            $this->output->set_output('The path indicated is reserved to the system');
            return;
        }
        $this->load->library('file_handler');
        if($this->file_handler->rename_path($path, $new_name))
        {
            $this->output->set_status_header(200);
            $this->output->set_output('ok');
        }
        else
        {
            $this->output->set_status_header(500);
            $this->output->set_output('Internal server error or bad input charset');
        }
    }

    function delete()
    {
        $paths = explode(';', rawurldecode($this->input->post('paths')));
        foreach($paths as $path)
        {
            if($this->is_path_unsafe($path))
            {
                $this->output->set_status_header(403);
                $this->output->set_output('The path indicated is reserved to the system');
                return;
            }
            $this->load->library('file_handler');
            $this->file_handler->delete_path($path);
        }
        $this->output->set_status_header(200);
        $this->output->set_output('ok');
    }

    function pack()
    {
        $paths = explode(';', rawurldecode($this->input->post('paths')));
        $base_path = rawurldecode($this->input->post('base_path'));
        if ($this->is_path_unsafe($base_path)) {
            $this->output->set_status_header(403);
            $this->output->set_output('The path indicated is reserved to the system');
            return;
        }
        foreach($paths as $path)
        {
            if ($this->is_path_unsafe($path)) {
                $this->output->set_status_header(403);
                $this->output->set_output('The path indicated is reserved to the system');
                return;
            }
        }
        $this->load->library('file_handler');
        $result = $this->file_handler->pack_zip($paths, $base_path);
        if($result)
        {
            $this->output->set_status_header(200);
            $this->output->set_output($result);
        }
        else
        {
            $this->output->set_status_header(500);
            $this->output->set_output('Internal server error or bad input charset');
        }
    }

    function move()
    {
        $paths = explode(';', rawurldecode($this->input->post('paths')));
        $target = rawurldecode($this->input->post('target'));
        if ($this->is_path_unsafe($target)) {
            $this->output->set_status_header(403);
            $this->output->set_output('The path indicated is reserved to the system');
            return;
        }
        foreach($paths as $path)
        {
            $this->load->library('file_handler');
            if ($this->is_path_unsafe($path)) {
                $this->output->set_status_header(403);
                $this->output->set_output('The path indicated is reserved to the system');
                return;
            }
            $this->file_handler->move_path($path, $target);
        }
        $this->output->set_status_header(200);
        $this->output->set_output('ok');
    }

    function copy()
    {
        $paths = explode(';', rawurldecode($this->input->post('paths')));
        $target = rawurldecode($this->input->post('target'));
        if ($this->is_path_unsafe($target)) {
            $this->output->set_status_header(403);
            $this->output->set_output('The path indicated is reserved to the system');
            return;
        }
        foreach($paths as $path)
        {
            $this->load->library('file_handler');
            if ($this->is_path_unsafe($path)) {
                $this->output->set_status_header(403);
                $this->output->set_output('The path indicated is reserved to the system');
                return;
            }
            $this->file_handler->copy_path($path, $target);
        }
        $this->output->set_status_header(200);
        $this->output->set_output('ok');
    }

    function new_folder()
    {
        $path = rawurldecode($this->input->post('path'));
        $name = rawurldecode($this->input->post('name'));
        if($this->is_path_unsafe($path))
        {
            $this->output->set_status_header(403);
            $this->output->set_output('The path indicated is reserved to the system');
            return;
        }
        $this->load->library('file_handler');
        if($this->file_handler->new_folder($path.'/'.$name))
        {
            $this->output->set_status_header(200);
            $this->output->set_output('ok');
        }
        else
        {
            $this->output->set_status_header(500);
            $this->output->set_output('Internal server error or bad input charset');
        }
    }

    protected function is_path_unsafe($path)
    {
        $path_array =explode('/', $path);
        return (!in_array($path_array[0], array('files', 'img'))) or in_array('..', $path_array);
    }
}
