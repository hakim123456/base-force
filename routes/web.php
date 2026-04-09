<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PersonController;
use App\Http\Controllers\PersonneController;

Route::get('/', function () {
    return redirect()->route('login');
});

use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return redirect()->route('dashboard.index');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [PersonController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/create', [PersonController::class, 'create'])->name('dashboard.create');
    Route::post('/dashboard/store', [PersonController::class, 'store'])->name('dashboard.store');
    Route::get('/dashboard/show/{person}', [PersonController::class, 'show'])->name('dashboard.show');

    Route::middleware('role:admin,manager')->group(function () {
        Route::get('/dashboard/edit/{person}', [PersonController::class, 'edit'])->name('dashboard.edit');
        Route::put('/dashboard/update/{person}', [PersonController::class, 'update'])->name('dashboard.update');
        Route::delete('/dashboard/destroy/{person}', [PersonController::class, 'destroy'])->name('dashboard.destroy');
    });

    Route::middleware('role:admin,manager')->group(function () {
        Route::resource('personnes', PersonneController::class)->except(['index', 'show']);
    });
    Route::resource('personnes', PersonneController::class)->only(['index', 'show']);

    // Admin Only routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.users.create');
        Route::post('/admin/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.users.store');
        Route::get('/admin/users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');
    });
});
