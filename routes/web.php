<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Import semua controller web
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardHrgaController;
use App\Http\Controllers\Web\DashboardKokiController;
use App\Http\Controllers\Web\LaporanWebController;
use App\Http\Controllers\Web\ManajemenSistemController;
use App\Http\Controllers\Web\MonitoringController;

// Rute utama yang "pintar"
Route::get('/', function () {
    if (Auth::guest()) {
        return redirect()->route('login');
    }

    $user = Auth::user();
    if ($user->hasRole('hrga')) {
        return redirect()->route('hrga.dashboard');
    } elseif ($user->hasRole('koki')) {
        return redirect()->route('koki.dashboard');
    }

    // Fallback jika punya role lain atau tidak ada dashboard khusus
    return redirect('/login');
});

// Rute untuk proses otentikasi (login & logout)
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


// RUTE DASHBOARD WEB YANG MEMERLUKAN LOGIN
Route::middleware(['auth'])->group(function () {

    // === RUTE DASHBOARD HRGA ===
    Route::prefix('hrga-dashboard')->middleware('role:hrga')->name('hrga.')->group(function() {
        Route::get('/', [DashboardHrgaController::class, 'index'])->name('dashboard');
        
        Route::get('/laporan/harian', [LaporanWebController::class, 'harian'])->name('laporan.harian');
        Route::get('/laporan/bulanan', [LaporanWebController::class, 'bulanan'])->name('laporan.bulanan');
        
        Route::get('/monitoring/konsumsi', [MonitoringController::class, 'konsumsiHarian'])->name('monitoring.konsumsi');
        
        // Grup untuk manajemen sistem
        Route::prefix('manajemen')->name('manajemen.')->group(function() {
            Route::get('/karyawan', [ManajemenSistemController::class, 'indexKaryawan'])->name('karyawan.index');
            Route::get('/karyawan/create', [ManajemenSistemController::class, 'createKaryawan'])->name('karyawan.create');
            Route::post('/karyawan', [ManajemenSistemController::class, 'storeKaryawan'])->name('karyawan.store');
        });
    });

    // === RUTE DASHBOARD KOKI ===
    Route::prefix('koki-dashboard')->middleware('role:koki')->name('koki.')->group(function() {
        Route::get('/', [DashboardKokiController::class, 'index'])->name('dashboard');
        Route::post('/scan', [DashboardKokiController::class, 'prosesScan'])->name('scan');
    });
}); 