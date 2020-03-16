<?php

namespace Vendor\RevoMailer;

use PHPMailer\PHPMailer\PHPMailer;

spl_autoload_register(function($class) {
    if (strpos($class, 'PHPMailer\\PHPMailer') !== false) {
        require ROOT . DS . 'Vendor/PHPMailer/' . basename(str_replace('\\', '/', $class)) . '.php';
    }
});

class RevoMailer extends PHPMailer {

    protected $debugMode = false;

    public function __construct($exceptions = null)
    {
        parent::__construct($exceptions);
        $this->boot();
    }

    protected function boot()
    {
        $this->debugMode = isDebug();
        $this->Debugoutput = array($this, 'debugOutput');
    }

    public function debugOutput($string, $debug)
    {
        if ($this->debugMode) {
            pr($string);
        }
    }

}
