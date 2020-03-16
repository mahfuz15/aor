<?php

namespace Controllers;

use Vendor\PostMaster;
use Framework\Encryption\CrypTor;

trait MailTrait {

    public function postmasterForSystemMail() {
        $config = require CONFIG_DIR . '/mail.config.php';

        if (empty($config['SMTP'])) {
            throw new \Exception('DEFAULT SMTP Configuration not found !');
        }
        $smtp = (object) $config['SMTP'];

        $postMaster = new PostMaster();

        $postMaster->loadConfig($smtp->server, $smtp->user, $smtp->password, $smtp->port, $smtp->secure, false, $smtp->auth);
        $postMaster->setMailFrom($smtp->user, SITE);
        $postMaster->setReplyTo($smtp->user, SITE);

        //$bounceEmail = $this->bounceMail();
        $postMaster->setSender($smtp->user);
//        $postMaster->addCustomHeader("Errors-To", '<' . $bounceEmail . '>');
//        $postMaster->addCustomHeader("Bounces-To", '<' . $bounceEmail . '>');

        return $postMaster;
    }

    public function sendMail(string $subject, string $body, array $recipients) {
        if (empty($recipients)) {
            throw new \Exception('Recipients array required');
        }
        $postMaster = $this->postmasterForSystemMail();

        $emails = [];
        foreach ($recipients as $recipient) {
            $emails[$recipient] = strstr($recipient, '@', true);
        }

        $postMaster->addBatchRecipient($emails);

        $postMaster->setSubject($subject);
        $postMaster->setMailBody($body);

        //pr($postMaster->getMailBody());die;

        return $postMaster->sendMail();
    }

    public function confirmRegistrationMail($email, $token) {
        $emailData = array('USER_EMAIL' => $email);
        $emailData['SUBJECT'] = $subject = 'Confirm Your Account on ' . SITE;
        $emailData['USER_VERIFY_LINK'] = BASE_URL . 'confirm-registration?token=' . base64_url_encode($token);

        $postMaster = $this->postmasterForSystemMail();
        $postMaster->addRecipientQueue([$email => strstr($email, '@', true)], 1);
        $postMaster->setSubject($subject);
        $postMaster->prepareMailBody($emailData, 'user/confirm-registration')->html();
//        pr($postMaster->getMailBody());
//        die;
        return $postMaster->sendMail();
    }

    public function emailVarifyMail($userName, $userEmail, $token) {
        $emailData = array('USER_NAME' => $userName, 'USER_EMAIL' => $userEmail);
        $emailData['SUBJECT'] = $subject = 'Varify Your Email on ' . SITE;
        $emailData['EMAIL_VERIFY_LINK'] = BASE_URL . 'confirm-email?token=' . base64_url_encode($token);

        $postMaster = $this->postmasterForSystemMail();
        $postMaster->addRecipientQueue([$userEmail => strstr($userEmail, '@', true)], 1);
        $postMaster->setSubject($subject);
        $postMaster->prepareMailBody($emailData, 'user/confirm-email')->html();
//        pr($postMaster->getMailBody());
//        die;
        return $postMaster->sendMail();
    }

    public function accountPendingMail($user) {
        $emailData = array(
            'USER_NAME' => $user->name,
            'USER_USERNAME' => $user->username,
            'USER_EMAIL' => $user->email,
            'USER_PASSWORD' => $user->password,
            'PANEL' => PANEL
//            'USER_PHONE' => $user->phone
        );

        $emailData['SUBJECT'] = $subject = 'Your ' . SITE . ' account is now pending for verification';

        $postMaster = $this->postmasterForSystemMail();
        $postMaster->addRecipientQueue([$user->email => $user->name], 1);
        $postMaster->setSubject($subject);
        $postMaster->prepareMailBody($emailData, 'user/verification-pending')->html();
//        pr($postMaster->getMailBody());
//        die;
        return $postMaster->sendMail();
    }

    public function successRegistrationMail($user) {
        $emailData = array(
            'USER_NAME' => $user->name,
            'USER_USERNAME' => $user->username,
            'USER_EMAIL' => $user->email,
            'USER_PASSWORD' => $user->password,
            'PANEL' => PANEL
//            'USER_PHONE' => $user->phone
        );

        $emailData['SUBJECT'] = $subject = 'Account Info on ' . SITE;

        $postMaster = $this->postmasterForSystemMail();
        $postMaster->addRecipientQueue([$user->email => $user->name], 1);
        $postMaster->setSubject($subject);
        $postMaster->prepareMailBody($emailData, 'user/newAccount')->html();
//        pr($postMaster->getMailBody());
//        die;
        return $postMaster->sendMail();
    }

    public function forgotPassMail(string $email, string $name, string $token) {
        $emailData = array(
            'USER_EMAIL' => $email,
            'USER_NAME' => $name);

        $emailData['USER_RESET_LINK'] = BASE_URL . PANEL. '/reset-password/' . $email . '/' .  base64_url_encode($token);
        $emailData['SUBJECT'] = $subject = 'Reset your ' . SITE . ' password';

        $postMaster = $this->postmasterForSystemMail();
        $postMaster->addRecipientQueue([$email => $name], 1);
        $postMaster->setSubject($subject);
        $postMaster->prepareMailBody($emailData, 'admin/reset-password')->html();
//        pr($postMaster->getMailBody());
//        die;
        return $postMaster->sendMail();
    }

    public function accountStatusMail($user) {
        $emailData = array(
            'USER_NAME' => $user->name,
            'USER_USERNAME' => $user->username,
            'USER_EMAIL' => $user->email,
            'USER_PHONE' => $user->phone,
            'PASSWORD_RESET_LINK' => BASE_URL . 'reset-password?token=' . base64_url_encode($user->token)
        );

        $emailData['SUBJECT'] = $subject = 'Account Info on ' . SITE;

        $postMaster = $this->postmasterForSystemMail();
        $postMaster->addRecipientQueue([$user->email => $user->name], 1);
        $postMaster->setSubject($subject);
        $postMaster->prepareMailBody($emailData, 'user/accountStatus')->html();

        return $postMaster->sendMail();
    }

    public function companyEmailVarifyMail($user, $email, $token) {
        $emailData = ['USER_NAME' => $user->name, 'USER_EMAIL' => $email];

        $emailData['SUBJECT'] = $subject = 'Varify Your Email on ' . SITE;
        $emailData['EMAIL_VERIFY_LINK'] = BASE_URL . 'varify-company-email/' . $user->company_id . '?token=' . base64_url_encode($token);

        $postMaster = $this->postmasterForSystemMail();
        $postMaster->addRecipientQueue([$email => strstr($email, '@', true)], 1);
        $postMaster->setSubject($subject);
        $postMaster->prepareMailBody($emailData, 'company/varify-email')->html();
//        pr($postMaster->getMailBody());
//        return true;
//        die;
        return $postMaster->sendMail();
    }

    public function sendTestMail($testMailTo, $subject, $fromfield, $replyto, $message, $textmessage, $footer) {
        
        $postMaster = $this->postmasterForSystemMail();
        
//        $postMaster->setMailFrom($testMailTo, SITE);
//        $postMaster->setReplyTo($replyto, SITE);
        $postMaster->setSubject('[TEST MAIL] '.$subject);

        $postMaster->addRecipientQueue([$testMailTo => strstr($testMailTo, '@', true)], 1);

        $emailBody = $message . $footer;
        $emailBody = str_replace('[EMAIL]', $testMailTo, $emailBody);
        $emailBody = str_replace('[FROMEMAIL]', htmlentities($fromfield), $emailBody);        
        
        $postMaster->setMailBody($emailBody);

        return $postMaster->sendMail();
    }

    public function adminAgentCreationMail(string $email, string $token)
    {
        $emailData = array(
            'USER_EMAIL' => $email);

        $emailData['AGENT_REGISTRATION_LINK'] = BASE_URL . 'agent-confirm/' . $email . '/' . base64_encode($token);
        $emailData['SUBJECT'] = $subject = 'Registration completion  on ' . SITE;
        $postMaster = $this->postmasterForSystemMail();
        $postMaster->addRecipientQueue([$email => $email], 1);
        $postMaster->setSubject($subject);
        $postMaster->prepareMailBody($emailData, 'agent/agent-confirm')->html();
        return $postMaster->sendMail();
    }
    

}
