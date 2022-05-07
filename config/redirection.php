<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Status codes valid for redirections
    |--------------------------------------------------------------------------
    |
    | The redirect statuses that you will use in your application.
    | By default, the "301", "302" and "307" are defined.
    |
    */
    'statuses' => [
        301 => 'Permanent (301)',
        302 => 'Normal (302)',
        307 => 'Temporary (307)',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Redirect status code (in case of not defined)
    |--------------------------------------------------------------------------
    |
    | Status code used by default to redirect from an old URL to a new mapped
    | URL.
    |
    */
    'default_status_code' => (int)env('REDIRECT_DEFAULT_STATUS', 301),

    /*
    |--------------------------------------------------------------------------
    | Case sensitivity
    |--------------------------------------------------------------------------
    |
    | Whether to match URLs case sensitively or not.
    | Default to false because most URLs are not case sensitive.
    |
    */
    'case-sensitive' => (bool) env('REDIRECT_CASE_SENSITIVE', false),

    /*
    |--------------------------------------------------------------------------
    | Redirect Driver
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default redirect driver that you want to use.
    | The "config" driver is used by default when you want to code faster.
    | Consider database driver better for admin panel configuration backed by
    | a relational DB.
    |
    */
    'driver' => env('REDIRECT_DRIVER', 'config'),

    /*
    |--------------------------------------------------------------------------
    | Array containing all available drivers and its implementations and source
    |--------------------------------------------------------------------------
    |
    | Concrete implementation for the "redirection model".
    | To extend or replace this functionality, change the value below with
    | your full "redirection model" FQN.
    |
    | Your class will have to (first option is recommended):
    | - extend the "SiroDiaz\Redirection\Models\Redirection" class
    | - or at least implement the "SiroDiaz\Redirection\Contracts\RedirectionModelContract" interface.
    |
    | Regardless of the concrete implementation below, you can still use it like:
    | - app('redirection.') OR app('\SiroDiaz\Redirection\Contracts\RedirectionModelContract')
    | - or you could even use your own class as a direct implementation. For this
    | case you must extend from "SiroDiaz\Redirection\Models\Redirection" model class and
    | replace in the published config file 'drivers.database.source'.
    |
    |
    */
    'drivers' => [
        'config' => [
            'driver' => SiroDiaz\Redirection\Drivers\FileRedirector::class,
            'source' => 'redirection.urls',
        ],
        'database' => [
            'driver' => SiroDiaz\Redirection\Drivers\DatabaseRedirector::class,
            'source' => SiroDiaz\Redirection\Models\Redirection::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Url list with redirections used for config driver
    |--------------------------------------------------------------------------
    |
    | You can use urls array of two different ways. The simple one uses the
    | default redirect status code ('redirection.default_status_code').
    | Example:
    | 'urls' => [
    |   '/old/url' => '/new/url',
    |   '/another/old/url' => '/another/new/url',
    |   '/url/with?id=123' => '/url/with/123',
    | ],
    |
    | The second way to write redirect urls in your config/redirection.php
    | is using associative arrays. You can combine this method with the previous one.
    | Look at this example:
    | 'urls' => [
    |   '/old/url' => ['new_url' => '/new/url', 'status_code' => 302],
    |   '/another/old/url' => '/another/new/url',
    |   '/url/with?id=123' => ['new_url' => '/url/with/123'],
    | ],
    |
    */
    'urls' => [],

];
