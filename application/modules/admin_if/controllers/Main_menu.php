<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Main_menu extends MX_Controller
{
    function index()
    {
        //Display menu editing GUI
        $this->load->model('menu_handler');
        $this->load->model('page_handler');
        $id = $this->menu_handler->get_main_menu_id();
        $view_data['menu_structure'] = $this->menu_handler->get_menu_edit_array($id);
        $view_data['containers']=$this->page_handler->get_containers_list();
        $this->load->view('menu/edit_main');
        $this->load->view('menu/editor_common', $view_data);
        $this->resources->load_aux_js_file('assets/administration/interfaces/menu_editor.js');
    }

    function get_pages()
    {
        $this->load->model('page_handler');
        $pages = $this->page_handler->get_pages_in_container($this->input->post('container'));
        //Upload data in CSV fromat, js generates the DOM <option> elements
        if($pages){
            echo implode(',', $pages);
        }
        else
        {
            echo "failed - 500";
        }
    }

    function save(){
        $json = rawurldecode($this->input->post('json'));
        $this->load->model('menu_handler');
        $result = $this->menu_handler->save($this->menu_handler->get_main_menu_id(), $json);
        if($result)
        {
            echo 'success';
        }
        else
        {
            echo 'failed - 500';
        }
    }

}
