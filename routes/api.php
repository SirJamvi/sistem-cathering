<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Import semua controller yang akan digunakan
use App\Http\Controllers\Api\AdminHrgaController;
use App\Http\Controllers\Api\AutentikasiController;
use App\Http\Controllers\Api\DistribusiMakananController;
use App\Http\Controllers\Api\KaryawanController;
use App\Http\Controllers\Api\KokiController;
use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\Api\ManajemenPenggunaController;
use App\Http\Controllers\Api\PesananMakananController;
use App\Http\Controllers\Api\QrCodeController;
use App\Http\Controllers\Api\ShiftController;
use App\Http\Controllers\Api\ValidasiController;
use App\Http\Controllers\Api\VendorController;

// RUTE PUBLIK
// Tidak memerlukan login
Route::post('/login', [AutentikasiController::class, 'login']);

// RUTE YANG MEMERLUKAN AUTENTIKASI (SEMUA ROLE)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AutentikasiController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        // Mengembalikan data user yang sedang login beserta rolenya
        return $request->user()->load($request->user()->getRoleNames()->first());
    });

    // === RUTE KHUSUS KARYAWAN ===
    Route::prefix('karyawan')->middleware('role:karyawan')->group(function () {
        Route::get('/profil', [KaryawanController::class, 'profil']);
        Route::get('/status-konsumsi', [KaryawanController::class, 'statusKonsumsi']);
        
        // Menerapkan middleware untuk cek jam makan dan pencegah screenshot
        Route::middleware(['shift.aktif', 'prevent.screenshot'])->group(function() {
            Route::post('/qr-code/generate', [QrCodeController::class, 'generate']);
        });
    });

    // === RUTE KHUSUS KOKI ===
    Route::prefix('koki')->middleware('role:koki')->group(function () {
        Route::get('/monitoring-shift', [KokiController::class, 'monitoringShift']);
        
        // Menerapkan middleware validasi QR dan rate limit pada endpoint scan
        Route::post('/scan-qr', [DistribusiMakananController::class, 'scanQr'])
             ->middleware(['qr.validate', 'throttle.scan']);
    });

    // === RUTE KHUSUS HRGA ===
    Route::prefix('hrga')->middleware('role:hrga')->group(function () {
        Route::get('/dashboard-summary', [AdminHrgaController::class, 'dashboardSummary']);

        // Rute untuk Laporan
        Route::get('/laporan/harian', [LaporanController::class, 'harian']);
        Route::get('/laporan/bulanan', [LaporanController::class, 'bulanan']);

        // Rute untuk Pesanan Makanan (CRUD)
        Route::apiResource('pesanan', PesananMakananController::class)->only(['index', 'store', 'show']);

        // Rute untuk Manajemen Pengguna (Karyawan)
        Route::get('/pengguna/karyawan', [ManajemenPenggunaController::class, 'indexKaryawan']);
        Route::post('/pengguna/karyawan', [ManajemenPenggunaController::class, 'storeKaryawan']);

        // Rute untuk Validasi Fisik
        Route::get('/validasi/pesanan-list', [ValidasiController::class, 'listPesananUntukValidasi']);
        Route::post('/validasi/fisik', [ValidasiController::class, 'storeValidasiFisik']);

        // Rute untuk mengambil data master (untuk form di mobile app)
        Route::get('/master/vendors', [VendorController::class, 'index']);
        Route::get('/master/shifts', [ShiftController::class, 'index']);
    });
});