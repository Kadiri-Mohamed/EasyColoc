<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InvitationController;
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
    Route::delete('/colocation/{colocation}/{membership}/kick' , [MembershipController::class, 'kickMember'])->name('colocation.kick');

     Route::get('/colocation/{colocation}/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/colocation/{colocation}/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::get('/colocation/{colocation}/expenses/{expense}', [ExpenseController::class, 'show'])->name('expenses.show');
    Route::get('/colocation/{colocation}/expenses/{expense}/edit', [ExpenseController::class, 'edit'])->name('expenses.edit');
    Route::put('/colocation/{colocation}/expenses/{expense}', [ExpenseController::class, 'update'])->name('expenses.update');
    Route::delete('/colocation/{colocation}/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');

    Route::post('/colocation/{colocation}/payments/{payment}/mark-paid', [ExpenseController::class, 'markPayment'])->name('payments.mark-paid');

    Route::get('/colocation/{colocation}/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/colocation/{colocation}/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/colocation/{colocation}/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/colocation/{colocation}/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/colocation/{colocation}/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/colocation/{colocation}/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::post('/colocation/{colocation}/invitations', [InvitationController::class, 'store'])->name('invitations.store');
});

Route::get('/invitations/accept/{token}', [InvitationController::class, 'accept'])->name('invitations.accept');
Route::get('/invitations/reject/{token}', [InvitationController::class, 'reject'])->name('invitations.reject');

require __DIR__ . '/auth.php';
