<?php

namespace App\Http\Controllers\Debug;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrTestController extends Controller
{
    public function testQr()
    {
        $pengajuan = PengajuanSurat::with('user')
            ->where('status', 'completed')
            ->whereNotNull('hash_verifikasi')
            ->first();

        if (! $pengajuan) {
            $warga = User::factory()->create();
            $pengajuan = PengajuanSurat::factory()->create([
                'user_id' => $warga->id,
                'submitted_by' => $warga->id,
                'jenis_surat' => 'sktm',
                'status' => 'completed',
                'current_step' => 5,
                'nomor_surat' => '460/001/DS-KP/2026',
                'hash_verifikasi' => hash('sha256', 'demo_'.now()->timestamp),
                'kode_klasifikasi' => '460',
                'data_tambahan' => [
                    'nama_lengkap' => $warga->name,
                    'tempat_lahir' => 'Subang',
                    'tanggal_lahir' => '1990-01-15',
                    'jenis_kelamin' => 'L',
                    'pekerjaan' => 'Swasta',
                    'alamat' => 'Kp. Kumpay RT 01 RW 01',
                ],
            ]);
        }

        $verifyUrl = route('verifikasi.show', $pengajuan->hash_verifikasi);

        $qrSvg = QrCode::format('svg')->size(200)->generate($verifyUrl);
        $qrBase64 = base64_encode($qrSvg);

        return view('debug.test-qr', compact('pengajuan', 'verifyUrl', 'qrSvg', 'qrBase64'));
    }
}
