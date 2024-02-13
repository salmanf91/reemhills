<?php

namespace App\Livewire;

use Livewire\Component;
use GuzzleHttp\Client;

class UtilityClass extends Component
{
    // const EPG_SANDBOX_URL = 'https://demo-ipg.comtrust.ae';
    // const EPG_SANDBOX_PORT = '2443';
    // const EPG_PRODUCTION_URL = 'https://ipg.comtrust.ae';
    // const EPG_PRODUCTION_PORT = '2443';

    public static function customerRegistration($cusomerData)
    {
        $client = new Client();
        $jsonData = [
            'Registration' => [
                'Currency' => 'AED',
                'ReturnPath' => env('APP_URL').'/payment/finalization?order_id='.$cusomerData->order_id,
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

        $response = $client->request('POST', config('epg.sandbox.url') . ':' . config('epg.sandbox.port'), [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'verify' => false,
            'json' => $jsonData,
        ]);

        return json_decode($response->getBody()->getContents());
    }
    public static function customerRegistrationOld($cusomerData)
    {
        $client = new Client();
        $jsonData = [
            'Registration' => [
                'Currency' => 'AED',
                'ReturnPath' => config('epg.reg_return_url').'?order_id='.$cusomerData->order_id,
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

        $response = $client->request('POST', config('epg.sandbox.url') . ':' . config('epg.sandbox.port'), [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'verify' => false,
            'json' => $jsonData,
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function finalizePaymentOld(Request $request)
    {
        if (!$request->order_id) {
            // TODO: redirect to error page that says NO orderId found EPG payment finalization
            dd('NO orderId found EPG payment finalization');
            return;
        }
        $orderId = $request->order_id;
        $buyer = Buyer::where('order_id', $orderId)->first();
        if (!$buyer || !$buyer->transaction_id) {
            //TODO: redirect to error page that says NO buyer found EPG payment finalization
            dd('NO buyer found EPG payment finalization');
            return;
        }
        $transactionId = $buyer->transaction_id;

        $client = new Client();
        $response = $client->request('POST', config('epg.sandbox.url') . ':' . config('epg.sandbox.port'), [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'verify' => false,
            'json' => [
                'Finalization' => [
                    'TransactionID' => $transactionId,
                    "Customer"=>"Demo Merchant",
                    "UserName"=>"Demo_fY9c",
                    "Password"=>"Comtrust@20182018"
                ],
            ],
        ]);

        $epgResponse = json_decode($response->getBody()->getContents());
        
        if(isset($epgResponse->Transaction->ResponseCode) && $epgResponse->Transaction->ResponseCode == BuyerPayment::PAYMENT_STATUS_SUCCESS){
            $buyerPayment = BuyerPayment::create([
                'buyer_id' => $buyer->id,
                'transaction_id' => $transactionId,
                'payment_status' => $epgResponse->Transaction->ResponseCode,
                'epg_json_response' => json_encode($epgResponse),
            ]);
        }elseif(isset($epgResponse->Transaction)){
            $buyerPayment = BuyerPayment::create([
                'buyer_id' => $buyer->id,
                'transaction_id' => $transactionId,
                'payment_status' => $epgResponse->Transaction->ResponseCode ?? null,
                'epg_json_response' => json_encode($epgResponse),
            ]);
        }else{
            //TODO: redirect to error page that payment failed
            dd('Payment failed');
            return;
        }

        dd('Payment successfull');
        return redirect()->route('payment.success');
    }



}
