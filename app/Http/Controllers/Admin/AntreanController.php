<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AntreanPengambilan;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AntreanController extends Controller
{
    public function pickup()
    {
        $menunggu = AntreanPengambilan::with('pengajuan.user')
            ->today()
            ->waiting()
            ->orderBy('jam_mulai')
            ->get();

        $diambil = AntreanPengambilan::with('pengajuan.user')
            ->today()
            ->where('status', AntreanPengambilan::STATUS_DIAMBIL)
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();

        $lewat = AntreanPengambilan::with('pengajuan.user')
            ->today()
            ->where('status', AntreanPengambilan::STATUS_LEWAT)
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.queue.pickup', [
            'menunggu' => $menunggu->map(fn ($a) => $this->formatAntrean($a))->values(),
            'diambil' => $diambil->map(fn ($a) => $this->formatAntrean($a))->values(),
            'lewat' => $lewat->map(fn ($a) => $this->formatAntrean($a))->values(),
        ]);
    }

    public function cari(Request $request)
    {
        $data = $request->validate([
            'query' => ['required', 'string', 'max:255'],
        ]);

        $query = trim($data['query']);
        $kodeQr = $this->extractKodeQr($query);

        $antrean = AntreanPengambilan::with('pengajuan.user')
            ->where(fn ($q) => $q->where('kode_qr', $kodeQr)->orWhere('nomor_antrean', $query))
            ->first();

        if (! $antrean) {
            throw ValidationException::withMessages([
                'query' => 'Antrean tidak ditemukan. Periksa kembali nomor antrean atau QR Code.',
            ]);
        }

        return response()->json(['antrean' => $this->formatAntrean($antrean)]);
    }

    public function proses(AntreanPengambilan $antrean)
    {
        if ($antrean->status !== AntreanPengambilan::STATUS_MENUNGGU) {
            return response()->json(['message' => 'Antrean ini sudah tidak berstatus menunggu.'], 422);
        }

        $antrean->markAsTaken(auth()->id());

        ActivityLog::catat(
            'antrean_diambil',
            'Antrean '.$antrean->nomor_antrean.' untuk '.$antrean->pengajuan->user->name.' telah diserahkan.',
            'queue',
            $antrean->id
        );

        return response()->json(['antrean' => $this->formatAntrean($antrean->fresh('pengajuan.user'))]);
    }

    public function lewat(AntreanPengambilan $antrean)
    {
        if ($antrean->status !== AntreanPengambilan::STATUS_MENUNGGU) {
            return response()->json(['message' => 'Antrean ini sudah tidak berstatus menunggu.'], 422);
        }

        $antrean->markAsMissed(auth()->id());

        ActivityLog::catat(
            'antrean_lewat',
            'Antrean '.$antrean->nomor_antrean.' untuk '.$antrean->pengajuan->user->name.' ditandai lewat.',
            'queue',
            $antrean->id
        );

        return response()->json(['antrean' => $this->formatAntrean($antrean->fresh('pengajuan.user'))]);
    }

    private function extractKodeQr(string $value): string
    {
        $trimmed = trim($value);

        if (preg_match('#/antrean/([a-zA-Z0-9]+)$#', $trimmed, $m)) {
            return $m[1];
        }

        return $trimmed;
    }

    private function formatAntrean(AntreanPengambilan $antrean): array
    {
        $user = $antrean->pengajuan->user;

        return [
            'id' => $antrean->id,
            'nomor_antrean' => $antrean->nomor_antrean,
            'status' => $antrean->status,
            'kode_qr' => $antrean->kode_qr,
            'tanggal_ambil' => $antrean->tanggal_ambil?->format('d-m-Y'),
            'jam_mulai' => $antrean->jam_mulai,
            'jam_selesai' => $antrean->jam_selesai,
            'pemohon' => $user->name,
            'nik' => $user->nik,
            'jenis_surat' => str_replace('_', ' ', $antrean->pengajuan->jenis_surat),
            'nomor_surat' => $antrean->pengajuan->nomor_surat,
        ];
    }
}
