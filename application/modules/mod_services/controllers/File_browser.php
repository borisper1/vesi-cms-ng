<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File_browser extends MX_Controller
{
    function index()
    {
        $function_number = $this->input->get('CKEditorFuncNum');
        $this->load->library('file_handler');
        $data['function_number'] = $function_number;
        $data['path'] = '/';
        $data['path_array'] = $this->file_handler->get_root_path_array();
        $data['urls'] = $this->resources->get_administration_urls();
        $this->load->view('file_browser/main_window', $data);
    }

    protected function is_path_unsafe($path)
    {
        $path_array = explode('/', $path);
        return (!in_array($path_array[0], array('files', 'img'))) or in_array('..', $path_array);
    }

    function get_path_picker_table()
    {
        $path = rawurldecode($this->input->post('path'));
        $mode = $this->input->post('mode');
        $this->load->library('file_handler');
        if ($path === '/')
        {
            $data = array('files' => $this->file_handler->get_root_path_array());
        }
        else
        {
            if ($this->is_path_unsafe($path))
            {
                $this->output->set_status_header(403);
                $this->output->set_output('The path indicated is reserved to the system');
                return;
            }
            $data = array('files' => $this->file_handler->get_path_array($path));
            if ($mode === 'only_folders')
            {
                foreach ($data['files'] as $key => $item)
                {
                    if ($item['type'] !== 'folder')
                    {
                        unset($data['files'][$key]);
                    }
                }
            }
        }
        $this->load->view('file_browser/file_picker_table', $data);
    }

}