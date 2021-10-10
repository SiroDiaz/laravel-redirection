<?php

namespace SiroDiaz\Redirection;

use Closure;

class RedirectRequests
{
    /**
     * Handle an incoming request.
     *
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $redirection = app('redirection.model')->findValidOrNull($request->path());

        if (!$redirection && $request->getQueryString()) {
            $path = $request->path().'?'.$request->getQueryString();
            $redirect = app('redirect.model')->findValidOrNull($path);
        }

        if ($redirection && $redirection->exists) {
            return redirect($redirection->new_url, $redirection->status);
        }

        return $next($request);
    }
}
