<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceOrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Models\Customer;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::middleware(['auth', 'company','active'])->get('/painel', [DashboardController::class, 'index'])->name('painel');

Route::middleware(['auth', 
    'company', 
    'active', 
    'role:admin,super-admin,employee,client'])->group(function(){
   
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
    Route::get('customer/{customer}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::patch('customer/{customer}/active', [CustomerController::class, 'active'])->name('customer.active');
    Route::put('customer/{customer}', [CustomerController::class, 'update'])->name('customer.update');
    Route::get('customer/{customer}/show', [CustomerController::class, 'show'])->name('customer.show');
    Route::get('/customers/search', [CustomerController::class, 'search'])->name('customers.search');
    Route::get('/api/customers/{customer}/vehicles', [CustomerController::class, 'getVehicles'])->name('customers.vehicles');
    Route::delete('customer/{customer}', [CustomerController::class, 'destroy'])->name('customer.destroy');

    //VEHICLE
    Route::get('vehicles/', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('vehicles/create', [VehicleController::class, 'create'])->name('vehicles.create');
    Route::post('vehicles/store', [VehicleController::class, 'store'])->name('vehicles.store');
    Route::get('vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])->name('vehicles.edit');
    Route::put('vehicles/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update');
    Route::get('vehicles/{vehicle}/show', [VehicleController::class, 'show'])->name('vehicles.show');
    Route::delete('vehicles/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');
    //Route::get('vehicles/{vehicle}/pdf', [VehicleController::class, 'generatePdf'])->name('vehicles.pdf');


    //SERVICE ORDER
    Route::get('service-orders/', [ServiceOrderController::class, 'index'])->name('service-orders.index');
    Route::get('service-orders/create', [ServiceOrderController::class, 'create'])->name('service-orders.create');
    Route::post('service-orders/store', [ServiceOrderController::class, 'store'])->name('service-orders.store');
    Route::get('service-orders/{service_order}/edit', [ServiceOrderController::class, 'edit'])->name('service-orders.edit');
    Route::put('service-orders/{service_order}', [ServiceOrderController::class, 'update'])->name('service-orders.update');
    Route::get('service-orders/{service_order}/show', [ServiceOrderController::class, 'show'])->name('service-orders.show');
    Route::delete('service-orders/{service_order}', [ServiceOrderController::class, 'destroy'])->name('service-orders.destroy');
    Route::get('service-orders/{service_order}/pdf', [ServiceOrderController::class, 'generatePdf'])->name('service-orders.pdf');
    Route::get('/service-orders/{service_order}/print', [ServiceOrderController::class, 'print'])
    ->name('service-orders.print');

});

Route::middleware(['auth', 'role:super-admin'])->group(function() {
    //BRAND (Acesso somente para Super Admin)
    Route::get('brands/', [BrandController::class, 'index'])->name('brands.index');
    Route::get('brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('brands/store', [BrandController::class, 'store'])->name('brands.store');
    Route::get('brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
    Route::get('brands/{brand}/show', [BrandController::class, 'show'])->name('brands.show');
    Route::delete('brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
