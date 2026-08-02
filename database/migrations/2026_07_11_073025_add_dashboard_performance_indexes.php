<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengajuan_surats', function (Blueprint $table) {
            $table->index('status');
            $table->index('created_at');
            $table->index(['status', 'created_at']);
            $table->index('jenis_surat');
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->index('aksi');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->index('tanggal');
            $table->index(['tanggal', 'status']);
        });

        Schema::table('berita', function (Blueprint $table) {
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('pengajuan_surats', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['status', 'created_at']);
            $table->dropIndex(['jenis_surat']);
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropIndex(['aksi']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex(['tanggal']);
            $table->dropIndex(['tanggal', 'status']);
        });

        Schema::table('berita', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });
    }
};
