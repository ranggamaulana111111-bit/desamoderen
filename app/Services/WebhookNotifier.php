<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WebhookNotifier
{
    public function isConfigured(): bool
    {
        $url = (string) config('village.integrasi_webhook_url', '');

        return $url !== '' && filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    public function send(array $payload): bool
    {
        if (! $this->isConfigured()) {
            return false;
        }

        try {
            $response = Http::timeout(10)
                ->acceptJson()
                ->post(config('village.integrasi_webhook_url'), $payload);

            return $response->successful();
        } catch (\Throwable $e) {
            return false;
        }
    }
}
