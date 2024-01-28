<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\SuperAdminLogin;
use App\Livewire\CreatePost;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Buyerdetails;

Route::middleware(['superadmin'])->group(function () {
    Route::get('/resale-requests', Dashboard::class)->name('admin.resale-requests');
    Route::get('/buyer-details-{id}', Buyerdetails::class)->name('buyer.details');
});

Route::get('/', function () {
    return view('welcome', [
        'livewireComponent' => 'resale-request',
    ]);
});

Route::get('/login', function () {
    return view('welcome', [
        'livewireComponent' => 'super-admin-login',
    ]);
});

Route::get('/createPost', function () {
    return view('welcome', [
        'livewireComponent' => 'create-post',
    ]);
});
