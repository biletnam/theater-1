<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
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
$route['default_controller'] = 'home/index';
$route['404_override'] = '';
$route['privacy'] = 'page/index';
$route['term'] = 'page/index';
$route['help'] = 'page/index';
$route['safety'] = 'page/index';

//$route['add_post/addpostdata/(:any)'] = 'add_post/addpostdata/$1';
//$route['add_post/(:any)'] = 'add_post/index/$1';
//$route['choose_category/choosecatdata/(:any)'] = 'choose_category/choosecatdata/$1';
//$route['choose_category/(:any)'] = 'choose_category/index/$1';

/* admin */
$route['admin'] = 'admin/index';
$route['admin/signup'] = 'admin/signup';
$route['admin/create_member'] = 'admin/create_member';
$route['admin/login'] = 'admin/index';
$route['admin/logout'] = 'admin/logout';
$route['admin/login/validate_credentials'] = 'admin/validate_credentials';

$route['admin/category'] = 'admin_category/index';
$route['admin/category/add'] = 'admin_category/add';
$route['admin/category/update'] = 'admin_category/update';
$route['admin/category/update/(:any)'] = 'admin_category/update/$1';
$route['admin/category/delete/(:any)'] = 'admin_category/delete/$1';
$route['admin/category/(:any)'] = 'admin_category/index/$1'; //$1 = page number


$route['admin/products'] = 'admin_products/index';
$route['admin/products/add'] = 'admin_products/add';
$route['admin/products/add_ingr'] = 'admin_products/add_ingr';
$route['admin/products/add_ingr/(:any)'] = 'admin_products/add_ingr/$1';
$route['admin/products/delete_ingr'] = 'admin_products/delete_ingr';
$route['admin/products/delete_ingr/(:any)'] = 'admin_products/delete_ingr/$1';
$route['admin/products/update'] = 'admin_products/update';
$route['admin/products/update/(:any)'] = 'admin_products/update/$1';
$route['admin/products/delete/(:any)'] = 'admin_products/delete/$1';
$route['admin/products/ingredients'] = 'admin_products/ingredients';
$route['admin/products/ingredients/(:any)'] = 'admin_products/ingredients/$1';
$route['admin/products/get_row_material/(:any)'] = 'admin_products/get_row_material/$1';
$route['admin/products/(:any)'] = 'admin_products/index/$1'; //$1 = page number


$route['admin/user'] = 'admin_user/index';
$route['admin/user/add'] = 'admin_user/add';
$route['admin/user/update'] = 'admin_user/update';
$route['admin/user/exportcsv'] = 'admin_user/exportcsv';
$route['admin/user/update/(:any)'] = 'admin_user/update/$1';
$route['admin/user/delete/(:any)'] = 'admin_user/delete/$1';
$route['admin/user/(:any)'] = 'admin_user/index/$1'; //$1 = page number

$route['admin/company'] = 'admin_company/index';
$route['admin/company/add'] = 'admin_company/add';
$route['admin/company/update'] = 'admin_company/update';
$route['admin/company/update/(:any)'] = 'admin_company/update/$1';
$route['admin/company/delete/(:any)'] = 'admin_company/delete/$1';
$route['admin/company/(:any)'] = 'admin_company/index/$1'; //$1 = page number

$route['admin/material'] = 'admin_material/index';
$route['admin/material/add'] = 'admin_material/add';
$route['admin/material/update'] = 'admin_material/update';
$route['admin/material/update/(:any)'] = 'admin_material/update/$1';
$route['admin/material/delete/(:any)'] = 'admin_material/delete/$1';
$route['admin/material/(:any)'] = 'admin_material/index/$1'; //$1 = page number

$route['admin/purchase_material'] = 'admin_purchase_material/index';
$route['admin/purchase_material/add'] = 'admin_purchase_material/add';
$route['admin/purchase_material/update'] = 'admin_purchase_material/update';
$route['admin/purchase_material/update/(:any)'] = 'admin_purchase_material/update/$1';
$route['admin/purchase_material/delete/(:any)'] = 'admin_purchase_material/delete/$1';
$route['admin/purchase_material/(:any)'] = 'admin_purchase_material/index/$1'; //$1 = page number


$route['admin/uom'] = 'admin_uom/index';
$route['admin/uom/add'] = 'admin_uom/add';
$route['admin/uom/update'] = 'admin_uom/update';
$route['admin/uom/update/(:any)'] = 'admin_uom/update/$1';
$route['admin/uom/delete/(:any)'] = 'admin_uom/delete/$1';
$route['admin/uom/(:any)'] = 'admin_uom/index/$1';


$route['admin/operator_data'] = 'admin_operator_data/index';
$route['admin/operator_data/(:any)'] = 'admin_operator_data/index/$1';

$route['admin/operator'] = 'admin_operator/index';

$route['admin/operator_list'] = 'admin_operator_list/index';
$route['admin/operator_list/add'] = 'admin_operator_list/add';
$route['admin/operator_list/get_operator/(:any)'] = 'admin_operator_list/get_operator/$1';
$route['admin/operator_list/update'] = 'admin_operator_list/update';
$route['admin/operator_list/update/(:any)'] = 'admin_operator_list/update/$1';
$route['admin/operator_list/delete/(:any)'] = 'admin_operator_list/delete/$1';
$route['admin/operator_list/(:any)'] = 'admin_operator_list/index/$1';

$route['admin/report'] = 'admin_report/index';
$route['admin/report/search'] = 'admin_report/search';
$route['admin/report/search/(:any)'] = 'admin_report/search/$1';
$route['admin/report/(:any)'] = 'admin_report/index/$1';
$route['admin/report/list_view'] = 'admin_report/list_view';

$route['admin/report_list'] = 'admin_report_list/index';
$route['admin/report_list/search'] = 'admin_report_list/search';
$route['admin/report_list/(:any)'] = 'admin_report_list/index/$1';

$route['admin/report_today'] = 'admin_report_today/index';
$route['admin/report_today/search'] = 'admin_report_today/search';
$route['admin/report_today/(:any)'] = 'admin_report_today/index/$1';


$route['admin/purchase_report'] = 'admin_purchase_report/index';
$route['admin/purchase_report/search'] = 'admin_purchase_report/search';
$route['admin/purchase_report/search/(:any)'] = 'admin_purchase_report/search/$1';
$route['admin/purchase_report/(:any)'] = 'admin_purchase_report/index/$1';
$route['admin/purchase_report/list_view'] = 'admin_purchase_report/list_view';

$route['admin/purchase_report_today'] = 'admin_purchase_report_today/index';
$route['admin/purchase_report_today/search'] = 'admin_purchase_report_today/search';
$route['admin/purchase_report_today/(:any)'] = 'admin_purchase_report_today/index/$1';

$route['admin/dashboard'] = 'dashboard/index';
/*/
/* End of file routes.php */
/* Location: ./application/config/routes.php */