<?php
// 2025_06_11_141154_create_laporan_harians_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_harians', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('shift_id')->constrained('shifts')->onDelete('restrict');
            $table->foreignId('pesanan_makanan_id')->constrained('pesanan_makanans')->onDelete('restrict');
            $table->integer('total_karyawan_hadir');
            $table->integer('total_porsi_dipesan');
            $table->integer('total_porsi_dikonsumsi');
            $table->integer('total_porsi_sisa');
            $table->decimal('persentase_konsumsi', 5, 2); // persentase yang dikonsumsi
            $table->json('detail_per_divisi')->nullable(); // breakdown per divisi
            $table->text('catatan')->nullable();
            $table->foreignId('dibuat_oleh')->constrained('admin_hrgas')->onDelete('restrict');
            $table->timestamps();
            
            $table->unique(['tanggal', 'shift_id'], 'unique_daily_report');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_harians');
    }
};