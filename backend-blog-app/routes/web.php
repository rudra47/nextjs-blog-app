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

//ADMIN PANEL
//Route::prefix('app')->as('app.')->group(function () {
//    Route::get('/app/login', [AppAuthController::class, 'login'])->name('app.login');
//    Route::post('/app/loginAction', [AppAuthController::class, 'loginAction'])->name('app.loginAction');
//    Route::get('/app/logout', [AppAuthController::class, 'logout'])->name('app.logout');
//});
// DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware('admin')->group(function () {
    Route::prefix('admin')->as('admin.')->group(function () {
        Route::get('/saloons', [SaloonController::class, 'saloon'])->name('saloons');
        Route::get('/customers', [CustomerController::class, 'customer'])->name('customers');
    });
});
