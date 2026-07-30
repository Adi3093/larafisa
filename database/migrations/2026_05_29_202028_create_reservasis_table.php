<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservasis', function (Blueprint $table) {
            $table->id();
            $table->string('no_reservasi', 20)->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('dibuat_oleh_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('kamar_id')->constrained('kamars')->cascadeOnDelete();
            $table->string('nama_tamu', 100);
            $table->string('no_ktp', 16)->nullable();
            $table->string('no_hp', 15);
            $table->text('alamat')->nullable();
            $table->datetime('check_in');
            $table->datetime('check_out');
            $table->json('ekstra')->nullable();
            $table->enum('tipe_reservasi', ['Walk-in', 'Online'])->default('Walk-in');
            $table->enum('status_reservasi', ['Menunggu Konfirmasi', 'Terkonfirmasi', 'Check-In', 'Selesai', 'Dibatalkan'])->default('Terkonfirmasi');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasis');
    }
};
