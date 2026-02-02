<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HeroSlideController;
use App\Http\Controllers\TeamMemberController;

/*
|--------------------------------------------------------------------------
| PUBLIC / GUEST ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('public.archive')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('welcome');
    Route::get('/jelajah', [ArchiveController::class, 'jelajah'])->name('jelajah');

    Route::get('/collections/{id}', [ArchiveController::class, 'showGuest'])
        ->name('archive.show-guest');

    Route::get('/collections/{id}/view', [ArchiveController::class, 'showFile'])
        ->name('archive.show_file');

    Route::get('/file/download/{id}', [ArchiveController::class, 'downloadWatermarked'])
        ->name('file.download.watermark');

    Route::view('/tentang-kami', 'public_guest.about')->name('about');

    // TEAM ROUTES
    Route::get('/tim-kami', [TeamMemberController::class, 'index'])->name('team');
    Route::get('/tim-kami/{id}', [TeamMemberController::class, 'show'])->name('team.show');


});


/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Archive management
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

Route::middleware(['auth', 'verified', 'superadmin'])
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

        // TEAM MANAGEMENT
        Route::get('/team', [TeamMemberController::class, 'manage'])->name('team.index');
        Route::get('/team/create', [TeamMemberController::class, 'create'])->name('team.create');
        Route::post('/team', [TeamMemberController::class, 'store'])->name('team.store');
        Route::get('/team/{teamMember}/edit', [TeamMemberController::class, 'edit'])->name('team.edit');
        Route::put('/team/{teamMember}', [TeamMemberController::class, 'update'])->name('team.update');
        Route::delete('/team/{teamMember}', [TeamMemberController::class, 'destroy'])->name('team.destroy');
    });


require __DIR__ . '/auth.php';
