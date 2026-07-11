<?php

use App\Http\Controllers\ArsipController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ScannerController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('dashboard'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('kategori', KategoriController::class)->except(['show']);

    // Export route — harus sebelum resource
    Route::get('/arsip/export', [ArsipController::class, 'export'])->name('arsip.export');

    // Scan routes — harus sebelum resource agar tidak tertimpa
    Route::get('/arsip/scan', [ScannerController::class, 'index'])->name('arsip.scan');
    Route::post('/arsip/scan', [ScannerController::class, 'scan'])->name('arsip.scan.process');

    // Download route — harus sebelum resource
    Route::get('arsip/{arsip}/download', [ArsipController::class, 'download'])->name('arsip.download');

    Route::resource('arsip', ArsipController::class);
});