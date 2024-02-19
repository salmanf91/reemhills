<?php
namespace App\Http\Livewire;

use Livewire\Component;

class Select2 extends Component
{
    public $selected = '';

    public $series = [
        'Wanda Vision',
        'Money Heist',
        'Lucifer',
        'Stranger Things',
    ];

    public function render()
    {
        return view('livewire.select2')
                ->layout('layouts.select2');
    }
}