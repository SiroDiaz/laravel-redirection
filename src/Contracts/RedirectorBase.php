<?php

namespace SiroDiaz\Redirection\Contracts;

use SiroDiaz\Redirection\Redirect;

interface RedirectorBase
{
    public function getRedirectFor(string $path): ?Redirect;
}
