<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class PaymentResponseHandler extends Component
{

    public $response;

    public function mount(Request $request) {
        // Get the current route
        $route = Route::current();

        // Get the error parameter from the route parameters
        $this->response = strpos($route->uri(), 'error') !== false ? 'error' : (strpos($route->uri(), 'success') !== false ? 'success' : null);

    }

    public function render()
    {
        return view('livewire.payment-response-handler');
    }
}
