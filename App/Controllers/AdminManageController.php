<?php

namespace Controllers;

use Framework\FileSystem\FileManager;
use Framework\Http\Uploader\Uploader;
use Framework\Http\Uploader\File;
use Framework\Tools\Pagination;
use Framework\Validation\Validator;
use Framework\Http\Request\Request;
use Framework\Http\Notification\Notification;

class AdminManageController extends AdminController
{

    public function __construct()
    {
        $this->model = $this->loadModel("Admin");
        $roleController = new RoleController();
        $this->roleArray = $roleController->getRoleList();
    }

    public function showList(Request $request)
    {
        $loggedAdmin = $this->model->findByID($request->loggedID("admin"));
        /*if ($loggedAdmin === false || $loggedAdmin->role < 10) {
            $this->redirect('admin');
        }*/
        $pagination = new Pagination;
        $offset = $pagination->getOffSet();
        $limit = $pagination->getSize();
        $order = $this->getOrder($this->model, 'id');
        $sort = $this->getSort('DESC');

        $this->model->join('roles','roles.id','admins.role_id','=','LEFT');

        if (!empty($_GET)) {
            foreach ($request->getUrlData() as $key => $param) {
                if ($key == 'q' && !empty($param)) {
                    $query = "%$param%";
                    $this->model->whereCond('admins.username', 'LIKE', $query, '(');
                    $this->model->orWhere('admins.name', 'LIKE', $query);
                    $this->model->orWhere('admins.email', 'LIKE', $query, null, ')');
                } else {
                    if ($param == '' || $param == 'all') {
                        continue;
                    }
                    if ($this->model->isColumn($key)) {
                        $this->model->whereCond('admins.' . $key, $param);
                    }
                }
            }
        }

        $pagination->setPaginationCssClass('pagination-sm no-margin pull-right');
        $pagination->showCounts(true);
        $admins = $this->model->whereIn('admins.status',['0',1])->paginate($pagination)->orderBy('admins.' . $order, $sort)
            ->limit($offset, $limit)->getAll(['admins.*','roles.title as role_title']);

        $roleArray = $this->roleArray;
//        pr($roleArray);die();

        return $this->loadView('admins', 'admin')->with(compact('admins', 'pagination', 'roleArray'));
    }

    public function create(Request $request)
    {
        return $this->edit($request);
    }

    public function edit(Request $request)
    {
        $userController = new AdminController();
        $userList = $userController->getUserList();
        $moduleController = new ModuleController();
        $moduleList = $moduleController->getModuleList();
        $permissionController = new PermissionController();

        $loggedAdmin = $this->model->findByID($request->loggedID("admin"));
        $uid = $request->getParams('id');
        $permission = $permissionController->getPermissionListByUserID($uid);
        $roleArray = $this->roleArray;

        if (!empty($uid)) {
            $this->model->join('roles','roles.id','admins.role_id','=','LEFT');
            $admin = $this->model
                    ->where('admins.id', $uid)
                    ->orderBy('admins.id')->limit(1)
                    ->get(['admins.*','roles.title as role_title']);

            if ($admin === false) {
                $this->redirect();
            }
            $edit = true;
            $adminID = $admin->id;
        } else {
            $admin = null;
            $edit = false;
            $adminID = false;
            //$attachmentID = false;
        }

        if ($request->requestType() == 'post') {
            $formData = (object) $request->getPostData();

            $notifier = new Notification();
            $validator = new Validator($request->getPostData(), $notifier);
            $validator->select('username')->unique($this->model, 'username', $admin)->min(4);
            $validator->select('name')->required();
            $validator->select('email')->required()->email()->unique($this->model, 'email', $admin);
            if (empty($edit)) {
                $validator->select('password')->required()->min(8);
                $validator->select('role_id')->required();
            }else{
                if (!empty($formData->password)) {
                    $validator->select('password')->required()->min(8);
                }
            }

            //$validator->select('password')->optional()->matchWith($validator->select('confirm_password'));

            $uploader = new Uploader();
            $file = $uploader->file('avatar');
            $validator->file($file)->optional()->image();

            if ($validator->validate()) {
                if (!empty($formData->password)) {
                    $this->model->password = password_hash($formData->password, PASSWORD_DEFAULT);
                }
                $this->model->name = $formData->name;
                $this->model->username = ucfirst($formData->username);
                $this->model->email = $formData->email;
                if (!empty($formData->role_id)) {
                    $this->model->role_id = $formData->role_id;
                }
                $this->model->status = $formData->status;
                if (empty($edit)) {
                    $this->model->created_at = DATETIME;
                    $this->model->created_by = $request->loggedID('admin');
                    $this->model->updated_by = 0;
                    $this->model->updated_at = NULL;
                    $saved = $this->model->insert();
                    $adminID = $saved;
                    $admin = (object) array('id' => $adminID, 'avatar' => '');
                } else {
                    $this->model->updated_by = $request->loggedID('admin');
                    $this->model->updated_at = date('Y-m-d H:i:s');
                    $saved = $this->model->where('id', $admin->id)->update();
                }

                $permissionController->updateModulePermission($request,$admin->id);
                if ($saved !== false) {

                    $this->uploadAvatar($file, $admin);

                    if (empty($edit)) {
                        $notifier->successNote('A new User has been added Successfully !');
                    } else {
                        $notifier->successNote('A User has been updated Successfully !');
                    }
                } else {
                    $notifier->successNote('Something went wrong, Couldn\'t create user. Please try again!');
                }

                redirect('admins');
            } else {
//                $this->redirect();
                $admin = $formData;
                return $this->loadView('form', 'admin')->with(compact('admin', 'edit', 'roleArray','userList','moduleList','permission'));
            }
        } else {
            return $this->loadView('form', 'admin')->with(compact('admin', 'edit', 'roleArray','userList','moduleList','permission'));
        }
    }

    public function delete(Request $request)
    {
        $loggedAdmin = $this->loggedAdminDetails($request);

        if (($admin = $this->model->where('admins.id', $request->getParams("id"))->orderBy('admins.id')->limit(1)->get(['admins.*'])) === false) {
            redirect();
        }

        if ($request->isPost()) {
            if ($request->getPostData('confirm') === 'delete') {
                $this->model->status = -1;
                $this->model->where('id', $admin->id)->update();

                $notifier = new Notification();

                $notifier->successNote('A User has been deleted !');
                redirect("admins");
            }
        } else {
            return $this->loadView('delete', 'admin')->with(compact('admin'));
        }
    }

    public function disableAdmin(Request $request)
    {
        $loggedAdmin = $this->loggedAdminDetails($request);

        if (($admin = $this->model->where('admins.id', $request->getParams("id"))->orderBy('admins.id')->limit(1)->get(['admins.*'])) === false) {
            $this->redirect();
        }

        if ($request->requestType() == 'post') {
            if ($request->getPostData("confirm") == 'delete') {
                $this->model->status = -1;
                $this->model->where("id", $admin->id)->update();

                $notifier = new Notification();

                $notifier->successNote("A Admin has been desabled !");
                $this->redirect("admin/list");
            }
        } else {
            $this->loadView("deleteAdmin", 'admin')->with(compact("admin"));
        }
    }

    public function logoutOtherUsers(Request $request)
    {
        $uid = $request->getParams("id");
        $user = $this->model->where("id", $uid)->limit(1)->get(['session_id']);

        $admin_session = session_id();
        session_commit();

        session_start();
        session_id($user->session_id);
        session_destroy();
        session_commit();
        $this->model->session_id = '';
        $this->model->where("id", $uid)->update();

        session_start();
        session_id($admin_session);

        $this->redirect();
    }

}
