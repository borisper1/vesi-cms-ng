<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modules_handler
{
    protected $CI, $schema, $plugin_cache = null, $interfaces_cache = null;
    public $installed_components = [],$installed_structures = [];

    public function __construct()
    {
        $this->CI =& get_instance();
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

    protected function register_new_component($object)
    {
        $this->schema = json_decode(file_get_contents(APPPATH . "config/modules.json"));
        $this->schema->components[] = $object;
        file_put_contents(APPPATH . "config/modules.json", json_encode($this->schema, JSON_PRETTY_PRINT));
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

    protected function register_new_service($object)
    {
        $schema = json_decode(file_get_contents(APPPATH . "config/services.json"));
        $schema->services[] = $object;
        file_put_contents(APPPATH . "config/services.json", json_encode($schema, JSON_PRETTY_PRINT));
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

    protected function register_new_plugin($object)
    {
        if ($this->plugin_cache === null) {
            $this->update_plugin_cache();
        }
        $this->plugin_cache->plugins[] = $object;
        file_put_contents(APPPATH . "config/plugins.json", json_encode($this->plugin_cache, JSON_PRETTY_PRINT));
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

    protected function register_new_interface($object)
    {
        if ($this->interfaces_cache === null) {
            $this->update_interfaces_cache();
        }
        $position_array = explode('|', $object->install_path);
        unset($object->install_path);
        $tree = $position_array[0];
        $insert_index = $position_array[1];
        $count = 0;
        $insert_key = null;
        foreach ($this->interfaces_cache->$tree->items as $index => $item) {
            if ($item->name === 'special::separator' and $count === $insert_index) {
                $insert_key = $index;
                $count += 1;
                break;
            }
        }
        $insert_array = array($object);
        array_splice($this->interfaces_cache->$tree->items, $insert_key, 0, $insert_array);
        file_put_contents(APPPATH . "config/admin_interfaces.json", json_encode($this->interfaces_cache, JSON_PRETTY_PRINT));
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

    public function get_config_interfaces_array()
    {
        $schema = json_decode(file_get_contents(APPPATH . "config/config_interfaces.json"), true);
        return $schema['interfaces'];
    }

    protected function register_new_config_interface($object)
    {
        $schema = json_decode(file_get_contents(APPPATH . "config/config_interfaces.json"), true);
        $schema->interfaces[] = $object;
        file_put_contents(APPPATH . "config/config_interfaces.json", json_encode($schema, JSON_PRETTY_PRINT));
    }


    function install_plugin($store_name, $repair = false)
    {
        $this->CI->load->library('file_handler');
        $store_path = APPPATH . 'plugins/' . $store_name;
        if (!file_exists($store_path . '/descriptor.json')) {
            return array('result' => false, 'error' => 'The given install store is invalid (Can\'t find descriptor.json)');
        }
        $descriptor_data = json_decode(file_get_contents(APPPATH . 'tmp/' . $store_name . '/descriptor.json'));
        $descriptor_data->files = [];
        //Copy plugin files
        if (file_exists($store_path . '/mod_plugins')) {
            $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($store_path . '/mod_plugins', FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS));
            $it->rewind();
            while ($it->valid()) {
                if ($it->getSubPath() == '') {
                    $this->CI->file_handler->copy_path('application/plugins/' . $store_name . '/mod_plugins/' . $it->getSubPathName(), 'application/modules/mod_plugins');
                }
                $descriptor_data->files[] = 'application/modules/mod_plugins/' . $it->getSubPathName();
                $it->next();
            }
        }
        if (file_exists($store_path . '/admin_if')) {
            $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($store_path . '/admin_if', FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS));
            $it->rewind();
            while ($it->valid()) {
                if ($it->getSubPath() == '') {
                    $this->CI->file_handler->copy_path('application/plugins/' . $store_name . '/admin_if/' . $it->getSubPathName(), 'application/modules/admin_if');
                }
                $descriptor_data->files[] = 'application/modules/admin_if/' . $it->getSubPathName();
                $it->next();
            }
        }
        if (file_exists($store_path . '/mod_services')) {
            $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($store_path . '/mod_services', FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS));
            $it->rewind();
            while ($it->valid()) {
                if ($it->getSubPath() == '') {
                    $this->CI->file_handler->copy_path('application/plugins/' . $store_name . '/mod_services/' . $it->getSubPathName(), 'application/modules/mod_services');
                }
                $descriptor_data->files[] = 'application/modules/mod_services/' . $it->getSubPathName();
                $it->next();
            }
        }
        if (file_exists($store_path . '/components')) {
            $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($store_path . '/components', FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS));
            $it->rewind();
            while ($it->valid()) {
                if ($it->getSubPath() == '') {
                    $this->CI->file_handler->copy_path('application/plugins/' . $store_name . '/components/' . $it->getSubPathName(), 'application/modules/components');
                }
                $descriptor_data->files[] = 'application/modules/components/' . $it->getSubPathName();
                $it->next();
            }
        }
        if (file_exists($store_path . '/assets')) {
            $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($store_path . '/assets', FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS));
            $it->rewind();
            while ($it->valid()) {
                if ($it->getSubPath() == '') {
                    $this->CI->file_handler->copy_path('application/plugins/' . $store_name . '/assets/' . $it->getSubPathName(), 'assets/plugins/' . $store_name);
                }
                $descriptor_data->files[] = 'assets/plugins/' . $store_name . '/' . $it->getSubPathName();
                $it->next();
            }
        }
        //Register installed components
        foreach ($descriptor_data->components as $component) {
            $this->register_new_component($component);
        }
        foreach ($descriptor_data->admin_interfaces as $admin_interface) {
            $this->register_new_interface($admin_interface);
        }
        foreach ($descriptor_data->config_interfaces as $config_interface) {
            $this->register_new_config_interface($config_interface);
        }
        foreach ($descriptor_data->services as $service) {
            $this->register_new_service($service);
        }
        //Register the plugin descriptor
        $descriptor_data->enabled = true;
        $this->register_new_plugin($descriptor_data);
        //TODO: Update the database

    }
}