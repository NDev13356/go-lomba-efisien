<?php

use App\Http\Controllers\Admin\AdminController as AdminAdminController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KandidatController as AdminKandidatController;
use App\Http\Controllers\Admin\SiswaController as AdminSiswaController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Siswa\AuthController as SiswaAuthController;
use App\Http\Controllers\Siswa\VotingController as SiswaVotingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Aplikasi Pemilihan Ketua OSIS
|--------------------------------------------------------------------------
*/

// ============ PUBLIC ROUTES ============
Route::get('/', [PublicController::class, 'index'])->name('public.index');

// ============ PUBLIC REST API ============
Route::prefix('api')->group(function () {
    Route::get('/kandidat', [PublicController::class, 'apiKandidat'])->name('api.kandidat');
    Route::get('/hasil', [PublicController::class, 'apiHasil'])->name('api.hasil');
});
Route::get('/api-docs', [PublicController::class, 'apiDocs'])->name('api.docs');

// ============ SISWA ROUTES ============
Route::prefix('siswa')->group(function () {
    // Auth (tanpa middleware)
    Route::get('/login', [SiswaAuthController::class, 'showLogin'])->name('siswa.login');
    Route::post('/login', [SiswaAuthController::class, 'login'])->name('siswa.login.post');
    
    // Protected (dengan middleware)
    Route::middleware('siswa')->group(function () {
        Route::get('/voting', [SiswaVotingController::class, 'showVoting'])->name('siswa.voting');
        Route::post('/vote', [SiswaVotingController::class, 'vote'])->name('siswa.vote');
        Route::post('/logout', [SiswaAuthController::class, 'logout'])->name('siswa.logout');
    });
});

// ============ ADMIN ROUTES ============
Route::prefix('admin')->group(function () {
    // Auth (tanpa middleware)
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    
    // Protected (dengan middleware)
    Route::middleware('admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
        
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        
        // CRUD Kandidat
        Route::get('/kandidat', [AdminKandidatController::class, 'index'])->name('admin.kandidat.index');
        Route::get('/kandidat/create', [AdminKandidatController::class, 'create'])->name('admin.kandidat.create');
        Route::post('/kandidat', [AdminKandidatController::class, 'store'])->name('admin.kandidat.store');
        Route::get('/kandidat/{id}/edit', [AdminKandidatController::class, 'edit'])->name('admin.kandidat.edit');
        Route::put('/kandidat/{id}', [AdminKandidatController::class, 'update'])->name('admin.kandidat.update');
        Route::delete('/kandidat/{id}', [AdminKandidatController::class, 'destroy'])->name('admin.kandidat.destroy');
        
        // CRUD Siswa
        Route::get('/siswa', [AdminSiswaController::class, 'index'])->name('admin.siswa.index');
        Route::get('/siswa/create', [AdminSiswaController::class, 'create'])->name('admin.siswa.create');
        Route::post('/siswa', [AdminSiswaController::class, 'store'])->name('admin.siswa.store');
        Route::get('/siswa/{nisn}/edit', [AdminSiswaController::class, 'edit'])->name('admin.siswa.edit');
        Route::put('/siswa/{nisn}', [AdminSiswaController::class, 'update'])->name('admin.siswa.update');
        Route::delete('/siswa/{nisn}', [AdminSiswaController::class, 'destroy'])->name('admin.siswa.destroy');
        
        // CRUD Admin
        Route::get('/akun', [AdminAdminController::class, 'index'])->name('admin.admin.index');
        Route::get('/akun/create', [AdminAdminController::class, 'create'])->name('admin.admin.create');
        Route::post('/akun', [AdminAdminController::class, 'store'])->name('admin.admin.store');
        Route::get('/akun/{id}/edit', [AdminAdminController::class, 'edit'])->name('admin.admin.edit');
        Route::put('/akun/{id}', [AdminAdminController::class, 'update'])->name('admin.admin.update');
        Route::delete('/akun/{id}', [AdminAdminController::class, 'destroy'])->name('admin.admin.destroy');
    });
});
