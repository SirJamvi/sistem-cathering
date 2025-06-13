<?php
// 2025_06_11_141151_create_kokis_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kokis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->enum('status', ['aktif', 'non_aktif'])->default('aktif');
            $table->json('shift_bertugas')->nullable(); // array shift yang bisa ditangani
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kokis');
    }
};
