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
    ->get('/dashboard-admin', [AdminDashboardController::class, 'index'])
    ->name('admin.dashboard');

require __DIR__ . '/auth.php';
