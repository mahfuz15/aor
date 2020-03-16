<?php

namespace Controllers;

use Vendor\PostMaster;
use Framework\Controller\Controller;
use Framework\Http\Request\Request;
use Framework\Validation\Validator;
use Framework\Http\Notification\Notification;

class MailController extends Controller {

    public function compose(Request $request)
    {
        $smtpServerController = new SmtpServerController();

        if ($request->isPost()) {
            $postData = (object) $request->getPostData();
            //pd($postData);

            $notification = new Notification();
            $validator = new Validator($request->getPostData(), $notification);
            $validator->select('receiver_email')->required()->email();
            $validator->select('subject')->required();
            $validator->select('message')->required();


            if ($validator->validate()) {
                $postMaster = new PostMaster();
                if (($smtp = $smtpServerController->returnUserSmtp($request->loggedID())) === false) {
                    $smtp = $smtpServerController->returnRandomServer();
                }

                $postMaster->loadConfig($smtp->server, $smtp->user, $smtp->password, $smtp->port, $smtp->protocol, false, $smtp->authenticate);
                $postMaster->setMailFrom($smtp->user, SITE);
                $postMaster->setReplyTo($smtp->user, SITE);

                $postMaster->setMailBody($postData->message);

                $bounceEmail = $this->bounceMail();

                $postMaster->setSender($bounceEmail);
                $postMaster->addCustomHeader("Errors-To", '<' . $bounceEmail . '>');
                $postMaster->addCustomHeader("Bounces-To", '<' . $bounceEmail . '>');
                
                // CC BCC
                if(!empty($postData->cc_email)){
                    $postMaster->addRecipientQueue($postData->cc_email, 2);
                }
                if(!empty($postData->bcc_email)){
                    $postMaster->addRecipientQueue($postData->bcc_email, 3);
                }

                $postMaster->sendMail($postData->subject, $postData->receiver_email, $postData->receiver_email, null);

                $notification->successNote('Mail has been sent successfully !');
            }

            redirect();
        } else {
            return $this->loadView('compose', 'admin', 'Mailbox')->with();
        }
    }

    public function bounceMail()
    {
        $bounceConfigs = require CONFIG_DIR . DS . 'mail.config.php';

        if (!isset($bounceConfigs['BOUNCE_HANDLER']['email'])) {
            throw new \Exception('No Bounce Mail Configuration Found !');
        }
        return $bounceConfigs['BOUNCE_HANDLER']['email'];
    }

    public function newUserAccount($user)
    {
        $emailInfo = new \stdClass;
        $emailInfo->user_name = $user->name;
        $emailInfo->user_username = $user->username;
        $emailInfo->user_email = $user->email;

        $postMaster = $this->postmasterForSystemMail();
        $postMaster->prepareMailBody($emailInfo, 'user/newAccount');

        $postMaster->sendMail('New Account on ' . SITE, $user->email, $user->name);
    }

    public function notifySubscription($user, $subscriptionPlan, $subscriptionPayment)
    {
        $emailInfo = new \stdClass();

        $emailInfo->subject = 'New Subscription';
        $emailInfo->user_name = $user->name;
        $emailInfo->plan_name = $subscriptionPlan->title;
        $emailInfo->subscribe_at = prettyDate($subscriptionPayment->subscribe_at);
        $emailInfo->expire_at = prettyDate($subscriptionPayment->expire_at);
        $emailInfo->paid_amount = $subscriptionPayment->amount;

        $postMaster = $this->postmasterForSystemMail();
        $postMaster->prepareMailBody($emailInfo, 'userSubscriptionStatus');

        $postMaster->sendMail(SITE . ' Usage Subscription Status', $user->email, $user->name);

        $notification = new Notification();
        $notification->successNote('User has been notified regarding his new subscription plan!');
    }

    public function notifyQuotaModification($user, $newQuota)
    {
        $emailInfo = cloneObj($newQuota);

        $emailInfo->subject = 'Usage Quota Changed';
        $emailInfo->user_name = $user->name;
        $emailInfo->followup_status = $newQuota->is_followup === 1 ? 'YES' : 'No';
        $emailInfo->deadline_status = $newQuota->is_deadline === 1 ? 'YES' : 'No';
        $emailInfo->subscriber_visibility = $newQuota->show_subscriber === 1 ? 'YES' : 'No';

        $postMaster = $this->preparePostman();
        $postMaster->prepareMailBody($emailInfo, 'userQuotaStatus');

        $postMaster->sendMail(SITE . ' Usage Quota Status', $user->email, $user->name);

        $notification = new Notification();
        $notification->successNote('User has been notified regarding his quota change!');
    }

    public function accountStatus(Request $request)
    {
        $userID = (int) $request->getUrlData('id');

        $userController = new UserController();
        $notification = new Notification();

        $user = $userController->returnByID($userID);

        if (empty($user)) {
            $notification->warningNote('User not found');
            $this->redirect();
        }
        
        $emailData = new \stdClass();
        $emailData->subject = 'Account Status';
        $emailData->user_name = $user->name;
        $emailData->user_username = $user->username;
        $emailData->user_email = $user->email;

        $postMaster = $this->preparePostman();
        $postMaster->prepareMailBody($user, 'user/accountStatus');

        $postMaster->sendMail(SITE . ' User Account Status', $user->email, $user->name);

        $notification->successNote('User account status has been sent !');
        redirect();
    }

    public function paymentHistory(Request $request)
    {
        $userID = (int) $request->getUrlData('id');

        $userController = new UserController();
        $notification = new Notification();
        $subscriptionPaymentController = new SubscriptionPaymentController();

        $user = $userController->returnByID($userID);

        if (empty($user)) {
            $notification->warningNote('User not found');
            $this->redirect();
        }

        $subscriptions = $subscriptionPaymentController->returnByColumn('user_id', $user->id);

        $postMaster = $this->preparePostman();
        $postMaster->prepareMailBody($user, 'userPaymentHistory');

        $postMaster->sendMail(SITE . ' User Account Status', $user->email, $user->name);

        $notification->successNote('User payment history has been sent !');
        redirect();
    }

    public function forgotPassMail(string $email, string $name, string $token)
    {
        $emailData = array(
            'USER_EMAIL' => $email,
            'USER_NAME' => $name);

        $emailData['USER_RESET_LINK'] = BASE_URL . 'panel/reset-password?email=' . $email . '&token=' . base64_encode($token);
        $emailData['SUBJECT'] = $subject = 'Reset your ' . SITE . ' password';

        $postMaster = $this->postmasterForSystemMail();
        $postMaster->prepareMailBody($emailData, 'user/reset-password');

        return $postMaster->sendMail($subject, $email, $name);
    }

    protected function preparePostman()
    {
        $postMaster = new PostMaster();
        $smtpServerController = new SmtpServerController();

        $smtp = $smtpServerController->returnRandomServer();

        $postMaster->loadConfig($smtp->server, $smtp->user, $smtp->password, $smtp->port, $smtp->protocol, false, $smtp->authenticate);
        $postMaster->setMailFrom($smtp->user, SITE);
        $postMaster->setReplyTo($smtp->user, SITE);

        $bounceEmail = $this->bounceMail();
        $postMaster->setSender($bounceEmail);
        $postMaster->addCustomHeader("Errors-To", '<' . $bounceEmail . '>');
        $postMaster->addCustomHeader("Bounces-To", '<' . $bounceEmail . '>');

        return $postMaster;
    }

    public function postmasterForSystemMail()
    {
        $config = require CONFIG_DIR . '/mail.config.php';

        if (empty($config['SMTP'])) {
            throw new \Exception('DEFAULT SMTP Configuration not found !');
        }
        $smtp = (object) $config['SMTP'];

        $postMaster = new PostMaster();

        $postMaster->loadConfig($smtp->server, $smtp->user, $smtp->password, $smtp->port, $smtp->secure, false, $smtp->auth);
        $postMaster->setMailFrom($smtp->user, SITE);
        $postMaster->setReplyTo($smtp->user, SITE);

        $bounceEmail = $this->bounceMail();
        $postMaster->setSender($bounceEmail);
        $postMaster->addCustomHeader("Errors-To", '<' . $bounceEmail . '>');
        $postMaster->addCustomHeader("Bounces-To", '<' . $bounceEmail . '>');

        return $postMaster;
    }

}
