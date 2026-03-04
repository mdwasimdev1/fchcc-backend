<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Forrest;

class SalesforceController extends Controller
{
    /**
     * Redirect user to Salesforce OAuth login (if WebServer flow)
     */
    public function connect()
    {
        if (config('forrest.authentication') === 'WebServer') {
            return Forrest::authenticate();
        }

        return response()->json(['message' => 'Using Password Grant, no user login required']);
    }

    /**
     * Handle OAuth callback
     */
    public function callback()
    {
        if (config('forrest.authentication') === 'WebServer') {
            Forrest::callback();
            return redirect('/salesforce/accounts');
        }

        return response()->json(['error' => 'Not using WebServer authentication']);
    }

    /**
     * Fetch Salesforce Accounts
     */
    public function accounts()
    {
        try {
            $accounts = Forrest::query("SELECT Id, Name FROM Account LIMIT 10");
            return response()->json($accounts);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
