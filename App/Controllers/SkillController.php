<?php

namespace Controllers;

use Framework\Tools\Pagination;
use Framework\Http\Request\Request;
use Framework\Http\Response\Response;
use Framework\Validation\Validator;
use Framework\Controller\Controller;
use Framework\Http\Notification\Notification;

class SkillController extends Controller
{

    public function __construct()
    {
        $this->model = $this->loadModel('Skill');
    }

    public function showSingle(Request $request)
    {
        $skill_id = $request->getParams('id');

        $skill = $this->model->where('id', $skill_id)->orderBy('id', 'ASC')->limit(1)->get();

        return $this->loadView('show', 'admin')->with(compact('skill'));
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
                    //$this->model->whereCond('title', 'LIKE', $query, '(');
                    //$this->model->orWhere('details', 'LIKE', $query);
                    //$this->model->orWhere('status', 'LIKE', $query, null, ')');
                } else {
                    
                    if ($this->model->isColumn($key)) {
                        $this->model->whereCond($key, $param);
                    }
                }
            }
        }

        $pagination->setPaginationCssClass('pagination-sm no-margin pull-right');
        $pagination->showCounts(true);
        $skills = $this->model->paginate($pagination)->orderBy($order, $sort)->limit($offset, $limit)->getAll();


        return $this->loadView('list', 'admin')->with(compact('skills', 'pagination'));
    }

    public function create(Request $request)
    {

        if(!empty($request->getParams('id'))){
            $edit = true;
            $skill = $this->model->findByID($request->getParams('id'));

        }else{
            $edit = false;
            $skill = null;
        }

        if($request->isPost()){
            $postData = (object) $request->getPostData();

            $notifier = new Notification();
            $validator = new Validator($request->getPostData(), $notifier);
            $validator->select('name')->required();
            if($validator->validate()){
                
                        $this->model->name = $postData->name;
                        $this->model->status = $postData->status;
                        $this->model->updated_at = DATETIME;

                if(empty($edit)){
                    $this->model->created_at = DATETIME;
                    $skillID = $this->model->insert();
                }else{
                    $this->model->where('id', $skill->id)->update();
                    $skillID = $skill->id;
                }

                $notifier->successNote('A Skill Has been updated successfully');
                redirect(PANEL . '/skill/edit/' . $skillID);
            }else{
                $skill = $postData;
                return $this->loadView('form', 'admin')->with(compact('skill', 'edit'));
            }
        }
        
        return $this->loadView('form', 'admin')->with(compact('skill', 'edit'));
    }

    public function edit(Request $request)
    {
        return $this->create($request);
    }

    public function delete(Request $request)
    {
        if (($skill = $this->model->findByID($request->getParams('id'))) === false) {
            redirect('');
        }

        if($request->isPost()){
            $notifier = new Notification();
            
            if ($request->getPostData('confirm') === 'delete') {
                $this->model->where('id', $skill->id)->delete();

                $notifier->successNote('A Skill has been deleted !');
            }
            redirect(PANEL . '/skills');
        }
        
        return $this->loadView('delete', 'admin')->with(compact('skill'));
    }

    public function returnByName($name){
        return $this->model->where('name', $name)->andWhere('status', 1)->get();
    }

    public function saveSkill($name){
        if(empty($name)){
            return false;
        }
        $this->model->name = $name;
        $this->model->status = 1;
        $this->model->created_at = DATETIME;
        $this->model->updated_at = DATETIME;
        return $skillID = $this->model->insert();
    }

    #--- API ----#
    public function skillByKeyword(Request $request) {
        $keyword = $request->getParams('keyword');
        $src = $this->model->where('name', 'LIKE', "%".$keyword."%")->getAll(['name']);
        //pr($src);
        Response::json($src);
    }
}
