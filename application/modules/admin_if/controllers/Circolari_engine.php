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
}