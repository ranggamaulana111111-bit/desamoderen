<?php

namespace App\Dashboard\Widgets;

use App\Dashboard\Contracts\WidgetInterface;
use App\Models\ActivityLog;
use App\Models\PengajuanSurat;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuditLogWidget implements WidgetInterface
{
    public function __construct(private readonly User $user) {}

    public function getKey(): string
    {
        return 'audit_log';
    }

    public function getTitle(): string
    {
        return 'Log Aktivitas';
    }

    public function getComponent(): string
    {
        return 'components.widgets._audit_log';
    }

    public function getPermissions(): array
    {
        return [];
    }

    public function getGroup(): string
    {
        return 'info';
    }

    public function getPosition(): int
    {
        return 80;
    }

    public function isVisible(): bool
    {
        return $this->user->role_label !== 'Warga';
    }

    public function isLazy(): bool
    {
        return false;
    }

    public function gridSpan(): int
    {
        return 12;
    }

    public function getData(): array
    {
        $logs = ActivityLog::with('user')
            ->latest()
            ->limit(15)
            ->get()
            ->map(fn ($log) => [
                'id' => $log->id,
                'user_name' => $log->user?->name ?? 'System',
                'user_avatar' => strtoupper(substr($log->user?->name ?? 'S', 0, 1)),
                'aksi' => $log->aksi,
                'deskripsi' => $log->deskripsi,
                'tipe' => $log->tipe,
                'created_at' => $log->created_at->diffForHumans(),
                'color' => $this->getActionColor($log->aksi),
                'icon' => $this->getActionIcon($log->aksi),
            ])
            ->toArray();

        $summary = ActivityLog::selectRaw('aksi, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDay())
            ->groupBy('aksi')
            ->pluck('count', 'aksi')
            ->toArray();

        $loginStats = $this->getLoginStats();

        $todaySubmissions = PengajuanSurat::whereDate('created_at', today())->count();
        $completedToday = PengajuanSurat::where('status', 'completed')
            ->whereDate('updated_at', today())
            ->count();

        $role = $this->user->roles()->first()?->name;
        $statusMap = [
            'Operator Pelayanan' => ['submitted'],
            'Sekretaris Desa' => ['approved_operator'],
            'Kepala Desa' => ['approved_sekdes'],
        ];
        $myStatuses = $role === 'Super Admin'
            ? ['submitted', 'verified', 'approved_operator', 'approved_sekdes']
            : ($statusMap[$role] ?? []);
        $myPending = empty($myStatuses) ? 0 : PengajuanSurat::whereIn('status', $myStatuses)->count();

        return [
            'logs' => $logs,
            'summary' => $summary,
            'totalToday' => array_sum($summary),
            'loginToday' => $loginStats['today'],
            'loginWeek' => $loginStats['week'],
            'loginUnique' => $loginStats['uniqueToday'],
            'todaySubmissions' => $todaySubmissions,
            'completedToday' => $completedToday,
            'myPending' => $myPending,
        ];
    }

    private function getLoginStats(): array
    {
        $base = DB::table('activity_logs')->where('aksi', 'like', '%login%');

        $today = (clone $base)->whereDate('created_at', today())->count();
        $week = (clone $base)->where('created_at', '>=', now()->subWeek())->count();
        $uniqueToday = (clone $base)->whereDate('created_at', today())->distinct('user_id')->count('user_id');

        return [
            'today' => $today,
            'week' => $week,
            'uniqueToday' => $uniqueToday,
        ];
    }

    private function getActionColor(string $aksi): string
    {
        return match (true) {
            str_contains($aksi, 'approve') => 'emerald',
            str_contains($aksi, 'reject') => 'red',
            str_contains($aksi, 'create') => 'blue',
            str_contains($aksi, 'update') || str_contains($aksi, 'edit') => 'amber',
            str_contains($aksi, 'delete') || str_contains($aksi, 'cancel') => 'red',
            str_contains($aksi, 'login') => 'purple',
            default => 'gray',
        };
    }

    private function getActionIcon(string $aksi): string
    {
        return match (true) {
            str_contains($aksi, 'approve') => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            str_contains($aksi, 'reject') => 'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            str_contains($aksi, 'create') => 'M12 4.5v15m7.5-7.5h-15',
            str_contains($aksi, 'delete') || str_contains($aksi, 'cancel') => 'M6 18L18 6M6 6l12 12',
            str_contains($aksi, 'login') => 'M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9',
            default => 'M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z',
        };
    }
}
