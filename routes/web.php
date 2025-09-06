<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DynamicCssController;
use App\Http\Controllers\MemorialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Route;

// Dynamic Stylesheet Route
Route::get('/css/dynamic-styles.css', [DynamicCssController::class, 'generate'])->name('css.dynamic');

Route::get('/', function () { return view('welcome'); });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/purchase', [PurchaseController::class, 'show'])->name('purchase.show');
    Route::post('/purchase', [PurchaseController::class, 'processPayment'])->name('purchase.process');
    Route::get('/purchase/success', [PurchaseController::class, 'success'])->name('purchase.success');
    Route::get('/purchase/cancel', [PurchaseController::class, 'cancel'])->name('purchase.cancel');
    Route::resource('memorials', MemorialController::class)->except(['index', 'show']);
});

// Public Memorial Page Route
Route::get('/memorials/{memorial:slug}', [MemorialController::class, 'showPublic'])->name('memorials.show_public');

// --- ADMIN ROUTES ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/memorials/{memorial}/edit', [MemorialController::class, 'edit'])->name('memorials.edit');
    Route::put('/memorials/{memorial}', [MemorialController::class, 'update'])->name('memorials.update');
    Route::delete('/memorials/{memorial}', [MemorialController::class, 'destroy'])->name('memorials.destroy');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
});

require __DIR__.'/auth.php';