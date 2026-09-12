<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSurat;
use App\Services\Surat\LetterServiceFactory;

class PublicVerificationController extends Controller
{
    public function show(string $hash)
    {
        $village = [
            'desa' => config('village.nama_desa', 'Desa Kumpay'),
            'kecamatan' => config('village.nama_kecamatan', 'Banjarsari'),
            'kabupaten' => config('village.nama_kabupaten', 'Lebak'),
        ];

        $surat = PengajuanSurat::with('user')
            ->where('hash_verifikasi', $hash)
            ->first();

        if (! $surat) {
            return view('verifikasi.tidak-ditemukan', $village + ['alasan' => 'hash_tidak_ditemukan']);
        }

        if ($surat->status !== 'completed') {
            return view('verifikasi.tidak-ditemukan', $village + ['alasan' => 'belum_selesai']);
        }

        $service = LetterServiceFactory::make($surat->jenis_surat);

        $tglCetak = $surat->updated_at;
        $tglBerlakuSampai = $tglCetak->copy()->addMonths($service->masaBerlakuBulan());
        $isExpired = now()->gt($tglBerlakuSampai);

        $ttd = $surat->tanda_tangan_meta;

        $dt = $surat->data_tambahan ?? [];

        $data = $village + [
            'status' => $isExpired ? 'expired' : 'valid',
            'nama_warga' => $dt['nama_lengkap'] ?? $surat->user->name,
            'nik' => $this->maskNik($dt['nik'] ?? $surat->user->nik),
            'jenis_surat' => str_replace('_', ' ', ucfirst($surat->jenis_surat)),
            'nomor_surat' => $surat->nomor_surat ?? '-',
            'tanggal_cetak' => $tglCetak->locale('id')->translatedFormat('d F Y'),
            'tgl_berlaku_sampai' => $tglBerlakuSampai->locale('id')->translatedFormat('d F Y'),
            'penandatangan' => $ttd['jabatan'] ?? config('village.jabatan_kades', 'Kepala Desa'),
        ];

        return view('verifikasi.show', $data);
    }

    private function maskNik(?string $nik): string
    {
        $nik = preg_replace('/\D/', '', (string) $nik);

        if ($nik === '') {
            return '-';
        }

        if (strlen($nik) < 8) {
            return substr($nik, 0, 1).'********';
        }

        return substr($nik, 0, 4).'********'.substr($nik, -4);
    }
}
