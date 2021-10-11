<?php

namespace SiroDiaz\Redirection;

use Illuminate\Routing\Router;
use SiroDiaz\Redirection\Commands\RedirectionListCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class RedirectionServiceProvider extends PackageServiceProvider
{
    /**
     * @var Router
     */
    protected Router $router;

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-redirection')
            ->hasConfigFile()
            ->hasMigration('create_redirections_table')
            ->hasCommand(RedirectionListCommand::class);
    }
}
