<?php

namespace Controllers;

use Framework\FileSystem\FileManager;
use Framework\Http\Uploader\Uploader;
use Framework\Http\Uploader\File;
use Framework\Tools\Pagination;
use Framework\Http\Request\Request;
use Framework\Validation\Validator;
use Framework\Controller\Controller;
use Framework\Http\Notification\Notification;
use Framework\Database\Stacky\Model;

class CandidateController extends Controller
{

    public function __construct(Request $request)
    {
        $this->model = $this->loadModel('Candidate');
        if ($request->isLoggedIn('agent')) {
            $this->template = 'site';
        } else {
            $this->template = 'admin';
        }
    }

    public function showSingle(Request $request)
    {
        $candidate_id = $request->getParams('id');

        $candidate = $this->model->where('id', $candidate_id)->orderBy('id', 'ASC')->limit(1)->get();
        
        return $this->loadView('show', $this->template)->with(compact('candidate'));
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
        $candidates = $this->model->paginate($pagination)
            ->join('candidate_skills','candidate_skills.candidate_id','candidates.id','=','LEFT')
            ->join('skills','candidate_skills.skill_id','skills.id','=','LEFT')
            ->groupBy('candidates.id')
            ->orderBy($order, $sort)->limit($offset, $limit)
            ->getAll(['candidates.*', 'GROUP_CONCAT(DISTINCT skills.name) as skills']);
        return $this->loadView('list', $this->template)->with(compact('candidates', 'pagination'));
    }

    public function create(Request $request)
    {
        if(!empty($request->getParams('id'))){
            $edit = true;
            $candidate = $this->model
            ->join('candidate_skills','candidate_skills.candidate_id','candidates.id','=','LEFT')
            ->join('skills','candidate_skills.skill_id','skills.id','=','LEFT')
            ->where('candidates.id', $request->getParams('id'))
            ->get(['candidates.*', 'GROUP_CONCAT(DISTINCT skills.name) as skills']);
            
        }else{
            $edit = false;
            $candidate = null;
        }

        if($request->isPost()){
            $postData = (object) $request->getPostData();
            //pr($request->getFileData());
            $notifier = new Notification();
            $validator = new Validator($request->getPostData(), $notifier);
            $uploader = new Uploader();
            //pr($request->getPostData());
            //pr($file);
            $validator->select('title')->required();
            $validator->select('skills')->required();
            $validator->select('description')->required();
            $validator->select('location')->required();
            $validator->select('state')->required();
            $validator->select('city')->required();
            $validator->select('candidate_email')->required()->email()->unique($this->model, 'candidate_email', $candidate);

            $file = $uploader->file('resume');

            if($file->size > 0 && $file->temp_path != "") {
                $validator->file($file)->required();
            }
            if($validator->validate()){
                        $this->model->title = $postData->title;
                        //$this->model->skills = $postData->skills;
                        $this->model->description = $postData->description;
                        $this->model->resume_link = $postData->resume_link;
                        $this->model->location = $postData->location;
                        $this->model->state = $postData->state;
                        $this->model->city = $postData->city;
                        $this->model->candidate_name = $postData->candidate_name;
                        $this->model->candidate_email = $postData->candidate_email;
                        $this->model->candidate_phone = $postData->candidate_phone;
                        $this->model->job_status = $postData->job_status;
                        $this->model->status = $postData->status;
                        $this->model->updated_at = DATETIME;
                        //pr($file);
                        //exit;
                if(empty($edit)){
                    $this->model->joined_by = $request->loggedID("agent");
                    $this->model->joined_at = DATETIME;
                    $candidateID = $this->model->insert();
                    $candidate = (object) array('id' => $candidateID, 'resume_link' => $postData->resume_link);
                }else{
                    $this->model->where('id', $candidate->id)->update();
                    $candidateID = $candidate->id;
                }
                
                if($candidateID !== false){
                    
                    $candidateSkillInfo = new \stdClass;
                    $candidateSkillInfo->candidate_id = $candidateID;
                    
                    // Save Skill
                    
                    if(!empty($postData->skills)){
                        $candidateSkillInfo->skills = array();
                        $postSkills = explode(",", $postData->skills);
                        
                        $skillController = new SkillController();
                        $candidateSkillController = new CandidateSkillController();

                        foreach($postSkills as $skillName){
                            $skillDetails = $skillController->returnByName($skillName);
                            if($skillDetails === false){
                                $skill_id = $skillController->saveSkill($skillName);
                            } else {
                                $skill_id = $skillDetails->id;
                            }
                            array_push($candidateSkillInfo->skills, $skill_id);
                        }
                        
                        // Save candidate skills

                        $candidateSkillController->saveCandidateSkill($candidateSkillInfo);
                        
                        //exit;
                    }

                    // Upload Resume
                    if($file->size > 0 && $file->temp_path != "") {
                        $this->uploadResume($file, $candidate);
                    }
                    if (empty($edit)) {
                        $notifier->successNote('A new Candidate has been added Successfully !');
                    } else {
                        $notifier->successNote('A Candidate has been updated Successfully !');
                    }
                } else {
                    $notifier->successNote('Something went wrong, Couldn\'t create candidate. Please try again!');
                    redirect(PANEL . '/candidate/add/');
                }
                redirect(PANEL . '/candidate/edit/' . $candidateID);
            }else{
                $candidate = $postData;
                return $this->loadView('form', $this->template)->with(compact('candidate', 'edit'));
            }
        }
        
        return $this->loadView('form', $this->template)->with(compact('candidate', 'edit'));
    }

    public function edit(Request $request)
    {
        return $this->create($request);
    }

    public function delete(Request $request)
    {
        if (($candidate = $this->model->findByID($request->getParams('id'))) === false) {
            redirect('');
        }

        if($request->isPost()){
            $notifier = new Notification();
            
            if ($request->getPostData('confirm') === 'delete') {
                $this->model->where('id', $candidate->id)->delete();

                $notifier->successNote('A Candidate has been deleted !');
            }
            redirect(PANEL . '/candidates');
        }
        
        return $this->loadView('delete', $this->template)->with(compact('candidate'));
    }

    protected function uploadResume(File $file, $candidate)
    {
        if ($file->isValid() === false) {
            return false;
        }
        
        // Purge previous resume
        if (!empty($candidate->resume_link)) {
            FileManager::unlink(ROOT . DS . PUBLIC_DIR . DS . $candidate->resume_link);
        }
        // Sub directory
        $upperBound = ceil($candidate->id / 1000.0) * 1000;
        $lowerBound = $upperBound - 999;
        $dir = FileManager::checkDIR(ROOT . DS . PUBLIC_DIR . DS . 'files' . DS . 'resumes'. DS . $lowerBound . '-' . $upperBound);
        
        $file->rename($candidate->id . '_' . $file->name);
        $resumePath = $file->save($dir);

        if (file_exists($resumePath)) {
            $this->model->resume_link = str_replace(ROOT . DS . PUBLIC_DIR . DS, '', $resumePath);
            $this->model->where('id', $candidate->id)->update();
        }

        return false;
    }

    #----------- API --------------------#
    public function candidateRegisterAPI(Request $request){
        $name = $request->getPostData('name');
        $phone = $request->getPostData('phone');
        $email = $request->getPostData('email');
    }
}
