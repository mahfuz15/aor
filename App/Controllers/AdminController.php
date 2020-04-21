<?php

namespace Controllers;

use \Vendor\Utilities;
use Vendor\SimpleImage;
use Framework\Http\Uploader\File;
use Framework\Validation\Validator;
use Framework\Http\Request\Request;
use Framework\Controller\Controller;
use Framework\Http\Uploader\Uploader;
use Framework\FileSystem\FileManager;
use Framework\Http\Notification\Notification;

class AdminController extends Controller
{

    use TokenTrait,
        MailTrait;

    public $loggedUserDetails;
    protected $roleArray;

    public function __construct()
    {
        $this->model = $this->loadModel('Admin');
        $roleController = new RoleController();
        $this->roleArray = $roleController->getRoleList();
        /*$this->roleArray = array(
            10 => 'Admin',
            20 => 'Super Admin'
        );*/
    }

    public function getUserList(){
        return $this->model->getAll();
    }

    public function index(Request $request)
    {
        return $this->loadView('panel', 'admin');
    }

    public function profile(Request $request)
    {

        $admin = $this->model->where('id', $request->loggedID('admin'))
            ->orderBy('id')->limit(1)
            ->get();

        if (empty($admin)) {
            redirect();
        }

        $roleArray = $this->roleArray;

        if ($request->isPost()) {
            $postData = (object) $request->getPostData();
            $notifier = new Notification();
            $validator = new Validator($request->getPostData(), $notifier);

            $validator->select('name')->required();
            $validator->select('username')->unique($this->model, 'username', [$admin->username]);
            $validator->select('email')->required()->email()->unique($this->model, 'email', [$admin->email]);
            
            if (empty($edit)) {
                $validator->select('password')->required()->min(8);
            }else{
                if (!empty($postData->password)) {
                    $validator->select('password')->required()->min(8);
                }
            }

            $uploader = new Uploader();
            $file = $uploader->file('avatar');
            $validator->file($file)->optional()->image();

            if ($validator->validate()) {
                if (!empty($postData->password)) {
                    $this->model->password = password_hash($postData->password, PASSWORD_DEFAULT);
                }
                $this->model->name = ucwords($postData->name);
                $this->model->username = ucfirst($postData->username);
                $this->model->email = $postData->email;

                $update = $this->model->where('id', $admin->id)->update();

                if(!empty($file)){
                    $this->uploadAvatar($file, $admin);
                }

                if ($update !== false) {
                    $notifier->successNote('Account Updated Successfully!');
                } else {
                    $notifier->warningNote('Something went Wrong !');
                }
                redirect();
            } else {
                $admin = $postData;
                return $this->loadView('profile', 'admin')->with(compact('admin', 'roleArray'));
            }
        } else {

            return $this->loadView('profile', 'admin')->with(compact('admin', 'roleArray'));
        }
    }

    protected function uploadAvatar(File $file, $admin)
    {
        if ($file->isValid() === false) {
            return false;
        }

        // Purge previous avatar
        if (!empty($admin->avatar)) {
            FileManager::unlink(ROOT . DS . PUBLIC_DIR . DS . $admin->avatar);
        }

        $dir = FileManager::checkDIR(ROOT . DS . PUBLIC_DIR . DS . 'images' . DS . 'admins');
        $image = new SimpleImage($file->temp_path);

        $avatarPath = FileManager::returnUniquePath($dir . DS . \Framework\Helpers\Random::str(8) . '.jpg');

        $image->thumbnail(250, 250)->toFile($avatarPath, null, 80);

        if (file_exists($avatarPath)) {
            $this->model->avatar = str_replace(ROOT . DS . PUBLIC_DIR . DS, '', $avatarPath);
            $this->model->where('id', $admin->id)->update();
        }

        return false;
    }

    public function login(Request $request)
    {
        if ($request->isLoggedIn('admin')) {
            redirect('admin');
        }

        if ($request->isPost()) {

            $username = $request->getPostData('username');
            $password = $request->getPostData('password');

            $notifier = new Notification();
            $validator = new Validator($request->getPostData(), $notifier);
            $validator->select('username')->required()->alphaNum()->min(4);
            $validator->select('password')->required()->min(8);

            if ($validator->validate()) {
                if (($admin = $this->model->findByUsername($username)) !== false) {
                    if (password_verify($password, $admin->password) !== false) {
                        $this->model->last_log = DATETIME;
                        $this->model->session_id = session_id();
                        $this->model->where('id', $admin->id)->update();

                        $request->setLoggedIn($admin->id, $admin->email, 'admin');
                        redirect('admin');
                    }
                }
                $notifier->warningNote('User Name/Password is invalid !');
            }

            redirect('admin/login');
        } else {

            return $this->loadView('login', 'admin');
        }
    }

    public function logout(Request $request)
    {
        $uid = $request->loggedID('admin');
        $this->model->last_log = DATETIME;
        $this->model->session_id = '';
        $this->model->where('id', $uid)->update();
        $request->setLoggedOut('admin');
        redirect();
    }

    public function forgotPassword(Request $request) {

        if ($request->isLoggedIn('admin')) {
            redirect('admin');
        }
        $notifier = new Notification();

        if ($request->isPost()) {
            $email = $request->getPostData('email');

            $validator = new Validator($request->getPostData(), $notifier);
            $validator->select('email')->required()->email();

            if (($validator->validate() === true) && ($admin = $this->model->findByEmail($email)) !== false) {
                $token = $this->registerToken($admin->email);
                //Mail to user
                $this->forgotPassMail($admin->email, $admin->username, $token);

                $notifier->successNote('Recovery mail has been sent to your MailBox.');
            } else {
                $notifier->warningNote('Email is invalid !');
            }

            redirect();
        }
        return $this->loadView('forgot', 'admin')->with();
    }

    public function resetPassword(Request $request) {
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
    }


    public function loggedAdminDetails(Request $request)
    {
        $uid = $request->loggedID('admin');
        $loggedAdminDetails = $this->model->where('id', $uid)->orderBy('id')->limit(1)->get('*', 3600);
        unset($loggedAdminDetails->password);
        if($loggedAdminDetails){
            $loggedAdminDetails->roleName = $this->userRoles($loggedAdminDetails->role_id);
        }
        return $loggedAdminDetails;
    }

    public function userRoles($role)
    {
        $roleController = new RoleController();
        $role = $roleController->getRoleByID($role);

        if ($role) {
            return $role;
        } else {
            return false;
        }
    }




    public function countAdmins()
    {
        return $this->model->countRows();
    }

}
