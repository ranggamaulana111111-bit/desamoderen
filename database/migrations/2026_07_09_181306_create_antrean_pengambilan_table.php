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
        Schema::create('antrean_pengambilan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained('pengajuan_surats')->onDelete('cascade');
            $table->string('nomor_antrean', 20);
            $table->date('tanggal_ambil');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('kode_qr', 64)->unique();
            $table->enum('status', ['menunggu', 'diambil', 'lewat'])->default('menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antrean_pengambilan');
    }
};
