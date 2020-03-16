<?php

namespace Controllers;

use Framework\Mail\Imap\Mail;
use Framework\Tools\Pagination;
use Vendor\RevoMailer\RevoMailer;
use Framework\Mail\Imap\Connection;
use Framework\Http\Request\Request;
use Framework\Controller\Controller;
use Framework\Http\Response\Response;
use AutoMail\AutoMail;
use AutoMail\NotFoundException;
use Vendor\Timezone\Timezone;

class ApiController extends Controller {

    public function __construct() {
        session_write_close();
    }

    public function callFunction() {
        $function = Request::getParams("function");
        $this->$function();
    }

    public function checkIMAP(Request $request) {
        $responder = new \stdClass();
        $responder->server = $_POST['host'];
        $responder->imap_port = $_POST['port'];
        $responder->imap_flag = $_POST['flag'];
        $responder->imap_folder = $_POST['folder'];
        $responder->user = $_POST['user'];
        $responder->password = $_POST['password'];

        $imapConnection = new Connection($responder->server, $responder->imap_port);
        $imapConnection->setFlag($responder->imap_flag)->selectFolder($responder->imap_folder);
        $imapConnection->login($responder->user, $responder->password);
        $imapConn = $imapConnection->connect();
        if (is_resource($imapConn)) {
            if (imap_check($imapConn)) {
                Response::json('true');
            }
            imap_close($imapConn);
        } else {
            //pr($imapConn->getMessage());
            echo $imapConn->getMessage();
            $imapConnection->closeConnection();
            exit;
        }
    }

    public function checkSMTP(Request $request) {
        $responder = new \stdClass();
        $responder->server = $_POST['host'];
        $responder->smtp_port = $_POST['port'];
        $responder->smtp_secure = $_POST['secure'];
        $responder->smtp_auth = $_POST['auth'];
        $responder->user = $_POST['user'];
        $responder->password = $_POST['password'];
        //pr($responder);
        //$host, $user, $password, $port, $auth, $secure
        $smtpTester = new \Vendor\SmtpTester();
        $res = $smtpTester->testConnection($responder->server, $responder->user, $responder->password, $responder->smtp_port, $responder->smtp_auth, $responder->smtp_secure);
        if ($res == true) {
            echo 'true';
        } else {
            echo $res;
        }
        exit;
    }

    protected function checkAlias(Request $request) {
        $getV = $request->getUrlData();
        $model = empty($getV["m"]) ? 'Content' : $getV["m"];
        $alias = empty($getV["a"]) ? null : $getV["a"];
        $preAlias = empty($getV["pa"]) ? null : $getV["pa"];
        $model = $this->loadModel($model);

        Response::json($this->returnAlias($alias, $model, $preAlias, true));
    }

    public function recentMailBox(Request $request) {
        $model = $this->loadModel('Mailbox');

        $mailBox = $model->orderBy('received_at', 'DESC')->limit(10)->getAll();

        if (!empty($mailBox)) {
            foreach ($mailBox as $i => $mail) {
                $mail->sl = $i + 1;
                $mail->received_time = vanilaTime(strtotime($mail->received_at)) . ' ago';
            }
        }

        Response::json($mailBox);
    }

    public function recentSubscriber(Request $request) {
        $model = $this->loadModel('Subscriber');

        $subscribers = $model
          ->orderBy('mail_subscribers.subscribed_at', 'DESC')->limit(10)
          ->selectRelated('mailbox', 'subscriber_id', 'id', 'sender_name', 'sender_name')
          ->getAll(['mail_subscribers.*']);

        if (!empty($subscribers)) {
            foreach ($subscribers as $i => $subscriber) {
                $subscriber->sl = $i + 1;
                $subscriber->subscribed_time = vanilaTime(strtotime($subscriber->subscribed_at)) . ' ago';
            }
        }

        Response::json($subscribers);
    }

    public function getImapConfig(Request $request) {
        require ROOT . DS . 'Vendor' . DS . 'AutoMail' . DS . 'AutoMail.php';
        require ROOT . DS . 'Vendor' . DS . 'AutoMail' . DS . 'NotFoundException.php';

        $email = $request->getUrlData('email');
        $configuration = AutoMail::discover($email);
        if (!empty($configuration) && isset($configuration['incoming'])) {
            foreach ($configuration['incoming'] as $incomingServerConfig) {
                if ($incomingServerConfig['protocol'] == 'IMAP') {
                    //pr($incomingServerConfig);
                    $imapConfig['server'] = $incomingServerConfig['hostname'];
                    $imapConfig['imap_port'] = $incomingServerConfig['port'];
                    $imapConfig['imap_flag'] = '/imap';
                    if (strtolower($incomingServerConfig['socketType']) == 'ssl') {
                        $imapConfig['imap_flag'] .= '/ssl/novalidate-cert';
                    } else if (strtolower($incomingServerConfig['socketType']) == 'tls') {
                        $imapConfig['imap_flag'] .= '/tls/novalidate-cert';
                    } else {
                        
                    }
                    $imapConfig['imap_folder'] = 'INBOX';
                    break;
                }
            }
        } else {
            $imapConfig = false;
        }
        Response::json($imapConfig);
        //pr($imapConfig);
    }

    public function detectTimezone(Request $request) {
        $timezone = new Timezone();
        
        if ($request->isPost()) {
            $postData = (object) $request->getPostData();
            
            $offset = $postData->offset;
            $dst = $postData->dst;
            
            echo json_encode($timezone->detect_timezone_id($offset, $dst));
        } else {
            echo json_encode(false);
        }
    }

}
