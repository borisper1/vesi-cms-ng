<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class File_conversion
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function get_available_conversions()
    {
        if($this->CI->db_config->get('file_conversion', 'enable_file_conversion') == 0)
        {
            return [];
        }
        $this->CI->load->library('file_handler');
        $capabilities = [];
        if($this->CI->db_config->get('file_conversion', 'enable_tcpdf') == 1)
        {
            $capabilities['export'][] = 'pdf';
        }
        if($this->CI->db_config->get('file_conversion', 'enable_pandoc') == 1)
        {
            if($this->CI->file_handler->command_exists('pandoc') or $this->CI->db_config->get('file_conversion', 'pandoc_execute_on_remote'))
            {
                $capabilities['export'][] = 'docx';
                $capabilities['export'][] = 'odt';
                $capabilities['import'][] = 'docx';
                $capabilities['import'][] = 'odt';
            }
        }
        return $capabilities;
    }
}