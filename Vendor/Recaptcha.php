<?php

 namespace Vendor;

 class Recaptcha
 {
     /* @var $recaptcha \ReCaptcha\ReCaptcha */

     protected $recaptcha;

     public function __construct()
     {
	 require __DIR__ . DS . 'recaptcha/src/autoload.php';

	 $this->recaptcha = new \ReCaptcha\ReCaptcha();
     }

     public function isValid($reponsekey)
     {
	 $recaptchaResponse = $this->recaptcha->verify($reponsekey, $_SERVER['REMOTE_ADDR']);

	 return $recaptchaResponse->isSuccess();
     }

 }
 