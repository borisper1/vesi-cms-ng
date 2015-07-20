<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Main_menu extends MX_Controller
{
    function index()
    {
        //Display users list
        $this->load->model('menu_handler');
        $this->load->model('page_handler');
        $id = $this->menu_handler->get_main_menu_id();
        $view_data = $this->menu_handler->get_menu_edit_array($id);
        $view_data['containers']=$this->page_handler->get_containers_list();
        $this->load->view('main_menu', $view_data);
    }

}
