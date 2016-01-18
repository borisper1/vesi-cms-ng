<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modules_handler
{
    protected $CI, $schema;
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
        foreach($this->schema->components as $component){
            if($component->name == $type){
                $output = $component;
            }
        }
        return $output;
    }

    function get_components_list()
    {
        $output=[];
        foreach($this->schema->components as $component){
            $output[]=array('name' => $component->name, 'description' => $component->description);
        }
        return $output;
    }

    function check_service($name)
    {
        $schema=json_decode(file_get_contents(APPPATH."config/services.json"));
        foreach($schema->services as $service){
            if($service->name === $name)
            {
                //For plugin-based services check if the plugin is enabled?
                return true;
            }
        }
        return false;
    }


}