<?php

namespace App\Services\Surat;

use App\Models\PengajuanSurat;

interface LetterGeneratorInterface
{
    public function generate(PengajuanSurat $surat): array;

    public function kodeKlasifikasi(): string;

    public function masaBerlakuBulan(): int;
}
