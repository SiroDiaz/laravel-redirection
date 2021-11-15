<?php

namespace SiroDiaz\Redirection\Drivers;

use SiroDiaz\Redirection\Contracts\Redirector;
use SiroDiaz\Redirection\Redirect;

class DatabaseRedirector implements Redirector
{
    /** @var string */
    protected string $driver;

    public function __construct(string $driver = 'database')
    {
        $this->driver = $driver;
    }

    public function getRedirectFor(string $path): ?Redirect
    {
        $model = app()->make(
            config("redirection.drivers.{$this->driver}.source"),
            [$this->driver],
        );

        $redirect = $model->findValidOrNull($path);

        return $redirect !== null
            ? new Redirect($redirect->old_url, $redirect->new_url, $redirect->status_code)
            : null;
    }
}
