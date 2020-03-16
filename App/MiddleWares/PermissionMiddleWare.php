<?php

namespace MiddleWares;

use Closure;
use Controllers\PermissionController;
use Framework\Http\Notification\Notification;
use Framework\Http\Request\Request;
use Framework\Http\MiddleWare\MiddleWareInterface;
use Framework\Validation\Validator;
use Vendor\Inflect;

class PermissionMiddleWare implements MiddleWareInterface
{

    public function handle(Request $request, Closure $next)
    {
        if (defined('PANEL') === false) {
            define('PANEL', ADMIN_PANEL_NAME);
        }

        if ($request->isLoggedIn('admin')) {
            $adminID = $request->loggedID('admin');
            $permissionController = new PermissionController();
            $data = $this->url();
            
            if ($data['alias'] == 1) {
                return $next($request);
            } else {
                $modulePermission = $permissionController->getPermissionByUserIDAndModule($adminID,$data['alias']);
                //pr($modulePermission);die();
                if($modulePermission){
                    if (strcmp($data['action'], 'add') == 0) {
                        if($modulePermission->permission > 1){
                            $_SESSION["permission"] = $modulePermission->permission;
                            return $next($request);
                        }
                    }
                    elseif (strcmp($data['action'], 'edit') == 0) {
                            if($modulePermission->permission >2){
                                $_SESSION["permission"] = $modulePermission->permission;
                                return $next($request);
                            }
                    }
                    elseif(strcmp($data['action'], 'delete') == 0) {
                            if($modulePermission->permission > 3){
                                $_SESSION["permission"] = $modulePermission->permission;
                                return $next($request);
                            }
                    }elseif (($data['action'] == '')) {
                        if($modulePermission->permission > 0){
                            $_SESSION["permission"] = $modulePermission->permission;
                            return $next($request);
                        }
                    }elseif (!empty($data['action']) && $modulePermission->permission > 2){
                        $_SESSION["permission"] = $modulePermission->permission;
                        return $next($request);
                    }
                }
            }
        }
        redirect();
    }

    public function url()
    {
        $route = explode('/', str_replace('/aor/Public/admin/', '', $_SERVER['REQUEST_URI']));
        
        if(!empty($route[0]) && !empty($route[1])) {
            $alias = Inflect::pluralize($route[1]);
            if (isset($route[2])) {
                $action = $route[2];
            } else {
                $action = '';
            }
            
        } else {
            $alias = 1;
            $action = '';
        }
        /*pr($alias);
        pr($action);
        exit;*/
        return [
            'alias' => $alias,
            'action' => $action
        ];
    }

}
