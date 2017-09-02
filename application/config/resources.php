<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Stores the path of fallback frontend resources that are normally loaded via CDN
// The path is relative to the wwwroot (index.php) of the server

//jQuery
$config['jquery1.x_path'] = 'assets/third_party/jquery/jquery-1.12.0.min.js';
$config['jquery2.x_path'] = 'assets/third_party/jquery/jquery-2.2.0.min.js';

//Bootstrap
$config['bootstrap.js_path']='assets/third_party/bootstrap/js/bootstrap.min.js';

//Fontawesome
$config['fontawesome_path']='assets/third_party/fontawesome/css/font-awesome.min.css';

//Local MathJax installation
$config['mathjax_path']='assets/third_party/mathjax/MathJax.js';