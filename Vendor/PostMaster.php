<?php

namespace Vendor;

use Vendor\RevoMailer\RevoMailer;
use PHPMailer\PHPMailer\Exception;

class PostMaster {

    const NOCC = 1;
    const CC = 1;
    const BCC = 1;

    protected $mailObject;
    protected $templateDIR;
    protected $config;

    public function __construct()
    {
        $this->mailObject = new RevoMailer();

        $appFolder = defined('APP') ? APP : ROOT . DS . 'App';
        $this->templateDIR = $appFolder . DS . 'Templates' . DS . 'email';
    }

    public function __set($name, $value)
    {
        $this->mailObject->$name = $value;
    }

    public function __get($name)
    {
        return $this->mailObject->{$name};
    }

    public function loadConfig($host, $user, $password, $port = 587, $secure = 'tls', $debug = false, $auth = true)
    {
        //Enable SMTP debugging.
        $this->mailObject->SMTPDebug = $debug;
        //Set PHPMailer to use SMTP.
        $this->mailObject->isSMTP();
        //Set SMTP host name
        $this->mailObject->Host = $host;
        //Set this to true if SMTP host requires authentication to send email
        $this->mailObject->SMTPAuth = ($auth == 1 || $auth === true) ? true : false;

        //Provide username and password
        $this->mailObject->Username = $user;
        $this->mailObject->Password = $password;
        //If SMTP requires TLS encryption then set it
        $this->mailObject->SMTPSecure = $secure;
        //Set TCP port to connect to
        $this->mailObject->Port = $port;

        return $this;
    }

    public function loadConfigFromObject($obj)
    {
        $this->loadConfig($obj->server, $obj->user, $obj->password, $obj->port, $obj->protocol, false, $obj->authenticate);

        $this->setMailFrom($obj->sender_email, $obj->sender_name);
        $this->setReplyTo($obj->reply_to, $obj->sender_name);

        return true;
    }

    public function addRecipientQueue($emails, $type = 2)
    {
        $emails = $this->filterEmailList($emails);

        if (empty($emails)) {
            return $this;
        }

        foreach ($emails as $email => $recipient) {
            if ($type === 1) {
                $this->mailObject->addAddress($email, $recipient);
            } elseif ($type === 2) {
                $this->mailObject->addCC($email, $recipient);
            } else {
                $this->mailObject->addBCC($email, $recipient);
            }
        }

        return $this;
    }

    public function addBatchRecipient($emails, $type = self::CC)
    {
        $emails = $this->filterEmailList($emails);

        if (empty($emails)) {
            return $this;
        }

        reset($emails);
        $firstEmail = [key($emails) => current($emails)];
        unset($emails[key($emails)]);

        $this->addRecipientQueue($firstEmail, self::NOCC);
        $this->addRecipientQueue($emails, $type);

        return $this;
    }

    public function filterEmailList($emails)
    {
        if (is_string($emails)) {
            $emails = explode(',', $emails);
            if (!empty($exp)) {
                $emails = array_flip($emails);
            }
        }
        if (!is_array($emails)) {
            return false;
        }

        return array_filter($emails, function($keyAsEmail) {
            return $this->validate($keyAsEmail);
        }, ARRAY_FILTER_USE_KEY);
    }

    private function validate($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }

    public function setSubject($subject)
    {
        $this->mailObject->Subject = $subject;

        return $this;
    }

    public function html($html = true)
    {
        if ($html === true) {
            $this->mailObject->isHTML(true);
            $this->mailObject->AltBody = strip_tags($this->mailObject->Body);
        } else {
            $this->mailObject->isHTML(false);
        }

        return $this;
    }

    public function attachments($attachments)
    {
        if (!empty($attachments)) {
            if (is_array($attachments)) {
                foreach ($attachments as $attachment) {
                    $this->mailObject->AddAttachment($attachment);
                }
            } elseif (is_string($attachments)) {
                $this->mailObject->AddAttachment($attachments);
            }
        }

        return $this;
    }

    public function sendMail()
    {
        if (empty($this->mailObject->Body)) {
            throw new \Exception('Email body not found!', 404);
        }

        $this->mailObject->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        try {
            $this->mailObject->send();

            if (!empty($this->mailObject->ErrorInfo)) {
                throw new Exception($this->mailObject->ErrorInfo);
            }

            // Clean Slate Protocole
            $this->cleanSlate();

            return true;
        } catch (Exception $e) {
            $error = 'Unable to send mail to: <pre>' . $e->getMessage() . '<pre>';

            throw new \Exception($error, 403);
            return false;
        }
    }

     public function prepareMailBody($data, $templateName, $isHtml = true)
    {
        $templatePath = $this->templateDIR . DS . $templateName . '.tpl';

        if (file_exists($templatePath)) {
            $body = file_get_contents($templatePath);
        } else {
            throw new \Exception('Email template ' . $templateName . ' not found!', 404);
            return false;
        }

        $mailFrom = $this->From;
        $body = str_replace('#SITE_NAME#', SITE, $body);
        $body = str_replace('#ROOT_URL#', BASE_URL, $body);
        $body = str_replace('#PANEL#', PANEL, $body);
        $body = str_replace('#MAIL_FROM#', $mailFrom, $body);
        $body = str_replace('#YEAR#', date('Y'), $body);

        foreach ($data as $key => $value) {
            $body = str_replace('#' . strtoupper($key) . '#', $value, $body);
        }

        $this->setMailBody($body, $isHtml);

        return $this;
    }

    public function getMailBody()
    {
        return $this->mailObject->Body;
    }

    public function setMailBody($body, $html = true)
    {
        $this->mailObject->Body = $body;
        $this->html($html);
    }

    public function setMailFrom($fromEmail, $fromName = SITE)
    {
        if ($this->validate($fromEmail)) {
            $this->From = $fromEmail;
            $this->FromName = $fromName;
        }
    }

    public function setReplyTo($replyEmail, $replyToName)
    {
        if ($this->validate($replyEmail)) {
            $this->mailObject->AddReplyTo($replyEmail, $replyToName);
        }
    }

    public function checkReplyTo()
    {
        $closure = function () {
            return empty($this->ReplyTo);
        };

        $newClosure = $closure->bindTo($this->mailObject, 'PHPMailer');

        return $newClosure();
    }

    public function setSender($email)
    {
        $this->mailObject->Sender = $email;
    }

    public function headerLine($name, $value)
    {
        $this->mailObject->addCustomHeader($name, $value);
    }

    public function addCustomHeader($name, $value = null)
    {
        $this->mailObject->addCustomHeader($name, $value);
    }

    public function cleanSlate()
    {
        $this->mailObject->clearAddresses();
        $this->mailObject->clearAllRecipients();
        $this->mailObject->clearReplyTos();
        $this->mailObject->clearCustomHeaders();
        $this->mailObject->clearAttachments();

        return $this;
    }

}
