<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Components extends MX_Controller
{
    protected $installed_components=[], $installed_structures=[];

    function __construct()
    {
        parent::__construct();
        //TODO: implement error checking, maybe move to component_render model.
        $modules=json_decode(file_get_contents(APPPATH."config/modules.json"));
        $this->installed_components = $modules->components;
        $this->installed_structures = $modules->structures;
    }

    function render_component($id)
    {
        //TODO: Ensure survival if the model/view does not exist (ERR_CORRUPT_INSTALL)
        $type = $this->get_content_type($id);
        //TODO: Add error checking
        if(in_array($type,$this->installed_components))
        {
            $model_cname=str_replace('-','_',$type).'_model';
            $this->load->model($model_cname);
            $data = $this->$model_cname->get_render_data($id);
            return $this->load->view(str_replace('-','_',$type), $data, true);
        }
        else
        {
            //TODO: Desired component is not installed (ERR_COMPONENT_NOT_FOUND)
            return false;
        }
    }

    function render_sec_menu($id)
    {
        $this->load->model('menu_handler');
        //Load the main menu (evaluate whether to make this a HMVC module)
        $menu_data = $this->menu_handler->get_menu_array($id,$GLOBALS['p_container'],$GLOBALS['p_name']);
        $menu_data = array_merge($menu_data, $this->menu_handler->get_menu_data($id));
        return $this->load->view('frontend/sec_menu',$menu_data,true);
    }

    function render_section($structure)
    {
        $html="";
        foreach($structure as $element)
        {
            if($element->type==='content')
            {
                $html.=$this->render_component($element->id);
            }
            elseif($element->type==='menu')
            {
                $html.=$this->render_sec_menu($element->id);
            }
            else
            {
                if(in_array($element->type,$this->installed_structures))
                {
                    $structure_data=[];
                    foreach($element->views as $view)
                    {
                        $view_data=[];
                        $view_data['id']=$view->id;
                        $view_data['title']=$view->title;
                        $view_data['content']=$this->render_section($view->elements);
                        $structure_data[]=$view_data;
                    }
                    $class = isset($element->class) ? $element->class : null;
                    $html.=$this->load->view(str_replace('-','_',$element->type), array( 'structure_data' => $structure_data, 'class' => $class), true);
                }
            }
        }
        return $html;
    }

    protected function get_content_type($id)
    {
        $this->db->select('type');
        $this->db->where('id', $id);
        $query = $this->db->get('contents');
        if ($query->num_rows() > 0) {
            $row = $query->row();

            return $row->type;
        } else {
            //TODO: The id does not exist (ERR_COMPONENT_ID_NOT_FOUND)
            return false;
        }
    }

    function load_editor($id)
    {
        $type = $this->get_content_type($id);
        $model_cname=str_replace('-','_',$type).'_model';
        $this->load->model($model_cname);
        $data = $this->$model_cname->get_edit_data($id);
        $this->load->view(str_replace('-','_',$type).'_editor', $data);
    }

}