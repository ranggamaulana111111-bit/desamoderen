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
        $ips = array_values(array_filter(array_map('trim', $entries), fn ($ip) => $ip !== ''));

        if (empty($ips)) {
            return $next($request);
        }

        if (! in_array($request->ip(), $ips, true)) {
            abort(403, 'Akses ditolak: alamat IP tidak terdaftar.');
        }

        return $next($request);
    }
}
