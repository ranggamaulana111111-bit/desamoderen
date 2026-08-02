<?php

namespace App\Services\Surat\Strategies;

use App\Models\PengajuanSurat;
use App\Services\Surat\LetterGeneratorInterface;

class KtpSementaraLetterService implements LetterGeneratorInterface
{
    public function kodeKlasifikasi(): string
    {
        return '471';
    }

    public function masaBerlakuBulan(): int
    {
        return 1;
    }

    public function generate(PengajuanSurat $surat): array
    {
        $dt = $surat->data_tambahan;

        return [
            'jenis_label' => 'Surat Keterangan Pengganti KTP (Sementara)',
            'view' => 'pdf.template_ktp_sementara',
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
                'alasan_ktp' => $dt['alasan_ktp'] ?? 'dalam proses pembuatan KTP di Dinas Kependudukan dan Pencatatan Sipil',
                'kewarganegaraan' => $dt['kewarganegaraan'] ?? 'Indonesia',
                'agama' => $dt['agama'] ?? '-',
                'status_perkawinan' => $dt['status_perkawinan'] ?? '-',
            ],
        ];
    }
}
