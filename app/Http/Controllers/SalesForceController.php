<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SalesforceController extends Controller
{    
    public static $token_url;
    public static $client_id;
    public static $client_secret;
    public static $username;
    public static $password;
    public static $api_url;
    
    public static function initialize()
    {
        self::$token_url = config('sfconfig.sandbox.token_url');
        self::$client_id = config('sfconfig.sandbox.client_id');
        self::$client_secret = config('sfconfig.sandbox.client_secret');
        self::$username = config('sfconfig.sandbox.username');
        self::$password = config('sfconfig.sandbox.password');
        self::$api_url = config('sfconfig.sandbox.api_url');

    }

    public static function getToken()
    {
        self::initialize();
        $client = new Client();
           
        try {
            $response = $client->post(self::$token_url, [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => self::$client_id,
                    'client_secret' => self::$client_secret,
                    'username' => self::$username,
                    'password' => self::$password
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
        dd($data);
        $token = self::getToken();
        if ($token) {
            $client = new Client();
            
            try {

                $response = $client->post(self::$api_url, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json'
                    ],
                    'json' => $data,
                    'verify' => false
                ]);
                
                $data = json_decode($response->getBody()->getContents(), true);
                dd($data);
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
