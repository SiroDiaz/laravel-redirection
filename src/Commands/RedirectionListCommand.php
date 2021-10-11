<?php

namespace SiroDiaz\Redirection\Commands;

use Illuminate\Console\Command;

class RedirectionListCommand extends Command
{
    public $signature = 'redirection:list';

    public $description = 'List all redirections in the console';

    public function handle(): void
    {
        $this->comment('All done');
    }
}
