<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\SalesforceService;
use Illuminate\Http\Request;

class SalesforceController extends Controller
{
    protected $salesforceService;

    public function __construct(SalesforceService $salesforceService)
    {
        $this->salesforceService = $salesforceService;
    }

    /**
     * Get Salesforce Accounts
     */
    public function accounts()
    {
        try {
            $accounts = $this->salesforceService->query("SELECT Id, Name, Phone, Website FROM Account LIMIT 10");
            return response()->json([
                'success' => true,
                'data' => $accounts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch accounts',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Execute SOQL query
     */
    public function query(Request $request)
    {
        $soql = $request->input('soql');
        if (!$soql) {
            return response()->json(['error' => 'SOQL query is required'], 400);
        }

        try {
            $result = $this->salesforceService->query($soql);
            return response()->json(['success' => true, 'data' => $result]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Query failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create Salesforce Record
     */
    public function create(Request $request)
    {
        $sobject = $request->input('sobject');
        $data = $request->input('data');

        if (!$sobject || !$data) {
            return response()->json([
                'error' => 'sobject and data are required'
            ], 400);
        }

        try {
            $result = $this->salesforceService->create($sobject, $data);
            return response()->json([
                'success' => true,
                'message' => 'Record created successfully',
                'data' => $result
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Record creation failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update Salesforce Record
     */
    public function update(Request $request)
    {
        $sobject = $request->input('sobject');
        $id = $request->input('id');
        $data = $request->input('data');

        if (!$sobject || !$id || !$data) {
            return response()->json([
                'error' => 'sobject, id, and data are required'
            ], 400);
        }

        try {
            $result = $this->salesforceService->update($sobject, $id, $data);
            return response()->json([
                'success' => true,
                'message' => 'Record updated successfully',
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Record update failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Salesforce Record
     */
    public function find(Request $request)
    {
        $sobject = $request->input('sobject');
        $id = $request->input('id');

        if (!$sobject || !$id) {
            return response()->json([
                'error' => 'sobject and id are required'
            ], 400);
        }

        try {
            $result = $this->salesforceService->find($sobject, $id);
            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Record retrieval failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Refresh Token
     */
    public function refreshToken()
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
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Token refresh failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}