<?php
// Path: config/epg.php
// Store the Etisalat payment gateway credentials

// SALESFORCE_TOKEN_URL=https://test.salesforce.com/services/oauth2/token
// SALESFORCE_CLIENT_ID=3MVG9buXpECUESHjyehPOUn_8aSfVKoQzcXCP6J4z3dPTfQU1HQx2D6mMxRk8ZJhbdEOH7sKvjGYyzJvApKGL
// SALESFORCE_CLIENT_SECRET=CFD17539159B232D752C5FBA1002FD05D8BA30D4FDBF94DBDB04F8300C926E26
// SALESFORCE_USERNAME=deb@aphidas.com.rdc.prod.albarari
// SALESFORCE_PASSWORD=Aphidas@20303kDFvbeoeJBaf8XX7XRaqnD7g
// SALESFORCE_API_URL=https://alqudra--albarari.sandbox.my.salesforce.com/services/apexrest/rdc

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