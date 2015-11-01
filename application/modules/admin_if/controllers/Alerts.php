<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Alerts extends MX_Controller
{
    function index()
    {
        $this->load->model('alerts_handler');
        $data['alerts_list'] = $this->alerts_handler->get_alerts_list();
        $this->load->view('alerts/list', $data);
    }

    function edit($id)
    {
        if($id=='new')
        {
            $data['id'] = uniqid();
            $data['type'] = 'info';
            $data['preview'] = '';
            $data['content'] = '';
            $data['display_on'] = 'all';
            $data['dismissible'] = 0;
            $data['is_new']=true;
        }
        else
        {
            $this->load->model('alerts_handler');
            $data = $this->alerts_handler->get_alert_data($id);
            $data['is_new']=false;
        }
        $this->resources->load_aux_js_file('assets/third_party/ckeditor/ckeditor.js');
        $this->load->view('alerts/edit',$data);
    }

    function save()
    {
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $display_on = rawurldecode($this->input->post('display_on'));
        $content = rawurldecode($this->input->post('content'));
        $dismissible = $this->input->post('dismissible');
        $this->load->model('alerts_handler');
        $response = $this->alerts_handler->save($id, $type, $dismissible, $display_on, $content);
        if($response)
        {
            echo 'success';
        }
        else
        {
            echo 'failed - 500';
        }
    }

    function delete()
    {
        $id = $this->input->post('id');
        $this->load->model('alerts_handler');
        $response = $this->alerts_handler->delete($id);
        if($response)
        {
            echo 'success';
        }
        else
        {
            echo 'failed - 500';
        }
    }

}
