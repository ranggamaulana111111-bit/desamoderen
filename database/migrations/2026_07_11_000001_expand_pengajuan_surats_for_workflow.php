<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengajuan_surats', function (Blueprint $table) {
            $table->unsignedBigInteger('submitted_by')->nullable()->after('user_id');
            $table->unsignedTinyInteger('current_step')->default(0)->after('submitted_by');
        });

        DB::table('pengajuan_surats')->orderBy('id')->each(function ($row) {
            $newStatus = match ($row->status) {
                'pending' => 'submitted',
                'proses' => 'verified',
                'selesai' => 'completed',
                'ditolak' => 'rejected',
                default => $row->status,
            };

            DB::table('pengajuan_surats')
                ->where('id', $row->id)
                ->update([
                    'status' => $newStatus,
                    'submitted_by' => $row->user_id,
                ]);
        });

        Schema::table('pengajuan_surats', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('pengajuan_surats', function (Blueprint $table) {
            $table->string('status', 30)->default('submitted')->after('kode_klasifikasi');
        });

        DB::table('pengajuan_surats')
            ->where('status', 'submitted')
            ->whereNull('submitted_by')
            ->update(['submitted_by' => DB::raw('user_id')]);
    }

    public function down(): void
    {
        DB::table('pengajuan_surats')->orderBy('id')->each(function ($row) {
            $oldStatus = match ($row->status) {
                'submitted' => 'pending',
                'verified' => 'proses',
                'approved_operator' => 'proses',
                'approved_sekdes' => 'proses',
                'approved_kades' => 'proses',
                'revision' => 'pending',
                'completed' => 'selesai',
                'rejected' => 'ditolak',
                default => 'pending',
            };

            DB::table('pengajuan_surats')
                ->where('id', $row->id)
                ->update(['status' => $oldStatus]);
        });

        Schema::table('pengajuan_surats', function (Blueprint $table) {
            $table->dropColumn(['submitted_by', 'current_step']);
        });

        Schema::table('pengajuan_surats', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('pengajuan_surats', function (Blueprint $table) {
            $table->enum('status', ['pending', 'proses', 'selesai', 'ditolak'])->default('pending')->after('kode_klasifikasi');
        });
    }
};
