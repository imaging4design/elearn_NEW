<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "site/main";
$route['404_override'] = '';


/**************************************************/
//ROUTE 'MODULE' PAGES
/**************************************************/
$route['main/(:any)'] = 'site/main/$1';
$route['section/(:any)'] = 'site/section/$1';
$route['results/(:any)'] = 'site/results/$1';
$route['teachers/(:any)'] = 'site/teachers/$1';

/**************************************************/
//ROUTE 'PRINT' PAGES
/**************************************************/
$route['teachers_pdf/(:any)'] = 'site/teachers_pdf/$1';
$route['teachers_stud_pdf/(:any)'] = 'site/teachers_stud_pdf/$1';
$route['students_pdf/(:any)'] = 'site/students_pdf/$1';
//$route['teachers_class_pdf/(:any)'] = 'site/teachers_class_pdf/$1';

/**************************************************/
//ROUTE 'STATIC' PAGES
/**************************************************/
$route['site/(:any)'] = 'site/main/$1';


/**************************************************/
//ROUTE 'ADMIN' PAGES
/**************************************************/
// This should account for additional URI segments, if they exist
$route['admin/(:any)'] = 'admin/$1';
$route['topic_con/(:any)'] = 'admin/topic_con/$1';
$route['content_con/(:any)'] = 'admin/content_con/$1';
$route['keynotes_con/(:any)'] = 'admin/keynotes_con/$1';
$route['flashwritten_con/(:any)'] = 'admin/flashwritten_con/$1';
$route['multichoice_con/(:any)'] = 'admin/multichoice_con/$1';
$route['audiovideo_con/(:any)'] = 'admin/audiovideo_con/$1';
$route['subscription_con/(:any)'] = 'admin/subscription_con/$1';
$route['subscribers_con/(:any)'] = 'admin/subscribers_con/$1';
$route['general_con/(:any)'] = 'admin/general_con/$1';


/**************************************************/
//ROUTE 'PAYPAL' PAGES
/**************************************************/
$route['item/:any'] = 'paypal/items/details';
$route['items/school_order'] = 'paypal/items/school_order'; // To form for school orders
$route['purchase/:any'] = 'paypal/items/purchase';
$route['download/:any'] = 'paypal/items/download';
$route['paypal/register_Paypal'] = 'paypal/items/register_Paypal';
$route['paypal/error'] = 'paypal/items/error';
$route['paypal/add_member'] = 'paypal/paypal/add_member';
$route['paypal/add_member/(:any)'] = 'paypal/paypal/add_member';
$route['add_member_codes'] = 'paypal/paypal/add_member_codes';


/* End of file routes.php */
/* Location: ./application/config/routes.php */