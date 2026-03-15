<?php

namespace App\Jobs;

use App\Services\SalesforceService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
// uncomment and implement if you wish to apply Rate Limiting on jobs
// use Illuminate\Queue\Middleware\RateLimited; 
use Illuminate\Support\Facades\Log;
use Exception;

class PushLeadToSalesforce implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     * Salesforce API transient issues will cause the job to retry up to 3 times.
     */
    public int $tries = 3;

    /**
     * Payload to be pushed to Salesforce as a new Lead
     */
    protected array $leadData;

    /**
     * Create a new job instance.
     */
    public function __construct(array $leadData)
    {
        $this->leadData = $leadData;
    }

    /**
     * Execute the job.
     */
    public function handle(SalesforceService $salesforce): void
    {
        try {
            $response = $salesforce->createLead($this->leadData);
            
            Log::info('Successfully queued a Lead creation event to Salesforce', [
                'salesforce_id' => $response['id'] ?? null
            ]);
        } catch (Exception $e) {
            Log::error('Queue: Failed to push Lead to Salesforce', [
                'message' => $e->getMessage(),
                'data' => $this->leadData
            ]);
            
            // Re-throw so Laravel's queue worker will mark it failed and naturally retry it via the retry logic
            throw $e;
        }
    }

    /**
     * Custom backoff algorithm for failed events. 
     * Retries after 10s, then 30s, then 60s.
     *
     * @return array<int, int>
     */
    public function backoff(): array
    {
        return [10, 30, 60];
    }

    /**
     * Get the middleware the job should pass through.
     * Allows optional implementation of a Redis rate limiter to prevent 100+ requests/second.
     *
     * @return array<int, object>
     */
    /*
    public function middleware(): array
    {
        // Require rate limiter configured in AppServiceProvider (e.g. RateLimiter::for('salesforce', function() { ... }))
        // return [new RateLimited('salesforce')];
        return [];
    }
    */
}
