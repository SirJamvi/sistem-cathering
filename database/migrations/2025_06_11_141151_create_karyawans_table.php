<?php
// 2025_06_11_141151_create_karyawans_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            // MENJADI
$table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('divisi_id')->constrained('divisis')->onDelete('restrict');
            $table->foreignId('shift_id')->constrained('shifts')->onDelete('restrict');
            $table->string('nip')->unique();
            $table->string('nama_lengkap');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->enum('status_kerja', ['aktif', 'cuti', 'sakit', 'non_aktif'])->default('aktif');
            $table->date('tanggal_bergabung');
            $table->boolean('berhak_konsumsi')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};