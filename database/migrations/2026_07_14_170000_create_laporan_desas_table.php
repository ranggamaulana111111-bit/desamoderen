<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_desas', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('judul');
            $table->date('periode_mulai');
            $table->date('periode_akhir');
            $table->enum('tipe_periode', ['bulanan', 'kuartal', 'tahunan', 'khusus']);
            $table->json('modul_yang_dipilih');
            $table->json('konten_naratif')->nullable();
            $table->enum('status', ['draft', 'finalisasi', 'archived'])->default('draft');
            $table->enum('format_pdf', ['surat_resmi', 'laporan_institusional'])->default('surat_resmi');
            $table->string('nomor_laporan')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->string('pdf_path')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'created_by']);
            $table->index(['periode_mulai', 'periode_akhir']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_desas');
    }
};
