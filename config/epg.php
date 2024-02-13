<?php 
// Path: config/epg.php
// Store the Etisalat payment gateway credentials 
return [
    'sandbox' => [
        'url' => env('EPG_SANDBOX'),
        'port' => env('EPG_SANDBOX_PORT'),
    ],
    'production' => [
        'url' => env('EPG_PRODUCTION'),
        'port' => env('EPG_PRODUCTION_PORT'),
    ],

    'reg_currency' => 'AED',
    'reg_return_url' => env('APP_URL').'/payment/finalization',
    'reg_transaction_hint' => 'CPT:Y;VCC:Y;',
    'reg_store' => '0000',
    'reg_terminal' => '0000',
    'reg_channel' => 'Web',
    'reg_customer' => 'Demo Merchant',
    'reg_order_name' => 'Paybill',
     
    'username' => 'Demo_fY9c',
    'password' => 'Comtrust@20182018',
];
?>