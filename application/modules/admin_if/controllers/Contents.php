<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contents extends MX_Controller
{

    function index()
    {
        $this->load->model('user_handler');
        $this->load->model('content_handler');
        $cfilter = $this->user_handler->check_content_filter();
        $data['cfilter_on'] = $cfilter!==false;
        $data['content_list'] = $this->content_handler->get_contents_list_with_usages($cfilter);
        $data['components_list'] = $this->modules_handler->get_components_list();
        $this->load->view('content/list',$data);
    }

    function edit($id)
    {
        $this->load->model('content_handler');
        $data = $this->content_handler->get_content_data($id);
        $data['is_new']=false;
        $this->load->view('content/editor_wrapper',$data);
        echo Modules::run('components/load_editor',$id);
    }

    function new_content($args)
    {
        if(strpos($args, '::')===false)
        {
            $data['id']=uniqid();
            $data['type']=$args;
        }
        else
        {
            $args = explode('::',$args);
            $data['id']=$args[1];
            $data['type']=$args[0];
        }
        $data['is_new']=true;
        $data['preview']='';

        $this->load->view('content/editor_wrapper',$data);
        echo Modules::run('components/load_new_editor',$data['type']);
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
        $data = rawurldecode($this->input->post('data'));
        $settings = rawurldecode($this->input->post('settings'));
        $displayname = strip_tags(rawurldecode($this->input->post('displayname')));
        $this->load->model('content_handler');
        $response = $this->content_handler->save($id, $type, $data, $settings, $displayname);
        if($response===0)
        {
            echo 'success';
        }
        elseif($response===1)
        {
            echo 'failed - 500';
        }
        elseif($response>1)
        {
            echo 'failed - 403: bad data format/value';
        }
    }

    function load_editor_preview()
    {
        $type = $this->input->post('type');
        $data = rawurldecode($this->input->post('data'));
        echo Modules::run('components/load_editor_preview',$type, $data);
    }

}