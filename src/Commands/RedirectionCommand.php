<?php

namespace SiroDiaz\Redirection\Commands;

use Illuminate\Console\Command;

class RedirectionCommand extends Command
{
    public $signature = 'skeleton';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
