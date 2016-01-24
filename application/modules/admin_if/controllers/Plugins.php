<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Plugins extends MX_Controller
{
    function index()
    {
        $this->load->view('plugins/main');
    }

    function load_registered_components()
    {
        $name = $this->input->post('name');
        $data = $this->modules_handler->get_plugin_data($name);
        $view_data['registered_components'] = [];
        foreach ($data['admin_interfaces'] as $interface) {
            $view_data['registered_components'][] = array('type' => 'admin_interface',
                'icon' => $interface->icon,
                'title' => $interface->label,
                'name' => $interface->name,
                'description' => $interface->description);
        }
        foreach ($data['config_interfaces'] as $interface) {
            $view_data['registered_components'][] = array('type' => 'admin_interface',
                'icon' => $interface->icon,
                'title' => $interface->label,
                'name' => $interface->name,
                'description' => 'N/A');
        }
        foreach ($data['services'] as $service) {
            $view_data['registered_components'][] = array('type' => 'admin_interface',
                'icon' => $service->icon,
                'title' => $service->label,
                'name' => $service->name,
                'description' => 'N/A');
        }
        foreach ($data['components'] as $component) {
            $view_data['registered_components'][] = array('type' => 'admin_interface',
                'icon' => 'fa-cube',
                'title' => $component->name,
                'name' => $component->name,
                'description' => $component->description);
        }
        foreach ($data['files'] as $file) {
            $view_data['files'][] = array('path' => $file,
                'installed' => file_exists(FCPATH . $file));
        }
        $this->load->view('plugins/components_modal', $view_data);
    }
}