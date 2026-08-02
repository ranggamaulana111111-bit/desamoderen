<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apbdesa', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->year('tahun');
            $table->enum('kategori', ['Pendapatan', 'Belanja']);
            $table->string('bidang');
            $table->string('uraian');
            $table->decimal('anggaran', 15, 2);
            $table->decimal('realisasi', 15, 2)->default(0);
            $table->string('sumber_dana')->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('status', ['Draft', 'Disetujui', 'Direvisi', 'Ditolak']);
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apbdesa');
    }
};
