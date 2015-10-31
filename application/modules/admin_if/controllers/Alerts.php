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
        $this->load->model('alerts_handler');
        $data = $this->alerts_handler->get_alert_data($id);
        $data['is_new']=false;
        $this->resources->load_aux_js_file('assets/third_party/ckeditor/ckeditor.js');
        $this->load->view('alerts/edit',$data);
    }


}
