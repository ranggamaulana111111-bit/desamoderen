<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSurat;
use App\Services\Surat\LetterServiceFactory;

class PublicVerificationController extends Controller
{
    public function show(string $hash)
    {
        $surat = PengajuanSurat::with('user')
            ->where('hash_verifikasi', $hash)
            ->where('status', 'completed')
            ->firstOrFail();

        $service = LetterServiceFactory::make($surat->jenis_surat);

        $tglCetak = $surat->updated_at;
        $tglBerlakuSampai = $tglCetak->copy()->addMonths($service->masaBerlakuBulan());
        $isExpired = now()->gt($tglBerlakuSampai);

        $ttd = $surat->tanda_tangan_meta;

        $data = [
            'status' => $isExpired ? 'expired' : 'valid',
            'nama_warga' => $surat->user->name,
            'nik' => $surat->user->nik,
            'jenis_surat' => str_replace('_', ' ', ucfirst($surat->jenis_surat)),
            'nomor_surat' => $surat->nomor_surat ?? '-',
            'tanggal_cetak' => $tglCetak->locale('id')->translatedFormat('d F Y'),
            'tgl_berlaku_sampai' => $tglBerlakuSampai->locale('id')->translatedFormat('d F Y'),
            'penandatangan' => $ttd['jabatan'] ?? config('village.jabatan_kades', 'Kepala Desa'),
            'desa' => config('village.nama_desa', 'Desa Kumpay'),
            'kecamatan' => config('village.nama_kecamatan', 'Banjarsari'),
            'kabupaten' => config('village.nama_kabupaten', 'Lebak'),
        ];

        return view('verifikasi.show', $data);
    }
}
