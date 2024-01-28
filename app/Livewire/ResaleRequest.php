<?php

namespace App\Livewire;

use Livewire\Component;

class ResaleRequest extends Component
{

    public $activeTab = 'national';
    public $buyerCount = 1;

    public function render()
    {
        return view('livewire.resale-request', [
            'activeTab' => $this->activeTab,
        ]);
    }

    public function changeTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function adminSignIn()
    {
        return redirect('/login');
    }
}

