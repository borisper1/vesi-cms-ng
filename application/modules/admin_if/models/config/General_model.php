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
            'use_fluid_containers' => (boolean)$this->db_config->get('style', 'use_fluid_containers'),
            'display_home_page_title' => (boolean)$this->db_config->get('style', 'display_home_page_title'),
            'logo_image_path' => $this->db_config->get('general', 'logo_image_path'),
			'enable_math_support' => $this->db_config->get('general', 'enable_math_support'),
			'mathjax_usecdn' => (boolean)$this->db_config->get('resources', 'mathjax_usecdn'),
			'mathjax_cdnurl' => $this->db_config->get('resources', 'mathjax_cdnurl'),
            );
        return $data;
    }
}