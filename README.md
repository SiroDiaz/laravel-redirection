# Laravel package for manage your URL redirects in database to get better SEO results

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sirodiaz/laravel-redirection.svg?style=flat-square)](https://packagist.org/packages/SiroDiaz/laravel-redirection)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/SiroDiaz/laravel-redirection/run-tests?label=tests&style=flat-square)](https://github.com/SiroDiaz/laravel-redirection/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/SiroDiaz/laravel-redirection/Check%20&%20fix%20styling?label=code%20style&style=flat-square)](https://github.com/SiroDiaz/laravel-redirection/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/SiroDiaz/laravel-redirection.svg?style=flat-square)](https://packagist.org/packages/SiroDiaz/laravel-redirection)

## Requirements

You need PHP ^7.4 or higher. It is only tested and was designed for Laravel 8.x.
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
    | Default model used for redirections
    |--------------------------------------------------------------------------
    |
    | Concrete implementation for the "redirection model".
    | To extend or replace this functionality, change the value below with your full "redirection model" FQN.
    |
    | Your class will have to (first option is recommended):
    | - extend the "SiroDiaz\Redirection\Models\Redirection" class
    | - or at least implement the "SiroDiaz\Redirection\Contracts\RedirectionModelContract" interface.
    |
    | Regardless of the concrete implementation below, you can still use it like:
    | - app('redirection.model') OR app('\SiroDiaz\Redirection\Models\Redirection\Contracts\RedirectsModelContract')
    | - or you could even use your own class as a direct implementation
    |
    */
    'model' => SiroDiaz\Redirection\Models\Redirection::class,
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

## Testing

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
