<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File_conversion_model extends CI_Model
{
    function get_data()
    {
        $data=array(
            'execute_on_remote' => false,
            'enable_file_conversion' => true,
            'temp_folder' => '',
            'remote_server_url' => '',
            'remote_server_token' => ''
        );
        return $data;
    }
}