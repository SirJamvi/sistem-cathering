<?php
// 2025_06_11_141152_create_distribusi_makanans_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('distribusi_makanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_makanan_id')->constrained('pesanan_makanans')->onDelete('restrict');
            $table->foreignId('karyawan_id')->constrained('karyawans')->onDelete('restrict');
            $table->foreignId('koki_id')->constrained('kokis')->onDelete('restrict');
            $table->foreignId('qr_code_dinamis_id')->constrained('qr_code_dinamis')->onDelete('restrict');
            $table->datetime('waktu_pengambilan');
            $table->enum('status_distribusi', ['berhasil', 'gagal', 'dikembalikan'])->default('berhasil');
            $table->text('catatan')->nullable();
            $table->json('detail_validasi')->nullable(); // detail hasil validasi QR
            $table->timestamps();
            
            // Unique constraint untuk mencegah double pengambilan
            $table->unique(['pesanan_makanan_id', 'karyawan_id'], 'unique_daily_consumption');
            $table->index(['waktu_pengambilan', 'status_distribusi']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('distribusi_makanans');
    }
};