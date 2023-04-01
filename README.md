# Laravel package for manage your URL redirects in database or other sources to get better SEO results

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sirodiaz/laravel-redirection.svg?style=flat-square)](https://packagist.org/packages/SiroDiaz/laravel-redirection)
[![run-tests](https://github.com/SiroDiaz/laravel-redirection/actions/workflows/run-tests.yml/badge.svg)](https://github.com/SiroDiaz/laravel-redirection/actions/workflows/run-tests.yml)
[![Check & fix styling](https://github.com/SiroDiaz/laravel-redirection/actions/workflows/php-cs-fixer.yml/badge.svg?branch=main)](https://github.com/SiroDiaz/laravel-redirection/actions/workflows/php-cs-fixer.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/SiroDiaz/laravel-redirection.svg?style=flat-square)](https://packagist.org/packages/SiroDiaz/laravel-redirection)

## Requirements

You need PHP 8.0 or higher. It is only tested and was designed for Laravel 9 and 10.
This package will receive updates for future Laravel versions. Previous Laravel versions
are not contemplated so use [Neurony/laravel-redirects](https://github.com/Neurony/laravel-redirects) package for
older Laravel versions.

## Installation

You can install the package via composer:

```bash
composer require SiroDiaz/laravel-redirection
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="SiroDiaz\Redirection\RedirectionServiceProvider" --tag="redirection-migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="SiroDiaz\Redirection\RedirectionServiceProvider" --tag="redirection-config"
```

This is the contents of the published config file:

```php
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


```

You can change and extend the default `SiroDiaz\Redirection\Models\Redirection` model class.
Image that you want to add some methods or fields. You would need to create a new model class, for example `App\Models\Redirect`.

Here is a basic example of how to extend the functionality of the default Redirection model.
We want to include support for Laravel BackPack admin panel would be:
```php
<?php

namespace App\Models;

use SiroDiaz\Redirection\Models\Redirection as RedirectionBaseModel;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Redirect extends Redirection
{
    use CrudTrait;
}
```

Finally, you have to vendor:publish the `sirodiaz/laravel-redirection` config file to change the model
class used now.

If you want to add more status codes for another type of redirect purposes, add them to your config/redirection.php
config file. By default, you have the most common redirections codes: 301, 302 and 307.

Ey! **don't forget** to append the middleware `SiroDiaz\Redirection\RedirectRequests` to your `app/Http/Kernel.php` file

```php
// app/Http/Kernel.php

    protected $middleware = [
        ...
        \SiroDiaz\Redirection\RedirectRequests::class,
    ],
```

## Extending and creating new redirect Drivers
**TODO**

## Testing this package for contribution

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Credits

- [SiroDiaz](https://github.com/SiroDiaz)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
