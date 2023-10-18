<?php

namespace App\Console\Commands;

use App\Jobs\PerformEndpointChecks;
use App\Models\Endpoint;
use Illuminate\Console\Command;

class PerformChecks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:perform-checks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perform endpoint checks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $endpoints = Endpoint::where('next_check', '<=', now())->each(function ($endpoint) {
            PerformEndpointChecks::dispatch($endpoint);
        });

        return Command::SUCCESS;
    }
}
