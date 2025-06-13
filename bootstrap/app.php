<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php', // Pastikan baris ini ada untuk rute API
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // --- TAMBAHKAN ALIAS MIDDLEWARE DI SINI ---
        $middleware->alias([
            'role.hrga' => \App\Http\Middleware\CekRoleHrga::class,
            'role.karyawan' => \App\Http\Middleware\CekRoleKaryawan::class,
            'role.koki' => \App\Http\Middleware\CekRoleKoki::class,
            'shift.aktif' => \App\Http\Middleware\CekShiftAktif::class,
            'qr.validate' => \App\Http\Middleware\ValidasiQrCode::class,
            'throttle.scan' => \App\Http\Middleware\RateLimitScanQr::class,
            'prevent.screenshot' => \App\Http\Middleware\CegahScreenshot::class,
            
            // Anda juga bisa mendaftarkan middleware dari Spatie di sini jika perlu
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();