<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends MX_Controller
{
    protected $modules;

    function index()
    {
        $this->load->model('content_handler');
        $data['rendered_elements']=$this->render_interactive_list();
        $data['contents_list']=$this->content_handler->get_contents_list();
        $this->load->view('pages/list_wrapper', $data);
    }

    function edit($id)
    {
        $this->load->model('page_handler');
        $this->load->model('content_handler');
        //Load installed modules / editor directives file
        $this->modules=json_decode(file_get_contents(APPPATH."config/modules.json"));
        if($id=='new')
        {
            $data_array['id']=uniqid();
            $data_array['title']='';
            $data_array['page_name']='';
            $data_array['container']='';
            $data_array['layout']='';
            $data_array['has_sidebar']=false;
            $data_array['main_content']='';
            $data_array['is_new']=true;
        }
        else
        {
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
        $data_array['contents_list']=$this->content_handler->get_contents_list();
        $data_array['containers']=$this->page_handler->get_containers_list();
        $this->load->view('pages/edit_wrapper', $data_array);
    }

    private function generate_tree($elements)
    {
        $rendered_html="";
        foreach($elements as $element)
        {
            if($element->type==='content')
            {
                $rendered_html.= $this->draw_content($element->id);
            }
            elseif(in_array($element->type, $this->modules->blocks_editor))
            {
                $block_array['type']=$element->type;
                $block_array['views_rendered'] = $this->draw_views($element->views);
                $rendered_html.= $this->load->view('pages/structure_block', $block_array, true);
            }
            elseif(in_array($element->type, $this->modules->single_view_editor))
            {
                //SINGLE VIEW COMPONENTS
                $view_array['type']=$element->type;
                $view_array['class']=$element->class;
                $view_array['title']=$element->views[0]->title;
                $view_array['id']=$element->views[0]->id;
                $view_array['items_rendered']=$this->generate_tree($element->views[0]->elements);
                $rendered_html.= $this->load->view('pages/structure_single_view', $view_array, true);
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

    function get_single_view_template(){
        $view_array['title'] = $this->input->post('title');
        $view_array ['id'] = $this->input->post('id');
        $view_array['type']=$this->input->post('type');
        $view_array['class']=$this->input->post('class');
        $view_array['items_rendered']='';
        if(preg_match('/^[a-z0-9-]+$/', $view_array['id']))
        {
            $this->load->view('pages/structure_single_view', $view_array);
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

    function save()
    {
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $name = $this->input->post('name');
        $container = $this->input->post('container');
        $json = $this->input->post('json');
        $this->load->model('page_handler');
        $result = $this->page_handler->save($id, $name, $container, $title, $json);
        if($result)
        {
            echo 'success';
        }
        else
        {
            echo 'failed - 500';
        }
    }

    //Functions for the list view (ajax-able)

    protected function render_interactive_list(){
        $this->load->model('page_handler');
        $containers = $this->page_handler->get_containers_list();
        $rendered_html='';
        foreach($containers as $container)
        {
            $pages = $this->page_handler->get_pages_container_list($container);
            $rendered_html.=$this->load->view('pages/list_block', array('pages' => $pages, 'container' => $container), true);
        }
        return $rendered_html;
    }

    function check_orphans()
    {
        $id = $this->input->post('id');
        $this->load->model('content_handler');
        $this->load->model('page_handler');
        $id_array = $this->page_handler->get_page_contents($id);
        $output = $this->content_handler->are_orphans($id_array);
        if (array_filter($output))
        {
            foreach($output as $out_id)
            {
                $content_array=$this->content_handler->get_symbol_array($out_id);
                $this->load->view('content/orphans_select', $content_array);
            }
        }
        else
        {
            echo 'false';
        }
    }

    function delete()
    {
        $id = $this->input->post('id');
        $this->load->model('page_handler');
        echo $this->page_handler->delete($id) ? 'success' : 'failed';
    }

    function set_tags()
    {
        $id = $this->input->post('id');
        $tag_string = $this->input->post('tags');
        $this->load->model('page_handler');
        echo $this->page_handler->set_tags($id, $tag_string) ? 'success' : 'failed';
    }

    function set_home()
    {
        $id = $this->input->post('id');
        $this->load->model('page_handler');
        echo $this->page_handler->set_home($id) ? 'success' : 'failed';
    }
}