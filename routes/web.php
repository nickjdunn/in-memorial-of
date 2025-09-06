<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MemorialController as AdminMemorialController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DynamicCssController;
use App\Http\Controllers\MemorialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Models\Memorial;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Dynamic Stylesheet Route
Route::get('/css/dynamic-styles.css', [DynamicCssController::class, 'generate'])->name('css.dynamic');

// Homepage Route with Example Memorial
Route::get('/', function () {
    // Cache the query for performance for 60 minutes
    $exampleMemorial = Cache::remember('homepage_example_memorial', 3600, function () {
        $setting = Setting::where('key', 'homepage_example_memorial_id')->first();
        // Eager load the user to avoid extra queries in the view
        return $setting ? Memorial::with('user')->find($setting->value) : null;
    });

    return view('welcome', [
        'exampleMemorial' => $exampleMemorial
    ]);
});

// Authenticated User Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// All routes inside this group require the user to be logged in.
Route::middleware('auth')->group(function () {
    
    // Profile routes (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Purchase routes
    Route::get('/purchase', [PurchaseController::class, 'show'])->name('purchase.show');
    Route::post('/purchase', [PurchaseController::class, 'processPayment'])->name('purchase.process');
    Route::get('/purchase/success', [PurchaseController::class, 'success'])->name('purchase.success');
    Route::get('/purchase/cancel', [PurchaseController::class, 'cancel'])->name('purchase.cancel');
    
    // User-facing Memorial Management Routes
    Route::resource('memorials', MemorialController::class)->except(['index', 'show']);
});

// Public Memorial Page Route - This is accessible to anyone with the link.
Route::get('/memorials/{memorial:slug}', [MemorialController::class, 'showPublic'])->name('memorials.show_public');


// --- ADMIN ROUTES ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Redirect the base dashboard to the users list
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Dedicated resource routes for Users and Memorials
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/memorials', [AdminMemorialController::class, 'index'])->name('memorials.index');

    // Admin Memorial Management Routes (These are for actions like edit/delete)
    Route::get('/memorials/{memorial}/edit', [MemorialController::class, 'edit'])->name('memorials.edit');
    Route::put('/memorials/{memorial}', [MemorialController::class, 'update'])->name('memorials.update');
    Route::delete('/memorials/{memorial}', [MemorialController::class, 'destroy'])->name('memorials.destroy');

    // Admin User Management Routes
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Admin route to create a memorial for a specific user
    Route::get('/users/{user}/memorials/create', [AdminMemorialController::class, 'createForUser'])->name('users.memorials.create');

    // Admin Settings Routes
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
});


require __DIR__.'/auth.php';