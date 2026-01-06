<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'company', 'active', 'role:admin,employee'])
    ->get('/dashboard', function(){
        return view('dashboard.index');

    })
        ->name('dashboard');


// Route::middleware(['auth', 'company'])->get('/company-test', function () {
//     return response()->json(['ok' => true]);
// });

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
