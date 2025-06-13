<?php
// 2025_06_11_141153_create_qr_code_dinamis_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qr_code_dinamis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawans')->onDelete('cascade');
            $table->string('qr_token')->unique(); // token unik untuk QR
            $table->string('qr_hash'); // hash untuk validasi
            $table->datetime('created_at_qr'); // waktu QR dibuat
            $table->datetime('expired_at'); // waktu QR expired (15 detik dari created)
            $table->boolean('is_used')->default(false);
            $table->datetime('used_at')->nullable();
            $table->ipAddress('generated_ip')->nullable();
            $table->timestamps();
            
            // Index untuk performa
            $table->index(['qr_token', 'expired_at']);
            $table->index(['karyawan_id', 'created_at_qr']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qr_code_dinamis');
    }
};