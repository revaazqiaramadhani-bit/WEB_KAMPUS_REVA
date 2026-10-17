<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\SessionController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.page');
Route::resource('mahasiswa', MahasiswaController::class);
Route::resource('prodi', ProdiController::class)->except('show');
Route::resource('mata-kuliah', MataKuliahController::class)
    ->parameters(['mata-kuliah' => 'mataKuliah'])
    ->except('show');
Route::get('/login', [SessionController::class, 'index'])->name('login');
Route::get('sesi', [SessionController::class, 'index']);
Route::post('/sesi/login', [SessionController::class, 'login']);
Route::post('/sesi/logout', [SessionController::class, 'logout'])->name('logout');


