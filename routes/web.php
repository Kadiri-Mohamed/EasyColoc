<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// ─ Routes Admin ─
Route::middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard-admin', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/users/{user}/ban', [AdminDashboardController::class, 'ban'])
            ->name('users.ban');
            
        Route::get('/users/{user}/unban', [AdminDashboardController::class, 'unban'])
             ->name('users.unban');
    });

require __DIR__ . '/auth.php';
