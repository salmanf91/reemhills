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

    public function customerRegistration($cusomerData)
    {
        $client = new Client();

        $response = $client->request('POST', self::EPG_SANDBOX_URL . ':' . self::EPG_SANDBOX_PORT, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'verify' => false,
            'json' => [
                'Registration' => [
                    'Currency' => 'AED',
                    'ReturnPath' => 'https://www.google.com/?client=safari',
                    'TransactionHint' => 'CPT:Y;VCC:Y;',
                    'OrderID' => '7210055701315195',
                    'Store' => '0000',
                    'Terminal' => '0000',
                    'Channel' => 'Web',
                    'Amount' => '10.00',
                    'Customer' => 'Demo Merchant',
                    'OrderName' => 'Paybill',
                    'UserName' => 'Demo_fY9c',
                    'Password' => 'Comtrust@20182018',
                ],
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }



}
