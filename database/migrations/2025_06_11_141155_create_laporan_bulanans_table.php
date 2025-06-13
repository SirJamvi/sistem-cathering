<?php
// 2025_06_11_141155_create_laporan_bulanans_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_bulanans', function (Blueprint $table) {
            $table->id();
            $table->integer('bulan');
            $table->integer('tahun');
            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('restrict');
            $table->integer('total_hari_operasional');
            $table->integer('total_porsi_dipesan');
            $table->integer('total_porsi_dikonsumsi');
            $table->integer('total_porsi_sisa');
            $table->decimal('total_biaya', 15, 2);
            $table->decimal('rata_rata_konsumsi_harian', 8, 2);
            $table->decimal('persentase_efektivitas', 5, 2);
            $table->json('detail_per_shift')->nullable();
            $table->json('detail_per_divisi')->nullable();
            $table->json('trend_konsumsi')->nullable(); // data untuk grafik trend
            $table->text('evaluasi')->nullable();
            $table->text('rekomendasi')->nullable();
            $table->foreignId('dibuat_oleh')->constrained('admin_hrgas')->onDelete('restrict');
            $table->timestamps();
            
            $table->unique(['bulan', 'tahun', 'vendor_id'], 'unique_monthly_report');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_bulanans');
    }
};