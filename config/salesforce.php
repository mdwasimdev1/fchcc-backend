<?php

return [
    'client_id' => env('SALESFORCE_CLIENT_ID'),
    'client_secret' => env('SALESFORCE_CLIENT_SECRET'),
    'username' => env('SALESFORCE_USERNAME'),
    'password' => env('SALESFORCE_PASSWORD'),
    'security_token' => env('SALESFORCE_SECURITY_TOKEN', ''),
    'login_url' => env('SALESFORCE_LOGIN_URL', 'https://login.salesforce.com'),
    'api_version' => env('SALESFORCE_API_VERSION', 'v60.0'),
    'timeout' => env('SALESFORCE_TIMEOUT', 30),
];
