<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_inventaris')->unique();
            $table->string('nama_barang');
            $table->enum('kategori', ['Peralatan', 'Kendaraan', 'Gedung', 'Tanah', 'Furniture', 'Elektronik', 'Lainnya']);
            $table->string('nomor_inventaris')->nullable();
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat', 'Perawatan']);
            $table->integer('jumlah')->default(1);
            $table->string('lokasi')->nullable();
            $table->year('tahun_perolehan')->nullable();
            $table->decimal('nilai_perolehan', 15, 2)->nullable();
            $table->string('foto')->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('status', ['Digunakan', 'Tersedia', 'Disimpan', 'Dihapus']);
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }
};
