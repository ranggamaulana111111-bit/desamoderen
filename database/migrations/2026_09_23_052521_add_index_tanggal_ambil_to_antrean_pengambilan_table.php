<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('antrean_pengambilan', function (Blueprint $table) {
            $table->index('tanggal_ambil');
        });
    }

    public function down(): void
    {
        Schema::table('antrean_pengambilan', function (Blueprint $table) {
            $table->dropIndex(['tanggal_ambil']);
        });
    }
};