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
            $table->foreignId('reservasi_id')->constrained()->cascadeOnDelete();
            $table->string('invoice', 20)->unique();
            $table->decimal('total', 10, 2);
            $table->text('qr_image')->nullable();
            $table->json('raw_response')->nullable();
            $table->enum('status', ['pending', 'berhasil', 'gagal', 'dibatalkan'])->default('pending');

            // PERBAIKAN DI SINI: Menggunakan 'timestamp' (singular) dan 'nullable()' dengan tanda kurung
            $table->timestamp('expired_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // PERBAIKAN DI SINI: Menyesuaikan nama tabel agar bisa di-rollback dengan aman
        Schema::dropIfExists('pembayarans');
    }
};
