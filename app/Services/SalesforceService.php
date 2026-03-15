<?php

namespace App\Services;

use App\Traits\InteractsWithSalesforce;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\RequestException;
use Exception;

class SalesforceService
{
    use InteractsWithSalesforce;

    protected string $cacheKey = 'salesforce_auth_token';

    /**
     * Authenticate and retrieve the access token and instance URL.
     * Caches the token to avoid re-authenticating on every request.
     *
     * @return array Contains 'access_token' and 'instance_url'
     * @throws Exception
     */
    public function authenticate(): array
    {
        // Try locking the auth request to prevent a stampede if multiple requests trigger auth concurrently
        return Cache::lock('salesforce_auth_lock', 10)->block(5, function () {
            // Check if token exists in cache
            if (Cache::has($this->cacheKey)) {
                return Cache::get($this->cacheKey);
            }

            $loginUrl = config('salesforce.login_url') . '/services/oauth2/token';
            $password = config('salesforce.password') . config('salesforce.security_token');

            try {
                $response = Http::asForm()->post($loginUrl, [
                    'grant_type' => 'password',
                    'client_id' => config('salesforce.client_id'),
                    'client_secret' => config('salesforce.client_secret'),
                    'username' => config('salesforce.username'),
                    'password' => $password,
                ]);

                if ($response->failed()) {
                    Log::error('Salesforce Authentication Failed', [
                        'status' => $response->status(),
                        'body' => $response->body()
                    ]);
                    throw new Exception('Salesforce authentication failed: ' . $response->body());
                }

                $data = $response->json();
                
                $authData = [
                    'access_token' => $data['access_token'],
                    'instance_url' => $data['instance_url'],
                ];

                // Cache the token slightly less than the expiration time (default Salesforce lifetime is ~120 min)
                Cache::put($this->cacheKey, $authData, now()->addMinutes(110));

                return $authData;
            } catch (Exception $e) {
                Log::error('Salesforce Auth Exception', ['message' => $e->getMessage()]);
                throw $e;
            }
        });
    }

    /**
     * Helper function to get the current Salesforce instance URL dynamically.
     *
     * @return string
     */
    public function getInstanceUrl(): string
    {
        $auth = $this->authenticate();
        return $auth['instance_url'];
    }

    /**
     * Clear cached token (e.g., if token is revoked or needed to force refresh).
     *
     * @return void
     */
    public function clearCache(): void
    {
        Cache::forget($this->cacheKey);
    }

    /**
     * Execute an API call to Salesforce with auto-retry on 401 Unauthorized (Expired Token).
     */
    protected function makeApiRequest(string $method, string $endpoint, array $data = [])
    {
        try {
            return $this->attemptApiRequest($method, $endpoint, $data);
        } catch (RequestException $e) {
            // Catch 401 Unauthorized which means the token likely expired
            if ($e->response->status() === 401) {
                Log::info('Salesforce token expired. Clearing cache and re-authenticating.');
                $this->clearCache();
                
                // Retry request with fresh token
                return $this->attemptApiRequest($method, $endpoint, $data);
            }
            
            throw $e;
        }
    }

    /**
     * Core helper to perform the HTTP request.
     */
    private function attemptApiRequest(string $method, string $endpoint, array $data = [])
    {
        $auth = $this->authenticate();
        
        $client = $this->getHttpClient($auth['access_token'], $auth['instance_url']);

        if ($method === 'get' || $method === 'delete') {
            $response = $client->{$method}("sobjects/{$endpoint}", $data);
        } else {
            $response = $client->{$method}("sobjects/{$endpoint}", $data);
        }

        // Throw an exception if a client or server error occurred
        $response->throw();

        return $response->json();
    }

    /**
     * Create a new Lead in Salesforce.
     *
     * @param array $data Map of Salesforce Lead fields
     * @return array
     */
    public function createLead(array $data): array
    {
        return $this->makeApiRequest('post', 'Lead', $data);
    }

    /**
     * Create a new Contact in Salesforce.
     *
     * @param array $data Map of Salesforce Contact fields
     * @return array
     */
    public function createContact(array $data): array
    {
        return $this->makeApiRequest('post', 'Contact', $data);
    }

    /**
     * Create a new Account in Salesforce.
     *
     * @param array $data Map of Salesforce Account fields
     * @return array
     */
    public function createAccount(array $data): array
    {
        return $this->makeApiRequest('post', 'Account', $data);
    }

    /**
     * Create a new Opportunity in Salesforce.
     *
     * @param array $data Map of Salesforce Opportunity fields
     * @return array
     */
    public function createOpportunity(array $data): array
    {
        return $this->makeApiRequest('post', 'Opportunity', $data);
    }

    // ==========================================
    // Legacy support methods from Forrest plugin
    // ==========================================

    /**
     * Backwards compatibility for raw queries
     */
    public function query(string $soql)
    {
        $auth = $this->authenticate();
        $client = $this->getHttpClient($auth['access_token'], $auth['instance_url']);
        
        $response = $client->get("query", ['q' => $soql]);
        $response->throw();
        
        return $response->json();
    }

    /**
     * Backwards compatibility for generic resource creation
     */
    public function create(string $sobject, array $data)
    {
        return $this->makeApiRequest('post', $sobject, $data);
    }

    /**
     * Backwards compatibility for generic resource update
     */
    public function update(string $sobject, string $id, array $data)
    {
        return $this->makeApiRequest('patch', "{$sobject}/{$id}", $data);
    }

    /**
     * Backwards compatibility for single resource retrieval
     */
    public function find(string $sobject, string $id, array $fields = null)
    {
        $endpoint = "{$sobject}/{$id}";
        
        // Use general attempt instead of standard makeApiRequest because this is a GET
        $auth = $this->authenticate();
        $client = $this->getHttpClient($auth['access_token'], $auth['instance_url']);
        
        $params = [];
        // Support custom fields
        if ($fields) {
            $params['fields'] = implode(',', $fields);
        }

        $response = $client->get("sobjects/{$endpoint}", $params);
        $response->throw();
        
        return $response->json();
    }
}
