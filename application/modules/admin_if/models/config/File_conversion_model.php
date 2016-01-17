<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File_conversion_model extends CI_Model
{
    function get_data()
    {
        $data=array(
            'execute_on_remote' =>  $this->db_config->get('file_conversion', 'execute_on_remote'),
            'enable_file_conversion' =>  $this->db_config->get('file_conversion', 'enable_file_conversion'),
            'remote_server_url' =>  $this->db_config->get('file_conversion', 'remote_server_url'),
            'remote_server_token' => $this->db_config->get('file_conversion', 'remote_server_token'),
            'limit_output_folder' => $this->db_config->get('file_conversion', 'limit_output_folder'),
            'output_folder_max_size' => $this->db_config->get('file_conversion', 'output_folder_max_size'),
        );
        $this->load->library('file_handler');
        $data['current_used_size'] = intval($this->file_handler->get_folder_size_raw(FCPATH . 'files/converted_files') / 1048576);
        $data['current_used_percent'] = intval(($data['current_used_size'] * 100) / $data['output_folder_max_size']);
        return $data;
    }
}