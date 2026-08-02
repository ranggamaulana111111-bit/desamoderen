<?php

namespace Database\Factories;

use App\Models\PengajuanSurat;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PengajuanSuratFactory extends Factory
{
    protected $model = PengajuanSurat::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'submitted_by' => fn (array $attrs) => $attrs['user_id'],
            'jenis_surat' => 'sktm',
            'current_step' => 0,
            'data_tambahan' => [
                'nama_lengkap' => fake()->name(),
                'tempat_lahir' => fake()->city(),
                'tanggal_lahir' => fake()->date(),
                'jenis_kelamin' => fake()->randomElement(['L', 'P']),
                'pekerjaan' => fake()->jobTitle(),
                'alamat' => fake()->address(),
            ],
            'status' => 'submitted',
        ];
    }
}
