<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Aplikasi Pemilihan Ketua OSIS
|--------------------------------------------------------------------------
| Akses tanpa token autentikasi
*/

Route::get('/rekap', [ApiController::class, 'rekap']);
