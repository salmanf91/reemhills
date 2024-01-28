<?php

// app/Http/Livewire/SuperAdminLogin.php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SuperAdminLogin extends Component
{
    protected $debug = true;
    public $username;
    public $password;

    public function render()
    {
        return view('livewire.super-admin-login');
    }

    public function login()
    {
        $credentials = [
            'email' => $this->username,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials)) {
            // Check if the authenticated user is a super admin
            if (auth()->user()->role === 'superadmin') {
                // Redirect to the super admin dashboard or perform other actions
                // session()->flash('success', 'correct.');
                return redirect()->route('admin.resale-requests');
            } else {
                // If not a super admin, log them out
                dd("hello error");
                Auth::logout();
                session()->flash('error', 'Invalid credentials for super admin.');
            }
        } else {
            session()->flash('error', 'Invalid username or password.');
        }
    }
}

