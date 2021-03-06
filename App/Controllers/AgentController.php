<?php

namespace Controllers;

use Framework\Tools\Pagination;
use Framework\Http\Request\Request;
use Framework\Http\Response\Response;
use Framework\Validation\Validator;
use Framework\Controller\Controller;
use Framework\Http\Notification\Notification;

class AgentController extends Controller
{
    use TokenTrait,
        MailTrait;

    public function __construct()
    {
        $this->model = $this->loadModel('Agent');
        $roleController = new RoleController();
        $this->roleArray = $roleController->getRoleList();
    }

    public function index(){
        redirect('');
    }

    public function showSingle(Request $request)
    {
        $agent_id = $request->getParams('id');

        $agent = $this->model->where('id', $agent_id)->orderBy('id', 'ASC')->limit(1)->get();

        return $this->loadView('show', 'admin')->with(compact('agent'));
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
        $agents = $this->model->paginate($pagination)->orderBy($order, $sort)->limit($offset, $limit)->getAll();


        return $this->loadView('list', 'admin')->with(compact('agents', 'pagination'));
    }

    public function create(Request $request)
    {
        $moduleController = new ModuleController();
        $moduleList = $moduleController->getModuleList();
        $permissionController = new PermissionController();

        $uid = $request->getParams('id');
        $permission = $permissionController->getPermissionListByUserID($uid);
        $roleArray = $this->roleArray;

        // if (!empty($uid)) {
        //     $this->model->join('roles','roles.id','admins.role_id','=','LEFT');
        //     $admin = $this->model
        //             ->where('admins.id', $uid)
        //             ->orderBy('admins.id')->limit(1)
        //             ->get(['admins.*','roles.title as role_title']);

        //     if ($admin === false) {
        //         $this->redirect();
        //     }
        //     $edit = true;
        //     $adminID = $admin->id;
        // } else {
        //     $admin = null;
        //     $edit = false;
        //     $adminID = false;
        // }

        // exit;
        if(!empty($request->getParams('id'))){
            $edit = true;
            $agent = $this->model->findByID($request->getParams('id'));

        }else{
            $edit = false;
            $agent = null;
        }

        if($request->isPost()){
            $postData = (object) $request->getPostData();
            $notifier = new Notification();
            $validator = new Validator($request->getPostData(), $notifier);
            $validator->select('email')->required()->email()->unique($this->model, 'email');
            
            if($validator->validate()){
                        
                $this->model->username = isset($postData->last_log)?$postData->last_log:NULL;
                $this->model->email = $postData->email;
                $this->model->role_id = 7;
                $this->model->status = $postData->status;
                $this->model->password = isset($postData->last_log)?$postData->last_log:NULL;
                //$this->model->last_log = $postData->last_log;
                //$this->model->session_id = $postData->session_id;
                $this->model->last_log = NULL;
                $this->model->session_id = NULL;
                if(empty($edit)){
                    $this->model->created_at = DATETIME; 
                    $this->model->created_by = $request->loggedID('admin');
                    $this->model->updated_at = DATETIME;
                    $agentID = $this->model->insert();
                    $token = $this->registerToken($postData->email, 1);
                    $this->adminAgentCreationMail($postData->email, $token);
                }else{
                    $this->model->updated_at = date('Y-m-d H:i:s');
                    $this->model->where('id', $agent->id)->update();
                    $agentID = $agent->id;
                }
                $notifier->successNote('A Agent Has been updated successfully');
                redirect(PANEL . '/agent/edit/' . $agentID);
            }else{
                $agent = $postData;
                return $this->loadView('form', 'admin')->with(compact('agent', 'edit'));
            }
        }
        
        return $this->loadView('form', 'admin')->with(compact('agent', 'edit'));
    }

    public function edit(Request $request)
    {
        return $this->create($request);
    }

    public function delete(Request $request)
    {
        if (($agent = $this->model->findByID($request->getParams('id'))) === false) {
            redirect('');
        }

        if($request->isPost()){
            $notifier = new Notification();
            
            if ($request->getPostData('confirm') === 'delete') {
                $this->model->where('id', $agent->id)->delete();

                $notifier->successNote('A Agent has been deleted !');
            }
            redirect(PANEL . '/agents');
        }
        
        return $this->loadView('delete', 'admin')->with(compact('agent'));
    }

    public function login(Request $request)
    {
        if ($request->isLoggedIn('agent')) {
            redirect('');
        }

        if ($request->isPost()) {

            $email = $request->getPostData('email');
            $password = $request->getPostData('password');
            
            $notifier = new Notification();
            $validator = new Validator($request->getPostData(), $notifier);
            $validator->select('email')->required()->email();
            $validator->select('password')->required()->min(8);

            if ($validator->validate()) {
                if (($agent = $this->model->findByEmail($email)) !== false) {
                    if (password_verify($password, $agent->password) !== false) {
                        $this->model->last_log = DATETIME;
                        $this->model->session_id = session_id();
                        $this->model->where('id', $agent->id)->update();

                        $request->setLoggedIn($agent->id, $agent->email, 'agent');
                        //pr($request->isLoggedIn('agent'));
                        //exit;
                        redirect();
                    }
                }
                $notifier->warningNote('Email/Password is invalid !');
            }
            redirect('agent/login');
        } else {

            return $this->loadView('login', 'site');
        }
    }

    public function logout(Request $request)
    {
        $uid = $request->loggedID('agent');
        $this->model->last_log = DATETIME;
        $this->model->session_id = '';
        $this->model->where('id', $uid)->update();
        $request->setLoggedOut('agent');
        redirect('');
    }

    public function forgotPassword(Request $request) {
        if ($request->isLoggedIn('agent')) {
            redirect('');
        }
        $notifier = new Notification();

        if ($request->isPost()) {
            $email = $request->getPostData('email');

            $validator = new Validator($request->getPostData(), $notifier);
            $validator->select('email')->required()->email();

            if (($validator->validate() === true) && ($agent = $this->model->findByEmail($email)) !== false) {
                $token = $this->registerToken($agent->email);
                //Mail to user
                $this->forgotPassMail($agent->email, $agent->username, $token);

                $notifier->successNote('Recovery mail has been sent to your MailBox.');
            } else {
                $notifier->warningNote('Email is invalid !');
            }

            redirect();
        }
        return $this->loadView('forgot', 'site')->with();
    }

    /*public function resetPassword(Request $request) {
        $notifier = new Notification();
        $email = $request->getParams('email');
        $token = base64_url_decode($request->getParams('token'));

        $tokenObj = $this->returnTokenObj($token);
        if (empty($tokenObj)) {
            $notifier->warningNote('Invalid Token !');
            redirect();
        } elseif (($user = $this->model->findByEmail($tokenObj->email)) === false) {
            $notifier->warningNote('Invalid Token !');
            redirect();
        }

        if ($request->isPost()) {
            $postData = (object) $request->getPostData();

            $validator = new Validator($request->getPostData(), $notifier);
            $validator->select('password')->required()->min(8);
            $validator->select('ConfirmPassword')->required()->matchWith($validator->select('password'));

            if ($validator->validate()) {
                $this->model->password = password_hash($postData->password, PASSWORD_DEFAULT);
                $update = $this->model->where('email', $email)->update();

                $this->terminateToken(false, 'id', $tokenObj->id);

                $notifier->successNote('Password has been changed Successfully !');
                redirect('admin/login');
            }
        }
        return $this->loadView('reset', 'admin')->with(compact('email', 'tokenObj'));
    }*/

    #-- Complete Agent Profile --#
    public function confirmAgent(Request $request){
        $notifier = new Notification();
        $email = $request->getParams('email');
        $token = base64_url_decode($request->getParams('token'));

        $tokenObj = $this->returnTokenObj($token);
        if (empty($tokenObj)) {
            $notifier->warningNote('Invalid Token !');
            redirect();
        } elseif (($user = $this->model->findByEmail($tokenObj->email)) === false) {
            $notifier->warningNote('Invalid Token !');
            redirect();
        }
        if ($request->isPost()) {
            $postData = (object) $request->getPostData();

            $validator = new Validator($request->getPostData(), $notifier);
            //$validator->select('password')->required();
            $validator->select('password')->required()->min(8);
            $validator->select('ConfirmPassword')->required()->matchWith($validator->select('password'));

            if ($validator->validate()) {
                $this->model->username = $postData->username;
                $this->model->password = password_hash($postData->password, PASSWORD_DEFAULT);
                $update = $this->model->where('email', $email)->update();

                $this->terminateToken(false, 'id', $tokenObj->id);

                $notifier->successNote('Password has been changed Successfully !');
                redirect('/login');
            }
        }
        return $this->loadView('profile', 'blank');
    }

    #--- Candidate ---#
    public function candidate(){
        return $this->loadView('candidate', 'site');
    }

    #--- API ----#

    public function getRegisterToken(Request $request) {
        echo json_encode($request->getSession()["csrf_token"] ?? '');
        die;
    }

    public function registerAPI(Request $request) {
        $email = $request->getPostData('email');
        $password = $request->getPostData('pass');
        //$token = $request->getUrlData('token');

        $notifier = new Notification();
        $validator = new Validator($request->getPostData(), $notifier);
        $validator->select('email')->required()->email()->unique($this->model, 'email');
        $validator->select('pass')->required()->min(8);
        $validator->select('ConfirmPass')->required()->matchWith($validator->select('pass'));

        $feedback = new \stdClass;
        
        if ($validator->validate()) {
            if (($agent = $this->model->findByEmail($email)) === false) {
                // 
            } else {
                $feedback->status = "fail";
                $feedback->message = "Email already exist!";
            }
        } else {
            $feedback->status = "fail";
            $feedback->message = "Email/Password is invalid!";
        }
        Response::json($feedback);
    }

    public function verifyToken(Request $request) {
        $retailerID = $request->getUrlData('id');
        $token = $request->getUrlData('code');
        $retailer = $this->model->where('id', $retailerID)->andWhere('temptoken', $token)->get();
        if (!empty($retailer)) {
            $this->model->temptoken = '';
            $this->model->verified = 1;
            $verified = $this->model->where('id', $retailerID)->update();
            $message = "Hello " . $retailer->name . ", Your phone number has been verified successfully!";
            $this->sendSMSToRetailer($retailer, $message);
            Response::json(true);
        } else {
            Response::json(false);
        }
    }

    public function sendVerificationCode($registrationID) {
        $randomNumber = rand(100000, 999999);
        $this->model->temptoken = $randomNumber;
        $updated = $this->model->where('id', $registrationID)->update();
        if ($updated !== FALSE) {
            $message = '';
            return true;//$this->sendSMS($registrationID, $message);
        }
    }

    public function resetTokenAPI(Request $request) {
        $registrationID = $request->getParams('agent_id');
        echo json_encode($this->sendVerificationCode($registrationID));
        die;
    }

    // public function loginAPI(Request $request) {
    //     $email = $request->getPostData('email');
    //     $password = $request->getPostData('pass');
    //     //$token = $request->getUrlData('token');

    //     $notifier = new Notification();
    //     $validator = new Validator($request->getPostData(), $notifier);
    //     $validator->select('email')->required()->email();
    //     $validator->select('pass')->required()->min(8);
    //     $feedback = new \stdClass;
        
    //     if ($validator->validate()) {
    //         if (($agent = $this->model->findByEmail($email)) !== false) {
    //             if (password_verify($password, $agent->password) !== false) {
    //                 $this->model->last_log = DATETIME;
    //                 $this->model->session_id = session_id();
    //                 $this->model->where('id', $agent->id)->update();
                    
    //                 $feedback->status = "success";
    //                 $feedback->message = "Login success!";
    //                 $feedback->data = $this->model->findByEmail($email);
    //             }else {
    //                 $feedback->status = "fail";
    //                 $feedback->message = "Worng password!";
    //             }
    //         } else {
    //             $feedback->status = "fail";
    //             $feedback->message = "Worng email address!";
    //         }
    //     } else {
    //         $feedback->status = "fail";
    //         $feedback->message = "Email/Password is invalid!";
    //     }
    //     Response::json($feedback);
    // }

    public function loginAPI(Request $request) {
        
        $params = json_decode(file_get_contents('php://input'),true);
        
        $email = $params['email'];
        $password = $params['pass'];

        if (($agent = $this->model->findByEmail($email)) !== false) {
            if (password_verify($password, $agent->password) !== false) {
                $this->model->last_log = DATETIME;
                $this->model->session_id = session_id();
                $this->model->where('id', $agent->id)->update();
                
                $this->feedback("success", "Login success!", $this->model->findByEmail($email));
            }else {
                $this->feedback("fail", "Worng password!", $password);
            }
        } else {
            $this->feedback("fail", "Worng email address!", $email);
        }
        
    }

    public function logoutAPI(Request $request)
    {
        $uid = $request->getPostData('uid');
        
        $feedback = new \stdClass;
        
        if($uid === false) {
            $feedback->status = "fail";
            $feedback->message = "User not found!";
        } else {
            $this->model->last_log = DATETIME;
            $this->model->session_id = '';
            $this->model->where('id', $uid)->update();
            $feedback->status = "success";
            $feedback->message = "Successfully logged out!";
        }
        Response::json($feedback);
    }

    protected function feedback($status, $message, $data = false) {
        $feedback = new \stdClass;
        $feedback->status = $status;
        $feedback->message = $message;
        if($data) $feedback->data = $data;
        
        Response::json($feedback);
    }

}
