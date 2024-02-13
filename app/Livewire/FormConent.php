<?php

namespace App\Livewire;

use App\Models\Buyer; // Add this import
use App\Models\BuyerRelationship; // Add this import
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Livewire\UtilityClass;
use App\Http\Controllers\EpgPaymentController;

class FormContent extends UtilityClass
{

    use WithFileUploads;
    const SUCCESS_RESPONSE_CODE = 0;

    public $buyerCount = 1;
    public $buyers = [];
    public $project;
    public $phase;
    public $unit_no;
    public $passport_copy;
    public $emirates_id;
    public $mou_document;

    protected $rules;

    public function render()
    {
        return view('livewire.form-content');
    }

    protected function rules()
    {
        $rules = $this->generateRules();

        $rules = array_merge($rules, [
            'project' => 'required|in:project1,project2',
            'phase' => 'required|in:phase1,phase2',
            'unit_no' => 'required|numeric',
            'passport_copy' => 'required|file|mimes:pdf,jpg,png|max:5120',
            'emirates_id' => 'required|file|mimes:pdf,jpg,png|max:5120',
            'mou_document' => 'required|file|mimes:pdf,jpg,png|max:5120',
        ]);

        return $rules;
    }

    private function generateRules()
    {
        $rules = [];

        foreach ($this->buyers as $index => $buyer) {
            $rules["buyers.$index.name"] = "required|string";
            $rules["buyers.$index.mobile_no"] = "required|numeric";
            $rules["buyers.$index.email_id"] = "required|email";
            $rules["buyers.$index.address"] = "required|string";
        }

        return $rules;
    }

    public function submitNationalOld()
    {
        $this->validate();

        // Save primary buyer
        $primaryBuyer = $this->saveBuyerData(0);
        if (!$primaryBuyer) {
            // TODO: redirect to error page that says something went wrong and try again
            dd('something went wrong and try again');
        }

        // Save secondary buyers
        foreach ($this->buyers as $index => $buyer) {
            if ($index > 0) {
                $secondaryBuyer = $this->saveBuyerData($index);
                // Create relationship
                BuyerRelationship::create([
                    'primary_buyer_id' => $primaryBuyer->buyer_id,
                    'secondary_buyer_id' => $secondaryBuyer->buyer_id,
                ]);
            }
        }

        $primaryBuyer->buyers_name = 'Demo Merchant';  // Update this with actual merchant name
        $primaryBuyer->amount = rand(0, 100);                // Update this with actual amount

        $epgResponse = $this->customerRegistration($primaryBuyer);
        $epgResponseCode = (int) $epgResponse->Transaction->ResponseCode ?? null;
        if (!isset($epgResponse->Transaction) || $epgResponseCode !== self::SUCCESS_RESPONSE_CODE) {
            // TODO: redirect to error page that says something went wrong with EPG customer registration
            dd('something went wrong with EPG customer registration');
        }

        $paymentPageUrl = $epgResponse->Transaction->PaymentPage ?? null;
        if (!$paymentPageUrl) {
            // TODO: redirect to error page that says something went wrong with EPG payment page url
            dd('something went wrong with EPG payment page url');
        }

        $updateBuyer = Buyer::find($primaryBuyer->buyer_id);
        $updateBuyer->transaction_id = $epgResponse->Transaction->TransactionID;
        $updateBuyer->epg_json_response = json_encode($epgResponse);
        $updateBuyer->save();

        return redirect($paymentPageUrl);
    }
    public function submitNational()
    {
        $this->validate();

        $primaryBuyer = $this->savePrimaryBuyer();
        $this->saveSecondaryBuyers($primaryBuyer);

        $buyerData = $primaryBuyer;
        $buyerData->buyers_name = 'Demo Merchant';  // Update this with actual merchant name
        // $buyerData->amount = rand(0, 100);                // Update this with actual amount

        // $epgResponse = $this->customerRegistration($buyerData);
        $epgResponse = EpgPaymentController::customerRegistration($buyerData);
        $this->handleEpgResponse($epgResponse, $primaryBuyer);
        return redirect($epgResponse->Transaction->PaymentPage);
    }

    private function savePrimaryBuyer()
    {
        $primaryBuyer = $this->saveBuyerData(0);
        if (!$primaryBuyer) {
            // TODO: redirect to error page that says something went wrong and try again
            dd('something went wrong and try again');
        }

        return $primaryBuyer;
    }

    private function saveSecondaryBuyers($primaryBuyer)
    {
        foreach ($this->buyers as $index => $buyer) {
            if ($index > 0) {
                $secondaryBuyer = $this->saveBuyerData($index);
                // Create relationship
                BuyerRelationship::create([
                    'primary_buyer_id' => $primaryBuyer->buyer_id,
                    'secondary_buyer_id' => $secondaryBuyer->buyer_id,
                ]);
            }
        }
    }

    private function handleEpgResponse($epgResponse, $buyer)
    {
        $epgResponseCode = (int) $epgResponse->Transaction->ResponseCode ?? null;
        if (!isset($epgResponse->Transaction) || $epgResponseCode !== self::SUCCESS_RESPONSE_CODE) {
            // TODO: redirect to error page that says something went wrong with EPG customer registration
            dd('something went wrong with EPG customer registration');
        }

        $paymentPageUrl = $epgResponse->Transaction->PaymentPage ?? null;
        if (!$paymentPageUrl) {
            // TODO: redirect to error page that says something went wrong with EPG payment page url
            dd('something went wrong with EPG payment page url');
        }

        $buyer->transaction_id = $epgResponse->Transaction->TransactionID;
        $buyer->epg_json_response = json_encode($epgResponse);
        $buyer->save();
    }

    private function saveBuyerData($index)
    {
        $buyer = Buyer::create([
            'buyer_type' => 1,
            'buyers_name' => $this->buyers[$index]['name'],
            'mobile_no' => $this->buyers[$index]['mobile_no'],
            'email_id' => $this->buyers[$index]['email_id'],
            'address' => $this->buyers[$index]['address'],
        ]);

        if ($index === 0) {
            // Save additional details for primary buyer
            $buyer->project = $this->project;
            $buyer->phase = $this->phase;
            $buyer->unit_no = $this->unit_no;
            $buyer->passport_path = $this->saveFile($this->passport_copy, 'passport', $buyer->buyer_id);
            $buyer->emirates_id_path = $this->saveFile($this->emirates_id, 'emirates_id', $buyer->buyer_id);
            $buyer->mou_doc_path = $this->saveFile($this->mou_document, 'mou_document', $buyer->buyer_id);
            $buyer->is_primary_buyer = 1;
            $buyer->order_id = date('Ymdh') . rand(0, 1000);
        } else {
            // Secondary buyer, set is_primary_buyer to 0
            $buyer->is_primary_buyer = 0;
        }

        $buyer->save();
        return $buyer;
    }

    private function saveFile($file, $directory, $buyer_id)
    {
        if ($file) {
            $path = $file->store("public/$directory/$buyer_id");
            return Storage::url($path);
        }

        return null;
    }

    private function resetForm()
    {
        // Reset form data
        $this->buyers = [
            [
                'name' => '',
                'mobile_no' => '',
                'email_id' => '',
                'address' => '',
            ]
        ];
        $this->buyerCount = 0;

        // Reset other properties if needed
        $this->project = null;
        $this->phase = null;
        $this->unit_no = null;
        $this->passport_copy = null;
        $this->emirates_id = null;
        $this->mou_document = null;

        // $this->resetErrorBag();
        // $this->resetValidation();
    }


    public function addBuyer()
    {
        $this->buyerCount++;
        if (!isset($this->buyers[0])) {
            $this->buyers = [[]];
        }

        array_splice($this->buyers, 1, 0, []);
        $this->buyers[] = [
            'name' => '',
            'mobile_no' => '',
            'email_id' => '',
            'address' => '',
        ];

        $this->rules = $this->generateRules();
    }

    public function dismissErrorMessage()
    {
        $this->resetValidation(); // Reset validation errors
    }

    public function removeBuyer()
    {
        array_pop($this->buyers);
        $this->buyerCount = count($this->buyers);
    }
}
