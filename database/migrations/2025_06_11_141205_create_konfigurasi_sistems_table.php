<?php
// 2025_06_11_141205_create_konfigurasi_sistems_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konfigurasi_sistems', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // nama konfigurasi
            $table->text('value'); // nilai konfigurasi
            $table->string('group')->default('general'); // grup konfigurasi
            $table->text('description')->nullable(); // deskripsi konfigurasi
            $table->enum('type', ['string', 'integer', 'boolean', 'json', 'text'])->default('string');
            $table->boolean('is_public')->default(false); // apakah bisa diakses public
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konfigurasi_sistems');
    }
};