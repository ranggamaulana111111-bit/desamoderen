<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_masuks', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('nomor_agenda')->unique();
            $table->date('tanggal_terima');
            $table->date('tanggal_surat');
            $table->string('nomor_surat');
            $table->string('pengirim');
            $table->text('perihal');
            $table->string('jenis_surat');
            $table->string('sifat_surat');
            $table->string('file_path')->nullable();
            $table->string('status')->default('unread');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_masuks');
    }
};
