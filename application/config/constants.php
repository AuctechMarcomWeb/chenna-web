<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

define('PROJECT_tit','Chenna');
define('PRICE1','Rs. ');
define('LOGIN','login_master');
define("USER_MASTER",'user_master');
// COLUMAN FILED
define('DEVICE','device_id');
define('USERID','uuid');
define('NAME','name');
define('MOBILE','mobile');
define('STATUS','status');
define('PASSWORD','password');
define('EMAIL','email');
define('GENDER','gender');
define('ADD_DATE','add_date');
define('MODIFY_DATE','modify_date');
define('LAST_LOGIN','last_login_time');
define('TYPE','type');
define('OTP','otp');
// TABLE COLUMN NAME

define('APP_NAME','Chenna');
define('OK','1');
define('NOT_EXISTS_DATA','3');
define('GET', 'GET');
define('POST', 'POST');
define('EXISTS', '1');
define('NOT_EXISTS', '0');
define('DATA', 'data');	
define('SUCCESS', 'Success');
define('RESCODES', 'resMS');
define('RESCODES2', 'resMS2');
define('RESCODEE', 'resME');			//used
define('FAIL', 'Fail');	
define('S', '1');			//used
define('F', '0');
# IMAGE
define('LDPI', 'Ldpi');
define('MDPI', 'Mdpi');
define('HDPI', 'Hdpi');
define('XXHDPI', 'Xxhdpi'); 
define('LOCATION', 'location');
define('IS_UPLOADED', 'is_uploaded');
define('DEFAULT_IMAGE','1463461206.jpg');
define('IMAGE_DIRECTORY', $_SERVER['DOCUMENT_ROOT'].'/assets/category_images/');
define('BRAND_DIRECTORY', $_SERVER['DOCUMENT_ROOT'].'/assets/brand_images/');
define('BANNER_DIRECTORY', $_SERVER['DOCUMENT_ROOT'].'/assets/banner_images/');
define('BOY_DIRECTORY', $_SERVER['DOCUMENT_ROOT'].'/assets/banner_images/boy/');
define('PRODUCT_DIRECTORY', $_SERVER['DOCUMENT_ROOT'].'/Chenna-co/assets/product_images/');
define('EXCEL_DIRECTORY', $_SERVER['DOCUMENT_ROOT'].'/assets/uploaded_excel_file');
define('BRAND_URL', $_SERVER['DOCUMENT_ROOT'].'/assets/brand_images/');
define('NOTIFICATION_URL', $_SERVER['DOCUMENT_ROOT'].'/assets/notification_images/');
define('IMAGE_URL', 'https://'.$_SERVER['HTTP_HOST'].'/assets/');
define('PROFILE_DIRECTORY', $_SERVER['DOCUMENT_ROOT'].'assets/profile_image/');
define('WEBSITE_DIRECTORY', $_SERVER['DOCUMENT_ROOT'].'/assets/promotion_img/');

define('INVOICE_DIRECTORY', $_SERVER['DOCUMENT_ROOT'].'/assets/invoice/');
define('LOGO_DIRECTORY', $_SERVER['DOCUMENT_ROOT'].'/assets/Website/img/');
define('ABOUT_DIRECTORY', $_SERVER['DOCUMENT_ROOT'].'/Chenna-co/assets/profile_image/');
define('REVIEW_DIRECTORY', $_SERVER['DOCUMENT_ROOT'].'/Chenna-co/assets/customer_review_images/');
define('PROMOTER_DOCUMNET_DIRECTORY', $_SERVER['DOCUMENT_ROOT'].'assets/promoter_images/');
define('VENDOR_DOCUMNET_DIRECTORY', $_SERVER['DOCUMENT_ROOT'].'assets/vendor_images/');


define('API_ACCESS_KEY','AAAAmyju-Hs:APA91bHLbnq9UAh07R4YnWrlxmjy1xhyDZcj2xe3LVR4aoLK5kFnKaaVHVD5TVRYkPJ4LIeagAWopeUS3uVwwarB8E1TeHjhRwea_0FUnKnqk3VGN-YifKGwwxPHO7_0VUju1_0h4_xVG_8eC1qi6v42tfNYywizTA');
