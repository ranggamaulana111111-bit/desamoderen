<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengajuan_surats', function (Blueprint $table) {
            $table->string('jenis_surat', 50)->change();
        });

        Schema::table('letter_configs', function (Blueprint $table) {
            if (! Schema::hasColumn('letter_configs', 'body_template')) {
                $table->text('body_template')->nullable()->after('fields');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pengajuan_surats', function (Blueprint $table) {
            $table->string('jenis_surat', 50)->change();
        });

        Schema::table('letter_configs', function (Blueprint $table) {
            $table->dropColumn('body_template');
        });
    }
};
