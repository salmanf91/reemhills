<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\{Buyer, BuyerRelationship, BuyerPayment};

class SalesForceController extends Controller
{
    public static function makeHttpRequest($client, $jsonData)
    {
        //dd($jsonData);
        self::initialize();
        return $client->request('POST', self::$epgUrl. ':' .self::$epgPort, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'verify' => false,
            'json' => $jsonData,
        ]);
    }
}