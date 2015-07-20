<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resources
{
    protected $CI;
    public $use_cdn=[], $urls=[], $fallback_urls=[], $legacy_support;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->library('db_config');
        $this->CI->load->config('resources');
        $this->legacy_support=(boolean)$this->CI->db_config->get('general','enable_legacy_support');
        //Load from Db whether to use CDNs or not.
        $this->use_cdn['jquery']=$this->legacy_support ? (boolean)$this->CI->db_config->get('resources','jquery1.x_usecdn') : (boolean)$this->CI->db_config->get('resources','jquery2.x_usecdn');
        $this->use_cdn['bootstrap.js']=(boolean)$this->CI->db_config->get('resources','bootstrap.js_usecdn');
        $this->use_cdn['fontawesome']=(boolean)$this->CI->db_config->get('resources','fontawesome_usecdn');
        //Compute primary URLs to use
        $this->urls['jquery']=$this->legacy_support ? ($this->use_cdn['jquery'] ? $this->CI->db_config->get('resources','jquery1.x_cdnurl') : $this->CI->config->item('jquery1.x_path')) : base_url(($this->use_cdn['jquery'] ? $this->CI->db_config->get('resources','jquery2.x_cdnurl') : $this->CI->config->item('jquery2.x_path')));
        $this->urls['bootstrap.js']=$this->use_cdn['bootstrap.js'] ? $this->CI->db_config->get('resources','bootstrap.js_cdnurl') : base_url($this->CI->config->item('bootstrap.js_path'));
        $this->urls['fontawesome']=$this->use_cdn['fontawesome'] ? $this->CI->db_config->get('resources','fontawesome_cdnurl') : base_url($this->CI->config->item('fontawesome_path'));
        //Compute fallback URLs to be used when needed (and loading detection is available (eg. only js files).
        $this->fallback_urls['jquery']=base_url($this->legacy_support ? $this->CI->config->item('jquery1.x_path') : $this->CI->config->item('jquery2.x_path'));
        $this->fallback_urls['bootstrap.js']=base_url($this->CI->config->item('bootstrap.js_path'));
        //Additional Components with no CDN support
        $this->urls['html5shiv']=base_url($this->CI->config->item('html5shiv_path'));
        $this->urls['respond.js']=base_url($this->CI->config->item('respond.js_path'));
        $this->urls['frontend_bootstrap.css']=base_url($this->CI->config->item('frontend_bootstrap_css_path'));
        $this->urls['bootstrap.css']=base_url($this->CI->config->item('bootstrap_css_path'));
        $this->urls['bootstrap_menu_hover']=base_url($this->CI->config->item('bootstrap_menu_hover_path'));
    }

    public function get_administration_urls()
    {
        $urls=[];
        $urls['jquery-ui.css']=base_url($this->CI->config->item('jqueryui_css_path'));
        $urls['admin_bootstrap.css']=base_url($this->CI->config->item('bootstrap_css_path'));
        $urls['fontawesome']=base_url($this->CI->config->item('fontawesome_path'));
        $urls['jquery']=$this->CI->db_config->get('resources','jquery2.x_cdnurl');
        $urls['jquery_local']=base_url($this->CI->config->item('jquery2.x_path'));
        $urls['jquery-ui.js']=base_url($this->CI->config->item('jqueryui_path'));
        $urls['bootstrap.js']=base_url($this->CI->config->item('bootstrap.js_path'));
        $urls['bootstrap-switch.js']= base_url($this->CI->config->item('bootstrap_switch.js_path'));
        $urls['bootstrap-switch.css']= base_url($this->CI->config->item('bootstrap_switch.css_path'));
        $urls['aux_js_loader']=[];
        $urls['aux_css_loader']=[];
        return $urls;
    }

}