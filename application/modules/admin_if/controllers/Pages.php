<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends MX_Controller
{
    protected $blocks_editor =[], $single_view_editor = [];

    function index()
    {
        $this->load->model('group_handler');
        $this->load->model('page_handler');
        $cfilter = $this->group_handler->check_content_filter($this->session->admin_group);
        $data['cfilter_on'] = $cfilter!==false;
        $data['rendered_elements']=$this->render_interactive_list($cfilter);
        $data['containers']=$this->page_handler->get_containers_list();
        $this->load->view('pages/list_wrapper', $data);
    }

    function edit($id)
    {
        $this->load->model('page_handler');
        $this->load->model('content_handler');
        $this->load->model('menu_handler');
        $this->load->model('group_handler');
        //Load installed modules / editor directives file
        $this->load_json_descriptor();
        if($id=='new')
        {
            $data_array['id']=uniqid();
            $data_array['title']='';
            $data_array['page_name']='';
            $data_array['container']='';
            $data_array['layout']='';
            $data_array['has_sidebar']=false;
            $data_array['main_content']='';
            $data_array['restrict_access'] = false;
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
        $data_array['menus_list']=$this->menu_handler->get_menu_list();
        $data_array['contents_list']=$this->content_handler->get_contents_list();
        $data_array['containers']=$this->page_handler->get_containers_list();
        $data_array['components_list'] = $this->modules_handler->get_components_list();
        $data_array['plugins'] = $this->modules_handler->get_full_plugin_list();
        $data_array['frontend_groups'] = $this->group_handler->get_frontend_group_list();
        $this->load->view('pages/edit_wrapper', $data_array);
    }

    private function load_json_descriptor()
    {
        $data = $this->modules_handler->get_editors_arrays();
        $this->single_view_editor = $data['single_view'];
        $this->blocks_editor = $data['blocks'];
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
            elseif(in_array($element->type, $this->blocks_editor))
            {
                $block_array['type']=$element->type;
                $block_array['views_rendered'] = $this->draw_views($element->views);
                $rendered_html.= $this->load->view('pages/structure_block', $block_array, true);
            }
            elseif(in_array($element->type, $this->single_view_editor))
            {
                //SINGLE VIEW COMPONENTS
                $view_array['type']=$element->type;
                $view_array['class']=$element->class;
                $view_array['title']=$element->views[0]->title;
                $view_array['id']=$element->views[0]->id;
                $view_array['items_rendered']=$this->generate_tree($element->views[0]->elements);
                $rendered_html.= $this->load->view('pages/structure_single_view', $view_array, true);
            }
            elseif($element->type==='menu')
            {
                $rendered_html.= $this->draw_menu($element->id);
            } elseif ($element->type === 'plugin') {
                $rendered_html .= $this->draw_plugin($element->name, $element->command);
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
        return $this->load->view('pages/content_symbol', $content_array, true);
    }

    private function draw_menu($id)
    {
        $this->load->model('menu_handler');
        $menu_array=$this->menu_handler->get_menu_data($id);
        if($menu_array!==false)
        {
            $menu_array['exists']=true;
        }
        else
        {
            $menu_array['exists']=false;
            $menu_array['id'] = $id;
            $menu_array['title']='';
        }
        return $this->load->view('pages/menu_symbol', $menu_array, true);
    }

    private function draw_plugin($name, $command = '')
    {
        $plugin_array = $this->modules_handler->get_plugin_data($name);
        if ($plugin_array !== false) {
            $plugin_array['exists'] = true;
        } else {
            $plugin_array['exists'] = false;
            $plugin_array['name'] = $name;
            $plugin_array['title'] = '';
        }
        $plugin_array['command'] = $command;
        return $this->load->view('pages/plugin_symbol', $plugin_array, true);
    }

    //AJAX accessible functions

    function get_content_symbol(){
        $id = $this->input->post('id');
        echo $this->draw_content($id);
    }

    function get_menu_symbol(){
        $id = $this->input->post('id');
        echo $this->draw_menu($id);
    }

    function get_plugin_symbol()
    {
        $name = $this->input->post('name');
        $command = rawurldecode($this->input->post('command'));
        echo $this->draw_plugin($name, $command);
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
        $title = strip_tags(rawurldecode($this->input->post('title')));
        $name = $this->input->post('name');
        $container = $this->input->post('container');
        $json = rawurldecode($this->input->post('json'));
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

    function get_new_id()
    {
        return uniqid();
    }

    //Functions for the list view (ajax-able)

    protected function render_interactive_list($cfilter = false)
    {
        //Implement content filtering
        $this->load->model('page_handler');
        $containers = $this->page_handler->get_containers_list();
        $rendered_html='';
        foreach($containers as &$container)
        {
            $pages = $this->page_handler->get_pages_container_list($container);
            $pages_full_identifiers = [];
            foreach($pages as &$page)
            {
                $pages_full_identifiers[]=$container.'::'.$page['name'];
            }
            $load_block = true;
            if($cfilter!==false)
            {
                $directives_containers =[];
                $directives_pages = [];
                foreach($cfilter['directives'] as &$directive)
                {
                    if(strpos($directive, '::')===false)
                    {
                        $directives_containers[]=$directive;
                    }
                    else
                    {
                        $directives_pages[]=$directive;
                    }
                }
                $common_pages = array_intersect($pages_full_identifiers,$directives_pages);
                if(in_array($container, $directives_containers))
                {
                    if($cfilter['mode']==='blacklist')
                    {
                        $load_block = false;
                    }
                }
                elseif($common_pages!=[])
                {
                    $pages=[];
                    foreach($common_pages as $common_page)
                    {
                        $pages[]=explode('::',$common_page)[1];
                    }
                }
                else
                {
                    $load_block = false;
                }
            }
            if($load_block)
            {
                $rendered_html.=$this->load->view('pages/list_block', array('pages' => $pages, 'container' => $container, 'cfilter_status' => $cfilter!==false), true);
            }
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

    function new_redirect()
    {
        $container = $this->input->post('container');
        $target = $this->input->post('target');
        $page = $this->input->post('page');
        $this->load->model('page_handler');
        echo $this->page_handler->new_redirect($container,$target,$page) ? 'success' : 'failed';
    }

    function edit_redirect()
    {
        $id = $this->input->post('id');
        $container = $this->input->post('container');
        $target = $this->input->post('target');
        $page = $this->input->post('page');
        $this->load->model('page_handler');
        echo $this->page_handler->edit_redirect($id,$container,$target,$page) ? 'success' : 'failed';
    }
}