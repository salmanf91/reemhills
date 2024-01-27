<?php

namespace App\Livewire\Admin;

use App\Models\Buyer;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class Dashboard extends Component
{
    use WithPagination;

    protected $listeners = ['logout'];
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
        ->paginate(10);

        // $query = Buyer::with('secondaryBuyers')
        //     ->where('buyers_name', 'like', '%' . $this->search . '%');

        // when(!empty($this->search), function() {
        //     $query->where('email_id', 'like', '%' . $this->search . '%')
        //         ->where('project', 'like', '%' . $this->search . '%');
        // })

        // $buyers = $query->paginate($this->perPage);

        return view('livewire.admin.dashboard', [
            'buyers' => $buyers,
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return Redirect::to('/login');
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
