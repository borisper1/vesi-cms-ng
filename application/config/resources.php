<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Stores the path of frontend resources that are not loaded via CDN
// The path is relative to the wwwroot (index.php) of the server

//jQuery (fallback, normally loaded form CDN).
$config['jquery1.x_path']='assets/third_party/jquery/jquery-1.11.3.min.js';
$config['jquery2.x_path']='assets/third_party/jquery/jquery-2.1.4.min.js';

//jQuery UI (preferred locally (lite version, little to no user-side usage).
$config['jqueryui_path']='assets/third_party/jquery-ui/jquery-ui.min.js';
$config['jqueryui_css_path']='assets/third_party/jquery-ui/css/jquery-ui.min.css';
$config['jqueryui_css-theme_path']='assets/third_party/jquery-ui/css/jquery-ui.theme.min.css';

//Bootstrap (css loaded only local; js is for fallback, normally loaded form CDN)
$config['bootstrap.js_path']='assets/third_party/bootstrap/js/bootstrap.min.js';
$config['bootstrap_css_path']='assets/third_party/bootstrap/css/bootstrap.min.css';
$config['frontend_bootstrap_css_path']='assets/third_party/bootstrap/css/bootstrap-custom.min.css';
//Only available locally
$config['bootstrap_switch.js_path']='assets/third_party/bootstrap-switch/bootstrap-switch.min.js';
$config['bootstrap_switch.css_path']='assets/third_party/bootstrap-switch/bootstrap-switch.min.css';
$config['bootstrap_menu_hover_path']='assets/third_party/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js';

//Fontawesome (fallback, normally loaded form CDN).
$config['fontawesome_path']='assets/third_party/fontawesome/css/font-awesome.min.css';