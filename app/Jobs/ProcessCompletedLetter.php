<?php

namespace App\Jobs;

use App\Models\PengajuanSurat;
use App\Services\PdfGenerationService;
use App\Services\TelegramNotifier;
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

            $this->sendTelegramNotification($surat);
        } catch (\Throwable $e) {
            Log::error("ProcessCompletedLetter: gagal memproses pengajuan #{$this->pengajuanId}: {$e->getMessage()}", [
                'exception' => $e,
            ]);

            throw $e;
        }
    }

    private function sendTelegramNotification(PengajuanSurat $surat): void
    {
        $antrean = $surat->antrean;

        $message = sprintf(
            "Surat Selesai Diproses\n\nPemohon: %s\nJenis: %s\nNomor surat: %s\nJadwal ambil: %s pukul %s-%s",
            $surat->user->name,
            str_replace('_', ' ', ucfirst($surat->jenis_surat)),
            $surat->nomor_surat ?? '-',
            $antrean ? $antrean->tanggal_ambil->format('d/m/Y') : '-',
            $antrean ? substr($antrean->jam_mulai, 0, 5) : '-',
            $antrean ? substr($antrean->jam_selesai, 0, 5) : '-',
        );

        app(TelegramNotifier::class)->send($message);
    }
}
