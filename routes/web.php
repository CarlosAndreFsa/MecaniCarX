<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Models\Customer;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('/dashboard', 'dashboard')
->middleware(['auth'])
    ->name('dashboard');

Route::middleware(['auth', 'company','active'])->get('/painel', [DashboardController::class, 'index'])->name('painel');

Route::middleware(['auth', 'company','active','role:admin'])->group(function(){
   
    Route::get('/users', [UserController::class,'index'])->name('users.index');
    Route::get('/users/create', [UserController::class,'create'])->name('users.create');
    Route::post('/users/store', [UserController::class,'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class,'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class,'update'])->name('users.update');
    Route::patch('/users/{user}/active', [UserController::class, 'active'])->name('users.active');

    //COMPRANY
    Route::get('company/show', [CompanyController::class, 'show'])->name('company.show');
    Route::get('company/edit', [CompanyController::class, 'edit'])->name('company.edit');
    Route::put('company', [CompanyController::class, 'update'])->name('company.update');

    //CUSTOMER
    Route::get('customer/', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('customer/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('customer/store', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('customer/{id}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::patch('customer/{customer}/active', [CustomerController::class, 'active'])->name('customer.active');
    Route::put('customer/{customer}', [CustomerController::class, 'update'])->name('customer.update');
    Route::get('customer/{id}/show', [CustomerController::class, 'show'])->name('customer.show');

    
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
