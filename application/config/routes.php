<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'page_render';
$route['404_override'] = 'page_render/display_404';
$route['translate_uri_dashes'] = FALSE;

//define the 404 route
$route['page_render/display_404'] = 'page_render/display_404';

//Routes for services system
$route['services/(:any)'] =  'services/execute_service/$1';
$route['services/(:any)/(:any)'] =  'services/execute_service/$1/$2';

//Routes for plugins system
$route['plugins/(:any)'] = 'plugins/execute_plugin/$1';
$route['plugins/(:any)/(:any)'] = 'plugins/execute_plugin/$1/$2';

//Routes for administration interface (page + ajax)
$route['admin'] = 'administration';
$route['admin/login'] = 'administration/login';
$route['admin/logout'] = 'administration/logout';
$route['admin/(:any)'] = 'administration/load_interface/$1/index';
$route['admin/config/(:any)'] = 'administration/load_interface/config/load_interface/$1';
$route['admin/(:any)/(:any)'] = 'administration/load_interface/$1/$2';
$route['admin/(:any)/(:any)/(:any)'] = 'administration/load_interface/$1/$2/$3';
$route['ajax/admin/(:any)/(:any)'] = 'administration/ajax_interface/$1/$2';

//The route for standard page views
$route['(:any)/(:any)'] = 'page_render/view/$1/$2';

//Draw a 404 on all non defined routes, securing modules from unwanted access (permits centralized authentication checking)
$route['(:any)'] = 'page_render/display_404';