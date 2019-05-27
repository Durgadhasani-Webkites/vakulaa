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

$route['default_controller'] = "index";
$route['404_override'] = '';


$route['admin'] = "admin/index";
$route['admin/(:any)']='admin/$1';
$route['admin/(:any)/(:any)']='admin/$1/$2';
$route['admin/(:any)/(:any)/(:any)']='admin/$1/$2/$3';
$route['admin/(:any)/(:any)/(:any)/(:any)']='admin/$1/$2/$3/$4';
$route['cart/cart_details'] = "cart/cart_details";
$route['cart/delete_cart_item'] = "cart/delete_cart_item";

$route['product/get_option_details']='product/get_option_details';
$route['product/product_ajax']='product/product_ajax';
$route['product/(:any)']='product/index/$1';

$route['cart/view']='cart/view';
$route['cart/update']='cart/update';
$route['cart/delete/(:any)']='cart/delete/$1';

$route['contact-us']='contact_us';
// $route['contact_us/process']='contact_us/process';

$route['partner-with-us']='partner';
$route['story']='story';

$route['product-details']='index/detailpage';
$route['clients']='index/clients';

$route['track-order']='track_order/index';
$route['user/signin']='user/signin';


$route['cart/add_to_cart']='cart/add_to_cart';
$route['cart/apply_coupon']='cart/apply_coupon';
$route['cart/remove_coupon/(:any)']='cart/remove_coupon/$1';
$route['cart/remove_coupon_code']='cart/remove_coupon_code';
$route['search/ajax_search_results']='search/ajax_search_results';
$route['search']='search/index';

$route['google']='google';
$route['fbci/fblogin']='fbci/fblogin';

$route['payment']='payment/index';
$route['payment/(:any)']='payment/$1';

// $route['payment']='checkout/payment';
$route['checkout']='checkout';
$route['checkout/process_shipping_addr']='checkout/process_shipping_addr';
// $route['checkout/process_payment']='checkout/process_payment';
// $route['checkout/get_timeslot']='checkout/get_timeslot';
// $route['checkout/get_estimated_date']='checkout/get_estimated_date';
$route['checkout/get_states']='checkout/get_states';
$route['product/pincode_check'] = "product/pincode_check";

$route['checkout/cashondelivery']='checkout/cashondelivery';
$route['checkout/(:any)']='checkout/$1';
// $route['checkout/ccavenue_payment']='checkout/ccavenue_payment';
// $route['checkout/ccavenue_return']='checkout/ccavenue_return';
// $route['checkout/instamojo_payment']='checkout/instamojo_payment';
// $route['checkout/instamojo_pay']='checkout/instamojo_pay';
$route['checkout/cancel_order']='checkout/cancel_order';

$route['checkout/success']='checkout/success';
$route['checkout/failure']='checkout/failure';

$route['index/subscribe_to_newsletter']='index/subscribe_to_newsletter';
$route['index/affiliate_process']='index/affiliate_process';

$route['user/(:any)']='user/$1';
$route['user/(:any)/(:any)']='user/$1/$2';

$route['(:any)'] = "index/index/$1";
$route['(:any)/(:any)']="index/index/$1/$2";
$route['(:any)/(:any)/(:any)']="index/index/$1/$2/$3";



/* End of file routes.php */
/* Location: ./application/config/routes.php */