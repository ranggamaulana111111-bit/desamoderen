<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DemoAuthSeeder extends Seeder
{
    public function run(): void
    {
        // Cari user berdasarkan NIK atau Email yang sudah ada
        $warga = User::where('nik', '3216010101010001')
            ->orWhere('email', 'demo@prodesa.id')
            ->first();

        // Jika belum ada, baru buat user baru
        if (! $warga) {
            $warga = User::create([
                'name' => 'Warga Demo',
                'email' => 'demo@prodesa.id',
                'nik' => '3216010101010001',
                'no_hp' => '081234567890',
                'rt' => '01',
                'rw' => '02',
                'alamat' => 'Jl. Raya Desa No. 1, Kecamatan Cibeureum',
                'password' => bcrypt('demo1234'),
            ]);
        }

        $wargaRole = Role::where('name', 'Warga')->first();
        if ($wargaRole) {
            $warga->syncRoles([$wargaRole]);
        }

        $this->command?->info('Demo warga siap: email demo@prodesa.id / password demo1234');
    }
}
