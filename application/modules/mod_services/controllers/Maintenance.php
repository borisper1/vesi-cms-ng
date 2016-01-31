<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends MX_Controller
{
    function execute()
    {
        if($this->db_config->get('general', 'enable_automatic_maintenance'))
        {
            $this->load->library('file_handler');
            if($this->db_config->get('resources', 'limit_temp_folder'))
            {
                $limit = $this->db_config->get('resources', 'max_temp_folder_size')*1048576;
                $size = $this->file_handler->get_folder_size_raw(APPPATH.'tmp');
                if($size >= $limit)
                {
                    $this->file_handler->delete_path(APPPATH.'tmp');
                    mkdir(APPPATH.'tmp');
                }
            }
            if($this->db_config->get('file_conversion', 'limit_output_folder'))
            {
                $limit = $this->db_config->get('file_conversion', 'output_folder_max_size')*1048576;
                $size = $this->file_handler->get_folder_size_raw(FCPATH.'files/converted_files');
                if($size >= $limit)
                {
                    $this->file_handler->delete_path(FCPATH.'files/converted_files');
                    mkdir(FCPATH.'files/converted_files');
                }
            }
            $this->output->set_status_header(200);
            $this->output->set_output('OK');
        }
        else
        {
            $this->output->set_status_header(403);
            $this->output->set_output('Automatic maintenance service disabled');
        }
    }
}