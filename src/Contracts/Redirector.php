<?php

namespace SiroDiaz\Redirection\Contracts;

use SiroDiaz\Redirection\Redirect;

interface Redirector
{
    public function getRedirectFor(string $path): ?Redirect;
}
