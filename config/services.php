<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        // 'domain' => 'e.beneficiosvacacionales.mx',
        // 'secret' => '0420fd894511027479b33323f88e1104-d51642fa-624d0112',
        // 'endpoint' => 'api.mailgun.net/v3/e.beneficiosvacacionales.mx',
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'zoho' => [
        'access_token' => env('ZOHO_ACCESS_TOKEN'),
        'refresh_token' => env('ZOHO_REFRESH_TOKEN'),
        'campaign_id' => env('ZOHO_CAMPAIGN_ID')
    ],

];
