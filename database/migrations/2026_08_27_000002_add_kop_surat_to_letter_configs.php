<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('letter_configs', function (Blueprint $table) {
            $table->string('kop_nama_kabupaten')->nullable()->after('is_active');
            $table->string('kop_nama_desa')->nullable()->after('kop_nama_kabupaten');
            $table->string('kop_nama_kecamatan')->nullable()->after('kop_nama_desa');
            $table->string('kop_alamat_kantor')->nullable()->after('kop_nama_kecamatan');
            $table->string('kop_email_desa')->nullable()->after('kop_alamat_kantor');
            $table->string('kop_telepon_desa')->nullable()->after('kop_email_desa');
            $table->string('kop_logo_pemda_path')->nullable()->after('kop_telepon_desa');
            $table->string('kop_logo_desa_path')->nullable()->after('kop_logo_pemda_path');
        });
    }

    public function down(): void
    {
        Schema::table('letter_configs', function (Blueprint $table) {
            $table->dropColumn([
                'kop_nama_kabupaten',
                'kop_nama_desa',
                'kop_nama_kecamatan',
                'kop_alamat_kantor',
                'kop_email_desa',
                'kop_telepon_desa',
                'kop_logo_pemda_path',
                'kop_logo_desa_path',
            ]);
        });
    }
};
