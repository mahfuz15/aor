<?php

namespace Controllers;

use Framework\Tools\Pagination;
use Framework\Http\Request\Request;
use Framework\Validation\Validator;
use Framework\Controller\Controller;
use Framework\Http\Notification\Notification;

class PwdAdminActivityLogController extends Controller {

    public function __construct() {
        $this->model = $this->loadModel('PwdAdminActivityLog');
    }

    public function showSingle(Request $request) {
        $pwdAdminActivityLog_id = $request->getParams('id');

        $pwdAdminActivityLog = $this->model->where('id', $pwdAdminActivityLog_id)->orderBy('id', 'ASC')->limit(1)->get();
        return $this->loadView('form', 'admin')->with(compact('pwdAdminActivityLog'));
    }

    public function showList(Request $request) {
        $pagination = new Pagination('get', $this->getPerPage());
        $offset = $pagination->getOffSet();
        $limit = $pagination->getSize();
        $order = $this->getOrder($this->model, 'id');
        $sort = $this->getSort('DESC');

//        pr($this->getBrowserWithVersion());die();
        //$this->model->join('languages','languages.id','pwd_admin_activity_log.language_id','=','FULL OUTER');

        $languageController = new LanguageController();
        $languageList = $languageController->getLanguageList();
        $languages[0] = '';
        $languages[-1] = ''; // update all language filed
        foreach ($languageList as $index => $language) {
            $languages[$language->id] = $language->code;
        }
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
        $pwdAdminActivityLog = $this->model->paginate($pagination)->orderBy($order, $sort)
                        ->limit($offset, $limit)->getAll(['pwd_admin_activity_log.*']);


        return $this->loadView('list', 'admin')->with(compact('pwdAdminActivityLog', 'pagination', 'languages'));
    }

    public function create(Request $request) {

        if (!empty($request->getParams('id'))) {
            $edit = true;
            $pwdAdminActivityLog = $this->model->findByID($request->getParams('id'));
        } else {
            $edit = false;
            $pwdAdminActivityLog = null;
        }
        if ($request->isPost()) {
            $postData = (object) $request->getPostData();

            $notifier = new Notification();
            $validator = new Validator($request->getPostData(), $notifier);

            if ($validator->validate()) {
                $this->model->date = $postData->date;
                $this->model->time = $postData->time;
                $this->model->week_of_year = $postData->week_of_year;
                $this->model->admin_id = $postData->admin_id;
                $this->model->ip = $postData->ip;
                $this->model->path = $postData->path;
                $this->model->search = $postData->search;
                $this->model->uagt = $postData->uagt;
                $this->model->ref = $postData->ref;
                $this->model->language_id = $postData->language_id;
                $this->model->product_id = $postData->product_id;
                $this->model->file = $postData->file;
                $this->model->os = $postData->os;
                $this->model->browser = $postData->browser;

                if (empty($edit)) {
                    $pwdAdminActivityLogID = $this->model->insert();
                } else {
                    $this->model->where('id', $pwdAdminActivityLog->id)->update();
                    $pwdAdminActivityLogID = $pwdAdminActivityLog->id;
                }

                $notifier->successNote('A Pwd Admin Activity Log Has been updated successfully');
                redirect(PANEL . '/pwd/activitylog/edit/' . $pwdAdminActivityLogID);
            } else {
                $pwdAdminActivityLog = $postData;
                return $this->loadView('form', 'admin')->with(compact('pwdAdminActivityLog', 'edit'));
            }
        }

        return $this->loadView('form', 'admin')->with(compact('pwdAdminActivityLog', 'edit'));
    }

    public function edit(Request $request) {
        return $this->create($request);
    }

    public function delete(Request $request) {
        if (($pwdAdminActivityLog = $this->model->findByID($request->getParams('id'))) === false) {
            redirect('');
        }

        if ($request->isPost()) {
            $notifier = new Notification();

            if ($request->getPostData('confirm') === 'delete') {
                $this->model->where('id', $pwdAdminActivityLog->id)->delete();

                $notifier->successNote('A Pwd Admin Activity Log has been deleted !');
            }
            redirect(PANEL . '/pwd/activitylogs');
        }

        return $this->loadView('delete', 'admin')->with(compact('pwdAdminActivityLog'));
    }

    public function insertData(Request $request, $adminID, $url) {

        if(is_array($request->getPostData('language_id'))){
            $languageID = -1;
        }else{
            $languageID = !empty($request->getPostData('language_id')) ? $request->getPostData('language_id') : '';
        }

        date_default_timezone_set("Asia/Dhaka");
        $info = $this->getBrowserWithVersion();
        $this->model->date = date('Y-m-d');
        $this->model->time = date("H:i:s");
        $this->model->week_of_year = date("W", strtotime(date('Y-m-d')));
        $this->model->admin_id = $adminID;
        $this->model->ip = $this->getUserIpAddr();
        $this->model->path = $url;
        $this->model->search = $request->getUrlData('q');
        $this->model->uagt = $info['userAgent'];
        $this->model->ref = $info['ref'];
        $this->model->language_id =$languageID;
        $this->model->product_id = !empty($request->getPostData('product_id')) ? $request->getPostData('product_id'): '';
        $this->model->file = null;
        $this->model->os = $info['platform'];
        $this->model->browser = $info['browser'];
        $this->model->insert();
    }

    private function getUserIpAddr() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    private function getBrowserWithVersion() {
        $u_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $browser = 'Unknown';
        $platform = 'Unknown';
        $version = " ";
        $ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        $os_array = array(
            '/windows nt 10/i' => 'Windows 10',
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );

        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $u_agent)) {
                $platform = $value;
            }
        }

        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $browser = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $browser = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/OPR/i', $u_agent)) {
            $browser = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Chrome/i', $u_agent) && !preg_match('/Edge/i', $u_agent)) {
            $browser = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent) && !preg_match('/Edge/i', $u_agent)) {
            $browser = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $browser = 'Netscape';
            $ub = "Netscape";
        } elseif (preg_match('/Edge/i', $u_agent)) {
            $browser = 'Edge';
            $ub = "Edge";
        } elseif (preg_match('/Trident/i', $u_agent)) {
            $browser = 'Internet Explorer';
            $ub = "MSIE";
        } else {
            $ub = "Unknown";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
                ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else if(isset($matches['version'][1])) {
                $version = $matches['version'][1];
            } else {
                $version = 'n/a';
            }
        } else {
            $version = $matches['version'][0];
        }

        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }

        return array(
            'userAgent' => $u_agent,
            'browser' => $browser,
            'version' => $version,
            'platform' => $platform,
            'ref' => $ref
        );
    }

}
