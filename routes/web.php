<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PersonController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    return redirect()->route('dashboard.index'); // dummy login action
});

Route::get('/dashboard', [PersonController::class, 'index'])->name('dashboard.index');
Route::get('/dashboard/create', [PersonController::class, 'create'])->name('dashboard.create');
Route::post('/dashboard/store', [PersonController::class, 'store'])->name('dashboard.store');
Route::get('/dashboard/show/{person}', [PersonController::class, 'show'])->name('dashboard.show');
