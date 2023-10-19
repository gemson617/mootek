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

    // 'mailgun' => [
    //     'domain' => env('MAILGUN_DOMAIN'),
    //     'secret' => env('MAILGUN_SECRET'),
    //     'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    //     'scheme' => 'https',
    // ],

     
    'sendinblue' => [        
        'v3'    => [
            'key'   => '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'                    
        ]
    ],
    // 'ses' => [
    //     'key' => env('AWS_ACCESS_KEY_ID'),
    //     'secret' => env('AWS_SECRET_ACCESS_KEY'),
    //     'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    // ],

];
