<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::post('/users/{user}/ban', [AdminController::class, 'ban'])->name('ban');
    Route::post('/users/{user}/unban', [AdminController::class, 'unban'])->name('unban');
    Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('destroy');
});

require __DIR__.'/auth.php';


Route::middleware(['auth'])->group(function() {
    Route::resource('colocations', ColocationController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::resource('categories', CategoryController::class);

    Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::post('payments', [PaymentController::class, 'store'])->name('payments.store');
    
    Route::get('invitations', [InvitationController::class, 'index'])->name('invitations.index');
    Route::post('invitations/invite', [InvitationController::class, 'invite'])->name('invitations.invite');
    Route::post('invitations/{invitation}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');
    Route::post('invitations/{invitation}/refuse', [InvitationController::class, 'refuse'])->name('invitations.refuse');
});