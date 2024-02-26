<?php

namespace App\Livewire;

use App\Models\Buyer;
use App\Models\BuyerRelationship; 
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Livewire\UtilityClass;
use App\Http\Controllers\EpgPaymentController;
use App\Http\Controllers\SalesforceController;
use App\Models\UnitDetail;
use function Livewire\Volt\{on};
use Illuminate\Support\Facades\File;

class FormContent extends UtilityClass
{

    use WithFileUploads;
    const SUCCESS_RESPONSE_CODE = 0;

    public $selectedTab = 'national';
    public $buyerCount = 1;
    public $buyers = [];
    public $project =[];
    public $phase = [];
    public $unit_nos = [];
    public $building = [];
    public $type = [];
    public $passport_copy;
    public $emirates_id_document;
    public $mou_document;
    public $primary_gender = 'Male';

    public $project_id;
    public $phase_id;
    public $unit_id;
    public $building_id;
    public $type_id;

    protected $rules;
    
    public $unitDetails = [];

    public function mount () {
        $sfController = new SalesforceController();
        // $data = [
        //     'name' => 'John Doe',
        //     'age' => 30,
        //     'email' => 'john@example.com',
        //     'address' => [
        //         'street' => '123 Main St',
        //         'city' => 'Anytown',
        //         'country' => 'USA'
        //     ],
        //     'tags' => ['php', 'json', 'example']
        // ];
        // $jsonObject = json_encode($data, JSON_PRETTY_PRINT);
        // dd($sfController->postData($jsonObject));
        $this->project = $this->getData('project_id');
        $this->unitDetails = UnitDetail::all();
    }

    private function getData ($column) {
        $data = UnitDetail::distinct($column)->pluck($column);
        return $data;
    }

    function getTypeForDropdown() {
        
        $this->type = [];
        $this->building = [];
        $this->unit_nos = [];

        $distinctRecords = UnitDetail::where('phase_id', $this->phase_id)
        ->distinct()
        ->select('type_id')
        ->get();
        $this->type = $distinctRecords->pluck('type_id')->unique()->toArray();
    }

    // function getBuildingForDropdown() {
    //     $this->building = [];
    //     $this->unit_nos = [];

    //     $filters = [
    //         'phase_id' => $this->phase_id,
    //         'type_id' => $this->type_id
    //     ];

    //     $distinctRecords = UnitDetail::where($filters)
    //     ->distinct()
    //     ->select('building_id')
    //     ->get();
    //     $this->building = $distinctRecords->pluck('building_id')->unique()->toArray();

    //     if (empty($myArray) || $this->building[0]==="") {
    //         $filters['building_id'] = '';
    //         $distinctRecords1 = UnitDetail::where($filters)
    //         ->distinct()
    //         ->select('unit_name')
    //         ->get();
    //         $this->unit_nos = $distinctRecords1->pluck('unit_name')->unique()->toArray();
    //     }
    // }

    // function getUnitNoForDropdown () {
    //     $filters = [
    //         'phase_id' => $this->phase_id,
    //         'type_id' => $this->type_id,
    //         'building_id' => $this->building_id
    //     ];
    //     $distinctRecords1 = UnitDetail::where($filters)
    //         ->distinct()
    //         ->select('unit_name')
    //         ->get();
    //     $this->unit_nos = $distinctRecords1->pluck('unit_name')->unique()->toArray();
    // }

    // function getOtherDropdowns () {
    //     $distinctRecords = UnitDetail::where('unit_name', $this->unit_id)
    //     ->distinct()
    //     ->select('unit_name','project_id','phase_id','type_id','building_id')
    //     ->get();
    //     $this->phase_id = $distinctRecords->pluck('phase_id')->unique();
    //     $this->type_id = $distinctRecords->pluck('type_id')->unique();
    //     $this->building_id = $distinctRecords->pluck('building_id')->unique();
    // }

    function getOtherDropdowns () {
        $distinctRecords = UnitDetail::where('unit_name', $this->unit_id)
        ->distinct()
        ->select('unit_name','project_id','phase_id','type_id','building_id')
        ->get();
        $this->phase_id = $distinctRecords->pluck('phase_id')->unique();
        $this->type_id = $distinctRecords->pluck('type_id')->unique();
        $this->building_id = $distinctRecords->pluck('building_id')->unique();
    }


    public function render()
    {
        return view('livewire.form-content');
    }

    protected function rules()
    {
        $rules = $this->generateRules();

        $rules = array_merge($rules, [
            'project' => 'required',
            'phase' => 'required',
            'unit_nos' => 'required',
            'passport_copy' => 'required|file|mimes:pdf,jpg,png|max:5120',
            'emirates_id_document' => 'required|file|mimes:pdf,jpg,png|max:5120',
            'mou_document' => 'required|file|mimes:pdf,jpg,png|max:5120',
        ]);

        return $rules;
    }

    private function generateRules()
    {
        $rules = [];

        foreach ($this->buyers as $index => $buyer) {
            $rules["buyers.$index.name"] = "required|string";
            $rules["buyers.$index.dob"] = "required|date";
            $rules["buyers.$index.gender"] = "required|in:Male,Female";
            $rules["buyers.$index.mobile_no"] = "required|numeric";
            $rules["buyers.$index.email_id"] = "required|email";
            $rules["buyers.$index.address"] = "required|string";
            $rules["buyers.$index.country"] = "required|string";
            $rules["buyers.$index.passport_number"] = "required|string";
            $rules["buyers.$index.emirates_id"] = "required|string";
        }

        return $rules;
    }

    // Function to get the record type based on buyer type
    private function getRecordType($buyerType)
    {
        switch ($buyerType) {
            case 1:
                return "Individual";
            case 2:
                return "Joint";
            case 3:
                return "Business";
            default:
                return "Unknown";
        }
    }

    private function getImageAsBase64($path)
    {
        $filePath;
        $base64String;

        $search = '/storage/';

        // Replace the string with an empty string
        $filePath = str_replace($search, '', $path);
        // Check if the file exists
        if (Storage::disk('public')->exists($filePath)) {
            // Read the file contents
            $fileContents = Storage::disk('public')->get($filePath);

            // Convert the file contents to base64
            return base64_encode($fileContents);
        } else {
            // File does not exist
            return null;
            // You can handle this case as per your requirement
        }

    }

    public function convertToBase64()
    {
        // Check if the file exists
        if (Storage::exists($this->filePath)) {
            // Read the file contents
            $fileContents = Storage::get($this->filePath);

            // Convert the file contents to base64
            $this->base64String = base64_encode($fileContents);
        } else {
            // File does not exist
            $this->base64String = null;
            // You can handle this case as per your requirement
        }
    }


    private function getFileExtension($path)
    {
        return pathinfo($path, PATHINFO_EXTENSION);
    }

    private function getDocumentType($path)
    {
        $extension = $this->getFileExtension($path);
        dd($extension);
        switch ($extension) {
            case 'pdf':
                return 'pdf';
            case 'png':
                return 'png';
            case 'jpg':
                return 'jpg';
            case 'jpeg':
                return 'jpeg';
            // Add more cases as needed
            default:
                return 'unknown';
        }
    }

    public function submit()
    {
        $this->validate();
        //Store to Database
        $primaryBuyer = $this->savePrimaryBuyer();
        $secondaryBuyer = $this->saveSecondaryBuyers($primaryBuyer);
        $data = [];
        if ($primaryBuyer) {
            $data = [
                "data" => [
                    "unit_details" => [
                        "unitno" => $primaryBuyer['unit_no'] ?? null,
                        "project" => $primaryBuyer['project'] ?? null,
                        "building" => $primaryBuyer['building'] ?? null,
                        "phase" => $primaryBuyer['phase']?? null
                    ],
                    "recordtype" => $this->getRecordType($primaryBuyer['buyer_type']),
                    "number_of_owners" => count($secondaryBuyer) + 1,
                    "account_Details" => [
                        [
                            "first_name" => explode(' ', $primaryBuyer['buyers_name'])[0], // Assuming first name is before the space
                            "last_name" => explode(' ', $primaryBuyer['buyers_name'])[1], // Assuming last name is after the space
                            "mobile_number" => $primaryBuyer['mobile_no'] ?? null,
                            "email" => $primaryBuyer['email_id'] ?? null,
                            "dob" => $primaryBuyer['dob'] ?? null,
                            "emirates_id" => $primaryBuyer['emirates_id'] ?? null,
                            "passport_number" => $primaryBuyer['passport_number'] ?? null,
                            "passport_document" => $this->getImageAsBase64($primaryBuyer['passport_path']),
                            "emirates_id_document" => $this->getImageAsBase64($primaryBuyer['emirates_id_path']),
                            "mou_Document" => $this->getImageAsBase64($primaryBuyer['mou_doc_path']),
                            "passport_document_type" => $this->getDocumentType($primaryBuyer['passport_path']),
                            "emirates_id_document_type" => $this->getDocumentType($primaryBuyer['emirates_id_path']),
                            "mou_Document_type" => $this->getDocumentType($primaryBuyer['mou_doc_path']),
                            "tl_number" => $primaryBuyer['trade_license'] ?? null,
                            "address" => $primaryBuyer['address'] ?? null,
                            "country" => $primaryBuyer['country'] ?? null,
                            "gender" => $primaryBuyer['gender'] ?? null,
                            "non_resident" => ($primaryBuyer['buyer_type'] == 1) ? "true" : (($primaryBuyer['buyer_type'] == 2) ? "true" : "true")
                        ]
                    ]
                ]
            ];
        }
        if ($secondaryBuyer) {
            foreach ($secondaryBuyer as $buyer) {
                $data['data']['account_Details'][] = [
                    "first_name" => explode(' ', $buyer['buyers_name'])[0],
                    "last_name" => explode(' ', $buyer['buyers_name'])[1],
                    "gender" => $buyer['gender'] ?? null,
                    "mobile_number" => $buyer['mobile_no'] ?? null,
                    "email" => $buyer['email_id'] ?? null,
                    "dob" => $buyer['dob'] ?? null,
                    "address" => $buyer['address'] ?? null,
                    "passport_number" => $buyer['passport_number'] ?? null,
                    "country" => $buyer['country'] ?? null,
                    "emirates_id" => $buyer['emirates_id'] ?? null,
                    "non_resident" => ($primaryBuyer['buyer_type'] == 1) ? "true" : (($primaryBuyer['buyer_type'] == 2) ? "false" : "false")
                ];
            }
        }

        //Call Saleforce API Here


        //Call Saleforce API Here

        $buyerData = $primaryBuyer;
        $json = json_encode($data, JSON_PRETTY_PRINT);
        dd($json);
        //Call Saleforce API Here

        $sfResponse = SalesforceController::postData($json);
        //Call Saleforce API Here

        $buyerData->buyers_name = 'Demo Merchant';  // Update this with actual merchant name
        // $buyerData->amount = rand(0, 100);                // Update this with actual amount

        $epgResponse = $this->customerRegistration($buyerData);
        $epgResponse = EpgPaymentController::customerRegistration($buyerData);
        $this->handleEpgResponse($epgResponse, $primaryBuyer);
        return redirect($epgResponse->Transaction->PaymentPage);
    }

    private function savePrimaryBuyer()
    {
        $primaryBuyer = $this->saveBuyerData(0);
        if (!$primaryBuyer) {
            dd('something went wrong and try again');
        }

        return $primaryBuyer;
    }

    private function saveSecondaryBuyers($primaryBuyer)
    {
        $secondaryBuyers = [];
        foreach ($this->buyers as $index => $buyer) {
            if ($index > 0) {
                $secondaryBuyer = $this->saveBuyerData($index);
                // Create relationship
                BuyerRelationship::create([
                    'primary_buyer_id' => $primaryBuyer->buyer_id,
                    'secondary_buyer_id' => $secondaryBuyer->buyer_id,
                ]);
                array_push($secondaryBuyers,$secondaryBuyer);
            }
        }
        return $secondaryBuyers;
    }

    private function handleEpgResponse($epgResponse, $buyer)
    {
        $epgResponseCode = (int) $epgResponse->Transaction->ResponseCode ?? null;
        if (!isset($epgResponse->Transaction) || $epgResponseCode !== self::SUCCESS_RESPONSE_CODE) {
            dd('something went wrong with EPG customer registration');
        }

        $paymentPageUrl = $epgResponse->Transaction->PaymentPage ?? null;
        if (!$paymentPageUrl) {
            dd('something went wrong with EPG payment page url');
        }

        $buyer->transaction_id = $epgResponse->Transaction->TransactionID;
        $buyer->epg_json_response = json_encode($epgResponse);
        $buyer->save();
    }

    private function saveBuyerData($index)
    {
        $buyer = Buyer::create([
            'buyer_type' => match ($this->selectedTab) {
                'national' => 1,
                'international' => 2,
                'company' => 3,
            },
            'buyers_name' => $this->buyers[$index]['name'],
            'dob' => $this->buyers[$index]['dob'],
            'gender' => $this->buyers[$index]['gender'],
            'mobile_no' => $this->buyers[$index]['mobile_no'],
            'email_id' => $this->buyers[$index]['email_id'],
            'address' => $this->buyers[$index]['address'],
            'country' => $this->buyers[$index]['country'],
            'passport_number' => $this->buyers[$index]['passport_number'],
            'emirates_id' => $this->buyers[$index]['emirates_id'],
        ]);

        if ($index === 0) {
            // Save additional details for primary buyer
            $explodedData = explode('|', $this->unit_id);

            // Assign values to different variables
            $this->phase_id = $explodedData[0];
            $this->type_id = $explodedData[1];
            $this->building_id = $explodedData[2];
            $this->unit_id = $explodedData[3];

            $buyer->project = $this->project[0];
            $buyer->phase = $this->phase_id;
            $buyer->type = $this->type_id;
            $buyer->building = $this->building_id;
            $buyer->unit_no = $this->unit_id;

            $buyer->passport_path = $this->saveFile($this->passport_copy, 'passport', $buyer->buyer_id);
            if ($this->selectedTab !== 'international') {
                $buyer->emirates_id_path = $this->saveFile($this->emirates_id_document, 'emirates_id_document', $buyer->buyer_id);
            }
            $buyer->mou_doc_path = $this->saveFile($this->mou_document, 'mou_document', $buyer->buyer_id);
            if ($this->selectedTab === 'company') {
                $buyer->company_name = $this->company_name;
                $buyer->tl_no = $this->company_tl_no;
                $buyer->trade_license_path = $this->saveFile($this->company_trade_license, 'trade_license', $buyer->buyer_id);
            }
            $buyer->is_primary_buyer = 1;
            $buyer->order_id = date('Ymdh') . rand(0, 1000);

            

        } else {
            // Secondary buyer, set is_primary_buyer to 0
            $buyer->is_primary_buyer = 0;
        }

        $buyer->save();

        //Send data to salesforce


        //Send data to salesforce
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
        $this->selectedTab = 'national';
        // Reset form data
        $this->buyers = [
            [
                'name' => '',
                'dob' => '',
                'gender' => '',
                'mobile_no' => '',
                'email_id' => '',
                'address' => '',
                'country' => '',
                'passport_number' => '',
                'emirates_id' => ''
            ]
        ];
        $this->buyerCount = 0;

        // Reset other properties if needed
        $this->project = null;
        $this->phase = null;
        $this->unit_nos = null;
        $this->passport_copy = null;
        $this->emirates_id_document = null;
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
            'dob' => '',
            'gender' => 'Male',
            'mobile_no' => '',
            'email_id' => '',
            'address' => '',
            'country' => '',
            'passport_number' => '',
            'emirates_id' => ''
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
