<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Components extends MX_Controller
{

    function render_component($id)
    {
        //TODO: Ensure survival if the model/view does not exist (ERR_CORRUPT_INSTALL)
        $type = $this->get_content_type($id);
        //TODO: Add error checking
        if(in_array($type,$this->modules_handler->installed_components))
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
            } elseif ($element->type === 'menu') {
                $html .= $this->render_plugin($element->name, $element->data);
            }
            else
            {
                if(in_array($element->type,$this->modules_handler->installed_structures))
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

    function render_plugin($name, $data)
    {
        if($this->modules_handler->get_plugin_data($name)['type']==='full')
        {
            return Modules::run('plugins/' . $name . '/render', $data);
        }
        else
        {
            return false;
        }
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
            //The id does not exist (ERR_COMPONENT_ID_NOT_FOUND)
            return false;
        }
    }

    function load_editor($id)
    {
        $type = $this->get_content_type($id);
        $module_cname=str_replace('-','_',$type);
        $model_cname=$module_cname.'_model';
        $this->load->model($model_cname);
        $data = $this->$model_cname->get_edit_data($id);
        //Load the js actions file for the editor
        $this->resources->load_aux_js_file('assets/administration/editors/'.$module_cname.'.js');
        $this->load->view('editors/'.$module_cname.'_editor', $data);
    }

    function load_new_editor($type)
    {
        $module_cname=str_replace('-','_',$type);
        $model_cname=$module_cname.'_model';
        $this->load->model($model_cname);
        $data = $this->$model_cname->get_new_data();
        //Load the js actions file for the editor
        $this->resources->load_aux_js_file('assets/administration/editors/'.$module_cname.'.js');
        $this->load->view('editors/'.$module_cname.'_editor', $data);
    }

    function load_editor_preview($type, $data)
    {
        $module_cname=str_replace('-','_',$type);
        $model_cname=$module_cname.'_model';
        $this->load->model($model_cname);
        $data = $this->$model_cname->get_preview_data($data);
        if($data)
        {
            $this->load->view($module_cname, $data);
        }
        else
        {
            echo "failed";
        }
    }

}