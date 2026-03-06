<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SalesforceAuthController extends Controller
{
    // Step 1: Redirect user to Salesforce login
    public function redirect()
    {
        // 1️⃣ Generate PKCE code verifier & code challenge
        $codeVerifier = bin2hex(random_bytes(64));
        $codeChallenge = strtr(
            rtrim(base64_encode(hash('sha256', $codeVerifier, true)), '='),
            '+/',
            '-_'
        );
        session(['salesforce_code_verifier' => $codeVerifier]);

        // 2️⃣ Build query
        $query = http_build_query([
            'client_id' => config('services.salesforce.client_id'),
            'redirect_uri' => config('services.salesforce.redirect'),
            'response_type' => 'code',
            'code_challenge' => $codeChallenge,
            'code_challenge_method' => 'S256',
            'scope' => 'full refresh_token id email profile'
        ]);

        return redirect(config('services.salesforce.login_url') . '/services/oauth2/authorize?' . $query);
    }

    // Step 2: Callback from Salesforce
    public function callback(Request $request)
    {
        $codeVerifier = session('salesforce_code_verifier');

        $response = Http::asForm()->post(
            config('services.salesforce.login_url') . '/services/oauth2/token',
            [
                'grant_type' => 'authorization_code',
                'client_id' => config('services.salesforce.client_id'),
                'redirect_uri' => config('services.salesforce.redirect'),
                'code' => $request->code,
                'code_verifier' => $codeVerifier,
            ]
        );

        $data = $response->json();

        // Optional: save in DB or session
        session(['salesforce_token' => $data]);

        return response()->json($data);
    }
}