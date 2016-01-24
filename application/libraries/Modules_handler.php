<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modules_handler
{
    protected $CI, $schema, $plugin_cache = null, $interfaces_cache = null;
    public $installed_components = [],$installed_structures = [];

    public function __construct()
    {
        $this->schema=json_decode(file_get_contents(APPPATH."config/modules.json"));
        foreach($this->schema->components as $component)
        {
            $this->installed_components[] = $component->name;
        }
        foreach($this->schema->structures as $structure)
        {
            $this->installed_structures[] = $structure->name;
        }
    }

    function get_editors_arrays()
    {
        $blocks_editor =[];
        $single_view_editor =[];
        foreach($this->schema->structures as $structure)
        {
            if($structure->editor=='blocks')
            {
                $blocks_editor[] = $structure->name;
            }
            elseif($structure->editor=='view')
            {
                $single_view_editor[] = $structure->name;
            }
        }
        return array('blocks' => $blocks_editor, 'single_view' => $single_view_editor);
    }

    function get_component_info($type)
    {
        $output = false;
        foreach ($this->schema->components as $component) {
            if ($component->name == $type) {
                $output = $component;
            }
        }
        return $output;
    }

    function get_components_list()
    {
        $output=[];
        foreach ($this->schema->components as $component) {
            $output[]=array('name' => $component->name, 'description' => $component->description);
        }
        return $output;
    }

    function check_service($name)
    {
        $schema=json_decode(file_get_contents(APPPATH."config/services.json"));
        foreach ($schema->services as $service) {
            if($service->name === $name)
            {
                //For plugin-based services check if the plugin is enabled?
                return true;
            }
        }
        return false;
    }

    protected function update_plugin_cache()
    {
        $this->plugin_cache = json_decode(file_get_contents(APPPATH . "config/plugins.json"));
    }

    function check_plugin($name)
    {
        if ($this->plugin_cache === null) {
            $this->update_plugin_cache();
        }
        foreach ($this->plugin_cache->plugins as $plugin) {
            if ($plugin->name === $name and $plugin->enabled) {
                return true;
            }
        }
        return false;
    }

    function get_plugin_list()
    {
        if ($this->plugin_cache === null) {
            $this->update_plugin_cache();
        }
        return $this->plugin_cache->plugins;
    }

    function get_full_plugin_list()
    {
        $plugins = $this->get_plugin_list();
        $output = [];
        foreach ($plugins as $plugin) {
            if ($plugin->type === 'full') {
                $output[] = $plugin;
            }
        }
        return $output;
    }

    function get_plugin_data($name)
    {
        $plugins = $this->get_plugin_list();
        foreach ($plugins as $plugin) {
            if ($plugin->name === $name) {
                return (array)$plugin;
            }
        }
        return false;
    }

    protected function update_interfaces_cache()
    {
        $this->interfaces_cache = json_decode(file_get_contents(APPPATH . "config/admin_interfaces.json"));
    }

    public function get_interfaces_menu_structure()
    {
        if ($this->interfaces_cache === null) {
            $this->update_interfaces_cache();
        }
        $menu = [];
        foreach (array_keys(get_object_vars($this->interfaces_cache)) as $instance) {
            $menu[$instance] = array('label' => $this->interfaces_cache->$instance->label, 'icon' => $this->interfaces_cache->$instance->icon);
            foreach ($this->interfaces_cache->$instance->items as $voice) {
                if ($voice->name !== 'special::separator') {
                    $menu[$instance]['items'][] = array('name' => $voice->name, 'icon' => $voice->icon, 'label' => $voice->label);
                } else {
                    $menu[$instance]['items'][] = 'separator';
                }
            }
        }
        return $menu;
    }

    public function get_interfaces_raw_array()
    {
        return json_decode(file_get_contents(APPPATH . "config/admin_interfaces.json"), true);
    }

    public function get_config_interfaces_array()
    {
        $schema = json_decode(file_get_contents(APPPATH . "config/config_interfaces.json"), true);
        return $schema['interfaces'];
    }

    function get_interface_data($name)
    {
        if ($this->interfaces_cache === null) {
            $this->update_interfaces_cache();
        }
        foreach (array_keys(get_object_vars($this->interfaces_cache)) as $instance) {
            foreach ($this->interfaces_cache->$instance->items as $voice) {
                if ($voice->name === $name) {
                    return (array)$voice;
                }
            }
        }
        return false;
    }


}