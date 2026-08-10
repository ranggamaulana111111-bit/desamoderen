<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DemoAuthSeeder extends Seeder
{
    public function run(): void
    {
        $warga = User::firstOrCreate(
            ['nik' => '3216010101010001'],
            [
                'name' => 'Warga Demo',
                'nik' => '3216010101010001',
                'no_hp' => '081234567890',
                'rt' => '01',
                'rw' => '02',
                'alamat' => 'Jl. Raya Desa No. 1, Kecamatan Cibeureum',
                'password' => bcrypt('demo1234'),
            ]
        );

        $wargaRole = Role::where('name', 'Warga')->first();
        if ($wargaRole) {
            $warga->syncRoles([$wargaRole]);
        }

        $this->command?->info('Demo warga siap: NIK 3216010101010001 / password demo1234');
    }
}
