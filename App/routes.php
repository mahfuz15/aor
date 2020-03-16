<?php
namespace App;

use Framework\Http\Routing\Router;

$router = new Router();

$router->any('/')->action( 'Home', 'index');
$router->any('/login')->action( 'Home', 'login');

$router->any('/forgot-password')->action('Admin', 'forgotPassword');
$router->any('/reset-password/{email:\S+}/{token:\S+}')->action('Admin', 'resetPassword');
$router->any('/agent-confirm/{email:\S+}/{token:\S+}')->action('Agent', 'confirmAgent');

$router->group(['prefix' => '/' . ADMIN_PANEL_NAME, 'middlewares' => ['Admin']], function(Router $router) {
    #------Addition Modules --------#
    $router->any('/access')->action('Error', 'accessForbidden');
    $router->any('/config/site')->action('Site', 'setting');

    
    #----CACHE CONTROL----#
    $router->get('/cache/clear')->action('Misc', 'clearCache');
    
});

$router->group(['prefix' => '/' . ADMIN_PANEL_NAME, 'middlewares' => ['Admin','Permission']], function(Router $router) {
    $router->any('/')->action('Admin', 'index');
    $router->any('/dashboard')->action('Admin', 'index');
    $router->any('/reports')->action('Report', 'index');
    $router->any('/login')->action('Admin', 'login')->middleware(['Regular'], true);
    $router->any('/profile')->action('Admin', 'profile');
    $router->any('/logout')->action('Admin', 'logout');
    $router->any('/forgot-password')->action('Admin', 'forgotPassword')->middleware(['Regular'], true);
    $router->any('/reset-password/{email:\S+}/{token:\S+}')->action('Admin', 'resetPassword')->middleware(['Regular'], true);;
    
    #--- Admin Management ---#
    $router->resource('', 'AdminManage', []);
    $router->resource('/'.strtolower(SITE).'/user', 'AdminManage', []);

    #--- User Management ---#
    $router->resource('/'.strtolower(SITE).'/role', 'Role', []);
    $router->resource('/'.strtolower(SITE).'/module', 'Module', []);
    $router->resource('/'.strtolower(SITE).'/permission', 'Permission', []);

    #----Permission----#
    $router->any('/permission/role')->action('RolePermission', 'getPermissionByRoleID');
    $router->any('product/details/update')->action('PwdProductDetail', 'productDetailsUpdate');

    #----Activity Log----#
    $router->resource('/'.strtolower(SITE).'/activitylog', 'PwdAdminActivityLog', []);

    #----Agents Management----#
    $router->resource('/'.strtolower(SITE).'/agent', 'Agent', []);

});


#----API CONTROL----#

$router->group(['prefix' => '/api', 'middleWares' => ['Regular']], function(Router $router) {

    $router->any('/getToken')->action('Retailer', 'registerToken');
    $router->any('/register')->action('Retailer', 'registerAPI');
    $router->any('/verify-registration')->action('Retailer', 'verifyToken');
    
    $router->any('/resendToken/{retailer_id:\d+}')->action('Retailer', 'resetTokenAPI');
    $router->any('/login')->action('Retailer', 'loginAPI');
    $router->any('/logout')->action('Retailer', 'logoutAPI');

    $router->any('/product/details/english')->action('PwdProductDetail', 'getSpecificProductEnglishDetails');
    $router->any('/specification')->action('PwdProductSpecification', 'getSpecificationForProductDetails');
    $router->any('/specification/{product_id:\d+}')->action('PwdProductSpecification', 'thisProductEnLanguageSpecInfo');

    $router->any('/re')->action('PwdRe', 'getReByreNo');
    $router->any('/product/option')->action('PwdProductOption', 'getProductOptionsByLngIDProdID');
    $router->any('/product_option/language_copy')->action('PwdProductOption', 'getProductOptionsForLanguageCopy');

    $router->any('/product_parts/model_copy')->action('PwdProductPart', 'getProductPartsByLngIDProdID');
    $router->any('/product_parts/language_copy')->action('PwdProductPart', 'getProductPartsForLanguageCopy');

});

$router->any('/test')->action('Test', 'test');
return $router->dispatch();