<?php

namespace App\Console\Commands;

use App\Models\PengajuanSurat;
use App\Services\LetterNumberService;
use Illuminate\Console\Command;

class BackfillSuratNomor extends Command
{
    protected $signature = 'surat:nomor {--dry-run : Tampilkan nomor yang akan diisi tanpa menyimpan}';

    protected $description = 'Isi nomor surat otomatis untuk surat berstatus selesai yang belum bernomor';

    public function handle(LetterNumberService $letterNumberService): int
    {
        $target = PengajuanSurat::query()
            ->where('status', 'completed')
            ->whereNull('nomor_surat');

        $total = (clone $target)->count();

        if ($total === 0) {
            $this->info('Tidak ada surat selesai tanpa nomor.');

            return self::SUCCESS;
        }

        $this->info("Ditemukan {$total} surat selesai tanpa nomor.");

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $filled = 0;
        foreach ($target->orderBy('id')->cursor() as $surat) {
            $nomor = $this->option('dry-run')
                ? $letterNumberService->format($surat)
                : $letterNumberService->generateFor($surat);

            $this->line(sprintf('  #%d %s -> %s', $surat->id, $surat->jenis_surat, $nomor));
            $filled++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        if ($this->option('dry-run')) {
            $this->info("Siap diisi: {$filled} nomor (dry-run, tidak disimpan).");
        } else {
            $this->info("Berhasil mengisi nomor untuk {$filled} surat.");
        }

        return self::SUCCESS;
    }
}
