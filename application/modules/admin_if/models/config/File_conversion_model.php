<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File_conversion_model extends CI_Model
{
    function get_data()
    {
        $this->load->library('file_handler');
        $data=array(
            'pandoc_execute_on_remote' =>  $this->db_config->get('file_conversion', 'pandoc_execute_on_remote'),
            'enable_file_conversion' =>  $this->db_config->get('file_conversion', 'enable_file_conversion'),
            'pandoc_remote_server_url' =>  $this->db_config->get('file_conversion', 'pandoc_remote_server_url'),
            'pandoc_remote_server_token' => $this->db_config->get('file_conversion', 'pandoc_remote_server_token'),
            'enable_pandoc' => $this->db_config->get('file_conversion', 'enable_pandoc'),
            'enable_tcpdf' => $this->db_config->get('file_conversion', 'enable_tcpdf'),
            'pdf_header_title' => $this->db_config->get('file_conversion', 'pdf_header_title'),
            'pdf_header_text' => $this->db_config->get('file_conversion', 'pdf_header_text'),
            'local_pandoc' => $this->file_handler->command_exists('pandoc')
        );

        return $data;
    }

}

