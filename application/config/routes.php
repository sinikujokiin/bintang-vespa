<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['cms/dashboard'] = 'cms/Dashboard';
$route['cms/get-data-dashboard'] = 'cms/Dashboard/getData';


// Menu
$route['cms/data-menu'] = 'cms/Menu';
$route['cms/get-data-menu'] = 'cms/Menu/getData';
$route['cms/get-data-menu/(:any)'] = 'cms/Menu/getDataById/$1';
$route['cms/get-parent-menu'] = 'cms/Menu/loadParent';
$route['cms/save-menu/(:any)'] = 'cms/Menu/$1';
$route['cms/delete-menu/(:any)'] = 'cms/Menu/delete/$1';



$route['cms/sorting-menu'] = 'cms/Sorting';
$route['cms/get-sorting-menu/(:any)'] = 'cms/sorting/getSortingMenu/$1';
$route['cms/save-sorting-menu/(:any)'] = 'cms/sorting/changePosition/$1';


// Profile
$route['cms/data-profile'] = 'cms/Profile';
$route['cms/update-profile'] = 'cms/Profile/saveProfile';
$route['cms/update-password'] = 'cms/Profile/savePassword';
$route['cms/save-profile-picture'] = 'cms/Profile/saveProfilePicture';
// Setting
$route['cms/web-setting'] = 'cms/Setting';
$route['cms/update-profile-website'] = 'cms/Setting/update';


$route['cms/data-user/(:any)'] = 'cms/User/index/$1';
$route['cms/data-user'] = 'cms/User';
$route['cms/get-data-user'] = 'cms/User/getData';
$route['cms/get-data-user/(:any)'] = 'cms/User/getDataById/$1';
$route['cms/save-user/(:any)'] = 'cms/User/$1user';
$route['cms/delete-user/(:any)'] = 'cms/User/delete/$1';

$route['cms/data-customer/(:any)'] = 'cms/Customers/index/$1';
$route['cms/data-customer'] = 'cms/Customers';
$route['cms/get-data-customer'] = 'cms/Customers/getData';
$route['cms/get-data-customer/(:any)'] = 'cms/Customers/getDataById/$1';
$route['cms/save-customer/(:any)'] = 'cms/Customers/$1';
$route['cms/delete-customer/(:any)'] = 'cms/Customers/delete/$1';

$route['cms/data-vespa/(:any)'] = 'cms/vespa/index/$1';
$route['cms/data-vespa'] = 'cms/vespa';
$route['cms/get-data-vespa'] = 'cms/vespa/getData';
$route['cms/get-data-vespa/(:any)'] = 'cms/vespa/getDataById/$1';
$route['cms/save-vespa/(:any)'] = 'cms/vespa/$1';
$route['cms/delete-vespa/(:any)'] = 'cms/vespa/delete/$1';

$route['cms/data-sparepart/(:any)'] = 'cms/Spareparts/index/$1';
$route['cms/data-sparepart'] = 'cms/Spareparts';
$route['cms/get-data-sparepart'] = 'cms/Spareparts/getData';
$route['cms/get-data-sparepart/(:any)'] = 'cms/Spareparts/getDataById/$1';
$route['cms/save-sparepart/(:any)'] = 'cms/Spareparts/$1';
$route['cms/delete-sparepart/(:any)'] = 'cms/Spareparts/delete/$1';

$route['cms/data-workshop/(:any)'] = 'cms/Workshops/$1';
$route['cms/data-workshop/(:any)/(:any)'] = 'cms/Workshops/$1/$2';
$route['cms/data-workshop'] = 'cms/Workshops';
$route['cms/get-data-workshop'] = 'cms/Workshops/getData';
$route['cms/get-data-workshop/(:any)'] = 'cms/Workshops/getDataById/$1';
$route['cms/save-workshop/(:any)'] = 'cms/Workshops/$1';
$route['cms/delete-workshop/(:any)'] = 'cms/Workshops/destroy/$1';


$route['get-data-workshop'] = 'Home/getWorkshop';
$route['booking-now'] = 'cms/Booking';
$route['cms/get-data-booking'] = 'cms/Booking/getData';
$route['cms/data-booking'] = 'cms/Booking';
$route['cms/data-booking/(:any)'] = 'cms/Booking/$1';
$route['cms/data-booking/(:any)/(:any)'] = 'cms/Booking/$1/$2';
$route['cms/delete-booking/(:any)'] = 'cms/Booking/destroy/$1';

$route['cms/get-data-history'] = 'cms/Transactions/getData';
$route['cms/data-history'] = 'cms/Transactions';
$route['cms/data-history/(:any)'] = 'cms/Transactions/$1';
$route['cms/data-history/(:any)/(:any)'] = 'cms/Transactions/$1/$2';

// Role
$route['cms/data-role'] = 'cms/Role';
$route['cms/get-data-role'] = 'cms/Role/getData';
$route['cms/get-data-role/(:any)'] = 'cms/Role/getDataById/$1';
$route['cms/save-role/(:any)'] = 'cms/Role/$1';
$route['cms/delete-role/(:any)'] = 'cms/Role/delete/$1';
$route['cms/get-access-role/(:any)'] = 'cms/Role/akses/$1';
$route['cms/save-access-role'] = 'cms/Role/saveAkses';

$route['cms/report'] = 'cms/Report';

$route['login'] = 'Auth';
$route['register'] = 'Auth/register';
$route['logout'] = 'Auth/logout';
$route['doLogin'] = 'Auth/doLogin';

$route['forgot-password'] = 'Auth/forgot';
$route['send-code'] = 'Auth/sendOtp';

$route['error-403'] = 'Errors/error403';
// $route['error-404'] = 'Errors/error404';


$route['default_controller'] = 'home';
$route['404_override'] = 'Errors/error404';
$route['translate_uri_dashes'] = FALSE;

//$route['(.*)'] = "error404";
