<?php

namespace Controllers;

use Framework\Tools\Pagination;
use Framework\Http\Request\Request;
use Framework\Validation\Validator;
use Framework\Controller\Controller;
use Framework\Http\Notification\Notification;
use Vendor\Inflect;

class ModuleController extends Controller
{

    public function __construct()
    {
        $this->model = $this->loadModel('Module');
    }

    public function getModuleByRoute($alias){
        $alias = explode("?",$alias);
        if(empty($alias[0])){
            return false;
        }else{
            $module = $this->model->where('alias',$alias[0])->get();
            return $module;
        }
    }
    public function getModuleList()
    {
        return $this->model->where('status',1)->orderBy('id','ASC')->getAll();
    }

    public function findModule($userID, $url)
    {
        $value = Inflect::pluralize(end($url));
        $module = $this->model->where('route', 'LIKE', $value)->get();
        $permissionController = new PermissionController();
        return $permissionController->modulePermission($module->id);

    }

    public function showSingle(Request $request)
    {
        $module_id = $request->getParams('id');
        $module = $this->model->where('id', $module_id)->orderBy('id', 'ASC')->limit(1)->get();

        return $this->loadView('show', 'admin')->with(compact('module'));
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
                    $this->model->orWhere('route', 'LIKE', $query);
                    $this->model->orWhere('alias', 'LIKE', $query, null, ')');
                } else {

                    if ($this->model->isColumn($key)) {
                        $this->model->whereCond($key, $param);
                    }
                }
            }
        }

        $pagination->setPaginationCssClass('pagination-sm no-margin pull-right');
        $pagination->showCounts(true);
        $modules = $this->model->whereIn('status',['0',1])->paginate($pagination)->orderBy($order, $sort)->limit($offset, $limit)->getAll();

        return $this->loadView('list', 'admin')->with(compact('modules', 'pagination'));
    }

    public function create(Request $request)
    {

        if (!empty($request->getParams('id'))) {
            $edit = true;
            $module = $this->model->findByID($request->getParams('id'));

        } else {
            $edit = false;
            $module = null;
        }

        if ($request->isPost()) {
            $postData = (object)$request->getPostData();

            $notifier = new Notification();
            $validator = new Validator($request->getPostData(), $notifier);

            if ($validator->validate()) {

                $this->model->title = $postData->title;
                $this->model->route = $postData->route;
                $this->model->icon = $postData->icon;
                $this->model->alias = $postData->alias;

                $this->model->status = $postData->status;

                if (empty($edit)) {
                    $this->model->created_at = date('Y-m-d H:i:s');
                    $this->model->created_by = $request->loggedID('admin');
                    $this->model->updated_by = 0;
                    $this->model->updated_at = NULL;
                    $moduleID = $this->model->insert();
                } else {
                    $this->model->updated_by = $request->loggedID('admin');
                    $this->model->updated_at = date('Y-m-d H:i:s');
                    $this->model->where('id', $module->id)->update();
                    $moduleID = $module->id;
                }

                $notifier->successNote('A Module Has been updated successfully');
                redirect(PANEL . '/module/edit/' . $moduleID);
            } else {
                $module = $postData;
                return $this->loadView('form', 'admin')->with(compact('module', 'edit'));
            }
        }

        return $this->loadView('form', 'admin')->with(compact('module', 'edit'));
    }

    public function edit(Request $request)
    {
        return $this->create($request);
    }

    public function delete(Request $request)
    {
        if (($module = $this->model->findByID($request->getParams('id'))) === false) {
            redirect('');
        }

        if ($request->isPost()) {
            $notifier = new Notification();

            if ($request->getPostData('confirm') === 'delete') {
                $this->model->status = -1;
                $this->model->where('id', $module->id)->update();

                $notifier->successNote('A Module has been deleted !');
            }
            redirect(PANEL . '/modules');
        }

        return $this->loadView('delete', 'admin')->with(compact('module'));
    }
}
