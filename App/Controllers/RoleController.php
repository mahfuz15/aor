<?php

namespace Controllers;

use Framework\Tools\Pagination;
use Framework\Http\Request\Request;
use Framework\Validation\Validator;
use Framework\Controller\Controller;
use Framework\Http\Notification\Notification;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->model = $this->loadModel('Role');
    }
    public function getRoleList(){
        return $this->model->where('status',1)->getAll();
    }
     public function getRoleByID($roleID){
            return $this->model->where('id',$roleID)->get();
        }


    public function showSingle(Request $request)
    {
        $role_id = $request->getParams('id');

        $role = $this->model->where('id', $role_id)->orderBy('id', 'ASC')->limit(1)->get();

        return $this->loadView('show', 'admin')->with(compact('role'));
    }

    public function showList(Request $request)
    {
        $pagination = new Pagination('get', $this->getPerPage());
        $offset = $pagination->getOffSet();
        $limit = $pagination->getSize();
        $order = $this->getOrder($this->model, 'id');
        $sort = $this->getSort('DESC');


        if (!empty($_GET)) {
            foreach ($request->getUrlData() as $key => $param) {
                if ($param === '' || $param === 'all') {
                    continue;
                }
                    
                if ($key == 'q' && !empty($param)) {
                    $query = "%$param%";
                    $this->model->whereCond('title', 'LIKE', $query, '(');
                    //$this->model->orWhere('details', 'LIKE', $query);
                    $this->model->orWhere('description', 'LIKE', $query, null, ')');
                } else {
                    
                    if ($this->model->isColumn($key)) {
                        $this->model->whereCond($key, $param);
                    }
                }
            }
        }

        $pagination->setPaginationCssClass('pagination-sm no-margin pull-right');
        $pagination->showCounts(true);
        $roles = $this->model->whereIn('status',['0',1])->paginate($pagination)->orderBy($order, $sort)->limit($offset, $limit)->getAll();

        return $this->loadView('list', 'admin')->with(compact('roles', 'pagination'));
    }

    public function create(Request $request)
    {
        $moduleController = new ModuleController();
        $moduleList = $moduleController->getModuleList();
        

        $rolePermissionController = new RolePermissionController();

        if(!empty($request->getParams('id'))){
            $edit = true;
            $role = $this->model->findByID($request->getParams('id'));
            $rolePermissions = $rolePermissionController->getRolePermission($request->getParams('id'));
        }else{
            $edit = false;
            $role = null;
            $rolePermissions ='';
        }

        // pr($edit);
        // pr($role);
        // pr($rolePermissions);
        // exit;

        if($request->isPost()){
            $postData = (object) $request->getPostData();

            $notifier = new Notification();
            $validator = new Validator($request->getPostData(), $notifier);

            if($validator->validate()){
                
                        $this->model->title = $postData->title;
                        $this->model->description = $postData->description;
                        $this->model->status = $postData->status;

                if(empty($edit)){
                    $this->model->created_at = date('Y-m-d H:i:s');
                    $this->model->created_by = $request->loggedID('admin');
                    $this->model->updated_by = 0;
                    $this->model->updated_at = NULL;
                    $roleID = $this->model->insert();
                }else{
                    $this->model->updated_by = $request->loggedID('admin');
                    $this->model->updated_at = date('Y-m-d H:i:s');
                    $this->model->where('id', $role->id)->update();
                    $roleID = $role->id;
                }
                $rolePermissionController->updateRolePermission($request,$roleID);
                $notifier->successNote('A Role Has been updated successfully');
                redirect(PANEL . '/'.strtolower(SITE).'/role/edit/' . $roleID);
            }else{
                $role = $postData;
                return $this->loadView('form', 'admin')->with(compact('role', 'edit','rolePermissions','moduleList'));
            }
        }
        
        return $this->loadView('form', 'admin')->with(compact('role', 'edit','rolePermissions','moduleList'));
    }

    public function edit(Request $request)
    {
        return $this->create($request);
    }

    public function delete(Request $request)
    {
        if (($role = $this->model->findByID($request->getParams('id'))) === false) {
            redirect('');
        }

        if($request->isPost()){
            $notifier = new Notification();
            
            if ($request->getPostData('confirm') === 'delete') {
                $this->model->status = -1;
                $this->model->where('id', $role->id)->update();

                $notifier->successNote('A Role has been deleted !');
            }
            redirect(PANEL . '/'.strtolower(SITE).'/roles');
        }
        
        return $this->loadView('delete', 'admin')->with(compact('role'));
    }
}
