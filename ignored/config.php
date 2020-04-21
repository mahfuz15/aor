<?php

//declare(strict_types=1);

//date_default_timezone_set('America/New_York');
//date_default_timezone_set('Asia/Dhaka');


// ready to go!
//All Configs

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');

define('SITE', 'PWD');
define('BASE_URL', 'http://localhost/pwd/Public/');
//define('BASE_URL', 'http://192.168.1.101/pwd/Public/');

define('DEVELOPMENT', true);
//define('DEVELOPER_IP', '::1');
//define('DEVELOPER_IP', '192.168.1.112');
define('TEMPLATE', 'site');
define('PUBLIC_DIR', 'Public');
define('ASSETS', BASE_URL . 'assets/');

// Define Your Application Path
define('APP', ROOT . DS . 'App');
define('CONTROLLERS', APP . DS . 'Controllers');
define('MODELS', APP . DS . 'Models');
define('VIEWS', APP . DS . 'Views');
define('TEMPLATES', APP . DS . 'Templates');
define('ROUTES', APP . DS . 'routes.php');
define('MIDDLEWARES', APP . DS . 'MiddleWares');

// Framework Directory
define('FRAMEWORK', ROOT . DS . 'Vendor' . DS . 'RevoInteractive' . DS . 'Framework');

define('CACHE_CLIENT', 'File');

// Panel Info
define('USER_PANEL_NAME', 'retailer');
define('ADMIN_PANEL_NAME', 'admin');

define("VERSION", "?version=0.4");

define("LIVE_URL", "https://www.atago.net/");
$main_dir = str_replace("pwd","",ROOT);
define("HOME", $main_dir); //htdocs
define("IMAGE_PATH",  'atago/folder_path/');
