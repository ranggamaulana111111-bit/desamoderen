<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disposisis', function (Blueprint $table) {
            $table->dropColumn('tujuan_disposisi');
        });

        Schema::table('disposisis', function (Blueprint $table) {
            $table->foreignId('tujuan_disposisi')->after('surat_masuk_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('deadline')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('disposisis', function (Blueprint $table) {
            $table->dropForeign(['tujuan_disposisi']);
            $table->dropColumn('tujuan_disposisi');
        });

        Schema::table('disposisis', function (Blueprint $table) {
            $table->string('tujuan_disposisi')->after('surat_masuk_id');
            $table->date('deadline')->nullable()->change();
        });
    }
};
