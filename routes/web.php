<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'company','active'])->get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth', 'company','active','role:admin'])->group(function(){
   
    Route::get('/users', [UserController::class,'index'])->name('users.index');
    
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
