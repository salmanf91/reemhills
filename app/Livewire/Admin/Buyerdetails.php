<?php

namespace App\Livewire\Admin;

use App\Models\Buyer;
use Livewire\Component;
use Illuminate\Http\Request;

class BuyerDetails extends Component
{
    public $buyer;

    // Livewire listens for this variable and updates the component when it changes
    public $buyerId;

    public function mount(Request $request, $id)
    {
        $this->buyerId = $id;
    }


    public function render()
    {
        $this->buyer = Buyer::find($this->buyerId);

        return view('livewire.admin.buyerdetails');
    }
}
