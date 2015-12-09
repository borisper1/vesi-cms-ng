<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resources_model extends CI_Model
{
    function get_data()
    {
        $data=array(
            'enable_legacy_support' => (boolean)$this->db_config->get('general', 'enable_legacy_support'),
            'bootstrap_js_usecdn' => (boolean)$this->db_config->get('resources', 'bootstrap_js_usecdn'),
            'fontawesome_usecdn' => (boolean)$this->db_config->get('resources', 'fontawesome_usecdn'),
            'jquery1_usecdn' => (boolean)$this->db_config->get('resources', 'jquery1_usecdn'),
            'jquery2_usecdn' => (boolean)$this->db_config->get('resources', 'jquery2_usecdn'),
            'bootstrap_js_cdnurl' => $this->db_config->get('resources', 'bootstrap_js_cdnurl'),
            'fontawesome_cdnurl' => $this->db_config->get('resources', 'fontawesome_cdnurl'),
            'jquery1_cdnurl' => $this->db_config->get('resources', 'jquery1_cdnurl'),
            'jquery2_cdnurl' => $this->db_config->get('resources', 'jquery2_cdnurl'),
        );
        return $data;
    }
}