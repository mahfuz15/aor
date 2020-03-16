<?php

namespace Templates\admin;

use Controllers\ModuleController;
use Controllers\PermissionController;
use Framework\DInjector\Singleton;
use Framework\Http\Request\Request;
use Framework\Template\BaseTemplateHandler;

class TemplateHandler extends BaseTemplateHandler {

    public $loggedUser;
    public $userModulePermission;
    public $notifications;
    public $totalNotifications = 0;

    public function boot() {
        $this->request = Singleton::get(Request::class);

        $this->loadLoggedUserDetails();
    }

    public function preRender() {
        if (empty($_GET['format'])) {
            $this->loadHead();
            $this->loadHeader();
        }
    }

    public function postRender() {
        if (empty($_GET['format'])) {
            $this->loadFooter();
            $this->loadFoot();
        }
    }

    public function loadHead() {
        require 'head.php';
    }

    public function loadHeader() {
        require 'header.php';
    }

    public function loadFooter() {
        require 'footer.php';
    }

    public function loadFoot() {
        require 'foot.php';
    }

    protected function loadLoggedUserDetails() {
        /*if (PANEL === 'admin') {*/
            $adminController = new \Controllers\AdminController();
            $permissionController = new PermissionController();
            $this->loggedUser = $adminController->loggedAdminDetails($this->request);
            if(!empty($this->loggedUser)){
                $this->userModulePermission = $permissionController->getModuleListByUserIDForMenu($this->loggedUser->id);
            }
       /* }*/
    }

    public function addJs($js) {
        $this->jsFiles[] = $js;
    }

    public function getJs() {
        return $this->jsFiles;
    }

    public function addRawJs($js) {
        $this->rawJs[] = $js;
    }

    public function getRawJs() {
        return $this->rawJs;
    }

    public function isAdmin() {
        return (!empty($this->values['loggedUser']) && isset($this->values['loggedUser']->role) && $this->values['loggedUser']->role >= 15);
    }

    protected function siteSettings() {
        return \Controllers\SiteController::returnSettings();
    }

    public function userPreference() {
        if (PANEL === USER_PANEL_NAME) {
            $userPreferenceController = new \Controllers\UserPreferenceController();
            return $userPreferenceController->returnByColumn('user_id', $this->request->loggedID());
        }
        return false;
    }

    public function thousandSep($number) {
        return number_format($number, 2, '.', ',');
    }

    public function formatDateTime($datetime) {
        $timestamp = strtotime($datetime);
        return date('m-d-Y h:i A', $timestamp);
    }

    public function formatFancyDateTime($datetime) {
        $timestamp = strtotime($datetime);
        return date('D, M d, Y', $timestamp) . ' at ' . date('h:i A', $timestamp);
    }

    public function formatShortFancyDateTime($datetime, $afterText = 'ago') {
        $remainingText = 'remaining';
        $remainingIcon = '';

        $timestamp = strtotime($datetime);

        if ($timestamp > time()) {
            $afterText = $remainingText;
            $remainingIcon = '<i class="fa fa-clock-o" aria-hidden="true"></i> &nbsp;';
        }

        $elapsedTime = round(abs(time() - $timestamp) / 60, 2);

        if ($elapsedTime < 2) {
            return 'Now';
        } else if ($elapsedTime < 60) {
            return $remainingIcon . $this->timeAgo($datetime, $afterText);
        } else if ($elapsedTime < 1440) {
            return $remainingIcon . $this->timeAgo($datetime, $afterText);
        } else if ($elapsedTime < 1440 * 2) {
            if ($timestamp > time()) {
                return $remainingIcon . 'Tomorrow, ' . date('h:i A', $timestamp);
            } else {
                return 'Yesterday, ' . date('h:i A', $timestamp);
            }
        } else if ($elapsedTime < 1440 * 7) {
            return $remainingIcon . date('D, h:i A', $timestamp);
        } else if ($elapsedTime < 1440 * 30) {
            return $remainingIcon . date('M d', $timestamp);
        } else if ($elapsedTime < 1440 * 365) {
            return $remainingIcon . date('M, Y', $timestamp);
        }
        return $remainingIcon . date('M d, Y', $timestamp);
    }
    function timeAgo($datetime, $afterText = 'ago', $detailLevel = 1)
    {
        $diffArr = $this->timeDifference($datetime);

        if ($detailLevel && $detailLevel > 1) {
            $diffArr = array_slice($diffArr, 0, $detailLevel);
        } else {
            $diffArr = array_slice($diffArr, 0, 1);
        }

        return $diffArr ? implode(', ', $diffArr) . ' ' . $afterText : 'Just now';
    }

    function timeRemaining($datetime, $afterText = 'remaining', $detailLevel = 1)
    {
        $diffArr = $this->timeDifference($datetime);

        if ($detailLevel && $detailLevel > 1) {
            $diffArr = array_slice($diffArr, 0, $detailLevel);
        } else {
            $diffArr = array_slice($diffArr, 0, 1);
        }

        return $diffArr ? implode(', ', $diffArr) . ' ' . $afterText : 'Just now';
    }

    function timeElapsedPercent($toTime, $fromTime, $percentSymbol = '')
    {
        $to = new \DateTime($toTime);
        $from = new \DateTime($fromTime);
        $now = new \DateTime();

        $diff = $to->diff($from);
        $diffFromNow = $from->diff($now);

        $timeElapsedPercent = round(($diffFromNow->days / $diff->days) * 100, 2);

        return $timeElapsedPercent . $percentSymbol;
    }

    function timeDifference($toTime, $fromTime = '')
    {
        $to = new \DateTime($toTime);
        $from = new \DateTime($fromTime);

        $diff = $to->diff($from);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $diffArr = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($diffArr as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($diffArr[$k]);
            }
        }
        return $diffArr;
    }

}
