<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\SalesforceService;
use App\Jobs\PushLeadToSalesforce;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Exception;

class SalesforceController extends Controller
{
    protected SalesforceService $salesforceService;

    public function __construct(SalesforceService $salesforceService)
    {
        $this->salesforceService = $salesforceService;
    }

    /**
     * Create a Salesforce Lead via synchronous API call.
     */
    public function createLead(Request $request): JsonResponse
    {
        // Example Payload validation for a Lead
        $validatedData = $request->validate([
            'FirstName' => 'required|string|max:50',
            'LastName' => 'required|string|max:50',
            'Company' => 'required|string|max:100',
            'Email' => 'required|email',
            'Phone' => 'nullable|string',
        ]);

        try {
            $result = $this->salesforceService->createLead($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Lead created successfully',
                'data' => $result
            ], 201);
        } catch (Exception $e) {
            Log::error('SalesforceController: Error creating Lead', [
                'message' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create Lead in Salesforce',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a Salesforce Lead asynchronously via Queue Job.
     */
    public function createLeadAsync(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'FirstName' => 'required|string|max:50',
            'LastName' => 'required|string|max:50',
            'Company' => 'required|string|max:100',
            'Email' => 'required|email',
            'Phone' => 'nullable|string',
        ]);

        // Dispatch the job to handle API communication in the background
        PushLeadToSalesforce::dispatch($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Lead creation has been queued successfully.'
        ], 202);
    }

    /**
     * Create a Salesforce Contact.
     */
    public function createContact(Request $request): JsonResponse
    {
        // Example Payload validation for a Contact
        $validatedData = $request->validate([
            'FirstName' => 'required|string|max:50',
            'LastName' => 'required|string|max:50',
            'Email' => 'required|email',
        ]);

        try {
            $result = $this->salesforceService->createContact($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Contact created successfully',
                'data' => $result
            ], 201);
        } catch (Exception $e) {
            Log::error('SalesforceController: Error creating Contact', [
                'message' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create Contact in Salesforce',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ==========================================
    // Original Generic Service Handlers
    // ==========================================

    /**
     * Get Salesforce Accounts
     */
    public function accounts(): JsonResponse
    {
        try {
            $accounts = $this->salesforceService->query("SELECT Id, Name, Phone, Website FROM Account LIMIT 10");
            
            return response()->json([
                'success' => true,
                'data' => $accounts
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch accounts',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Execute SOQL query
     */
    public function query(Request $request): JsonResponse
    {
        $soql = $request->input('soql');
        
        if (!$soql) {
            return response()->json(['error' => 'SOQL query is required'], 400);
        }

        try {
            $result = $this->salesforceService->query($soql);
            return response()->json(['success' => true, 'data' => $result]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Query failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display a single record via Generic fetch
     */
    public function find(Request $request): JsonResponse
    {
        $sobject = $request->input('sobject');
        $id = $request->input('id');

        if (!$sobject || !$id) {
            return response()->json(['error' => 'sobject and id are required'], 400);
        }

        try {
            $result = $this->salesforceService->find($sobject, $id);
            return response()->json(['success' => true, 'data' => $result]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Record retrieval failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Force refresh the OAuth token
     */
    public function refreshToken(): JsonResponse
    {
        try {
            $this->salesforceService->clearCache();
            $auth = $this->salesforceService->authenticate();
            
            return response()->json([
                'success' => true,
                'message' => 'Token refreshed successfully',
                'access_token' => $auth['access_token'],
                'instance_url' => $auth['instance_url']
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Token refresh failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}