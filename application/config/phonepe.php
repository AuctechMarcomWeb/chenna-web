<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('PHONEPE_MODE', 'TEST');

define('PHONEPE_CLIENT_ID',     'M23J23PSN2702_2512191528');    
define('PHONEPE_CLIENT_SECRET', 'ZTVkZWM0OWQtMzdlZi00YmNmLWJhMWUtMTU5MjgzOWRjMmUz'); 
define('PHONEPE_CLIENT_VERSION', 1);

define('TOKEN_URL',  'https://api-preprod.phonepe.com/apis/pg-sandbox/v1/oauth/token');
define('PAY_URL',    'https://api-preprod.phonepe.com/apis/pg-sandbox/checkout/v2/pay');
define('STATUS_URL', 'https://api-preprod.phonepe.com/apis/pg-sandbox/checkout/v2/order/');

?>