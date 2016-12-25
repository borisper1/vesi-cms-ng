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
            $output[] = (array)$component;
        }
        return $output;
    }

    protected function register_new_component($object)
    {
        $this->schema = json_decode(file_get_contents(APPPATH . "config/modules.json"));
        $this->schema->components[] = $object;
        file_put_contents(APPPATH . "config/modules.json", json_encode($this->schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }

    protected function unregister_component($name)
    {
        $this->schema = json_decode(file_get_contents(APPPATH . "config/modules.json"));
        $rem_index = null;
        foreach ($this->schema->components as $index => $component) {
            if ($component->name === $name and $component->builtin === false)
            {
                $rem_index = $index;
            }
        }
        if($rem_index!==null)
        {
            array_splice($this->schema->components, $rem_index, 1);
        }
        file_put_contents(APPPATH . "config/modules.json", json_encode($this->schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
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

    function get_services_list()
    {
        $schema = json_decode(file_get_contents(APPPATH . "config/services.json"), true);
        return $schema['services'];
    }

    protected function register_new_service($object)
    {
        $schema = json_decode(file_get_contents(APPPATH . "config/services.json"));
        $schema->services[] = $object;
        file_put_contents(APPPATH . "config/services.json", json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }

    protected function unregister_service($name)
    {
        $schema = json_decode(file_get_contents(APPPATH . "config/services.json"));
        $rem_index = null;
        foreach ($schema->services as $index =>$service) {
            if ($service->name === $name and $service->builtin === false)
            {
                $rem_index = $index;
            }
        }
        if($rem_index!==null)
        {
            array_splice($schema->services, $rem_index, 1);
        }
        file_put_contents(APPPATH . "config/services.json", json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
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
                $output[] = (array)$plugin;
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
        $this->save_plugin_cache();
    }

    protected function unregister_plugin($name)
    {
        if ($this->plugin_cache === null) {
            $this->update_plugin_cache();
        }
        $rem_index = null;
        foreach ($this->plugin_cache->plugins as $index => $plugin) {
            if ($plugin->name === $name) {
                $rem_index = $index;
                break;
            }
        }
        if($rem_index!==null)
        {
            array_splice($this->plugin_cache->plugins, $rem_index, 1);
        }
        $this->save_plugin_cache();
    }

    public function change_plugin_state($name, $enable)
    {
        if ($this->plugin_cache === null) {
            $this->update_plugin_cache();
        }
        $result = false;
        foreach ($this->plugin_cache->plugins as &$plugin) {
            if ($plugin->name === $name) {
                $plugin->enabled = $enable;
                $result = true;
            }
        }
        $this->save_plugin_cache();
        return $result;
    }

    protected function save_plugin_cache()
    {
        file_put_contents(APPPATH . "config/plugins.json", json_encode($this->plugin_cache, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
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
        $insert_index = (int)$position_array[1];
        $count = 0;
        $insert_key = null;
        foreach ($this->interfaces_cache->$tree->items as $index => $item) {
            if ($item->name === 'special::separator') {
                if ($count === $insert_index) {
                    $insert_key = $index;
                    break;
                }
                $count += 1;
            }
        }
        $insert_key = $insert_key !== null ? $insert_key : count($this->interfaces_cache->$tree->items) - 1;
        array_splice($this->interfaces_cache->$tree->items, $insert_key, 0, array($object));
        $this->save_interface_cache();
    }

    protected function unregister_interface($name)
    {
        if ($this->interfaces_cache === null) {
            $this->update_interfaces_cache();
        }
        $tree = null;
        $rem_index = null;
        foreach ($this->interfaces_cache as $key=>$tree) {
            foreach ($tree->items as $index=>$item) {
                if ($item->name === $name and $item->builtin === false)
                {
                    $tree = $key;
                    $rem_index = $index;
                    break;
                }
            }
        }
        if($tree!==null and $rem_index!==null)
        {
            array_splice($this->interfaces_cache->$tree->items, $rem_index, 1);
        }
        $this->save_interface_cache();
    }

    protected function save_interface_cache()
    {
        file_put_contents(APPPATH . "config/admin_interfaces.json", json_encode($this->interfaces_cache, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
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
        file_put_contents(APPPATH . "config/config_interfaces.json", json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }

    protected function unregister_config_interface($name)
    {
        $schema = json_decode(file_get_contents(APPPATH . "config/config_interfaces.json"), true);
        $rem_index = null;
        foreach ($schema->interfaces as $index => $interface) {
            if ($interface->name === $name and $interface->builtin === false)
            {
                $rem_index = $index;
            }
        }
        if($rem_index!==null)
        {
            array_splice($schema->interfaces, $rem_index, 1);
        }
        file_put_contents(APPPATH . "config/config_interfaces.json", json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }

    function get_frontend_permissions_array()
    {
        $schema = json_decode(file_get_contents(APPPATH . "config/frontend_permissions.json"), true);
        return $schema['frontend_permissions'];
    }

    function install_plugin($store_name)
    {
        $this->CI->load->library('file_handler');
        $store_path = APPPATH . 'plugins/' . $store_name;
        if (!file_exists($store_path . '/descriptor.json')) {
            return array('result' => false, 'error' => 'The given install store is invalid (Can\'t find descriptor.json)');
        }
        $descriptor_data = json_decode(file_get_contents($store_path . '/descriptor.json'));
        $descriptor_data->files = [];
        //Copy plugin files
        if (file_exists($store_path . '/mod_plugins'))
        {
            $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($store_path . '/mod_plugins', FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS));
            $it->rewind();
            while ($it->valid())
            {
                $descriptor_data->files[] = 'application/modules/mod_plugins/' . $it->getSubPathName();
                $it->next();
            }
            $copy_items = array_diff(scandir($store_path . '/mod_plugins'), array('..', '.'));
            foreach($copy_items as $item)
            {
                $this->CI->file_handler->copy_path('application/plugins/' . $store_name . '/mod_plugins/' . $item, 'application/modules/mod_plugins');
            }
        }
        if (file_exists($store_path . '/admin_if'))
        {
            $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($store_path . '/admin_if', FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS));
            $it->rewind();
            while ($it->valid())
            {
                $descriptor_data->files[] = 'application/modules/admin_if/' . $it->getSubPathName();
                $it->next();
            }
            $copy_items = array_diff(scandir($store_path . '/admin_if'), array('..', '.'));
            foreach($copy_items as $item)
            {
                $this->CI->file_handler->copy_path('application/plugins/' . $store_name . '/admin_if/' . $item, 'application/modules/admin_if');
            }
        }
        if (file_exists($store_path . '/mod_services'))
        {
            $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($store_path . '/mod_services', FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS));
            $it->rewind();
            while ($it->valid())
            {
                $descriptor_data->files[] = 'application/modules/mod_services/' . $it->getSubPathName();
                $it->next();
            }
            $copy_items = array_diff(scandir($store_path . '/mod_services'), array('..', '.'));
            foreach($copy_items as $item)
            {
                $this->CI->file_handler->copy_path('application/plugins/' . $store_name . '/mod_services/' . $item, 'application/modules/mod_services');
            }
        }
        if (file_exists($store_path . '/components'))
        {
            $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($store_path . '/components', FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS));
            $it->rewind();
            while ($it->valid())
            {
                $descriptor_data->files[] = 'application/modules/components/' . $it->getSubPathName();
                $it->next();
            }
            $copy_items = array_diff(scandir($store_path . '/components'), array('..', '.'));
            foreach($copy_items as $item)
            {
                $this->CI->file_handler->copy_path('application/plugins/' . $store_name . '/components/' . $item, 'application/modules/components');
            }
        }
        if (file_exists($store_path . '/assets/plugins'))
        {
            if (!file_exists(FCPATH . 'assets/plugins/' . $store_name)) {
                mkdir(FCPATH . 'assets/plugins/' . $store_name, 0777, true);
            }
            $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($store_path . '/assets/plugins', FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS));
            $it->rewind();
            while ($it->valid())
            {
                $descriptor_data->files[] = 'assets/plugins/' . $store_name . '/' . $it->getSubPathName();
                $it->next();
            }
            $copy_items = array_diff(scandir($store_path . '/assets/plugins'), array('..', '.'));
            foreach($copy_items as $item)
            {
                $this->CI->file_handler->copy_path('application/plugins/' . $store_name . '/assets/plugins/' . $item, 'assets/plugins/' . $store_name);
            }
        }
        if (file_exists($store_path . '/assets/administration')) {
            $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($store_path . '/assets/administration', FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS));
            $it->rewind();
            while ($it->valid()) {
                $descriptor_data->files[] = 'assets/administration/' . $it->getSubPathName();
                $it->next();
            }
            $copy_items = array_diff(scandir($store_path . '/assets/administration'), array('..', '.'));
            foreach ($copy_items as $item) {
                $this->CI->file_handler->copy_path('application/plugins/' . $store_name . '/assets/administration/' . $item, 'assets/administration');
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
        //Update the database
        $this->ExecuteSQLFile($store_path . '/' . $descriptor_data->db_install_file);
        return array('result' => true, 'error' => '');
    }

    protected function ExecuteSQLFile($file)
    {
        $sqls = explode(';', file_get_contents($file));
        array_pop($sqls);
        foreach ($sqls as $statement) {
            $this->CI->db->query($statement . ';');
        }
    }

    function remove_plugin($name, $remove_install_store = false, $remove_data = false)
    {
        $this->CI->load->library('file_handler');
        $plugin_data = $this->get_plugin_data($name);
        if (!$plugin_data) {
            return array('result' => false, 'error' => 'The given plugin name is not an installed plugin');
        }
        //Delete plugin files
        foreach ($plugin_data['files'] as $file) {
            $this->CI->file_handler->delete_path($file);
        }
        //Unregister installed components
        foreach ($plugin_data['components'] as $component) {
            $this->unregister_component($component->name);
        }
        foreach ($plugin_data['admin_interfaces'] as $admin_interface) {
            $this->unregister_interface($admin_interface->name);
        }
        foreach ($plugin_data['config_interfaces'] as $config_interface) {
            $this->unregister_config_interface($config_interface->name);
        }
        foreach ($plugin_data['services'] as $service) {
            $this->unregister_service($service->name);
        }
        //Unresister plugin
        $this->unregister_plugin($name);
        //Clean up plugin files folders
        $this->CI->file_handler->remove_empty_subfolders(APPPATH . 'modules/mod_plugins');
        $this->CI->file_handler->remove_empty_subfolders(APPPATH . 'modules/mod_services');
        $this->CI->file_handler->remove_empty_subfolders(APPPATH . 'modules/admin_if');
        $this->CI->file_handler->remove_empty_subfolders(APPPATH . 'modules/components');
        $this->CI->file_handler->remove_empty_subfolders(FCPATH . 'assets/plugins');
        //Delete DB data if required
        if ($remove_data) {
            $this->ExecuteSQLFile(APPPATH . 'plugins/' . $name . '/' . $plugin_data['db_remove_file']);
        }
        //Delete install_store if required
        if ($remove_install_store) {
            $this->CI->file_handler->delete_path('application/plugins/' . $name);
        }
        return array('result' => true, 'error' => '');
    }

    function repair_plugin($name)
    {
        $result = $this->remove_plugin($name);
        if (!$result['result']) {
            return false;
        }
        $result = $this->install_plugin($name);
        if (!$result['result']) {
            return false;
        }
        return true;
    }
}