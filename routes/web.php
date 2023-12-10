<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LandingController::class, 'home']);
Route::post('/cek-kelulusan', [LandingController::class, 'home']);

// Auth
Route::get('/admin', [AuthController::class, 'login']);
Route::get('/daftar', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::post('/admin', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Admin
Route::get('/admin/beranda', [AdminController::class, 'home']);
Route::get('/admin/lihat-peserta', [AdminController::class, 'participant']);
Route::get('/admin/spk', [AdminController::class, 'spk']);

Route::post('/admin/beri-nilai', [AdminController::class, 'grade']);
Route::post('/admin/beri-kelulusan', [AdminController::class, 'graduate']);


