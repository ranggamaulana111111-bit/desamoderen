<?php

namespace App\Services\Surat;

use App\Models\LetterConfig;
use App\Services\Surat\Strategies\AktaLetterService;
use App\Services\Surat\Strategies\KtpSementaraLetterService;
use App\Services\Surat\Strategies\SktmLetterService;

class LetterServiceFactory
{
    private static array $strategyMap = [
        'sktm' => SktmLetterService::class,
        'ktp_sementara' => KtpSementaraLetterService::class,
        'akta' => AktaLetterService::class,
    ];

    public static function make(string $jenisSurat): LetterGeneratorInterface
    {
        if (isset(self::$strategyMap[$jenisSurat])) {
            $class = self::$strategyMap[$jenisSurat];

            return new $class;
        }

        $config = LetterConfig::where('jenis_surat', $jenisSurat)->first();

        if (! $config) {
            throw new \InvalidArgumentException("Jenis surat tidak dikenal: {$jenisSurat}");
        }

        return new DynamicLetterService($config);
    }
}
