<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ArchiveController::class, 'welcome'])->name('welcome');

// Route untuk melihat detail arsip (guest/public) - HARUS SEBELUM resource route
Route::get('/collections/{id}', [ArchiveController::class, 'showGuest'])->name('archive.show-guest')->where('id', '[0-9]+');

// Route untuk melihat detail file/preview (guest/public)
Route::get('/collections/{id}/view', [ArchiveController::class, 'showFile'])->name('archive.show_file')->where('id', '[0-9]+');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Archive routes (untuk semua user yang sudah login)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('archive', ArchiveController::class)->except(['show']);
    // Route khusus admin show
    Route::get('/archive/{archive}/show', [ArchiveController::class, 'show'])->name('archive.show');
    Route::delete('archive-file/{archiveFile}', [ArchiveController::class, 'deleteFile'])->name('archive.deleteFile');
});

// Admin management routes (hanya untuk superadmin)
Route::middleware(['auth', 'verified', 'is_superadmin'])->group(function () {
    Route::resource('admin', AdminController::class)->except(['edit', 'update']);
});

require __DIR__.'/auth.php';
