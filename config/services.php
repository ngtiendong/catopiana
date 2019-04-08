<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),         // Your Facebook Client ID
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'), // Your Facebook Client Secret
        'redirect' => 'https://beta.catopiana.com/login/facebook/callback',
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),         // Your Google Client ID
        'client_secret' => env('GOOGLE_CLIENT_SECRET'), // Your Google Client Secret
        'redirect' => 'https://beta.catopiana.com/login/google/callback',
    ],

    'paypal' => [
        'id' => env('PAYPAL_CLIENT_ID'),
        'secret' => env('PAYPAL_CLIENT_SECRET'),
        'url' => [
            'redirect' => 'https://beta.catopiana.com/execute-payment',
            'cancel'=>'https://beta.catopiana.com/payment-test',
            'executeAgreement' => [
                'success'=>'https://beta.catopiana.com/execute-agreement/true',
                'failure'=>'https://beta.catopiana.com/execute-agreement/false'
            ]
        ],
        'currency' => 'USD',
        'settings' => [
            'mode' => env('PAYPAL_MODE','sandbox'),
            'http.ConnectionTimeOut' => 30,
        ],
    ],

];
