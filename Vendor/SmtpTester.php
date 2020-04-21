<?php

namespace Vendor;

use Exception;
use Vendor\RevoMailer\RevoMailer;
use PHPMailer\PHPMailer\SMTP;

class SmtpTester extends RevoMailer
{

    public function testConnection($host, $user, $password, $port, $auth, $secure)
    {
        $smtp = new SMTP();
        $smtp->do_debug = SMTP::DEBUG_CONNECTION;
        try {
            //Connect to an SMTP server
            $smtp->connect($host, $port);

            //Say hello
            if (!$smtp->hello(gethostname())) {
                throw new Exception('EHLO failed: ' . $smtp->getError()['error']);
            }
            //Get the list of ESMTP services the server offers
            $e = $smtp->getServerExtList();
            //If server can do TLS encryption, use it
            if (is_array($e) && array_key_exists('STARTTLS', $e)) {
                $tlsok = $smtp->startTLS();
                if (!$tlsok) {
                    throw new Exception('Failed to start encryption: ' . $smtp->getError()['error']);
                }
                //Repeat EHLO after STARTTLS
                if (!$smtp->hello(gethostname())) {
                    throw new Exception('EHLO (2) failed: ' . $smtp->getError()['error']);
                }
                //Get new capabilities list, which will usually now include AUTH if it didn't before
                $e = $smtp->getServerExtList();
            }
            //If server supports authentication, do it (even if no encryption)
            if (is_array($e) && array_key_exists('AUTH', $e)) {
                if ($smtp->authenticate($user, $password)) {
                    return true;
                } else {
                    throw new Exception('Authentication failed: ' . $smtp->getError()['error']);
                }
            }
        } catch (phpmailerException $e) {
            echo 'phpmailer error';
            echo $e->getMessage();
        } catch (Exception $e) {
            echo 'error';
            echo 'SMTP error: ' . $e->getMessage();
        }


        $smtp->quit(true);
    }

}
