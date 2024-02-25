<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\GenericAttribute;

class ManageAmount extends Component
{
    public $amount;
    public $amountId;
    public $message = "Amount is not set. Please add the amount.";

    public function mount()
    {
        $record = GenericAttribute::where('generic_key', 'amount')->first();

        if ($record) {
            $this->amount = $record->generic_value;
            $this->amountId = $record->id; // Assuming you have $amountId property in your component
        } else {
            $this->amountId = null;
        }
    }

    public function render()
    {
        return view('livewire.admin.manage-amount');
        // return view('livewire.manage-amount')->layout('layouts.app');
    }

    public function storeAmount()
    {
        $this->validate([
            'amount' => 'required|numeric'
        ]);

        try {
            if ($this->amountId) {
                // Update existing record
                GenericAttribute::where('id', $this->amountId)->update(['generic_value' => $this->amount]);
            } else {
                // Create new record
                GenericAttribute::create(['generic_key' => 'amount', 'generic_value' => $this->amount]);
            }

            $this->dispatch('amountSaved', 'Amount saved successfully.');
        } catch (\Exception $e) {
            $this->dispatch('amountSaveError', 'Error saving amount. Please try again.');
        }

        // Reload the component to reflect changes
        $this->mount();
    }
}
