<?php

namespace SiroDiaz\Redirection\Tests;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use SiroDiaz\Redirection\Contracts\RedirectionModelContract;
use SiroDiaz\Redirection\Models\Redirection;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Create a new service provider instance.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function boot()
    {
        $this->publishConfigs();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
    }

    /**
     * Setup the config.
     *
     * @throws BindingResolutionException
     */
    protected function publishConfigs(): void
    {
        $this->app->make('config')->set('redirection.statuses', [
            301 => 'Permanent (301)',
            302 => 'Normal (302)',
            307 => 'Temporary (307)',
        ]);
    }

    /**
     * @return void
     */
    protected function registerBindings()
    {
        $this->app->bind(RedirectionModelContract::class, $this->config['redirection']['model'] ?? Redirection::class);
        $this->app->alias(RedirectionModelContract::class, 'redirect.model');
    }
}
