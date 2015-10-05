<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sec_menu extends MX_Controller
{
    function index()
    {
        //Display secondary menu list GUI
        $this->load->model('menu_handler');
        $menulist = $this->menu_handler->get_menu_list();
        $this->load->view('menu/list_sec', array('menulist' => $menulist));
    }

    function edit($menu)
    {
        if($menu=='new')
        {
            $this->load->model('page_handler');
            $data = array('title' => '', 'display_title' => '', 'id' => uniqid(), 'is_new'=>true);
            $this->load->view('menu/edit_sec', $data);
            $data['menu_structure'] = [];
            $data['containers']=$this->page_handler->get_containers_list();
            $this->load->view('menu/editor_common', $data);
        }
        else
        {
            $this->load->model('menu_handler');
            $this->load->model('page_handler');
            $data = $this->menu_handler->get_menu_data($menu);
            $data['is_new']=false;
            $this->load->view('menu/edit_sec', $data);
            $data['menu_structure'] = $this->menu_handler->get_menu_edit_array($menu);
            $data['containers']=$this->page_handler->get_containers_list();
            $this->load->view('menu/editor_common', $data);
        }
        $this->resources->load_aux_js_file('assets/administration/interfaces/menu_editor.js');
    }

    function save()
    {
        $json = rawurldecode($this->input->post('json'));
        $id = $this->input->post('id');
        $title = rawurldecode($this->input->post('title'));
        $display_title = $this->input->post('display_title');
        $this->load->model('menu_handler');
        $result = $this->menu_handler->save($id, $json, $title, $display_title);
        if($result)
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
        $this->load->model('menu_handler');
        $id = $this->input->post('id');
        $result = $this->menu_handler->delete($id);
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
