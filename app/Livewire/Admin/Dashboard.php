<?php

namespace App\Livewire\Admin;

use App\Models\Buyer;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Redirect;

class Dashboard extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $search = '';

    public function render()
    {
        $buyers = Buyer::with('secondaryBuyers')
        ->when(!empty($this->search), function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('buyers_name', 'like', "%" . $this->search . "%");
            });
        })
        ->paginate($this->perPage);

        return view('livewire.admin.dashboard', [
            'buyers' => $buyers,
        ]);
    }

    public function perPageChanged()
    {
        $this->resetPage(); // Reset pagination page when perPage changes
    }
}



// $bookings = BookingFacility::with('b_user')
        // ->when(!empty($this->searchTerm), function ($query) {
        //     $query->where(function ($subquery) {
        //         $subquery->where('facility_name', 'like', "%" . $this->searchTerm . "%")
        //             ->orWhere('reference_no', 'like', "%" . $this->searchTerm . "%")
        //             ->orWhere('grand_total', 'like', "%" . $this->searchTerm . "%")
        //             ->orWhereHas('b_user', function ($userQuery) {
        //                 $userQuery->where(function ($nameQuery) {
        //                     $nameQuery->whereRaw("concat(first_name, ' ', last_name) like ?", ["%{$this->searchTerm}%"])
        //                     ->orWhere('email', 'like', "%" . $this->searchTerm . "%");
        //                 });
        //             });
        //     });
        // })

        // ->latest()
        // ->paginate(10);
