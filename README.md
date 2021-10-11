# Laravel package for manage your URL redirects in database to get better SEO results

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sirodiaz/laravel-redirection.svg?style=flat-square)](https://packagist.org/packages/SiroDiaz/laravel-redirection)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/SiroDiaz/laravel-redirection/run-tests?label=tests&style=flat-square)](https://github.com/SiroDiaz/laravel-redirection/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/SiroDiaz/laravel-redirection/Check%20&%20fix%20styling?label=code%20style&style=flat-square)](https://github.com/SiroDiaz/laravel-redirection/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/SiroDiaz/laravel-redirection.svg?style=flat-square)](https://packagist.org/packages/SiroDiaz/laravel-redirection)

---
This repo can be used to scaffold a Laravel package. Follow these steps to get started:

1. Press the "Use template" button at the top of this repo to create a new repo with the contents of this skeleton
2. Run "php ./configure.php" to run a script that will replace all placeholders throughout all the files
3. Remove this block of text.
4. Have fun creating your package.
5. If you need help creating a package, consider picking up our <a href="https://laravelpackage.training">Laravel Package Training</a> video course.
---

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require SiroDiaz/laravel-redirection
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="SiroDiaz\Redirection\RedirectionServiceProvider" --tag="laravel-redirection-migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="SiroDiaz\Redirection\RedirectionServiceProvider" --tag="laravel-redirection-config"
```

This is the contents of the published config file:

```php
return [
    /*
    |
    | The redirect statuses that you will use in your application.
    | By default, the "301", "302" and "307" are defined.
    |
    */
    'statuses' => [
        302 => 'Normal (302)',
        301 => 'Permanent (301)',
        307 => 'Temporary (307)',
    ],

    /*
    |
    | Concrete implementation for the "redirection model".
    | To extend or replace this functionality, change the value below with your full "redirection model" FQN.
    |
    | Your class will have to (first option is recommended):
    | - extend the "SiroDiaz\Redirection\Models\Redirection" class
    | - or at least implement the "SiroDiaz\Redirection\Contracts\RedirectionModelContract" interface.
    |
    | Regardless of the concrete implementation below, you can still use it like:
    | - app('redirection.model') OR app('\SiroDiaz\Redirection\Models\Redirection\Contracts\RedirectionModelContract')
    | - or you could even use your own class as a direct implementation
    |
    */
    'model' => SiroDiaz\Redirection\Models\Redirection::class,
];

```

## Usage

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
