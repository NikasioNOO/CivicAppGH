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
        'domain' => '',
        'secret' => '',
    ],

    'mandrill' => [
        'secret' => '',
    ],

    'ses' => [
        'key'    => '',
        'secret' => '',
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => CivicApp\User::class,
        'key'    => '',
        'secret' => '',
    ],

    //Socialite
    'facebook' => [
        'client_id'     => '881604891929928',
        'client_secret' => '76f656698cc2c9f4a0bc244144531347',
        'redirect'      => 'http://appcivica.dev:8000/login/Facebook',
    ],

];
