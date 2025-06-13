<?php
// 2025_06_11_141154_create_status_konsumsis_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('status_konsumsis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawans')->onDelete('cascade');
            $table->date('tanggal');
            $table->foreignId('shift_id')->constrained('shifts')->onDelete('restrict');
            $table->boolean('sudah_konsumsi')->default(false);
            $table->datetime('waktu_konsumsi')->nullable();
            $table->enum('status_kehadiran', ['hadir', 'tidak_hadir', 'cuti', 'sakit', 'izin'])->default('hadir');
            $table->text('catatan')->nullable();
            $table->timestamps();
            
            // Unique constraint per karyawan per hari
            $table->unique(['karyawan_id', 'tanggal'], 'unique_daily_status');
            $table->index(['tanggal', 'shift_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('status_konsumsis');
    }
};