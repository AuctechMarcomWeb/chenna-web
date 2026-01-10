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

    $main         = $this->uri->segment(1); 
    $category     = $this->uri->segment(2); 
    $subCategory  = $this->uri->segment(3); 

	if (is_numeric($category)) {
	    $numeric = '1';
	} else {
	    $numeric = '0';
	}
 


$route['default_controller'] = 'web';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['user-registration']   = 'User_master/user_registration';
$route['acc-del-req']   = 'User_master/account_delete_req';
$route['user-signing']        = 'User_master/user_login';


$route['privacy-policy']      = 'web/privacy_policy';
$route['cancellation-policy'] = 'web/cancellation_policy';
$route['return-policy']       = 'web/refund_policy';
$route['terms-condition']     = 'web/terms_condition';
$route['help-center']         = 'web/help';
$route['contact-us']          = 'web/contact';
$route['about-us']            = 'web/about';
$route['faq']                 = 'web/faq';
$route['checkout']            = 'web/checkout';
$route['order-list']          = 'web/account_order';
$route['wish-list']           = 'web/account_wishlist';
$route['profile']             = 'web/account_profile';
$route['address']             = 'web/account_address';
$route['seller-login']        = 'seller/login';
$route['all-product-list']    = 'admin/Product/all_product_list';
$route['admin/Product/all-product-list-vendor/(:any)']    = 'admin/Product/all_product_list_vendor/$1';


$route['category-items/(:any)']      = 'web/category_list/$1';
$route['vegetable-items']      = 'web/vegetable_item_list';
$route['chicken-items']      = 'web/chicken_item_list';
$route['grocery-items']      = 'web/grocery_item_list';

if ($main == 'fashion-clothing' OR $main == 'bottomwear' OR $main == 'footwear' OR $main == 'men'
    OR $main == 'women' OR $main == 'western-wear' OR $main == 'women-footwear' 
    OR $main == 'indian-and-festive-wear' OR $main == 'boys-clothing'  
    OR $main == 'girls-clothing' OR $main == 'kid' OR $main == 'kids-infants'
    OR $main == 'women-accessories' OR $main == 'Jewelry') {

 $route[$main.'/'.$category] = 'web/category_product_list/'.$main.'/'.$category;
 
 $route['(:any)/(:any)/(:any)'] = 'web/sub_category_product_list/$1/$2/$3';
 
} 

if($numeric=='1'){
   if(!empty($main) AND !empty($category)  AND $main!=='admin' AND $main!=='web' AND $main!=='api'){
      $route[$main.'/'.$category] = 'web/product_detail/'.$main.'/'.$category;
   }  
}



$route['product/(:any)/(:num)'] = 'web/product/$1/$2';
$route['admin'] = 'admin/Welcome';

$route['apply-coupon'] = 'web/apply_coupon';