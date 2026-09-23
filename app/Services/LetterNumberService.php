<?php

namespace App\Services;

use App\Models\PengajuanSurat;
use App\Services\Surat\LetterServiceFactory;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\DB;

class LetterNumberService
{
    public function generateFor(PengajuanSurat $surat, ?CarbonInterface $date = null): string
    {
        if ($surat->nomor_surat) {
            return $surat->nomor_surat;
        }

        $nomor = $this->format($surat, $date);

        $surat->update(['nomor_surat' => $nomor]);

        return $nomor;
    }

    public function format(PengajuanSurat $surat, ?CarbonInterface $date = null): string
    {
        $date ??= Carbon::now();

        $format = (string) config('village.format_nomor_surat', '{prefix} / {no} / {suffix} / {tahun}');
        $padding = (int) config('village.nomor_padding', 4);
        $reset = (string) config('village.nomor_reset', 'tahunan');

        $nomor = $this->nextSequenceNumber($surat, $date, $reset);
        $padded = str_pad((string) $nomor, max(1, $padding), '0', STR_PAD_LEFT);

        $replacements = [
            '{kode_surat}' => $this->kodeKlasifikasi($surat),
            '{kode}' => $this->kodeKlasifikasi($surat),
            '{id}' => $surat->id,
            '{tahun}' => $date->format('Y'),
            '{bulan}' => $date->format('m'),
            '{hari}' => $date->format('d'),
            '{no}' => $padded,
            '{prefix}' => (string) config('village.nomor_prefix', '470'),
            '{suffix}' => (string) config('village.nomor_suffix', 'DS-KP'),
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $format);
    }

    public function nextSequenceNumber(PengajuanSurat $surat, CarbonInterface $date, string $reset): int
    {
        return DB::transaction(function () use ($surat, $date, $reset) {
            $range = fn ($query, string $column) => match ($reset) {
                'bulanan' => $query->whereYear($column, $date->year)->whereMonth($column, $date->month),
                'harian' => $query->whereDate($column, $date->toDateString()),
                default => $query->whereYear($column, $date->year),
            };

            $query = PengajuanSurat::query()
                ->where('jenis_surat', $surat->jenis_surat)
                ->whereNotNull('nomor_surat')
                ->where(function ($q) use ($date, $reset, $range) {
                    $range($q->whereNotNull('tgl_selesai'), 'tgl_selesai');
                    $q->orWhere(function ($legacy) use ($date, $reset, $range) {
                        $range($legacy->whereNull('tgl_selesai'), 'updated_at');
                    });
                });

            $count = $query->lockForUpdate()->count();

            return $count + 1;
        });
    }

    private function kodeKlasifikasi(PengajuanSurat $surat): string
    {
        try {
            return LetterServiceFactory::make($surat->jenis_surat)->kodeKlasifikasi();
        } catch (\Throwable) {
            return $surat->kode_klasifikasi ?? strtoupper($surat->jenis_surat);
        }
    }
}
