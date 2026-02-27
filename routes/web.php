<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\ColocationController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    Route::post('/logout', LogoutController::class)->name('logout');
    Route::view('profile', 'profile')->name('profile');

    // ─ Routes Admin ─
    Route::middleware(['admin'])->name('admin.')->group(function () {
        Route::get('/dashboard-admin', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/users/{user}/ban', [AdminDashboardController::class, 'ban'])->name('users.ban');
        Route::get('/users/{user}/unban', [AdminDashboardController::class, 'unban'])->name('users.unban');
    });

    Route::resource('colocation', ColocationController::class)->except(['index']);
    Route::get('/colocations', [ColocationController::class, 'index'])->name('colocation.index');

    Route::patch('/colocation/{colocation}/cancel' , [ColocationController::class, 'cancelColocation'])->name('colocation.cancel');
    Route::delete('/colocation/{colocation}/leave' , [MembershipController::class, 'leaveColocation'])->name('colocation.leave');

});


require __DIR__ . '/auth.php';
