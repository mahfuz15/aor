<?php

namespace MiddleWares;

use Closure;
use Controllers\PwdAdminActivityLogController;
use Framework\Http\Request\Request;
use Framework\Http\MiddleWare\MiddleWareInterface;
use Vendor\Inflect;

class AdminMiddleWare implements MiddleWareInterface
{
    public function handle(Request $request, Closure $next)
    {
        if(defined('PANEL') === false){
            define('PANEL', ADMIN_PANEL_NAME);
        }
        if ($request->isLoggedIn('admin')) {

            $activityController = new PwdAdminActivityLogController();
            $activityController->insertData($request, $request->loggedID('admin') ,$_SERVER['REQUEST_URI']);
            return $next($request);
        }
        redirect('admin/login');
    }



    /*public function url(){
        $route = explode('/', str_replace('/pwd/Public/admin/','',$_SERVER['REQUEST_URI']));
        //pr($route);
        if(!empty($route[0]) && !empty($route[1])){
            $alias =Inflect::pluralize($route[1]);
            if(isset($route[2])){
                $action = $route[2];
            }else{
                $action = '';
            }
        }
        else{
            $alias = 1;
            $action = '';
        }
        return [
            'alias' => $alias,
            'action' => $action
        ];
    }*/

}
