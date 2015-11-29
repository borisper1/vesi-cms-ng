<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Interfaces_handler
{
    protected $schema;

    public function __construct()
    {
        $this->schema=json_decode(file_get_contents(APPPATH."config/admin_interfaces.json"));
    }

    public function get_admin_menu_structure(){
        foreach(array_keys(get_object_vars($this->schema)) as $instance)
        {
            $menu[$instance]=array('label'=> $this->schema->$instance->label, 'icon'=> $this->schema->$instance->icon);
            foreach($this->schema->$instance->items as $voice)
            {
                if($voice->name!=='special::separator')
                {
                    $menu[$instance]['items'][]=array('name' => $voice->name, 'icon' => $voice->icon, 'label' => $voice->label);
                }
                else
                {
                    $menu[$instance]['items'][]='separator';
                }
            }
        }
        return $menu;
    }

    public function get_raw_array(){
        return json_decode(file_get_contents(APPPATH."config/admin_interfaces.json"),true);
    }

}