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
        Schema::create('reservasis', function (Blueprint $table) {
            $table->id();
            $table->string('no_reservasi')->unique();
            $table->string('nama_tamu');
            $table->string('no_ktp');
            $table->string('no_hp');
            $table->foreignId('kamar_id')->constrained('kamars')->onDelete('cascade');
            $table->json('ekstra')->nullable();
            $table->date('check_in');
            $table->date('check_out');
            $table->enum('tipe_reservasi', ['Walk-in', 'Online'])->default('Walk-in');
            $table->enum('status_reservasi', ['Aktif', 'Selesai', 'Batal'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasis');
    }
};
