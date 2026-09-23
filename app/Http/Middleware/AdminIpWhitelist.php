<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminIpWhitelist
{
    public function handle(Request $request, Closure $next): Response
    {
        $raw = (string) config('village.security_ip_whitelist', '');
        $entries = preg_split('/[\r\n,]+/', $raw) ?: [];
        $rules = array_values(array_filter(array_map('trim', $entries), fn ($ip) => $ip !== ''));

        if (empty($rules)) {
            return $next($request);
        }

        $clientIp = $this->clientIp($request);

        foreach ($rules as $rule) {
            if ($this->matches($clientIp, $rule)) {
                return $next($request);
            }
        }

        abort(403, 'Akses ditolak: alamat IP tidak terdaftar.');
    }

    private function clientIp(Request $request): string
    {
        $trusted = $request->getTrustedProxies();

        if (! empty($trusted)) {
            $forwarded = $request->headers->get('X-Forwarded-For', '');
            $first = (string) strtok($forwarded, ',');

            if ($first !== '' && filter_var(trim($first), FILTER_VALIDATE_IP)) {
                return trim($first);
            }
        }

        return (string) $request->ip();
    }

    private function matches(string $ip, string $rule): bool
    {
        $rule = trim($rule);

        if (str_contains($rule, '/')) {
            return $this->cidrMatch($ip, $rule);
        }

        return $ip === $rule;
    }

    private function cidrMatch(string $ip, string $cidr): bool
    {
        [$subnet, $mask] = array_pad(explode('/', $cidr, 2), 2, null);

        if ($mask === null || ! ctype_digit((string) $mask)) {
            return false;
        }

        $subnetIp = filter_var($subnet, FILTER_VALIDATE_IP);
        $ipValid = filter_var($ip, FILTER_VALIDATE_IP);

        if (! $subnetIp || ! $ipValid || ! str_contains($subnetIp, '.')) {
            return false;
        }

        $mask = (int) $mask;
        if ($mask < 0 || $mask > 32) {
            return false;
        }

        $subnetBits = ip2long($subnetIp);
        $ipBits = ip2long($ip);

        if ($subnetBits === false || $ipBits === false) {
            return false;
        }

        $maskBits = $mask === 0 ? 0 : (0xFFFFFFFF << (32 - $mask)) & 0xFFFFFFFF;

        return ($subnetBits & $maskBits) === ($ipBits & $maskBits);
    }
}
