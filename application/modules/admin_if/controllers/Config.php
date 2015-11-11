<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends MX_Controller
{
    function index()
    {
        $data=array(
            'website_name' => $this->db_config->get('general', 'website_name'),
            'menu_class' => $this->db_config->get('style', 'menu_class'),
            'menu_hover' => (boolean)$this->db_config->get('style', 'menu_hover'),
            'use_fluid_containers' => (boolean)$this->db_config->get('style', 'use_fluid_containers'),
            'display_home_page_title' => (boolean)$this->db_config->get('style', 'display_home_page_title')
        );
        $this->load->view('config/index', $data);
    }

    function sources()
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
        $this->load->view('config/sources', $data);
    }

    function save()
    {
        $data = $this->input->post('code');
        $decoded = json_decode($data, true);
        $sections = array_keys($decoded);
        foreach($sections as $section)
        {
            $keys = array_keys($decoded[$section]);
            foreach($keys as $key)
            {
                $this->db_config->set($section, $key, $decoded[$section][$key]);
            }

        }
        $this->db_config->save();
    }



}
