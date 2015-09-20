<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_render extends MX_Controller
{
    /**
     * Index Page for this controller.
     *
     * Calls Page_render::view() for the page home::home, this displays the homepage.
     */
    public function index()
    {

        $page_info=explode('::',$this->db_config->get('general','home_page'));
        $this->view($page_info[0],$page_info[1]);
    }

    public function view($container,$page)
    {
        if(!isset($container))
        {
            $container='home';
            $page='home';
        }
        $base_data=[];
        $GLOBALS['p_container']=$container;
        $GLOBALS['p_name']=$page;
        $this->load->model('menu_handler');
        //Load the main menu (evaluate whether to make this a HMVC module)
        $id=$this->menu_handler->get_main_menu_id();
        $menu_data = $this->menu_handler->get_menu_array($id,$container,$page);
        $menu_data['home_active'] = ($container==='home' and $page==='home');
        $base_data['menu']=$this->load->view('frontend/main_menu',$menu_data,true);

        //Get page data
        $this->load->model('page_handler');
        //Get the true page id, taking into account container redirection.
        $page_id = $this->page_handler->get_true_page_id($container, $page);
        if($page_id===false)
        {
            redirect('page_render/display_404', 'auto', 404);
        }

        $page_data = $this->page_handler->get_page_obj($page_id);
        $base_data['title']=strip_tags($page_data->title);
        $base_data['content']=$this->display_layout($page_data);

        //Load basic system data
        $base_data['use_cdn']=$this->resources->use_cdn;
        $base_data['legacy_support']=$this->resources->legacy_support;
        $base_data['urls']=$this->resources->urls;
        $base_data['fallback_urls']=$this->resources->fallback_urls;
        $base_data['hover_menus']=(boolean)$this->db_config->get('style','menu_hover');

        //Load the final view and render the page
        $this->load->view('frontend/base', $base_data);
    }

    protected function display_layout($page_data)
    {
        $page_view=str_replace('-','_',$page_data->layout);
        $data=[];
        $data['title']=$page_data->title;
        $data['container_class']=$this->db_config->get('style','use_fluid_containers') ? 'container-fluid' : 'container';
        $data['content']=Modules::run('components/render_section',$page_data->elements);
        if(isset($page_data->sidebar_elements))
        {
            $data['sidebar_content']=Modules::run('components/render_section',$page_data->sidebar_elements);
        }
        return $this->load->view('frontend/'.$page_view,$data,true);
    }

    public function display_404(){
        $basedata=[];

        $this->load->model('menu_handler');
        //Load the main menu (evaluate whether to make this a HMVC module)
        $id=$this->menu_handler->get_main_menu_id();
        $menu_data = $this->menu_handler->get_menu_array($id,'','');
        $menu_data['home_active'] = false;
        $base_data['menu']=$this->load->view('frontend/main_menu',$menu_data,true);

        $base_data['title']='404 - Page not found';
        $base_data['content']=$this->load->view('frontend/404');

        //Load basic system data
        $base_data['use_cdn']=$this->resources->use_cdn;
        $base_data['legacy_support']=$this->resources->legacy_support;
        $base_data['urls']=$this->resources->urls;
        $base_data['fallback_urls']=$this->resources->fallback_urls;
        $base_data['hover_menus']=(boolean)$this->db_config->get('style','menu_hover');

        //Load the final view and render the page
        $this->load->view('frontend/base', $base_data);
        $this->output->set_status_header('404');
    }
}
