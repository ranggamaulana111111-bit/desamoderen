<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;

class Recaptcha
{
    public function configured(): bool
    {
        return (bool) (config('village.integrasi_recaptcha_key') && config('village.integrasi_recaptcha_secret'));
    }

    public function verify(?string $token): bool
    {
        if (! $this->configured() || blank($token)) {
            return false;
        }

        try {
            $response = Http::timeout(10)
                ->asForm()
                ->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => config('village.integrasi_recaptcha_secret'),
                    'response' => $token,
                ]);

            return (bool) ($response->json('success') ?? false);
        } catch (\Throwable $e) {
            return false;
        }
    }
}
