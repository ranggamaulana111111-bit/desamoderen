<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengajuan_surats', function (Blueprint $table) {
            $table->string('nomor_surat', 100)->nullable()->after('jenis_surat');
            $table->json('tanda_tangan_meta')->nullable()->after('catatan_admin');
        });
    }

    public function down(): void
    {
        Schema::table('pengajuan_surats', function (Blueprint $table) {
            $table->dropColumn(['nomor_surat', 'tanda_tangan_meta']);
        });
    }
};
