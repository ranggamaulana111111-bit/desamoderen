<?php

namespace App\Jobs;

use App\Models\PengajuanSurat;
use App\Services\PdfGenerationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessCompletedLetter implements ShouldQueue
{
    use Queueable;

    public int $tries = 5;

    public array $backoff = [30, 60, 120, 300, 600];

    public function __construct(
        public int $pengajuanId
    ) {
        $this->onQueue('default');
    }

    public function handle(PdfGenerationService $pdfService): void
    {
        $surat = PengajuanSurat::with('user')->find($this->pengajuanId);

        if (! $surat || $surat->status !== 'completed') {
            Log::warning("ProcessCompletedLetter: pengajuan #{$this->pengajuanId} tidak ditemukan atau status bukan completed.");

            return;
        }

        try {
            if (! $surat->pdf_path || ! Storage::disk('private')->exists($surat->pdf_path)) {
                $pdfService->generateAndStore($surat);
            }

            $this->sendWhatsAppNotification($surat);
        } catch (\Throwable $e) {
            Log::error("ProcessCompletedLetter: gagal memproses pengajuan #{$this->pengajuanId}: {$e->getMessage()}", [
                'exception' => $e,
            ]);

            throw $e;
        }
    }

    private function sendWhatsAppNotification(PengajuanSurat $surat): void
    {
        $noHp = $surat->user->no_hp;

        if (! $noHp) {
            Log::info("ProcessCompletedLetter: pengajuan #{$surat->id} — no_hp warga tidak tersedia, lewati notifikasi.");

            return;
        }

        $antrean = $surat->antrean;
        $pesan = sprintf(
            "Yth. %s,\n\nSurat %s Anda telah selesai diproses.\nNomor surat: %s\nSilakan ambil di kantor desa pada %s pukul %s-%s.\n\nTerima kasih.\n- Pemerintah Desa %s",
            $surat->user->name,
            str_replace('_', ' ', ucfirst($surat->jenis_surat)),
            $surat->nomor_surat ?? '-',
            $antrean ? $antrean->tanggal_ambil->format('d/m/Y') : '-',
            $antrean ? substr($antrean->jam_mulai, 0, 5) : '-',
            $antrean ? substr($antrean->jam_selesai, 0, 5) : '-',
            config('village.nama_desa', 'Desa')
        );

        Log::info("ProcessCompletedLetter: simulasi WA ke {$noHp} untuk pengajuan #{$surat->id}", [
            'pengajuan_id' => $surat->id,
            'no_hp' => $noHp,
            'pesan' => $pesan,
        ]);
    }
}
