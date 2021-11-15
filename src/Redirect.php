<?php

namespace SiroDiaz\Redirection;

class Redirect
{
    /** @var string */
    public string $oldUrl;

    /** @var string */
    public string $newUrl;

    /** @var int */
    public int $statusCode;

    public function __construct($oldUrl, $newUrl, $statusCode)
    {
        $this->oldUrl = $oldUrl;
        $this->newUrl = $newUrl;
        $this->statusCode = $statusCode;
    }
}
