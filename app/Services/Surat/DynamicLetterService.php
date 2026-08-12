<?php

namespace App\Services\Surat;

use App\Models\LetterConfig;
use App\Models\PengajuanSurat;

class DynamicLetterService implements LetterGeneratorInterface
{
    public function __construct(
        private LetterConfig $config,
    ) {}

    public function generate(PengajuanSurat $surat): array
    {
        $dt = $surat->data_tambahan;

        $dt = array_merge(
            config('village', []),
            $dt ?? [],
        );

        $renderedBody = $this->config->renderBody($dt);

        $data = [
            'jenis_label' => $this->config->label,
            'view' => 'pdf.template_dynamic',
            'data' => [
                'rendered_body' => $renderedBody,
                'body_sections' => (new LetterBodyParser)->parse($renderedBody),
                'masa_berlaku_bulan' => $this->config->masa_berlaku_bulan,
                'nama_lengkap' => $dt['nama_lengkap'] ?? $surat->user->name,
                'nik' => $dt['nik'] ?? $surat->user->nik,
                'alamat_lengkap' => $dt['alamat_lengkap'] ?? $surat->user->alamat ?? sprintf(
                    'RT %s / RW %s',
                    $surat->user->rt ?? '-',
                    $surat->user->rw ?? '-'
                ),
            ],
        ];

        if (isset($dt['tempat_lahir'])) {
            $data['data']['tempat_lahir'] = $dt['tempat_lahir'];
        }
        if (isset($dt['tgl_lahir'])) {
            $data['data']['tgl_lahir'] = $dt['tgl_lahir'];
        }

        return $data;
    }

    public function kodeKlasifikasi(): string
    {
        return $this->config->kode_klasifikasi;
    }

    public function masaBerlakuBulan(): int
    {
        return $this->config->masa_berlaku_bulan;
    }
}
