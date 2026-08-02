<?php

namespace App\Dashboard\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Cache;

class ActivityFeedService
{
    private const CACHE_TTL = 60;

    private const PREFIX = 'dsh_activity_';

    public function recent(int $limit = 10): array
    {
        return Cache::remember(self::PREFIX.'recent', self::CACHE_TTL, function () use ($limit) {
            return ActivityLog::with('user')
                ->latest()
                ->take($limit)
                ->get()
                ->map(fn ($log) => [
                    'id' => $log->id,
                    'user_name' => $log->user->name ?? 'System',
                    'user_avatar' => $log->user ? $log->user->avatar_initials : 'S',
                    'aksi' => $log->aksi,
                    'deskripsi' => $log->deskripsi,
                    'waktu' => $log->created_at->diffForHumans(),
                    'created_at' => $log->created_at,
                    'icon' => $this->activityIcon($log->aksi),
                    'color' => $this->activityColor($log->aksi),
                ])->toArray();
        });
    }

    private function activityIcon(string $aksi): string
    {
        return match (true) {
            str_contains($aksi, 'create') || str_contains($aksi, 'add') => 'plus',
            str_contains($aksi, 'update') || str_contains($aksi, 'edit') || str_contains($aksi, 'ubah') => 'pencil',
            str_contains($aksi, 'delete') || str_contains($aksi, 'hapus') => 'trash',
            str_contains($aksi, 'approve') || str_contains($aksi, 'setuju') => 'check',
            str_contains($aksi, 'reject') || str_contains($aksi, 'tolak') => 'x-mark',
            str_contains($aksi, 'revision') || str_contains($aksi, 'revisi') => 'arrow-path',
            str_contains($aksi, 'login') || str_contains($aksi, 'masuk') => 'arrow-right',
            str_contains($aksi, 'toggle') || str_contains($aksi, 'aktif') => 'power',
            default => 'document',
        };
    }

    private function activityColor(string $aksi): string
    {
        return match (true) {
            str_contains($aksi, 'create') || str_contains($aksi, 'add') => 'emerald',
            str_contains($aksi, 'update') || str_contains($aksi, 'edit') || str_contains($aksi, 'ubah') => 'blue',
            str_contains($aksi, 'delete') || str_contains($aksi, 'hapus') => 'red',
            str_contains($aksi, 'approve') || str_contains($aksi, 'setuju') => 'green',
            str_contains($aksi, 'reject') || str_contains($aksi, 'tolak') => 'red',
            str_contains($aksi, 'revision') || str_contains($aksi, 'revisi') => 'amber',
            str_contains($aksi, 'login') || str_contains($aksi, 'masuk') => 'indigo',
            default => 'gray',
        };
    }
}
