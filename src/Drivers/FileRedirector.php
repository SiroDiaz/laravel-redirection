<?php

namespace SiroDiaz\Redirection\Drivers;

use SiroDiaz\Redirection\Contracts\Redirector;
use SiroDiaz\Redirection\Redirect;

class FileRedirector implements Redirector
{
    /** @var string */
    protected string $driver;

    public function __construct(string $driver = 'config')
    {
        $this->driver = $driver;
    }

    public function getRedirectFor(string $path): ?Redirect
    {
        $redirect = config(config("redirection.drivers.{$this->driver}.source"));

        if (false === config('redirection.case-sensitive')) {
            $redirect = array_change_key_case($redirect, CASE_LOWER);
            $path = strtolower($path);
        }

        if (! array_key_exists($path, $redirect)) {
            return null;
        }

        $redirect = $redirect[$path];
        // in case of associative array with redirection status code
        if (is_array($redirect)) {
            return new Redirect(
                $path,
                $redirect['new_url'],
                $redirect['status_code'] ?? config('redirection.default_status_code')
            );
        }

        return new Redirect(
            $path,
            $redirect,
            config('redirection.default_status_code'),
        );
    }
}
