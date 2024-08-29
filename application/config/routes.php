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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller']   = 'dashboard';
$route['404_override'] 			 = 'errors/show_404';
$route['translate_uri_dashes'] = FALSE;

$route['admin-login']			= 'login/index/admin';
$route['admin-mobile-otp']			= 'login/admin_mobile_otp';
$route['admin-check-otp']			= 'login/admin_check_otp';
$route['admin-update-pass']			= 'login/admin_update_pass';
$route['seller-login']			= 'login/seller_login/seller';
$route['seller-logout']			= 'login/seller_logout';
$route['seller-mobile-otp']			= 'login/seller_mobile_otp';
$route['seller-check-otp']			= 'login/seller_check_otp';
$route['seller-update-pass']			= 'login/seller_update_pass';
$route['dashboard_content'] 	 = 'dashboard/dashboard_content';
$route['host_dashboard_content'] = 'dashboard/host_dashboard_content';
$route['reset-password']			= 'Reset_password/reset_password';
$route['reset-send-otp']			= 'Reset_password/reset_send_otp';
$route['verify-send-otp']			= 'Reset_password/verify_send_otp';
$route['new-password/(:any)']			= 'Reset_password/new_password/$1';
$route['reset-update-pass']			= 'Reset_password/reset_update_pass';


$route['changeStatus']         		= 'main/changeStatus';
$route['changeStatusDispaly']  = 'main/changeStatusDispaly';
$route['change_status']        = 'main/change_status';
$route['changeIndexing']       = 'main/changeIndexing';
$route['title/(:any)/(:num)']  = 'main/title/$1/$2';
$route['logout'] 	           = 'login/logout';

$route['admin-menu/(:num)'] = 'ACL/admin_menu';
$route['admin-menu/(:any)'] = 'ACL/admin_menu/$1';
$route['admin-menu/(:any)'] 						= 'ACL/admin_menu/$1';
$route['admin-menu/(:any)/(:num)'] 				= 'ACL/admin_menu/$1/$2';

$route['acl-data/(:num)'] = 'ACL';
$route['acl-data/(:any)'] = 'ACL/$1';
$route['acl-data/(:any)/(:any)'] = 'ACL/$1/$2';
$route['acl-data/(:any)/(:any)/(:any)'] = 'ACL/$1/$2/$3';
$route['acl-data/(:any)/(:any)/(:any)/(:any)'] = 'ACL/$1/$2/$3/$4';

$route['users/(:num)'] = 'ACL/users';
$route['users/(:any)'] = 'ACL/users/$1';
$route['users/(:any)/(:num)'] = 'ACL/users/$1/$2';

$route['user-role/(:num)'] = 'ACL/user_role';
$route['user-role/(:any)'] = 'ACL/user_role/$1';
$route['user-role/(:any)'] 						= 'ACL/user_role/$1';
$route['user-role/(:any)/(:num)'] 				= 'ACL/user_role/$1/$2';

$route['buyers-sellers/(:num)'] = 'sellers';
$route['buyers-sellers/(:any)'] = 'sellers/$1';
$route['buyers-sellers/(:any)/(:any)'] = 'sellers/$1/$2';
$route['buyers-sellers/(:any)/(:any)/(:any)'] = 'sellers/$1/$2/$3';
$route['buyers-sellers/(:any)/(:any)/(:any)/(:any)'] = 'sellers/$1/$2/$3/$4';

$route['sellers/(:num)'] = 'sellers/sellers';
$route['sellers/(:any)'] = 'sellers/sellers/$1';
$route['sellers/(:any)/(:any)'] = 'sellers/sellers/$1/$2';
$route['sellers/(:any)/(:any)/(:any)'] = 'sellers/sellers/$1/$2/$3';

// Master

$route['master-data/(:num)'] = 'Master';
$route['master-data/(:any)'] = 'Master/$1';
$route['master-data/(:any)/(:any)'] = 'Master/$1/$2';
$route['master-data/(:any)/(:any)/(:any)'] = 'Master/$1/$2/$3';
$route['master-data/(:any)/(:any)/(:any)/(:any)'] = 'Master/$1/$2/$3/$4';


$route['daily-items-master/(:num)'] = 'master/daily_items';
$route['daily-items-master/(:any)'] = 'master/daily_items/$1';
$route['daily-items-master/(:any)/(:any)'] = 'master/daily_items/$1/$2';

$route['daily-items-rates/(:num)'] = 'master/daily_rates';
$route['daily-items-rates/(:any)'] = 'master/daily_rates/$1';
$route['daily-items-rates/(:any)/(:any)'] = 'master/daily_rates/$1/$2';

$route['features-master/(:num)'] = 'master/features';
$route['features-master/(:any)'] = 'master/features/$1';
$route['features-master/(:any)/(:any)'] = 'master/features/$1/$2';

$route['package-master/(:num)'] = 'master/package';
$route['package-master/(:any)'] = 'master/package/$1';
$route['package-master/(:any)/(:any)'] = 'master/package/$1/$2';

$route['booking-timings/(:num)'] = 'master/booking_timings';
$route['booking-timings/(:any)'] = 'master/booking_timings/$1';
$route['booking-timings/(:any)/(:any)'] = 'master/booking_timings/$1/$2';

$route['transporter/(:num)'] = 'master/transporter';
$route['transporter/(:any)'] = 'master/transporter/$1';
$route['transporter/(:any)/(:any)'] = 'master/transporter/$1/$2';

