<?php

namespace Tests\Unit;

use App\Models\LetterConfig;
use Tests\TestCase;

class LetterConfigRenderBodyTest extends TestCase
{
    private function makeConfig(array $attributes = []): LetterConfig
    {
        return new LetterConfig(array_merge([
            'body_template' => 'Kepala Desa {jabatan_kades}, Desa {nama_desa}, Kecamatan {kecamatan}, Kabupaten {kabupaten}',
        ], $attributes));
    }

    public function test_renders_village_aliases(): void
    {
        $config = $this->makeConfig();

        $body = $config->renderBody([
            'nama_desa' => 'Kumpay',
            'nama_kecamatan' => 'Ciasem',
            'nama_kabupaten' => 'Subang',
            'jabatan_kades' => 'Kepala Desa Kumpay',
        ]);

        $this->assertSame(
            'Kepala Desa Kepala Desa Kumpay, Desa Kumpay, Kecamatan Ciasem, Kabupaten Subang',
            $body
        );
    }

    public function test_derives_label_placeholders(): void
    {
        $config = $this->makeConfig([
            'body_template' => 'JK: {jenis_kelamin_label} | Status: {status_janda_label} | Akta: {jenis_akta_label}',
        ]);

        $body = $config->renderBody([
            'jenis_kelamin' => 'Perempuan',
            'penyebab_janda' => 'Meninggal Dunia',
            'jenis_akta' => 'kelahiran',
        ]);

        $this->assertSame('JK: Perempuan | Status: janda | Akta: Akta Kelahiran', $body);
    }

    public function test_formats_tanggal_lahir(): void
    {
        $config = $this->makeConfig([
            'body_template' => 'Lahir: {tgl_lahir}',
        ]);

        $body = $config->renderBody(['tgl_lahir' => '2000-01-01']);

        $this->assertSame('Lahir: 01 Januari 2000', $body);
    }

    public function test_strips_unknown_placeholders(): void
    {
        $config = $this->makeConfig([
            'body_template' => 'Nama: {nama_lengkap} | Tidak diketahui: {foo_bar}',
        ]);

        $body = $config->renderBody(['nama_lengkap' => 'Andi']);

        $this->assertSame('Nama: Andi | Tidak diketahui: ', $body);
    }
}
