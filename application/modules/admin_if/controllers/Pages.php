<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends MX_Controller
{

    function index()
    {
        //Display users list
        $this->load->model('page_handler');
        $this->load->view('pages/list_wrapper');
    }

    function edit($id)
    {
        if($id=='new')
        {

            $data_array['is_new']=true;
        }
        else
        {
            $this->load->model('page_handler');
            $object = $this->page_handler->get_page_obj($id);
            $arrayObject = new ArrayObject($object);
            $data_array = $arrayObject->getArrayCopy();
            $data_array['has_sidebar']=strpos($data_array['layout'],'sidebar')===0;
            $data_array['main_content']= $this->generate_tree($data_array['elements']);
            if($data_array['has_sidebar'])
            {
                $translation_array = array('sidebar-left' => 'sinistra', 'sidebar-right' => 'destra');
                $data_array['sidebar_text'] = $translation_array[$data_array['layout']];
                $data_array['sidebar_content'] = $this->generate_tree($data_array['sidebar_elements']);
            }
            $data_array['is_new']=false;
        }
        $data_array['containers']=$this->page_handler->get_containers_list();
        $this->load->view('pages/edit_wrapper', $data_array);
    }

    private function generate_tree($elements)
    {
        $rendered_html="";
        foreach($elements as $element)
        {
            switch($element->type)
            {
                case "content":
                    $rendered_html.= $this->draw_content($element->id);
                    break;
                case "tabs-block":
                case "collapse-block":
                    $block_array['type']=$element->type;
                    $block_array['views_rendered'] = $this->draw_views($element->views);
                    $rendered_html.= $this->load->view('pages/structure_block', $block_array, true);
                    break;
            }
        }
        return $rendered_html;
    }

    private function draw_views($views)
    {
        $rendered_html="";
        foreach($views as $view)
        {
            $view_array['title']=$view->title;
            $view_array['id']=$view->id;
            $view_array['items_rendered']=$this->generate_tree($view->elements);
            $rendered_html.= $this->load->view('pages/structure_view', $view_array, true);
        }
        return $rendered_html;
    }

    private function draw_content($id)
    {
        $this->load->model('content_handler');
        $content_array=$this->content_handler->get_symbol_array($id);
        return $this->load->view('content/content_symbol', $content_array, true);
    }

    //AJAX accessible functions

    function get_content_symbol(){
        $id = $this->input->post('id');
        echo $this->draw_content($id);
    }

    function get_view_template(){
        $view_array['title'] = $this->input->post('title');
        $view_array ['id'] = $this->input->post('id');
        $view_array['items_rendered']='';
        if(preg_match('/^[a-z0-9-]+$/', $view_array['id']))
        {
            $this->load->view('pages/structure_view', $view_array);
        }
        else
        {
            echo 'failed';
        }

    }

    function get_block_template(){
        $block_array['type']=$this->input->post('type');
        $block_array['views_rendered'] = '';
        if(in_array($block_array['type'], array('tabs-block','collapse-block')))
        {
            $this->load->view('pages/structure_block', $block_array);
        }
        else
        {
            echo 'failed';
        }
    }

}