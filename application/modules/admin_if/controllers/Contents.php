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
        //Identify the input type by matching reported and expected from modules.json
        $reported_input_type = $this->input->post('input_type');
    }


}