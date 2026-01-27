<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HeroSlideController;

/*
|--------------------------------------------------------------------------
| PUBLIC / GUEST ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('welcome');

Route::get('/jelajah', [ArchiveController::class, 'jelajah'])
    ->name('jelajah');

// Detail arsip (guest)
Route::get('/collections/{id}', [ArchiveController::class, 'showGuest'])
    ->name('archive.show-guest')
    ->whereNumber('id');

// Preview / view file arsip (guest)
Route::get('/collections/{id}/view', [ArchiveController::class, 'showFile'])
    ->name('archive.show_file')
    ->whereNumber('id');


/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard (semua user login)
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | ARCHIVE MANAGEMENT (admin & superadmin)
    |--------------------------------------------------------------------------
    */

    Route::resource('archive', ArchiveController::class)->except(['show']);

    Route::get('/archive/{archive}/show', [ArchiveController::class, 'show'])
        ->name('archive.show');

    Route::delete('/archive-file/{archiveFile}', [ArchiveController::class, 'deleteFile'])
        ->name('archive.deleteFile');
});


/*
|--------------------------------------------------------------------------
| SUPER ADMIN ONLY ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'is_superadmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Admin user management
        Route::resource('admin', AdminController::class)
            ->except(['edit', 'update']);

        // HERO SLIDE MANAGEMENT (SUPERADMIN ONLY)
        Route::get('/hero', [HeroSlideController::class, 'index'])
            ->name('hero.index');

        Route::post('/hero', [HeroSlideController::class, 'store'])
            ->name('hero.store');

        Route::patch('/hero/{id}/toggle', [HeroSlideController::class, 'toggle'])
            ->name('hero.toggle');

        Route::put('/hero/reorder', [HeroSlideController::class, 'reorder'])
            ->name('hero.reorder');

        Route::delete('/hero/{id}', [HeroSlideController::class, 'destroy'])
            ->name('hero.destroy');
    });


require __DIR__ . '/auth.php';
