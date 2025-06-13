<?php
// 2025_06_11_141153_create_log_scan_qrs_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_scan_qrs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawans')->onDelete('cascade');
            $table->foreignId('koki_id')->constrained('kokis')->onDelete('restrict');
            $table->foreignId('qr_code_dinamis_id')->nullable()->constrained('qr_code_dinamis')->onDelete('set null');
            $table->string('qr_token_scanned'); // token QR yang di-scan
            $table->datetime('waktu_scan');
            $table->enum('hasil_scan', ['berhasil', 'gagal_expired', 'gagal_used', 'gagal_invalid', 'gagal_shift', 'gagal_double'])->default('gagal_invalid');
            $table->text('pesan_error')->nullable();
            $table->json('detail_validasi')->nullable(); // detail proses validasi
            $table->ipAddress('ip_scanner')->nullable();
            $table->string('device_info')->nullable();
            $table->timestamps();
            
            $table->index(['waktu_scan', 'hasil_scan']);
            $table->index(['karyawan_id', 'waktu_scan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_scan_qrs');
    }
};