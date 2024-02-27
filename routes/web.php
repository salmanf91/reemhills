<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\SuperAdminLogin;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Buyerdetails;
use App\Livewire\Admin\ManageAmount;
use App\Http\Controllers\EpgPaymentController;
use App\Http\Controllers\AuthController;
use App\Livewire\PaymentResponseHandler;

Route::middleware(['superadmin'])->group(function () {
    Route::get('/resale-requests', Dashboard::class)->name('admin.resale-requests');
    Route::get('/buyer-details-{id}', Buyerdetails::class)->name('buyer.details');
    Route::get('/manage-amount', ManageAmount::class)->name('admin.manage-amount');
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

Route::get('thankyou/success', function () {
    return view('welcome', [
        'livewireComponent' => 'payment-response-handler',
    ]);
});

Route::get('thankyou/error', function () {
    return view('welcome', [
        'livewireComponent' => 'payment-response-handler',
    ]);
});

Route::post('/payment/finalization', [EpgPaymentController::class, 'finalizePayment']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

