<?php

namespace App\Jobs;

use App\Events\EndpointRecovered;
use App\Events\EndpointWentDown;
use App\Models\Endpoint;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class PerformEndpointChecks implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Endpoint $endpoint)
    {
        //
    }

    public function uniqueId()
    {
        return 'endpoint_check_' . $this->endpoint->id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $response = Http::get($this->endpoint->url());
        } catch (Exception $e) {
            //
        }

        $check = $this->endpoint->checks()->create([
            'response_code' => $response->status(),
            'response_body' => !$response->successful() ? $response->body() : null,
        ]);

        if (
            !$check->isSuccessful() &&
            ($check->previous()?->isSuccessful() || $check->endpoint->checks->count() === 1)
        ) {
            EndpointWentDown::dispatch($check);
        }

        if (
            $check->isSuccessful() &&
            !$check->previous()?->isSuccessful() && $check->endpoint->checks->count() !== 1
        ) {
            EndpointRecovered::dispatch($check);
        }

        $this->endpoint->update([
            'next_check' => now()->addSeconds($this->endpoint->frequency),
        ]);
    }
}
