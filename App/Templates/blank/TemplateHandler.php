<?php

namespace Templates\blank;

use Framework\Template\BaseTemplateHandler;
use Framework\Http\Request\Request;

class TemplateHandler extends BaseTemplateHandler {
    public function boot()
    {
        if (empty($this->request)) {
            $this->request = new Request(new \Framework\Http\Session\Session);
        }
    }
}
