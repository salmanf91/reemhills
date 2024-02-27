<?php
// Path: config/epg.php
// Store the Etisalat payment gateway credentials

return [
    'sandbox' => [
        'token_url' => env('SALESFORCE_TOKEN_URL'),
        'client_id' => env('SALESFORCE_CLIENT_ID'),
        'client_secret' => env('SALESFORCE_CLIENT_SECRET'),
        'username' => env('SALESFORCE_USERNAME'),
        'password' => env('SALESFORCE_PASSWORD'),
        'api_url' => env('SALESFORCE_API_URL')
    ],
    'production' => [
        'token_url' => env('SALESFORCE_TOKEN_URL'),
        'client_id' => env('SALESFORCE_CLIENT_ID'),
        'client_secret' => env('SALESFORCE_CLIENT_SECRET'),
        'username' => env('SALESFORCE_USERNAME'),
        'password' => env('SALESFORCE_PASSWORD'),
        'api_url' => env('SALESFORCE_API_URL')
    ]
];
?>