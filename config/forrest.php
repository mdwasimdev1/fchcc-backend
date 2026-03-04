<?php

return [

    'authentication' => env('FORREST_AUTHENTICATION', 'UserPassword'),
    
    'consumerKey' => env('SALESFORCE_CLIENT_ID', ''),
    'consumerSecret' => env('SALESFORCE_CLIENT_SECRET', ''),
    
    'username' => env('SALESFORCE_USERNAME', ''),
    'password' => env('SALESFORCE_PASSWORD', ''),
    
    'loginURL' => env('SALESFORCE_LOGIN_URL', 'https://login.salesforce.com'),
    'version' => env('SALESFORCE_API_VERSION', '57.0'),
    
    // For WebServer/OAuth flow
    'callbackURI' => env('SALESFORCE_REDIRECT_URI', ''),
    
    // Cache configuration for tokens
    'cache' => true,
    'cacheDriver' => 'file',

];

