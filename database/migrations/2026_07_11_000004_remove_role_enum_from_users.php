<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'warga'])->default('warga')->after('no_hp');
        });

        DB::table('users')->each(function ($row) {
            $hasAdminRole = DB::table('model_has_roles')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('model_has_roles.model_id', $row->id)
                ->where('model_has_roles.model_type', User::class)
                ->whereIn('roles.name', ['Super Admin', 'Operator Pelayanan', 'Sekretaris Desa', 'Kepala Desa', 'RT', 'RW'])
                ->exists();

            DB::table('users')
                ->where('id', $row->id)
                ->update(['role' => $hasAdminRole ? 'admin' : 'warga']);
        });
    }
};
