<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\LetterConfig;
use App\Models\PengajuanSurat;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $total = PengajuanSurat::where('user_id', $user->id)->count();
        $pending = PengajuanSurat::where('user_id', $user->id)->whereIn('status', ['submitted', 'verified', 'approved_operator', 'approved_sekdes', 'approved_kades'])->count();
        $selesai = PengajuanSurat::where('user_id', $user->id)->where('status', 'completed')->count();
        $ditolak = PengajuanSurat::where('user_id', $user->id)->where('status', 'rejected')->count();
        $revisi = PengajuanSurat::where('user_id', $user->id)->where('status', 'revision')->count();
        $terbaru = PengajuanSurat::where('user_id', $user->id)->latest()->take(10)->get()->map(function ($item) {
            if ($item->hash_verifikasi) {
                $qrUrl = route('verifikasi.show', $item->hash_verifikasi);

                $item->qr_verifikasi_svg = QrCode::format('svg')->size(120)->generate($qrUrl);
            }

            return $item;
        });

        $antreanAktif = $user->pengajuanSurat()
            ->whereHas('antrean', fn ($q) => $q->where('status', 'menunggu'))
            ->with('antrean')
            ->latest()
            ->get()
            ->map(function ($item) {
                $antrean = $item->antrean;
                $qrUrl = route('antrean.show', $antrean->kode_qr);

                $antrean->qr_svg = QrCode::format('svg')->size(120)->generate($qrUrl);

                return $item;
            });

        $undanganAktif = $user->eventPeserta()
            ->whereHas('event', fn ($q) => $q->where('status', 'akan_datang'))
            ->with('event')
            ->latest()
            ->get();

        $letterConfigs = LetterConfig::active()->get();

        return view('warga.dashboard', compact(
            'total', 'pending', 'selesai', 'ditolak', 'revisi', 'terbaru',
            'antreanAktif', 'undanganAktif', 'letterConfigs'
        ));
    }
}
