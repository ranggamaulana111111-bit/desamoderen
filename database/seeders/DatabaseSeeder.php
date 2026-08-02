<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            VillageSettingSeeder::class,
            RolePermissionSeeder::class,
            AdminUserSeeder::class,
            LetterConfigSeeder::class,
        ]);
    }
}
