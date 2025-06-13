<?php
// 2025_06_11_141155_create_validasi_fisiks_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('validasi_fisiks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_makanan_id')->constrained('pesanan_makanans')->onDelete('cascade');
            $table->foreignId('admin_hrga_id')->constrained('admin_hrgas')->onDelete('restrict');
            $table->integer('jumlah_fisik_diterima');
            $table->integer('jumlah_kurang')->default(0);
            $table->integer('jumlah_rusak')->default(0);
            $table->enum('status_validasi', ['sesuai', 'kurang', 'lebih', 'ada_masalah'])->default('sesuai');
            $table->text('catatan_validasi')->nullable();
            $table->datetime('waktu_validasi');
            $table->json('foto_bukti')->nullable(); // array path foto validasi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('validasi_fisiks');
    }
};
