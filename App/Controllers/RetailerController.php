<?php

namespace Controllers;

use Framework\Tools\Pagination;
use Framework\Http\Request\Request;
use Framework\Http\Response\Response;
use Framework\Validation\Validator;
use Framework\Controller\Controller;
use Framework\Http\Notification\Notification;
use Vendor\Sms;

class RetailerController extends Controller {

    public function __construct() {
        session_write_close();
        $this->model = $this->loadModel('Retailer');
    }

    public function showSingle(Request $request) {
        $retailer_id = $request->getParams('id');

        $retailer = $this->model->where('id', $retailer_id)->orderBy('id', 'ASC')->limit(1)->get();

        return $this->loadView('show', 'admin')->with(compact('retailer'));
    }

    public function showList(Request $request) {
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
        $retailers = $this->model->paginate($pagination)->orderBy($order, $sort)->limit($offset, $limit)->getAll();


        return $this->loadView('list', 'admin')->with(compact('retailers', 'pagination'));
    }

    public function create(Request $request) {

        if (!empty($request->getParams('id'))) {
            $edit = true;
            $retailer = $this->model->findByID($request->getParams('id'));
        } else {
            $edit = false;
            $retailer = null;
        }

        if ($request->isPost()) {
            $postData = (object) $request->getPostData();

            $notifier = new Notification();
            $validator = new Validator($request->getPostData(), $notifier);

            if ($validator->validate()) {

                $this->model->name = $postData->name;
                $this->model->shop_name = $postData->shop_name;
                $this->model->address = $postData->address;
                $this->model->email = $postData->email;
                $this->model->phone = $postData->phone;
                $this->model->pin = $postData->pin;
                $this->model->nid = $postData->nid;
                $this->model->trade_license_no = $postData->trade_license_no;
//                $this->model->registration_date = date('Y-m-d H:i:s');
                $this->model->status = $postData->status;
                $this->model->verified = !empty($postData->verified) ? $postData->verified : 0;
//                $this->model->temptoken = $postData->temptoken;

                if (empty($edit)) {
                    $retailerID = $this->model->insert();
                } else {
                    $this->model->where('id', $retailer->id)->update();
                    $retailerID = $retailer->id;
                }

                if (!empty($retailer) && $postData->status > $retailer->status) {
                    $message = "Hello " . $retailer->name . ", Your " . SITE . " account is now active. Login to your account through app and start shopping!";
                    $this->sendSMSToRetailer($retailer, $message);
                }

                $notifier->successNote('A Retailer Has been updated successfully');
                redirect(PANEL . '/retailer/edit/' . $retailerID);
            } else {
                $retailer = $postData;
                return $this->loadView('form', 'admin')->with(compact('retailer', 'edit'));
            }
        }

        return $this->loadView('form', 'admin')->with(compact('retailer', 'edit'));
    }

    public function register($postData = false) {
        if (empty($postData)) {
            return false;
        }

        $postData = (object) $postData;
        $notifier = new Notification();
        $validator = new Validator($postData, $notifier);

        if ($validator->validate()) {

            $this->model->name = $postData->name;
            $this->model->shop_name = $postData->shop_name;
            $this->model->address = $postData->address;
            $this->model->email = $postData->email;
            $this->model->phone = $postData->phone;
            $this->model->pin = $postData->pin;
            $this->model->nid = $postData->nid;
            $this->model->trade_license_no = $postData->trade_licence_no;
            $this->model->registration_date = date('Y-m-d H:i:s');
//            $this->model->status = $postData->status;
//            $this->model->verified = $postData->verified;
//            $this->model->temptoken = $postData->temptoken;

            $registrationID = $this->model->insert();
            if ($registrationID !== FALSE) {
                $this->sendVerificationCode($registrationID);
            }
            return $registrationID;
        } else {
            return false;
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
        $registrationID = $request->getParams('retailer_id');
        echo json_encode($this->sendVerificationCode($registrationID));
        die;
    }

    public function sendSMS($registrationID, $message) {
        /*$retailer = $this->model->where('id', $registrationID)->get();
        $sms = new Sms();
        $sms->SetNumbar($retailer->phone);
        $message = "Hello " . $retailer->name . ", Your " . SITE . " verification code is: " . $retailer->temptoken;
        $sms->SetMessage($message);
        $sms->Send();*/
        return true;
    }

    public function sendSMSToRetailer($retailer, $message) {
        //$retailer = $this->model->where('id', $registrationID)->get();
        /*$sms = new Sms();
        $sms->SetNumbar($retailer->phone);
        $sms->SetMessage($message);
        $sms->Send();*/
        return true;
    }

    public function registerAPI(Request $request) {
        //$postData = $request->getPostData();
        $postData = $request->getUrlData();
        Response::json($this->register($postData));
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

    public function registerToken(Request $request) {
        echo json_encode($request->getSession()["csrf_token"] ?? '');
        die;
    }

    public function login($phone, $pin) {
        return $this->model->where('phone', $phone)->andWhere('pin', $pin)->limit(1)->get(['id', 'verified', 'status']);
    }

    public function loginAPI(Request $request) {
        $phone = $request->getUrlData('phone');
        $pin = $request->getUrlData('pin');
//        Response::json($this->login($phone, $pin));
//        die;
        Response::json($this->login($phone, $pin));
    }

    public function edit(Request $request) {
        return $this->create($request);
    }

    public function delete(Request $request) {

        if (($retailer = $this->model->findByID($request->getParams('id'))) === false) {
            redirect('');
        }

        if ($request->isPost()) {
            $notifier = new Notification();

            if ($request->getPostData('confirm') === 'delete') {
                $this->model->where('id', $retailer->id)->delete();

                $notifier->successNote('A Retailer has been deleted !');
            }
            redirect(PANEL . '/retailers');
        }

        return $this->loadView('delete', 'admin')->with(compact('retailer'));
    }

    public function getSingleRetailer($retailerID) {
        return $this->model->findByID($retailerID);
    }

    public function getSingleRetailerAPI(Request $request) {
        $data = $this->getSingleRetailer($request->getParams('id'));
        if ($data) {
            Response::json($data);
        } else {
            Response::json(false);
        }
    }

    public function getRetailerList() {
        return $this->model->getAll();
    }

    public function getRetailerListJSON() {
        $data = $this->getRetailerList();
        if ($data) {
            Response::json($data);
        } else {
            Response::json(false);
        }
    }

    public function updateRetailer(Request $request) {
        $this->model->pin = $request->getPostData('pin');
        return $this->model->where('id', $request->getParams('id'))->update();
    }

    public function updateRetailerAPI(Request $request) {

        $data = $this->updateRetailer($request);

        if ($data) {
            Response::json(true);
        } else {
            Response::json(false);
        }
    }

}
