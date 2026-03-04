<?php

namespace App\Services;

use Forrest;
use Illuminate\Support\Facades\Cache;

class SalesforceService
{
    const TOKEN_CACHE_KEY = 'salesforce_token';
    const INSTANCE_URL_CACHE_KEY = 'salesforce_instance_url';

    /**
     * Authenticate with Salesforce using UserPassword flow
     */
    public function authenticate()
    {
        try {
            // Check if we already have a cached token
            $token = Cache::get(self::TOKEN_CACHE_KEY);
            $instanceUrl = Cache::get(self::INSTANCE_URL_CACHE_KEY);

            if ($token && $instanceUrl) {
                return [
                    'access_token' => $token,
                    'instance_url' => $instanceUrl,
                    'cached' => true
                ];
            }

            // Authenticate with Salesforce
            Forrest::authenticate();

            // Get token from Forrest
            $accessToken = Forrest::getAccessToken();
            $instanceUrl = Forrest::getInstanceURL();

            // Cache the token for 1 hour
            Cache::put(self::TOKEN_CACHE_KEY, $accessToken, now()->addHour());
            Cache::put(self::INSTANCE_URL_CACHE_KEY, $instanceUrl, now()->addHour());

            return [
                'access_token' => $accessToken,
                'instance_url' => $instanceUrl,
                'cached' => false
            ];
        } catch (\Exception $e) {
            throw new \Exception('Salesforce authentication failed: ' . $e->getMessage());
        }
    }

    /**
     * Execute SOQL query
     */
    public function query($soql)
    {
        try {
            $this->authenticate(); // Ensure auth before query
            $result = Forrest::query($soql);
            return $result;
        } catch (\Exception $e) {
            throw new \Exception('SOQL query failed: ' . $e->getMessage());
        }
    }

    /**
     * Create a Salesforce record
     */
    public function create($sobject, $data)
    {
        try {
            $this->authenticate(); // Ensure auth before create
            $result = Forrest::create($sobject, $data);
            return $result;
        } catch (\Exception $e) {
            throw new \Exception('Record creation failed: ' . $e->getMessage());
        }
    }

    /**
     * Update a Salesforce record
     */
    public function update($sobject, $id, $data)
    {
        try {
            $this->authenticate(); // Ensure auth before update
            $result = Forrest::update($sobject, $id, $data);
            return $result;
        } catch (\Exception $e) {
            throw new \Exception('Record update failed: ' . $e->getMessage());
        }
    }

    /**
     * Get Salesforce records
     */
    public function find($sobject, $id, $fields = null)
    {
        try {
            $this->authenticate(); // Ensure auth before find
            $result = Forrest::find($sobject, $id, $fields);
            return $result;
        } catch (\Exception $e) {
            throw new \Exception('Record retrieval failed: ' . $e->getMessage());
        }
    }

    /**
     * Clear cached tokens
     */
    public function clearCache()
    {
        Cache::forget(self::TOKEN_CACHE_KEY);
        Cache::forget(self::INSTANCE_URL_CACHE_KEY);
    }
}
