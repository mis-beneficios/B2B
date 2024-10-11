<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | This option controls the default mailer that is used to send any email
    | messages sent by your application. Alternative mailers may be setup
    | and used as needed; however, this mailer will be used by default.
    |
     */

    'default'  => env('MAIL_MAILER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | Here you may configure all of the mailers used by your application plus
    | their respective settings. Several examples have been configured for
    | you and you are free to add your own as your application requires.
    |
    | Laravel supports a variety of mail "transport" drivers to be used while
    | sending an e-mail. You will specify which one you are using for your
    | mailers below. You are free to add additional mailers as required.
    |
    | Supported: "smtp", "sendmail", "mailgun", "ses",
    |            "postmark", "log", "array"
    |
     */

    'mailers'  => [
        'smtp'      => [
            'transport'  => 'smtp',
            'host'       => env('MAIL_HOST', 'smtp.mailgun.org'),
            'port'       => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username'   => env('MAIL_USERNAME'),
            'password'   => env('MAIL_PASSWORD'),
            'timeout'    => null,
            'auth_mode'  => null,
        ],        
        // 'mailgun'      => [
        //     'transport'  => 'mailgun',
        //     'host'       => env('MAIL_HOST', 'smtp.mailgun.org'),
        //     'port'       => env('MAIL_PORT', 587),
        //     'encryption' => env('MAIL_ENCRYPTION', 'tls'),
        //     'username'   => env('MAIL_USERNAME'),
        //     'password'   => env('MAIL_PASSWORD'),
        //     'timeout'    => null,
        //     'auth_mode'  => null,
        // ],

        'mailersend' => [
            'transport' => 'mailersend',
            'host'       => env('MAIL_HOST', 'smtp.mailersend.net'),
            'port'       => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username'   => env('MAIL_USERNAME'),
            'password'   => env('MAIL_PASSWORD'),
            'timeout'    => null,
            'auth_mode'  => null,
        ],
        'ses'       => [
            'transport' => 'ses',
        ],

        'mailgun' => [
            'transport' => 'mailgun',
            'domain' => env('MAILGUN_DOMAIN'),
            'secret' => env('MAILGUN_SECRET'),
        ],
        'postmark'  => [
            'transport' => 'postmark',
        ],

        'sendmail'  => [
            'transport' => 'sendmail',
            'path'      => '/usr/sbin/sendmail -bs',
        ],

        'log'       => [
            'transport' => 'log',
            'channel'   => env('MAIL_LOG_CHANNEL'),
        ],

        'array'     => [
            'transport' => 'array',
        ],

        'hortencia' => [
            'transport'  => 'smtp',
            'host'       => 'smtppro.zoho.com',
            'port'       => '465',
            'encryption' => 'SSL',
            'username'   => 'hortenciareservaciones@beneficiosvacacionales.mx',
            'password'   => 'MBV.herrera21',
            'timeout'    => null,
            'auth_mode'  => null,
        ],
        'luvir'     => [
            'transport'  => 'smtp',
            'host'       => 'smtppro.zoho.com',
            'port'       => '465',
            'encryption' => 'SSL',
            'username'   => 'luvir@beneficiosvacacionales.mx',
            'password'   => 'MBV.figueroa21',
            'timeout'    => null,
            'auth_mode'  => null,
        ],
        'paolar'    => [
            'transport'  => 'smtp',
            'host'       => 'smtppro.zoho.com',
            'port'       => '465',
            'encryption' => 'SSL',
            'username'   => 'paolar@beneficiosvacacionales.mx',
            'password'   => 'MBV.rojas21',
            'timeout'    => null,
            'auth_mode'  => null,
        ],
        'pablor'    => [
            'transport'  => 'smtp',
            'host'       => 'smtppro.zoho.com',
            'port'       => '465',
            'encryption' => 'SSL',
            'username'   => 'pabloramos@beneficiosvacacionales.mx',
            'password'   => 'MBV.ramos21',
            'timeout'    => null,
            'auth_mode'  => null,
        ],
        'castillo'  => [
            'transport'  => 'smtp',
            'host'       => 'smtppro.zoho.com',
            'port'       => '465',
            'encryption' => 'SSL',
            'username'   => 'atencionpostventa02@beneficiosvacacionales.mx',
            'password'   => 'Mbv.desactivo23',
            'timeout'    => null,
            'auth_mode'  => null,
        ],

        'ilianas'   => [
            'transport'  => 'smtp',
            'host'       => 'smtppro.zoho.com',
            'port'       => '465',
            'encryption' => 'SSL',
            'username'   => 'ilianasamper@beneficiosvacacionales.mx',
            'password'   => 'Misionimposible#2021',
            'timeout'    => null,
            'auth_mode'  => null,
        ],

        'diego'     => [
            'transport'  => 'smtp',
            'host'       => 'smtppro.zoho.com',
            'port'       => '465',
            'encryption' => 'SSL',
            'username'   => 'dsanchez@beneficiosvacacionales.mx',
            'password'   => 'Opt.sanchez19',
            'timeout'    => null,
            'auth_mode'  => null,
        ],

        'rubi'      => [
            'transport'  => 'smtp',
            'host'       => 'smtppro.zoho.com',
            'port'       => '465',
            'encryption' => 'SSL',
            'username'   => 'reservaciones02@beneficiosvacacionales.mx',
            'password'   => '200314Rubi@',
            'timeout'    => null,
            'auth_mode'  => null,
        ],
        'suhey'   => [
            'transport'  => 'smtp',
            'host'       => 'smtppro.zoho.com',
            'port'       => '465',
            'encryption' => 'SSL',
            'username'   => 'reservaciones01@beneficiosvacacionales.mx',
            'password'   => 'Mbv.Benreservas#22',
            'timeout'    => null,
            'auth_mode'  => null,
        ],
        'grecia'   => [
            'transport'  => 'smtp',
            'host'       => 'smtppro.zoho.com',
            'port'       => '465',
            'encryption' => 'SSL',
            'username'   => 'reservaciones03@beneficiosvacacionales.mx',
            'password'   => 'Mbv.estrada#23',
            'timeout'    => null,
            'auth_mode'  => null,
        ],

        'atcr'  => [
            'transport'  => 'smtp',
            'host'       => 'smtppro.zoho.com',
            'port'       => '465',
            'encryption' => 'SSL',
            'username'   => 'atencionpostventa02@beneficiosvacacionales.mx',
            'password'   => 'Mbv.desactivo23',
            'timeout'    => null,
            'auth_mode'  => null,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | You may wish for all e-mails sent by your application to be sent from
    | the same address. Here, you may specify a name and address that is
    | used globally for all e-mails that are sent by your application.
    |
     */

    'from'     => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name'    => env('MAIL_FROM_NAME', 'Example'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Markdown Mail Settings
    |--------------------------------------------------------------------------
    |
    | If you are using Markdown based email rendering, you may configure your
    | theme and component paths here, allowing you to customize the design
    | of the emails. Or, you may simply stick with the Laravel defaults!
    |
     */

    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

];
