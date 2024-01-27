<?php

namespace App\Livewire;

use App\Models\Buyer; // Add this import
use App\Models\BuyerRelationship; // Add this import
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class TabCompany extends Component
{
    use WithFileUploads;

    public $companyBuyerCount = 1;
    public $company_buyers = [];
    public $company_project;
    public $company_phase;
    public $company_unit_no;
    public $company_passport_copy;
    public $company_emirates_id;
    public $company_mou_document;
    public $company_name;
    public $company_tl_no;
    public $company_trade_license;

    protected $rules;

    public function render()
    {
        return view('livewire.tab-company');
    }

    protected function rules()
    {
        $rules = $this->generateRules();

        // Add rules for fixed fields
        $rules = array_merge($rules, [
            'company_project' => 'required|in:project1,project2',
            'company_phase' => 'required|in:phase1,phase2',
            'company_unit_no' => 'required|numeric',
            'company_passport_copy' => 'required|file|mimes:pdf,jpg,png|max:5120',
            'company_emirates_id' => 'required|file|mimes:pdf,jpg,png|max:5120',
            'company_mou_document' => 'required|file|mimes:pdf,jpg,png|max:5120',
            'company_name' => 'required | string',
            'company_tl_no' => 'required | string',
            'company_trade_license' => 'required|file|mimes:pdf,jpg,png|max:5120',
        ]);

        return $rules;
    }

    private function generateRules()
    {
        $rules = [];

        foreach ($this->company_buyers as $index => $buyer) {
            $rules["company_buyers.$index.name"] = "required|string";
            $rules["company_buyers.$index.mobile_no"] = "required|numeric";
            $rules["company_buyers.$index.email_id"] = "required|email";
            $rules["company_buyers.$index.address"] = "required|string";
        }

        return $rules;
    }

    public function submitCompany()
    {
        $this->validate();

        // Save primary buyer
        $primaryBuyer = $this->saveBuyerData(0);

        // Save secondary buyers
        foreach ($this->company_buyers as $index => $buyer) {
            if ($index > 0) {
                $secondaryBuyer = $this->saveBuyerData($index);

                // Create relationship
                BuyerRelationship::create([
                    'primary_buyer_id' => $primaryBuyer->buyer_id,
                    'secondary_buyer_id' => $secondaryBuyer->buyer_id,
                ]);
            }
        }

        return redirect()->to('livewire.super-admmin-login');
        // Additional logic after saving

        // Clear the form
        $this->resetForm();
    }

    private function saveBuyerData($index)
    {
        $buyer = Buyer::create([
            'buyer_type' => 3,
            'buyers_name' => $this->company_buyers[$index]['name'],
            'mobile_no' => $this->company_buyers[$index]['mobile_no'],
            'email_id' => $this->company_buyers[$index]['email_id'],
            'address' => $this->company_buyers[$index]['address'],
        ]);

        if ($index === 0) {
            // Save additional details for primary buyer
            $buyer->project = $this->company_project;
            $buyer->phase = $this->company_phase;
            $buyer->unit_no = $this->company_unit_no;
            $buyer->passport_path = $this->saveFile($this->company_passport_copy, 'passport', $buyer->buyer_id);
            $buyer->emirates_id_path = $this->saveFile($this->company_emirates_id, 'emirates_id', $buyer->buyer_id);
            $buyer->mou_doc_path = $this->saveFile($this->company_mou_document, 'mou_document', $buyer->buyer_id);
            $buyer->company_name = $this->company_name;
            $buyer->tl_no = $this->company_tl_no;
            $buyer->trade_license_path = $this->saveFile($this->company_trade_license, 'trade_license', $buyer->buyer_id);
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
        $this->company_buyers = [
            [
                'name' => '',
                'mobile_no' => '',
                'email_id' => '',
                'address' => '',
            ]
        ];
        $this->addBuyerCompany = 0;

        // Reset other properties if needed
        $this->company_project = null;
        $this->company_phase = null;
        $this->company_unit_no = null;
        $this->company_passport_copy = null;
        $this->company_emirates_id = null;
        $this->company_mou_document = null;
        $this->compnay_name = null;
        $this->company_tl_no = null;
        $this->company_trade_license = null;

        // $this->resetErrorBag();
        // $this->resetValidation();
    }

    public function addBuyerCompany()
    {
        $this->companyBuyerCount++;
        if (!isset($this->company_buyers[0])) {
            $this->company_buyers = [[]];
        }

        array_splice($this->company_buyers, 1, 0, []);
        $this->company_buyers[] = [
            'name' => '',
            'mobile_no' => '',
            'email_id' => '',
            'address' => '',
        ];

        $this->rules = $this->generateRules();
    }


}
