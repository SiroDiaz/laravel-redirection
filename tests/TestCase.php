<?php

namespace VendorName\Skeleton\Tests;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use SiroDiaz\Redirection\RedirectionServiceProvider;
use SiroDiaz\Redirection\RedirectRequests;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        $this->getEnvironmentSetUp($this->app);
        $this->setUpDatabase();
        $this->setUpMiddleware($this->app);

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'SiroDiaz\\Redirection\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            RedirectionServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    public function setUpDatabase(): void
    {
        $migration = include __DIR__.'/../database/migrations/create_skeleton_table.php.stub';
        $migration->up();
    }

    public function setUpMiddleware(Application $app): void
    {
        $app->make(Kernel::class)->pushMiddleware(RedirectRequests::class);
    }
}
