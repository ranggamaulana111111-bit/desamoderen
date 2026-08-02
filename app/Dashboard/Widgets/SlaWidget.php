<?php

namespace App\Dashboard\Widgets;

use App\Dashboard\Contracts\WidgetInterface;
use App\Models\PengajuanSurat;
use App\Models\User;

class SlaWidget implements WidgetInterface
{
    public function __construct(private readonly User $user) {}

    public function getKey(): string
    {
        return 'sla';
    }

    public function getTitle(): string
    {
        return 'SLA Monitoring';
    }

    public function getComponent(): string
    {
        return 'components.widgets._sla';
    }

    public function getPermissions(): array
    {
        return ['letter.view'];
    }

    public function getGroup(): string
    {
        return 'monitoring';
    }

    public function getPosition(): int
    {
        return 40;
    }

    public function isVisible(): bool
    {
        return $this->user && $this->user->role_label !== 'Warga';
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
        $overdue = PengajuanSurat::with('user')
            ->whereIn('status', ['submitted', 'verified', 'approved_operator', 'approved_sekdes', 'approved_kades'])
            ->where('created_at', '<', now()->subDays(3))
            ->latest()
            ->take(10)
            ->get()
            ->map(fn ($s) => [
                'id' => $s->id,
                'user_name' => $s->user->name ?? '-',
                'user_avatar' => $s->user->avatar_initials ?? '?',
                'jenis_surat' => str_replace('_', ' ', $s->jenis_surat),
                'status' => $s->status,
                'status_label' => $s->status_label,
                'status_color' => $s->status_color,
                'days' => (int) $s->created_at->diffInDays(now()),
                'url' => route('admin.pengajuan.show', $s),
            ])->toArray();

        $overdueCount = PengajuanSurat::whereIn('status', ['submitted', 'verified', 'approved_operator', 'approved_sekdes', 'approved_kades'])
            ->where('created_at', '<', now()->subDays(3))
            ->count();

        $avgTime = PengajuanSurat::where('status', 'completed')
            ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as avg_hours')
            ->value('avg_hours') ?? 0;

        return [
            'overdue' => $overdue,
            'overdueCount' => $overdueCount,
            'avgProcessingHours' => round($avgTime, 1),
        ];
    }
}
