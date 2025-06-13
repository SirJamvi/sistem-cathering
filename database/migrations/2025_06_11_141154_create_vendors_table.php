<?php
// 2025_06_11_141154_create_vendors_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('nama_vendor');
            $table->string('kontak_person');
            $table->string('email')->unique();
            $table->string('phone');
            $table->text('alamat');
            $table->enum('status_kontrak', ['aktif', 'non_aktif', 'suspended'])->default('aktif');
            $table->date('tanggal_kontrak_mulai');
            $table->date('tanggal_kontrak_berakhir');
            $table->decimal('harga_per_porsi', 10, 2);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};