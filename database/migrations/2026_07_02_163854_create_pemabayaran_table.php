<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservasi_id')->constrained()->cascadeOnDelete(); // Opsional: relasi ke tabel reservasi hotel
            $table->string('invoice')->unique();
            $table->decimal('total', 10, 2);
            $table->text('qr_image')->nullable(); // Menyimpan URL atau Base64 gambar QRIS
            $table->json('raw_response')->nullable(); // Menyimpan respon asli dari Pakasir
            $table->enum('status', ['pending', 'berhasil', 'gagal', 'dibatalkan'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemabayaran');
    }
};
