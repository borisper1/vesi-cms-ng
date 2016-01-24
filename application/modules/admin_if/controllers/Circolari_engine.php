<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Circolari_engine extends MX_Controller
{
    function index()
    {
        $this->load->model('circolari_engine_model');
        $data['categories'] = $this->circolari_engine_model->get_categories_list();
        $this->load->view('circolari_engine/index', $data);
    }

    function list_cats($category)
    {
        $this->load->model('circolari_engine_model');
        $data['list'] = $this->circolari_engine_model->get_circolari_list($category);
        $data['category'] = $category;
        $this->load->view('circolari_engine/list', $data);
    }

    function edit($id)
    {
        $this->load->model('circolari_engine_model');
        $data = $this->circolari_engine_model->get_circolare_data($id);
        $data['is_new'] = false;
        $this->resources->load_aux_js_file('assets/third_party/ckeditor/ckeditor.js');
        $this->load->view('circolari_engine/edit', $data);
    }
}