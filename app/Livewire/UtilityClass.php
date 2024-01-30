<?php

namespace App\Livewire;

use Livewire\Component;
use GuzzleHttp\Client;

class UtilityClass extends Component
{
    const EPG_SANDBOX_URL = 'https://demo-ipg.comtrust.ae';
    const EPG_SANDBOX_PORT = '2443';
    const EPG_PRODUCTION_URL = 'https://ipg.comtrust.ae';
    const EPG_PRODUCTION_PORT = '2443';

    public static function customerRegistration($cusomerData)
    {
        $client = new Client();
        $jsonData = [
            'Registration' => [
                'Currency' => 'AED',
                'ReturnPath' => 'http://127.0.0.1:8001',
                'TransactionHint' => 'CPT:Y;VCC:Y;',
                'OrderID' => $cusomerData->order_id ?? (date('Ymdh') . rand(0, 1000)),
                'Store' => '0000',
                'Terminal' => '0000',
                'Channel' => 'Web',
                'Amount' => $cusomerData->amount ?? 0,
                'Customer' => $cusomerData->buyers_name ?? 'Buyer',
                'OrderName' => 'Paybill',
                'UserName' => 'Demo_fY9c',
                'Password' => 'Comtrust@20182018',
            ],
        ];

        $response = $client->request('POST', self::EPG_SANDBOX_URL . ':' . self::EPG_SANDBOX_PORT, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'verify' => false,
            'json' => $jsonData,
        ]);

        return json_decode($response->getBody()->getContents());
    }



}
