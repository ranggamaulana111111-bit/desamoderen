<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('letter_configs', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_surat', 50)->unique();
            $table->string('label', 100);
            $table->string('kode_klasifikasi', 10);
            $table->unsignedTinyInteger('masa_berlaku_bulan')->default(3);
            $table->json('fields');
            $table->json('requirements')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('letter_configs');
    }
};
