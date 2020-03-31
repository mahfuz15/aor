<?php

namespace Controllers;

use Framework\Http\Request\Request;
use Framework\Controller\Controller;
use Framework\Http\Notification\Notification;
use Framework\Validation\Validator;

class HomeController extends Controller {

    public function index() {
        return $this->loadView('index', 'site');
    }
}
