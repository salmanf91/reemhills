<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SalesforceController extends Controller
{
    public static function getToken()
    {
        $client = new \GuzzleHttp\Client([
            'verify' => false
        ]);
        
        // try {
        //     $response = $client->post('https://test.salesforce.com/services/oauth2/token?grant_type=password'
        //         . '&client_id=3MVG9buXpECUESHjyehPOUn_8aSfVKoQzcXCP6J4z3dPTfQU1HQx2D6mMxRk8ZJhbdEOH7sKvjGYyzJvApKGL'
        //         . '&client_secret=CFD17539159B232D752C5FBA1002FD05D8BA30D4FDBF94DBDB04F8300C926E26'
        //         . '&username=deb@aphidas.com.rdc.prod.albarari'
        //         . '&password=Aphidas@20303kDFvbeoeJBaf8XX7XRaqnD7g'
        //     );
    // public function getToken()
    // {
    //     $client = new Client();
        
        try {
            $response = $client->post('SALESFORCE_AUTH_URL', [
                'json' => [
                    'grant_type' => 'password',
                    'client_id' => '3MVG9buXpECUESHjyehPOUn_8aSfVKoQzcXCP6J4z3dPTfQU1HQx2D6mMxRk8ZJhbdEOH7sKvjGYyzJvApKGL',
                    'client_secret' => 'CFD17539159B232D752C5FBA1002FD05D8BA30D4FDBF94DBDB04F8300C926E26',
                    'username' => 'deb@aphidas.com.rdc.prod.albarari',
                    'password' => 'Aphidas@20303kDFvbeoeJBaf8XX7XRaqnD7g'
                ]
            ]);
            
            $data = json_decode($response->getBody()->getContents(), true);
            $token = $data['access_token'];
            
            return $token;
            
        } catch (\Exception $e) {
            dd($e);
            return null;
        }
    }

    public static function postData($data)
    {
        $token = self::getToken();
    public function postData(Request $request)
    {
        $token = $this->getToken();
        
        if ($token) {
            $client = new Client();
            
            try {
                $response = $client->post('https://alqudra--albarari.sandbox.my.salesforce.com/services/apexrest/rdc', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Content-Type' => 'application/json'
                    ],
                    'json' => $data,
                    'verify' => false
                ]);
                
                $data = json_decode($response->getBody()->getContents(), true);
                // Process response data as needed
                
                return response()->json($data);
                
            } catch (\Exception $e) {
                // Handle exception
                return response()->json(['error' => $e->getMessage()], 500);
            }
        } else {
            return response()->json(['error' => 'Failed to get token'], 500);
        }
    }
}
