<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;

class Turnstile
{
    public function configured(): bool
    {
        return (bool) (config('village.integrasi_turnstile_site_key') && config('village.integrasi_turnstile_secret_key'));
    }

    public function verify(?string $token): bool
    {
        if (! $this->configured() || blank($token)) {
            return false;
        }

        try {
            $response = Http::timeout(10)
                ->asForm()
                ->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                    'secret' => config('village.integrasi_turnstile_secret_key'),
                    'response' => $token,
                ]);

            return (bool) ($response->json('success') ?? false);
        } catch (\Throwable $e) {
            return false;
        }
    }
}
