<?php

use Illuminate\Support\Str;

return [


    'driver' => env('SESSION_DRIVER', 'file'),


    'lifetime' => env('SESSION_LIFETIME', null),

    'expire_on_close' => false,


    'encrypt' => false,


    'files' => storage_path('framework/sessions'),


    'connection' => env('SESSION_CONNECTION', null),


    'table' => env('SESSION_TABLE', 'sessions'),


    'store' => env('SESSION_STORE', null),


    'lottery' => [2, 100],


    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel'), '_').'_session'
    ),

    'path' => env('SESSION_PATH', '/'),


    'domain' => env('SESSION_DOMAIN', null),


    'secure' => env('SESSION_SECURE_COOKIE', false),



    'http_only' => env('SESSION_HTTP_ONLY', true),


    'same_site' => 'lax',


    'partitioned' => env('SESSION_PARTITIONED_COOKIE', false),

];
