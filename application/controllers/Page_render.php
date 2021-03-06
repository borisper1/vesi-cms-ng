<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_render extends MX_Controller
{
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
        $menu_data['class'] = $this->db_config->get('style', 'menu_class');
        $menu_data['logo_image_path'] = $this->db_config->get('general', 'logo_image_path');
        $base_data['menu']=$this->load->view('frontend/main_menu',$menu_data,true);

        //Get page data
        $this->load->model('page_handler');
        //Get the true page id, taking into account container redirection.
        $page_id = $this->page_handler->get_true_page_id($container, $page);
        if($page_id===false)
        {
            $this->display_404();
            return;
        }

        $page_data = $this->page_handler->get_page_obj($page_id);
        $base_data['title']=strip_tags($page_data->title).' | '.$this->db_config->get('general','website_name');
        $base_data['content'] =$this->display_layout($page_data);
        if($this->db_config->get('content','display_footer')){
            $base_data['content'].=$this->db_config->get('content','footer_html');
        }

        //Load basic system data
        $base_data['use_cdn']=$this->resources->use_cdn;
        $base_data['legacy_support']=$this->resources->legacy_support;
        $base_data['urls']=$this->resources->urls;
        $base_data['urls']['aux_js_loader']=$this->resources->get_aux_js_urls();
        $base_data['fallback_urls']=$this->resources->fallback_urls;
        $base_data['hover_menus']=(boolean)$this->db_config->get('style','menu_hover');

        //Load the final view and render the page
        $this->load->view('frontend/base', $base_data);
    }

    protected function render_alerts($container, $name)
    {
        $this->load->model('alerts_handler');
        $alerts = $this->alerts_handler-> get_alerts_for_page($container, $name);
        $render_out = PHP_EOL;
        foreach($alerts as $alert)
        {
            $render_out.= $this->load->view('frontend/alert', $alert, true).PHP_EOL;
        }
        return $render_out;
    }

    protected function display_layout($page_data)
    {
        $page_view=str_replace('-','_',$page_data->layout);
        $data=[];
        $hide_title = ($page_data->container.'::'.$page_data->page_name==$this->db_config->get('general','home_page') and $this->db_config->get('style','display_home_page_title')==0);
        $data['title']=$hide_title ? '' : $page_data->title;
        $data['container_class']=$this->db_config->get('style','use_fluid_containers') ? 'container-fluid' : 'container';
        if($this->db_config->get('content','display_footer')){
            $data['container_class'].=' with-footer';
        }
        $data['alerts'] = $this->render_alerts($page_data->container, $page_data->page_name);
        $data['content'] = $this->render_section($page_data->elements);
        if(isset($page_data->sidebar_elements))
        {
            $data['sidebar_content'] = $this->render_section($page_data->sidebar_elements);
        }
        return $this->load->view('frontend/'.$page_view,$data,true);
    }

    public function display_404()
    {
        $this->load->model('menu_handler');
        //Load the main menu (evaluate whether to make this a HMVC module)
        $id=$this->menu_handler->get_main_menu_id();
        $menu_data = $this->menu_handler->get_menu_array($id,'','');
        $menu_data['home_active'] = false;
        $menu_data['logo_image_path'] = $this->db_config->get('general', 'logo_image_path');
        $base_data['menu']=$this->load->view('frontend/main_menu',$menu_data,true);

        $base_data['title']='404 - Page not found';
        $base_data['content']=$this->load->view('frontend/404', null, true);

        //Load basic system data
        $base_data['use_cdn']=$this->resources->use_cdn;
        $base_data['legacy_support']=$this->resources->legacy_support;
        $base_data['urls']=$this->resources->urls;
        $base_data['urls']['aux_js_loader']=[];
        $base_data['fallback_urls']=$this->resources->fallback_urls;
        $base_data['hover_menus']=(boolean)$this->db_config->get('style','menu_hover');

        //Load the final view and render the page
        $this->load->view('frontend/base', $base_data);
        $this->output->set_status_header('404');

        //Log the error in syslog
        $this->load->model('error_logger');
        $referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        $this->error_logger->log_404_error($referrer);
    }

    protected function render_section($structure)
    {
        $html = "";
        foreach ($structure as $element) {
            if ($element->type === 'content') {
                $html .= Modules::run('components/render_component', $element->id);
            } elseif ($element->type === 'menu') {
                $html .= Modules::run('components/render_sec_menu', $element->id);
            } elseif ($element->type === 'plugin') {
                $html .= $this->render_plugin($element->name, $element->command);
            } elseif (in_array($element->type, $this->modules_handler->installed_structures)) {
                $structure_data = [];
                foreach ($element->views as $view) {
                    $view_data = [];
                    $view_data['id'] = $view->id;
                    $view_data['title'] = $view->title;
                    $view_data['content'] = $this->render_section($view->elements);
                    $structure_data[] = $view_data;
                }
                $class = isset($element->class) ? $element->class : null;
                $html .= Modules::run('components/load_structure_view', $element->type, $structure_data, $class);
            };
        }
        return $html;
    }

    function render_plugin($name, $command)
    {
        $plugin_info = $this->modules_handler->get_plugin_data($name);
        if ($plugin_info['type'] === 'full' and $plugin_info['enabled']) {
            return Modules::run('mod_plugins/' . $name . '/render', $command);
        } else {
            $this->load->model('error_logger');
            $this->error_logger->log_no_plugin_error($name);
            return $this->load->view('frontend/errors/plugin_not_found', array('name' => $name), true);
        }
    }
}
