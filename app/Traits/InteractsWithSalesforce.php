<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\PendingRequest;

/**
 * Trait InteractsWithSalesforce
 * 
 * Provides a reusable base HTTP client configured for Salesforce API calls,
 * including timeout and automatic retry logic for transient errors and rate limits.
 */
trait InteractsWithSalesforce
{
    /**
     * Get an HTTP client pre-configured for Salesforce API communication.
     *
     * @param string $token
     * @param string $instanceUrl
     * @return PendingRequest
     */
    protected function getHttpClient(string $token, string $instanceUrl): PendingRequest
    {
        $timeout = config('salesforce.timeout', 30);
        $apiVersion = config('salesforce.api_version', 'v60.0');
        
        return Http::withToken($token)
            ->baseUrl("{$instanceUrl}/services/data/{$apiVersion}")
            ->timeout($timeout)
            ->retry(3, 1000, function ($exception, $request) {
                // Retry specifically on Rate Limit (429) or Server Errors (500+)
                if ($exception instanceof \Illuminate\Http\Client\RequestException) {
                    $status = $exception->response->status();
                    if ($status === 429 || $status >= 500) {
                        Log::warning('Retrying Salesforce API call', [
                            'url' => $request->url(),
                            'status' => $status
                        ]);
                        return true;
                    }
                }
                return false;
            })
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]);
    }
}
