<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvitationController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('colocation', ColocationController::class);
    Route::post('colocation/{id}/leave', [ColocationController::class, 'leave'])->name('colocation.leave');

    Route::resource('expense', ExpenseController::class);
    Route::resource('payment', PaymentController::class);
    Route::resource('category', CategoryController::class);

    Route::get('invitations', [InvitationController::class, 'index'])->name('invitations.index');
    Route::get('invitations/create', [InvitationController::class, 'create'])->name('invitations.create');
    Route::post('invitations', [InvitationController::class, 'store'])->name('invitations.store');
    Route::post('invitations/{invitation}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');
    Route::post('invitations/{invitation}/decline', [InvitationController::class, 'decline'])->name('invitations.decline');

    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'index'])->name('index');
        Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users');
        Route::get('/colocations', [\App\Http\Controllers\AdminController::class, 'colocations'])->name('colocations');
        Route::get('/expenses', [\App\Http\Controllers\AdminController::class, 'expenses'])->name('expenses');
        Route::get('/payments', [\App\Http\Controllers\AdminController::class, 'payments'])->name('payments');
        Route::get('/categories', [\App\Http\Controllers\AdminController::class, 'categories'])->name('categories');
        Route::get('/invitations', [\App\Http\Controllers\AdminController::class, 'invitations'])->name('invitations');
        Route::post('/users/{id}/ban', [\App\Http\Controllers\AdminController::class, 'ban'])->name('ban');
        Route::post('/users/{id}/unban', [\App\Http\Controllers\AdminController::class, 'unban'])->name('unban');
    });
});

require __DIR__.'/auth.php';
