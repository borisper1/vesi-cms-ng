<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Components extends MX_Controller
{

    function render_component($id)
    {
        $type = $this->get_content_type($id);
        if ($type === false) {
            $this->load->model('error_logger');
            $this->error_logger->log_no_content_error($id);
            return $this->load->view('frontend/errors/content_not_found', array('id' => $id), true);
        }
        if(in_array($type,$this->modules_handler->installed_components))
        {
            $model_cname=str_replace('-','_',$type).'_model';
            $this->load->model($model_cname);
            $data = $this->$model_cname->get_render_data($id);
            return $this->load->view(str_replace('-','_',$type), $data, true);
        }
        else
        {
            $this->load->model('error_logger');
            $this->error_logger->log_no_component_error($id, $type);
            return $this->load->view('frontend/errors/component_not_found', array('id' => $id, 'component' => $type), true);
        }
    }

    function render_sec_menu($id)
    {
        $this->load->model('menu_handler');
        $menu_data = $this->menu_handler->get_menu_array($id,$GLOBALS['p_container'],$GLOBALS['p_name']);
        if ($menu_data === false) {
            $this->load->model('error_logger');
            $this->error_logger->log_no_menu_error($id);
            return $this->load->view('frontend/errors/content_not_found', array('id' => $id), true);
        }
        $menu_data = array_merge($menu_data, $this->menu_handler->get_menu_data($id));
        return $this->load->view('frontend/sec_menu',$menu_data,true);
    }

    function load_structure_view($name, $data, $class)
    {
        return $this->load->view(str_replace('-', '_', $name), array('structure_data' => $data, 'class' => $class), true);
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