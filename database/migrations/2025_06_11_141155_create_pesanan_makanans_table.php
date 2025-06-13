<?php
// 2025_06_11_141152_create_pesanan_makanans_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanan_makanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_hrga_id')->constrained('admin_hrgas')->onDelete('restrict');
            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('restrict');
            $table->foreignId('shift_id')->constrained('shifts')->onDelete('restrict');
            $table->date('tanggal_pesanan');
            $table->integer('jumlah_porsi_dipesan');
            $table->decimal('total_harga', 12, 2);
            $table->enum('status_pesanan', [
                'draft', 
                'dikirim_ke_vendor', 
                'dikonfirmasi_vendor', 
                'dalam_persiapan', 
                'dikirim', 
                'diterima', 
                'selesai',
                'dibatalkan'
            ])->default('draft');
            $table->datetime('waktu_pengiriman_estimasi')->nullable();
            $table->text('catatan_pesanan')->nullable();
            $table->json('menu_detail')->nullable(); // detail menu yang dipesan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan_makanans');
    }
};