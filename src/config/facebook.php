<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Facebook Application Configurations
    |--------------------------------------------------------------------------
    |
    | This option controls the authentication driver that will be utilized.
    | This driver manages the retrieval and authentication of the users
    | attempting to get access to protected areas of your application.
    |
    */

    'application' => [
        'key'    => env('FACEBOOK_APP_ID'),
        'secret' => env('FACEBOOK_APP_SECRET'),
        'scopes' => [],
    ],

];
