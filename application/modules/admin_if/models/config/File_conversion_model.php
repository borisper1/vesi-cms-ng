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
        );
        return $data;
    }
}