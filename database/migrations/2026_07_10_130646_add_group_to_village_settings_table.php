<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('village_settings', function (Blueprint $table) {
            $table->string('group', 32)->default('general')->after('id');
            $table->index('group');
        });
    }

    public function down(): void
    {
        Schema::table('village_settings', function (Blueprint $table) {
            $table->dropIndex(['group']);
            $table->dropColumn('group');
        });
    }
};
