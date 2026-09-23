<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Throwable;

class WeatherService
{
    private const CACHE_KEY = 'village_weather_current';

    private const CACHE_TTL_MINUTES = 10;

    private const FAILURE_TTL_MINUTES = 5;

    private const TIMEOUT_SECONDS = 3;

    private const WEATHER_CODES = [
        0 => 'Cerah',
        1 => 'Cerah Berawan',
        2 => 'Berawan',
        3 => 'Mendung',
        45 => 'Berkabut',
        48 => 'Berkabut',
        51 => 'Gerimis Ringan',
        53 => 'Gerimis',
        55 => 'Gerimis Lebat',
        56 => 'Gerimis Beku',
        57 => 'Gerimis Beku',
        61 => 'Hujan Ringan',
        63 => 'Hujan Sedang',
        65 => 'Hujan Lebat',
        66 => 'Hujan Beku',
        67 => 'Hujan Beku',
        71 => 'Salju Ringan',
        73 => 'Salju',
        75 => 'Salju Lebat',
        77 => 'Butiran Salju',
        80 => 'Hujan Gerimis',
        81 => 'Hujan Sedang',
        82 => 'Hujan Lebat',
        85 => 'Hujan Salju Ringan',
        86 => 'Hujan Salju Lebat',
        95 => 'Badai Petir',
        96 => 'Badai Petir Hujan Es',
        99 => 'Badai Petir Hujan Es',
    ];

    public function getWeather(): ?array
    {
        $latitude = config('village.latitude');
        $longitude = config('village.longitude');

        if (blank($latitude) || blank($longitude)) {
            return null;
        }

        $cacheKey = self::CACHE_KEY.':'.md5($latitude.'|'.$longitude);

        $cached = Cache::get($cacheKey);
        if (is_array($cached)) {
            return ($cached['ok'] ?? false) ? ($cached['data'] ?? null) : null;
        }

        $data = $this->fetch((string) $latitude, (string) $longitude);

        if ($data === null) {
            Cache::put($cacheKey, ['ok' => false], now()->addMinutes(self::FAILURE_TTL_MINUTES));

            return null;
        }

        Cache::put(
            $cacheKey,
            ['ok' => true, 'data' => $data],
            now()->addMinutes(self::CACHE_TTL_MINUTES)
        );

        return $data;
    }

    private function fetch(string $latitude, string $longitude): ?array
    {
        try {
            $response = Http::timeout(self::TIMEOUT_SECONDS)
                ->get('https://api.open-meteo.com/v1/forecast', [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'current' => 'temperature_2m,weather_code',
                ]);
        } catch (Throwable $e) {
            return null;
        }

        if (! $response->ok()) {
            return null;
        }

        $current = $response->json('current');

        if (! isset($current['temperature_2m'])) {
            return null;
        }

        $temperature = (int) round((float) $current['temperature_2m']);
        $code = (int) ($current['weather_code'] ?? -1);
        $description = self::WEATHER_CODES[$code] ?? 'Tidak Diketahui';

        return [
            'temperature' => $temperature,
            'description' => $description,
            'label' => "{$temperature}°C {$description}",
            'code' => $code,
        ];
    }
}
