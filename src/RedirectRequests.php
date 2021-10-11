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
        $redirection = app()->make(config('redirection.model'))->findValidOrNull($request->path());
        // dd(app()->make(config('redirection.model'))->findValidOrNull($request->path()));
        if (! $redirection && $request->getQueryString()) {
            $path = sprintf('%s?%s', $request->path(), $request->getQueryString());
            $redirection = app()->make(config('redirection.model'))->findValidOrNull($path);
        }

        if ($redirection && $redirection->exists) {
            return redirect($redirection->new_url, $redirection->status_code);
        }

        return $next($request);
    }
}
