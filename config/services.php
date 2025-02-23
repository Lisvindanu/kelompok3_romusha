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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_CALLBACK'),
    ],

    'spring' => [
        'auth_url' => env('SPRING_API_URL_AUTH', 'https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/auth'),
        'base_url' => env('SPRING_API_URL', 'https://virtual-realm-b8a13cc57b6c.herokuapp.com'),
        'category_url' => env('CATEGORY_API_URL', 'https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/categories'),
        'api_key' => env('SPRING_API_KEY', 'secret')
    ],

    'midtrans' => [
        'server_key' => env('MIDTRANS_SERVER_KEY'),
        'client_key' => env('MIDTRANS_CLIENT_KEY'),
        'is_production' => env('MIDTRANS_PRODUCTION', true),
    ],

    'youtube' => [
        'api_key' => env('YOUTUBE_API_KEY'),
    ],

//    'midtrans' => [
//        'server_key' => env('MIDTRANS_SERVER_KEY', ''),
//        'client_key' => env('MIDTRANS_CLIENT_KEY', ''),
//        'is_production' => env('MIDTRANS_PRODUCTION', true),
//    ],

];
