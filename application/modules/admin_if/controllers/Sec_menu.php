<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sec_menu extends MX_Controller
{
    function index()
    {
        //Display secondary menu list GUI
        $this->load->model('menu_handler');
        $menulist = $this->menu_handler->get_menu_list();
        $this->load->view('sec_menu/list', array('menulist' => $menulist));
    }

    function edit($menu)
    {
        if($menu=='new')
        {

        }
        else
        {
            $this->load->model('menu_handler');
            $data = $this->menu_handler->get_menu_data($menu);
            $data['structure'] = $this->menu_handler->get_menu_edit_array($menu)['main_menu'];
            $this->load->view('sec_menu/edit', $data);
        }
    }
}
