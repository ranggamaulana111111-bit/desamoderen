<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403, __('Anda tidak memiliki izin untuk mengakses halaman ini.'));
        }

        $permissions = array_values(array_filter(array_map('trim', explode('|', $permission))));

        $allowed = $user->hasAnyPermission($permissions);

        if (! $allowed) {
            abort(403, __('Anda tidak memiliki izin untuk mengakses halaman ini.'));
        }

        return $next($request);
    }
}
