<?php

use App\Http\Controllers\ArsipController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScannerController;
use App\Services\OcrService;

Route::get('/', fn () => redirect()->route('dashboard'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('kategori', KategoriController::class)->except(['show']);

    Route::get(
    '/arsip/scan',
    function () {
        return 'Halaman Scan Dokumen';
    }
)->name('arsip.scan');
});

Route::get(
    '/arsip/scan',
    [ScannerController::class, 'index']
)->name('arsip.scan');


Route::post(
    '/arsip/scan',
    [ScannerController::class, 'scan']
)->name('arsip.scan.process');

    Route::get('arsip/{arsip}/download', [ArsipController::class, 'download'])->name('arsip.download');
    Route::resource('arsip', ArsipController::class);

    Route::get('/test-ocr', function(OcrService $ocr){

    $text = $ocr->read(
        storage_path('app/public/test.png')
    );


    return nl2br($text);

});