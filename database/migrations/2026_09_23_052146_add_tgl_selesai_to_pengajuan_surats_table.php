<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengajuan_surats', function (Blueprint $table) {
            $table->date('tgl_selesai')->nullable()->after('hash_verifikasi');
            $table->index(['jenis_surat', 'updated_at'], 'pengajuan_surats_jenis_updated_index');
        });
    }

    public function down(): void
    {
        Schema::table('pengajuan_surats', function (Blueprint $table) {
            $table->dropIndex('pengajuan_surats_jenis_updated_index');
            $table->dropColumn('tgl_selesai');
        });
    }
};