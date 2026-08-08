<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lembagas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('singkatan', 50)->nullable();
            $table->enum('jenis', ['karang_taruna', 'bumdes', 'pkk', 'lpm', 'linmas', 'kwt', 'bkm', 'toga', 'lainnya'])->default('lainnya');
            $table->text('deskripsi')->nullable();
            $table->string('ketua', 100)->nullable();
            $table->string('alamat', 255)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('foto')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lembagas');
    }
};
