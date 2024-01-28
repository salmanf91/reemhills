<?php

namespace App\Livewire;

use App\Models\Buyer; // Add this import
use App\Models\BuyerRelationship; // Add this import
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Livewire\UtilityClass;

class TabNational extends UtilityClass
{

    use WithFileUploads;

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
        return view('livewire.tab-national');
    }
    public function test()
    {
        // REMOVE AFTER DEVELOPMENT
        return redirect('https://demo-ipg.ctdev.comtrust.ae/PaymentEx/MerchantPay/Payment?t=8323f690a2d60e6aa3a00a76289beeac&lang=en&layout=C0STCBVLEI');
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

    public function submitNational()
    {
        $this->validate();

        // Save primary buyer
        $primaryBuyer = $this->saveBuyerData(0);

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

        $epgResponse = $this->customerRegistration($primaryBuyer);
        $paymentPageUrl = $epgResponse->Transaction->PaymentPage ?? null;
        if ($paymentPageUrl) {
            return redirect($paymentPageUrl);
        }else{
            dd('Error');
        }
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
}

