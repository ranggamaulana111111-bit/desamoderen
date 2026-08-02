<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained('pengajuan_surats')->onDelete('cascade');
            $table->unsignedInteger('version_number');
            $table->string('status_at_version', 30);
            $table->json('data_snapshot');
            $table->text('catatan')->nullable();
            $table->string('pdf_path', 255)->nullable();
            $table->text('changes_summary')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['pengajuan_id', 'version_number']);
            $table->index(['pengajuan_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_versions');
    }
};
