<?php
defined('BASEPATH') or exit('No direct script access allowed');

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

/* GENERAL */
$route['default_controller'] = 'Frontend';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['openai'] = 'Frontend/openai_view';


 /* LEGAL */

/* $route['imprint'] = 'Frontend/imprint';
$route['faq'] = 'Frontend/faq';
$route['terms'] = 'Frontend/terms';
$route['about'] = 'Frontend/about'; */


 /* LANGUAGE */
/* $route['lang/(:any)'] = 'Frontend/lang/$1'; */

/* CUSTOM PAGES */
$route['search/(:any)'] = 'Frontend/search/$1';
// $route['heygen-easter-egg'] = 'Frontend/heygen';


/* BACKEND */

$route['backend'] = 'Backend/index';
$route['login'] = 'Frontend/login';
$route['reset_password/(:any)/(:any)'] = 'Frontend/reset_password_page/$1/$2';

 /* TESTING */
$route['design'] = 'Frontend/design';
$route['edit_db'] = 'Frontend/edit_db';
$route['sitemap'] = 'Frontend/site_map';

/* FOOTER */
$route['cookies'] = 'Frontend/cookies';


/* FORMS */
$route['forms/(:any)'] = 'Frontend/form/$1';

/* CATEGORY PAGE */
$route['programme/(:any)'] = 'Frontend/programme/$1';



/* SHOP */
$route['registration'] = 'Shop/customer_registration';
$route['confirm_registration/(:any)'] = 'Shop/confirm_registration/$1';
$route['shop/checkout'] = 'Shop/checkout';
$route['shop_cancel'] = 'Shop/cancel';
$route['shop_success'] = 'Shop/success';
/*$route['shop/failure'] = 'Shop/failure';
$route['shop/pending'] = 'Shop/pending';
$route['shop/confirm'] = 'Shop/confirm';*/
$route['shopping_cart'] = 'Shop/cart_view';
$route['billing_info'] = 'Shop/billing_info';
// $route['authentication/showLogin'] = 'Frontend/showLogin';




/* DETAIL PAGES */
$route['print/(:any)'] = 'Frontend/detail/$1/true';
$route['(:any)'] = 'Frontend/detail/$1'; // keep down here