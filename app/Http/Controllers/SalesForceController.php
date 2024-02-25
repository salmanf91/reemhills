<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SalesforceController extends Controller
{
    
    public static function getToken()
    {
        $client = new Client();

        try {
            $response = $client->post(env('SALESFORCE_TOKEN_URL'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => env('SALESFORCE_CLIENT_ID'),
                    'client_secret' => env('SALESFORCE_CLIENT_SECRET'),
                    'username' => env('SALESFORCE_USERNAME'),
                    'password' => env('SALESFORCE_PASSWORD')
                ],
                'verify' => false
            ]);
            
            $data = json_decode($response->getBody()->getContents(), true);
            $token = $data['access_token'];
            
            return $token;
            
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function postData($data)
    {
        $token = self::getToken();

        if ($token) {
            $client = new Client();
            
            try {

                $response = $client->post(env('SALESFORCE_API_URL'), [
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
