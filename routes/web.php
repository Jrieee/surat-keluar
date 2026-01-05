<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
});

// Dashboard dengan logic berbeda per role
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Surat Keluar Routes (Admin & Staff)
    Route::resource('surat-keluars', SuratKeluarController::class);
    Route::get('surat-keluars/{suratKeluar}/download', [SuratKeluarController::class, 'download'])->name('surat-keluars.download');
    
    // User Management Routes (Admin only)
    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class)->except(['create', 'store', 'edit', 'update']);
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});

require __DIR__.'/auth.php';

