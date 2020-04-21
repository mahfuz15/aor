<?php

namespace Controllers;

use Framework\Tools\Pagination;
use Framework\Http\Request\Request;
use Framework\Validation\Validator;
use Framework\Controller\Controller;
use Framework\Http\Notification\Notification;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->model = $this->loadModel('Permission');
    }

    public function getPermissionByUserIDAndModule($adminID,$url){

        $moduleController = new ModuleController();
        $module = $moduleController->getModuleByRoute($url);

        if(!empty($module)){
            $permission = $this->model->where('user_id',$adminID)->andWhere('module_id',$module->id)->get();
            return $permission;
        }
            return false;
    }
    public function getPermissionListByUserID($userID){
        $this->model->join('modules','modules.id','permissions.module_id');
        return $this->model->where('user_id',$userID)->andWhere('permission','>=',1)->orderBy('module_id','ASC')->getAll(['permissions.*','modules.*']);
         //->andWhere('permission',1)
    }
    public function getModuleListByUserID($userID){
        $this->model->join('modules','modules.id','permissions.module_id');
        return $this->model->where('user_id',$userID)->orderBy('module_id','ASC')->getAll(['permissions.*','modules.*']);
    }
    public function getModuleListByUserIDForMenu($userID){
        $this->model->join('modules','modules.id','permissions.module_id');
        return $this->model->where('user_id',$userID)->andWhere('permission','>',0)->orderBy('module_id','ASC')->getAll(['permissions.*','modules.*','modules.status as module_status']);
    }

    public function modulePermission($moduleID){
        return $this->model->where('module_id',$moduleID)->get();
    }

    public function updateModulePermission(Request $request,$userID){
        $postData = (object) $request->getPostData();
        foreach( $postData->module_id as $key=>$module){
            $modulePermission = $this->model->where('module_id', $module)->andWhere('user_id',$userID)->get();
            if($modulePermission){
                $this->model->permission= $postData->view[$key];
                $this->model->updated_by = $request->loggedID('admin');
                $this->model->updated_at = date('Y-m-d H:i:s');
                $this->model->where('id', $modulePermission->id)->update();
            }else{
                $this->model->user_id = $userID;
                $this->model->module_id = $module;
                $this->model->permission= $postData->view[$key];
                $this->model->created_at = date('Y-m-d H:i:s');
                $this->model->created_by = $request->loggedID('admin');
                $this->model->updated_by = 0;
                $this->model->updated_at = NULL;
                $this->model->insert();
            }
        }
    }
}
