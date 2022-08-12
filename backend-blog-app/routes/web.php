<?php

use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\SaloonController;
use App\Http\Controllers\Admin\CustomerController;
//CUSTOMER
use App\Http\Controllers\Customer\PagesController;

//APP
Use App\Http\Controllers\AppAuthController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

// DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware('admin')->group(function () {
    Route::prefix('admin')->as('admin.')->group(function () {
        Route::get('/saloons', [SaloonController::class, 'saloon'])->name('saloons');
        Route::get('/customers', [CustomerController::class, 'customer'])->name('customers');
    });
});
