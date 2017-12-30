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

    'facebook' => [
        'client_id'     => '122224608430277',
        'client_secret' => '2f12b932aa9c037455630a79f4cb2184',
        'redirect'      => 'https://pedidos2click.com/auth/facebook/callback',
    ],
    
    'google' => [
        'client_id'     => '490707348489-fuia5icdudb3s7lpc8vaj85tp6m696fr.apps.googleusercontent.com',
        'client_secret' => 'VJfM-WLfCLbxra2wsImtoak2',
        'redirect'      => 'https://pedidos2click.com/auth/google/callback',
    ],
    'twitter' => [
        'client_id'     => 'RZkZX4qfybHYAi5BogN8DnbYu',
        'client_secret' => 'IsmtcjvFtHrgaN9QD5JCwnYBVlEKeVxq8TgAYiSCUChOhDAjqk',
        'redirect'      => 'https://pedidos2click.com/auth/twitter/callback',
    ],

];
