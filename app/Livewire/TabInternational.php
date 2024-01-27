<?php

namespace App\Livewire;

use App\Models\Buyer; // Add this import
use App\Models\BuyerRelationship; // Add this import
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class TabInterNational extends Component
{

    use WithFileUploads;

    public $intBuyerCount = 1;
    public $int_buyers = [];
    public $int_project;
    public $int_phase;
    public $int_unit_no;
    public $int_passport_copy;
    // public $emirates_id;
    public $int_mou_document;

    protected $rules;

    public function render()
    {
        return view('livewire.tab-international');
    }

    protected function rules()
    {
        $rules = $this->generateRules();

        // Add rules for fixed fields
        $rules = array_merge($rules, [
            'int_project' => 'required|in:project1,project2',
            'int_phase' => 'required|in:phase1,phase2',
            'int_unit_no' => 'required|numeric',
            'int_passport_copy' => 'required|file|mimes:pdf,jpg,png|max:5120',
            // 'emirates_id' => 'required|file|mimes:pdf,jpg,png|max:5120',
            'int_mou_document' => 'required|file|mimes:pdf,jpg,png|max:5120',
        ]);

        return $rules;
    }

    private function generateRules()
    {
        $rules = [];

        foreach ($this->int_buyers as $index => $buyer) {
            $rules["int_buyers.$index.name"] = "required|string";
            $rules["int_buyers.$index.mobile_no"] = "required|numeric";
            $rules["int_buyers.$index.email_id"] = "required|email";
            $rules["int_buyers.$index.address"] = "required|string";
        }

        return $rules;
    }

    public function submitInternational()
    {
        $this->validate();

        // Save primary buyer
        $primaryBuyer = $this->saveBuyerData(0);

        // Save secondary buyers
        foreach ($this->int_buyers as $index => $buyer) {
            if ($index > 0) {
                $secondaryBuyer = $this->saveBuyerData($index);

                // Create relationship
                BuyerRelationship::create([
                    'primary_buyer_id' => $primaryBuyer->buyer_id,
                    'secondary_buyer_id' => $secondaryBuyer->buyer_id,
                ]);
            }
        }

        return redirect()->to('/livewire.super-admmin-login');
        // Additional logic after saving

        // Clear the form
        $this->resetForm();
    }

    private function saveBuyerData($index)
    {
        $buyer = Buyer::create([
            'buyer_type' => 2,
            'buyers_name' => $this->int_buyers[$index]['name'],
            'mobile_no' => $this->int_buyers[$index]['mobile_no'],
            'email_id' => $this->int_buyers[$index]['email_id'],
            'address' => $this->int_buyers[$index]['address'],
        ]);

        if ($index === 0) {
            // Save additional details for primary buyer
            $buyer->project = $this->int_project;
            $buyer->phase = $this->int_phase;
            $buyer->unit_no = $this->int_unit_no;
            $buyer->passport_path = $this->saveFile($this->int_passport_copy, 'passport', $buyer->buyer_id);
            // $buyer->emirates_id_path = $this->saveFile($this->emirates_id, 'emirates_id', $buyer->buyer_id);
            $buyer->mou_doc_path = $this->saveFile($this->int_mou_document, 'mou_document', $buyer->buyer_id);
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
        $this->int_buyers = [
            [
                'name' => '',
                'mobile_no' => '',
                'email_id' => '',
                'address' => '',
            ]
        ];
        $this->intBuyerCount = 0;

        // Reset other properties if needed
        $this->int_project = null;
        $this->int_phase = null;
        $this->int_unit_no = null;
        $this->int_passport_copy = null;
        // $this->emirates_id = null;
        $this->int_mou_document = null;

        // $this->resetErrorBag();
        // $this->resetValidation();
    }


    public function addBuyerInternational()
    {
        $this->intBuyerCount++;
        if (!isset($this->int_buyers[0])) {
            $this->int_buyers = [[]];
        }

        array_splice($this->int_buyers, 1, 0, []);
        $this->int_buyers[] = [
            'name' => '',
            'mobile_no' => '',
            'email_id' => '',
            'address' => '',
        ];

        $this->rules = $this->generateRules();
    }
}

