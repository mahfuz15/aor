<?php

namespace Controllers;

use Framework\Http\Request\Request;
use Framework\Controller\Controller;

class RolePermissionController extends Controller
{

    public function __construct()
    {
      $this->model = $this->loadModel('RolePermission');
    }

    public function getRolePermission($roleID){
        return $this->model->where('role_id',$roleID)->orderBy('module_id','ASC')->getAll();
    }

    public function updateRolePermission(Request $request,$roleID){
        $postData = (object) $request->getPostData();
        foreach( $postData->module_id as $key=>$module){
            $modulePermission = $this->model->where('module_id', $module)->andWhere('role_id',$roleID)->get();
            if($modulePermission){
                $this->model->permission= $postData->view[$key];

                $this->model->updated_by = $request->loggedID('admin');
                $this->model->updated_at = date('Y-m-d H:i:s');
                $this->model->where('id', $modulePermission->id)->update();
            }else{
                $this->model->role_id = $roleID;
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
    public function getPermissionByRoleID(Request $request){
        $uid = $request->getPostData('uid');
        $roleID = $request->getPostData('id');

        $moduleController = new ModuleController();
        $moduleList = $moduleController->getModuleList();
        $permissionController = new PermissionController();
        $userPermission = $permissionController->getPermissionListByUserID($uid);
        $permission = $this->model->where('role_id',$roleID)->getAll();
        return $this->loadView('permission','blank')->with(compact('permission','moduleList','userPermission'));
    }
}