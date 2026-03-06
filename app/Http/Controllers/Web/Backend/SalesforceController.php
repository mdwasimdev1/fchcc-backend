<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SalesforceAuthController extends Controller
{

    // Step 1: Redirect to Salesforce
    public function redirect()
    {
        $query = http_build_query([
            'client_id' => config('services.salesforce.client_id'),
            'redirect_uri' => config('services.salesforce.redirect'),
            'response_type' => 'code'
        ]);

        return redirect(config('services.salesforce.login_url').'/services/oauth2/authorize?'.$query);
    }


    // Step 2: Callback from Salesforce
    public function callback(Request $request)
    {

        $response = Http::asForm()->post(
            config('services.salesforce.login_url').'/services/oauth2/token',
            [
                'grant_type' => 'authorization_code',
                'client_id' => config('services.salesforce.client_id'),
                'client_secret' => config('services.salesforce.client_secret'),
                'redirect_uri' => config('services.salesforce.redirect'),
                'code' => $request->code
            ]
        );

        $data = $response->json();

        return $data;
    }
}