<?php
// 2025_06_11_141150_create_shifts_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('nama_shift'); // Shift 1, Shift 2, Shift 3
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->time('jam_makan_mulai'); // waktu distribusi makanan dimulai
            $table->time('jam_makan_selesai'); // waktu distribusi makanan berakhir
            $table->text('keterangan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};