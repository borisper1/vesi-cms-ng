<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General_model extends CI_Model
{
    function get_data()
    {
        $this->load->library('file_handler');
        $data=array(
            'website_name' => $this->db_config->get('general', 'website_name'),
            'menu_class' => $this->db_config->get('style', 'menu_class'),
            'menu_hover' => (boolean)$this->db_config->get('style', 'menu_hover'),
            'use_fluid_containers' => (boolean)$this->db_config->get('style', 'use_fluid_containers'),
            'display_home_page_title' => (boolean)$this->db_config->get('style', 'display_home_page_title'),
            'logo_image_path' => $this->db_config->get('general', 'logo_image_path'),
            'current_temp_size' => $this->file_handler->get_folder_size(APPPATH.'tmp'),
            'current_temp_max_size' => $this->db_config->get('resources', 'max_temp_folder_size'),
            'limit_temp_folder' => (boolean)$this->db_config->get('resources', 'limit_temp_folder'),
            'current_temp_size_percent' => intval(($this->file_handler->get_folder_size_raw(APPPATH.'tmp')/1048576)/$this->db_config->get('resources', 'max_temp_folder_size')),
            'enable_automatic_maint' => (boolean)$this->db_config->get('general', 'enable_automatic_maintenance')
            );
        return $data;
    }
}