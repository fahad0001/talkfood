<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
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
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'facebook'=>[
        'client_id'=>'269045566885020',
        'client_secret'=>'31969495fcc76d7e9aaa4dd7b2939344',
        'redirect'=>'http://localhost:8000/auth/facebook/callback',
    ],
    'google' => [
    'client_id' =>'34489876429-huf346964s8scs439ued60afrq4ar8h3.apps.googleusercontent.com' ,
    'client_secret' =>'BXtZdAoGZ5c1ml0wL9td9Nuk',
    'redirect' => 'http://localhost:8000/auth/google/callback',  
], 
    'linkedin' => [
    'client_id' =>'81obo4vvf7gyp5' ,
    'client_secret' =>'a315GlhnmdgOI4Aq',
    'redirect' => 'http://localhost:8000/auth/linkedin/callback',  
],
    'twitter' => [
    'client_id' =>'f0HKmwrCPCUvEi9hyppgB90GR' ,
    'client_secret' =>'Smo5qCz5j0qJj6XgaGFeB8CgoD9Q2s4hVaKRwIzEcETKylZEL7',
    'redirect' => 'http://localhost:8000/auth/twitter/callback',  
],
];
