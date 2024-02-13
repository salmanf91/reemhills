<?php

namespace App\Livewire\Admin;

use App\Models\GenericAttributes;
use Livewire\Component;

class ManageAmount extends Component
{
    public $amount;

    public function mount()
    {
        $this->amount = $this->getAmountData(); // Initialize with existing amount
    }

    public function updatedAmount()
    {
        $this->validateOnly('amount', [
            'amount' => 'required|numeric'
        ]);
    }

    public function submit()
    {
        $this->validate([
            'amount' => 'required|numeric'
        ]);

        $this->saveAmount($this->amount);

        $this->dispatchBrowserEvent('amount-saved'); // For success notification

        $this->reset('amount'); // Clear input field after successful save
    }

    protected function getAmountData()
    {
        // Fetch existing amount from database (adjust query as needed)
        return GenericAttributes::where('generic_key', 'amount')->first()?->generic_value;
    }

    protected function saveAmount($amount)
    {
        // Update or create entry in database (adjust logic as needed)
        GenericAttributes::updateOrCreate(
            ['generic_key' => 'amount'],
            ['generic_value' => $amount]
        );
    }
    public function render()
    {
        return view('livewire.admin.manage-amount');
    }
}
