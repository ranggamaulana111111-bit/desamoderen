<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramNotifier
{
    public function isConfigured(): bool
    {
        return (bool) (config('village.notif_telegram_token') && config('village.notif_telegram_chat_id'));
    }

    public function send(string $message, ?string $parseMode = 'HTML'): bool
    {
        $token = config('village.notif_telegram_token');
        $chatId = config('village.notif_telegram_chat_id');

        if (! $token || ! $chatId) {
            return false;
        }

        $payload = [
            'chat_id' => $chatId,
            'text' => $message,
        ];

        if ($parseMode) {
            $payload['parse_mode'] = $parseMode;
        }

        $response = Http::timeout(10)
            ->post("https://api.telegram.org/bot{$token}/sendMessage", $payload);

        if ($response->failed()) {
            Log::warning('TelegramNotifier gagal mengirim pesan', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return false;
        }

        return (bool) ($response->json('ok') ?? false);
    }
}
