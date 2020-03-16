<?php

return array(
    'IMAP' => array(
        'server' => 'mail.hotemailer.com',
        'imap_username' => 'info@hotemailer.com',
        'imap_password' => 'password',
        'imap_port' => 143,
        'imap_flag' => '/novalidate-cert',
        'imap_folder' => 'INBOX',
    ),
    'GOOGLE_IMAP' => array(
        'server' => 'imap.gmail.com',
        'imap_username' => '@gmail.com',
        'imap_password' => '',
        'imap_port' => 993,
        'imap_flag' => '/imap/ssl/novalidate-cert ',
        'imap_folder' => 'INBOX',
    ),
    'YAHOO_IMAP' => array(
        'server' => 'imap.mail.yahoo.com',
        'imap_username' => '@yahoo.com',
        'imap_password' => '',
        'imap_port' => 993,
        'imap_flag' => '/novalidate-cert',
        'imap_folder' => 'INBOX',
    ),
    'SMTP' => array(
        'server' => 'mail.massmailplus.com',
        'user' => 'noreply@massmailplus.com',
        'password' => 'r3V)d3vTe@m',
        'port' => '587',
        'secure' => 'tls',
        'auth' => true
    ),
    'BOUNCE_HANDLER' => array(
        'server' => 'mail.hotemailer.com',
        'email' => 'bounces@hotemailer.com',
        'password' => 'password',
        'imap_port' => 143,
        'imap_flag' => '/novalidate-cert',
        'imap_folder' => 'INBOX'
    )
);

