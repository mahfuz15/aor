<?php

namespace Controllers;

use Framework\Controller\Controller;

class ErrorController extends Controller {

    public function accessForbidden() {
        return $this->loadView('403', 'admin');
    }

}
