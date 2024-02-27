<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\{Buyer, BuyerRelationship, BuyerPayment, GenericAttribute};
use App\Utilities\EmailUtility;
use Illuminate\Support\Facades\Mail;

class EpgPaymentController extends Controller
{
    public static $epgUrl;
    public static $epgPort;
    public static $flag;

    public static function initialize()
    {
        self::$epgUrl = config('epg.sandbox.url');
        self::$epgPort = config('epg.sandbox.port');
    }

    public static function customerRegistration($customerData)
    {
        $client = new Client();
        $jsonData = self::prepareJsonData($customerData);
        $response = self::makeHttpRequest($client, $jsonData);

        return json_decode($response->getBody()->getContents());
    }

    private static function prepareJsonData($customerData)
    {
        $orderId = $customerData->order_id ?? (date('Ymdh') . rand(0, 1000));
        $amount = GenericAttribute::where('generic_key', 'amount')->first();
        $amount = $amount->generic_value ?? 1;
        return [
            'Registration' => [
                'Currency' => config('epg.reg_currency'),
                'ReturnPath' => config('epg.reg_return_url').'?order_id='.$orderId,
                'TransactionHint' => 'CPT:Y;VCC:Y;',
                'OrderID' => $orderId,
                'Store' => config('epg.reg_store'),
                'Terminal' => config('epg.reg_terminal'),
                'Channel' => config('epg.reg_channel'),
                'Amount' => $amount,
                'Customer' => config('epg.reg_customer'),
                'OrderName' => config('epg.reg_order_name'),
                'UserName' => config('epg.username'),
                'Password' => config('epg.password'),
            ],
        ];
    }

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


    public function finalizePayment(Request $request)
    {
        $orderId = $this->validateOrderId($request);
        $buyer = $this->findBuyer($orderId);
        $epgResponse = $this->finalizeEpgPayment($buyer->transaction_id);
        $this->handleEpgResponse($epgResponse, $buyer);

        $flag = $epgResponse->Transaction->ResponseCode == 0 ? 'success' : 'error';
        // Redirect to the /thankyou route with the dynamic flag
        return redirect()->to('thankyou/'.$flag);
    }

    private function validateOrderId($request)
    {
        if (!$request->order_id) {
            // TODO: redirect to error page that says NO orderId found EPG payment finalization
            dd('NO orderId found EPG payment finalization');
        }

        return $request->order_id;
    }

    private function findBuyer($orderId)
    {
        $buyer = Buyer::where('order_id', $orderId)->first();

        if (!$buyer || !$buyer->transaction_id) {
            //TODO: redirect to error page that says NO buyer found EPG payment finalization
            dd('NO buyer found EPG payment finalization');
        }

        return $buyer;
    }

    private function finalizeEpgPayment($transactionId)
    {
        self::initialize();
        $client = new Client();
        $response = $client->request('POST', self::$epgUrl. ':' .self::$epgPort, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'verify' => false,
            'json' => [
                'Finalization' => [
                    'TransactionID' => $transactionId,
                    "Customer"=> config('epg.reg_customer'),
                    "UserName"=> config('epg.username'),
                    "Password"=> config('epg.password'),
                ],
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }

    private function handleEpgResponse($epgResponse, $buyer)
    {
        if(isset($epgResponse->Transaction->ResponseCode) && $epgResponse->Transaction->ResponseCode == BuyerPayment::PAYMENT_STATUS_SUCCESS){
            $this->createBuyerPayment($epgResponse, $buyer);

            $data = [
                'to' => $buyer['email_id'] ?? '',
                'subject' => 'Confirmation: Your Payment Was Successfully Processed',
                'view' => 'emails.payment_confirmation',
            ];
            $data['details'] = $buyer;
            Mail::to($data['to'])->send(new EmailUtility($data));
        }else {
            if(isset($epgResponse->Transaction)){
                $this->createBuyerPayment($epgResponse, $buyer);
            }

            $data = [
                'to' => $buyer['email_id'] ?? '',
                'subject' => 'Payment Unsuccessful/Error Notification',
                'view' => 'emails.payment_error',
            ];
            $data['details'] = $buyer;
            Mail::to($data['to'])->send(new EmailUtility($data));
        }

        return;
    }

    private function createBuyerPayment($epgResponse, $buyer)
    {
        $buyerPayment = new BuyerPayment();
        $buyerPayment->buyer_id = $buyer->buyer_id;
        $buyerPayment->payment_status = $epgResponse->Transaction->ResponseCode ?? null;
        $buyerPayment->payment_json_response = json_encode($epgResponse);
        if($buyerPayment->save()){
            return;
        }else{
            // TODO: redirect to error page that says something went wrong with payment
            return;
        }
    }
}
