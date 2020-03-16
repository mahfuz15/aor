<?php

namespace Vendor;

use Exception;

class Sms {

    Protected $url;
    Protected $user_name;
    Protected $password;
    protected $receiver;
    Protected $message;

//	public function __construct(){
//      $this->url ="http://api.boom-cast.com/boomcast/WebFramework/boomCastWebService/externalApiSendTextMessage.php?masking=NOMASK&userName=01797262459&password=417b8cf17444cff287a1590b3c051b55&MsgType=TEXT&receiver=$this->GetNumbar()&message=$this->GetMessage()";
//    }

    public function auth($user_name, $password) {
        if (isset($user_name) && isset($password)) {
            $this->user_name = $user_name;
            $this->password = $password;
        } else {
            return false;
        }
    }

    public function SetMessage($message) {
        $this->message = $message;
    }

    public function GetMessage() {
        return $this->message;
    }

    public function SetNumbar($receiver) {
        $this->receiver = $receiver;
    }

    public function GetNumbar() {
        return $this->receiver;
    }

    public function Send() {
        $message = $this->GetMessage();
        $receiver = $this->GetNumbar();
        $ch = curl_init();
        $sendMessageRequestString = "http://api.boom-cast.com/boomcast/WebFramework/boomCastWebService/externalApiSendTextMessage.php?masking=NOMASK&userName=01797262459&password=417b8cf17444cff287a1590b3c051b55&MsgType=TEXT&receiver=".urlencode($receiver)."&message=".urlencode($message);
        curl_setopt($ch, CURLOPT_URL, $sendMessageRequestString);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
        curl_close($ch);
    }

    public function sendSMS($receiver, $message) {
        $this->receiver = $receiver;
        $this->message = $message;
        $this->Send();
    }

}
