<?php

namespace Morrislaptop\LaravelPulse4xx\Commands;

use Illuminate\Console\Command;

class LaravelPulse4xxCommand extends Command
{
    public $signature = 'laravel-pulse-4xx';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
