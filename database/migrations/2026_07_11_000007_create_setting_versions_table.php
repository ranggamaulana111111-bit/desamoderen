<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('setting_versions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('version_number');
            $table->string('label')->nullable();
            $table->longText('data_snapshot');
            $table->json('changes_summary')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('version_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('setting_versions');
    }
};
