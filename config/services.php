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

    'services' => [
        'one' => 'strokya/images/sprite.svg#fi-free-delivery-48',
        'two' => 'strokya/images/sprite.svg#fi-24-hours-48',
        'three' => 'strokya/images/sprite.svg#fi-payment-security-48',
        'four' => 'strokya/images/sprite.svg#fi-tag-48',
    ],

    'shipping' => [
        'Inside Dhaka' => 60,
        'Outside Dhaka' => 100,
    ],

    'stdfst' => [
        'key' => env('STEADFAST_KEY'),
        'secret' => env('STEADFAST_SECRET'),
    ],

    'logo' => [
        'desktop' => [
            'width' => 260,
            'height' => 54
        ],
        'mobile' => [
            'width' => 150,
            'height' => 40
        ],
        'favicon' => [
            'width' => 56,
            'height' => 56
        ],
    ],

    'products_count' => [
        'related' => 20,
    ],

    'slides' => [
        'mobile' => [360, 180],
        'desktop' => [840, 395],
    ],

    'bdwebs' => [
        'api_key' => env('BDWEBS_API_KEY'),
        'senderid' => env('BDWEBS_SENDERID'),
    ]

];
