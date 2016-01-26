<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Circolari_engine extends MX_Controller
{
    function render($command)
    {
        $this->load->model('circolari_engine_model');
        $data['list'] = $this->circolari_engine_model->get_circolari_list($command);
        $this->load->view('circolari_engine/frontend_render_main', $data);
        $this->resources->load_aux_js_file('assets/plugins/circolari_engine/frontend.js');
    }

    function load_text()
    {
        $id = $this->input->post('id');
        $this->load->model('circolari_engine_model');
        $data['circolare'] = $this->circolari_engine_model->get_circolare_data($id);
        $this->load->view('circolari_engine/frontend_render_page', $data);
    }

    function admin_index()
    {
        $this->load->model('circolari_engine_model');
        $data['categories'] = $this->circolari_engine_model->get_categories_list();
        $this->load->view('circolari_engine/admin_index', $data);
    }

    function admin_list_cats($category)
    {
        $this->load->model('circolari_engine_model');
        $data['list'] = $this->circolari_engine_model->get_circolari_list($category);
        $data['category'] = $category;
        $this->load->view('circolari_engine/admin_list', $data);
    }

    function admin_edit($id)
    {
        $this->load->model('circolari_engine_model');
        $data = $this->circolari_engine_model->get_circolare_data($id);
        $data['is_new'] = false;
        $this->resources->load_aux_js_file('assets/third_party/ckeditor/ckeditor.js');
        $this->load->view('circolari_engine/admin_edit', $data);
    }

    function admin_new_circolare($category)
    {
        $this->load->model('circolari_engine_model');
        $data['id'] = uniqid();
        $data['category'] = $category;
        $data['number'] = $this->circolari_engine_model->get_next_number($category);
        $data['suffix'] = '/A';
        $data['title'] = '';
        $data['content'] = '';
        $data['is_new'] = true;
        $this->resources->load_aux_js_file('assets/third_party/ckeditor/ckeditor.js');
        $this->load->view('circolari_engine/admin_edit', $data);
    }

    function admin_save()
    {
        $id = $this->input->post('id');
        $category = $this->input->post('category');
        $title = rawurldecode($this->input->post('title'));
        $number = $this->input->post('number');
        $suffix = rawurldecode($this->input->post('suffix'));
        $content = rawurldecode($this->input->post('content'));
        $this->load->model('circolari_engine_model');
        $response = $this->circolari_engine_model->save($id, $category, $title, $number, $suffix, $content);
        if ($response) {
            echo 'success';
        } else {
            echo 'failed - 500';
        }
    }

    function admin_delete_article()
    {
        $id = $this->input->post('id');
        $this->load->model('circolari_engine_model');
        $response = $this->circolari_engine_model->delete($id);
        if ($response) {
            echo 'success';
        } else {
            echo 'failed - 500';
        }
    }

    function admin_delete_category()
    {
        $name = $this->input->post('name');
        $this->load->model('circolari_engine_model');
        $response = $this->circolari_engine_model->delete_cat($name);
        if ($response) {
            echo 'success';
        } else {
            echo 'failed - 500';
        }
    }
}