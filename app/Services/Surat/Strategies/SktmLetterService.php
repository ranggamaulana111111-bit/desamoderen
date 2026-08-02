<?php

namespace App\Services\Surat\Strategies;

use App\Models\PengajuanSurat;
use App\Services\Surat\LetterGeneratorInterface;

class SktmLetterService implements LetterGeneratorInterface
{
    public function kodeKlasifikasi(): string
    {
        return '460';
    }

    public function masaBerlakuBulan(): int
    {
        return 3;
    }

    public function generate(PengajuanSurat $surat): array
    {
        $dt = $surat->data_tambahan;

        return [
            'jenis_label' => 'Surat Keterangan Tidak Mampu (SKTM)',
            'view' => 'pdf.template_sktm',
            'data' => [
                'nama_lengkap' => $dt['nama_lengkap'] ?? $surat->user->name,
                'nik' => $dt['nik'] ?? $surat->user->nik,
                'tempat_lahir' => $dt['tempat_lahir'] ?? '-',
                'tgl_lahir' => $dt['tgl_lahir'] ?? null,
                'jenis_kelamin' => $dt['jenis_kelamin'] ?? '-',
                'pekerjaan' => $dt['pekerjaan'] ?? '-',
                'alamat_lengkap' => $dt['alamat_lengkap'] ?? sprintf(
                    'RT %s / RW %s',
                    $surat->user->rt ?? '-',
                    $surat->user->rw ?? '-'
                ),
                'penghasilan' => $dt['penghasilan'] ?? 0,
                'alasan_sktm' => $dt['alasan_sktm'] ?? 'berobat dan mendapatkan pelayanan kesehatan di Puskesmas / Rumah Sakit',
                'kewarganegaraan' => $dt['kewarganegaraan'] ?? 'Indonesia',
                'agama' => $dt['agama'] ?? '-',
                'status_perkawinan' => $dt['status_perkawinan'] ?? '-',
            ],
        ];
    }
}
