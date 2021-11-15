<?php

namespace SiroDiaz\Redirection;

use Closure;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;

class RedirectRequests
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws BindingResolutionException
     */
    public function handle(Request $request, Closure $next)
    {
        $driverName = config('redirection.driver');

        $redirectorDriverInstance = app()->make(
            config("redirection.drivers.{$driverName}.driver"),
            [$driverName],
        );
        $redirection = $redirectorDriverInstance->getRedirectFor($request->path());

        if (! $redirection && $request->getQueryString()) {
            $path = sprintf('%s?%s', $request->path(), $request->getQueryString());
            $redirection = $redirectorDriverInstance->getRedirectFor($path);
        }

        if ($redirection) {
            return redirect($redirection->newUrl, $redirection->statusCode);
        }

        return $next($request);
    }
}
