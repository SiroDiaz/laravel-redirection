<?php

namespace SiroDiaz\Redirection\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Routing\Router;
use Orchestra\Testbench\TestCase as Orchestra;
use SiroDiaz\Redirection\RedirectionServiceProvider;
use SiroDiaz\Redirection\RedirectRequests;

class TestCase extends Orchestra
{
    /**
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->getEnvironmentSetUp($this->app);
        $this->setUpDatabase();
        //$this->setUpMiddleware($this->app);

        Factory::guessFactoryNamesUsing(
            function (string $modelName) {
                return 'SiroDiaz\\Redirection\\Database\\Factories\\' . class_basename($modelName) . 'Factory';
            }
        );
    }

    /**
     * Define routes setup.
     *
     * @param  Router  $router
     *
     * @return void
     */
    protected function defineRoutes($router): void
    {
        $router->middleware(RedirectRequests::class)->get('old-url', function () {
            return '';
        });
        $router->middleware(RedirectRequests::class)->get('OLD-URL', function () {
            return '';
        });
        $router->middleware(RedirectRequests::class)->get('/new/url', function () {
            return '';
        });

        $router->middleware(RedirectRequests::class)->get('/1', function () {
            return '';
        });
        $router->middleware(RedirectRequests::class)->get('/2', function () {
            return '';
        });
        $router->middleware(RedirectRequests::class)->get('/3', function () {
            return '';
        });
        $router->middleware(RedirectRequests::class)->get('/4', function () {
            return '';
        });
    }

    protected function getPackageProviders($app): array
    {
        return [
            RedirectionServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ]);
    }

    public function setUpDatabase(): void
    {
        $migration = include __DIR__ . '/../database/migrations/create_redirections_table.php.stub';
        $migration->up();
    }
}
