<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@prodesa.id'],
            [
                'name' => 'Admin',
                'nik' => '0000000000000000',
                'password' => bcrypt('admin123'),
            ]
        );

        $superAdminRole = Role::where('name', 'Super Admin')->first();

        // Ensure the admin user has ONLY the Super Admin role
        if ($superAdminRole) {
            $admin->syncRoles([$superAdminRole]);
        }
    }
}
