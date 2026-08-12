<?php

namespace App\Services\Surat\Strategies;

use App\Models\PengajuanSurat;
use App\Services\Surat\LetterGeneratorInterface;

class AktaLetterService implements LetterGeneratorInterface
{
    public function kodeKlasifikasi(): string
    {
        return '472';
    }

    public function masaBerlakuBulan(): int
    {
        return 3;
    }

    public function generate(PengajuanSurat $surat): array
    {
        $dt = $surat->data_tambahan;

        return [
            'jenis_label' => 'Surat Pengantar Akta',
            'view' => 'pdf.template_akta',
            'data' => [
                'nama_lengkap' => $dt['nama_lengkap'] ?? $surat->user->name,
                'nik' => $dt['nik'] ?? $surat->user->nik,
                'tempat_lahir' => $dt['tempat_lahir'] ?? '-',
                'tgl_lahir' => $dt['tgl_lahir'] ?? null,
                'jenis_kelamin' => $dt['jenis_kelamin'] ?? '-',
                'pekerjaan' => $dt['pekerjaan'] ?? '-',
                'alamat_lengkap' => $dt['alamat_lengkap'] ?? $surat->user->alamat ?? sprintf(
                    'RT %s / RW %s',
                    $surat->user->rt ?? '-',
                    $surat->user->rw ?? '-'
                ),
                'jenis_akta' => $dt['jenis_akta'] ?? 'kelahiran',
                'nama_anak' => $dt['nama_anak'] ?? $dt['nama_ahli_waris'] ?? '-',
                'tempat_lahir_anak' => $dt['tempat_lahir_anak'] ?? '-',
                'tgl_lahir_anak' => $dt['tgl_lahir_anak'] ?? null,
                'kewarganegaraan' => $dt['kewarganegaraan'] ?? 'Indonesia',
                'agama' => $dt['agama'] ?? '-',
                'status_perkawinan' => $dt['status_perkawinan'] ?? '-',
            ],
        ];
    }
}
