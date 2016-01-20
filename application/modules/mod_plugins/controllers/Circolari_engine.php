<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Circolari_engine extends MX_Controller
{
    function render($command)
    {
        $this->load->model('circolari_engine_model');
        $data['list'] = $this->circolari_engine_model->get_circolari_list($command);
        $this->load->view('circolari_engine', $data);
        $this->resources->load_aux_js_file('assets/plugins/circolari_engine.js');
    }
}