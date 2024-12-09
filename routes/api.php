<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\BarberController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\ReviewController;

Route::post('/pelanggan', [PelangganController::class, 'store']);
Route::post('/barber', [BarberController::class, 'store']);
Route::get('/barber', [BarberController::class, 'index']);
Route::post('/layanan', [LayananController::class, 'store']);
Route::get('/layanan', [LayananController::class, 'index']);
Route::get('/pelanggan', [PelangganController::class, 'index']);
Route::post('/login', [PelangganController::class, 'login']);
Route::get('/reviews', [ReviewController::class, 'index']);
Route::get('/reviews/barber/{barber_id}', [ReviewController::class, 'getReviewsByBarber']);
Route::post('/reviews', [ReviewController::class, 'store']);
Route::middleware('auth:sanctum')->post('/logout', [PelangganController::class, 'logout']);

