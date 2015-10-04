<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contents extends MX_Controller
{

    function index()
    {

    }

    function edit($id)
    {
        $this->load->model('content_handler');
        $data = $this->content_handler->get_content_data($id);
        $data['is_new']=false;
        $this->load->view('content/editor_wrapper',$data);
        echo Modules::run('components/load_editor',$id);
    }

    function check_orphans()
    {
        $id_array = explode(',', $this->input->post('id_string'));
        $this->load->model('content_handler');
        $output = $this->content_handler->are_orphans($id_array);
        if (array_filter($output))
        {
            echo implode(',', $output);
        }
        else
        {
            echo 'false';
        }
    }

    function delete_multiple()
    {
        $id_array = explode(',', $this->input->post('id_string'));
        $this->load->model('content_handler');
        echo $this->content_handler->delete_contents($id_array) ? 'success' : 'failed';
    }

    function save()
    {
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $data = $this->input->post('data');
        $component_info = $this->get_component_info($type);
        $this->load->library('validation');
        $valid = false;
        if ($component_info->save_type=='html')
        {
            $data = $this->validation->filter_html($data, $component_info->allow_iframe);
            $valid = true;
        }
        elseif($component_info->save_type=='json')
        {
            $valid = $this->validation->check_json($data);
        }
        elseif($component_info->save_type=='path')
        {
            $valid = $this->validation->check_path($data);
        }
        elseif($component_info->save_type=='url')
        {
            $valid = $this->validation->check_url($data);
        }
        if(!$valid)
        {
            echo '500-1 - Main input is invalid';
            return;
        }
        if($component_info->has_options)
        {
            $settings = $this->input->post('settings');
            if(! $this->validation->check_json($settings))
            {
                echo '500-2 - Settings input is invalid';
                return;
            }
        }
        if($component_info->has_displayname)
        {
            $displayname = strip_tags('displayname');
        }

    }

    protected function get_component_info($type)
    {
        $output = false;
        $modules=json_decode(file_get_contents(APPPATH.'config/modules.json'));
        foreach($modules->components as $component){
            if($component->name == $type){
                $output = $component;
            }
        }
        return $output;
    }
}