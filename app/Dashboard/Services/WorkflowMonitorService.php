<?php

namespace App\Dashboard\Services;

use App\Models\ApprovalHistory;
use App\Models\PengajuanSurat;
use Illuminate\Support\Facades\Cache;

class WorkflowMonitorService
{
    private const CACHE_TTL = 60;

    private const PREFIX = 'dsh_workflow_';

    public function pipeline(): array
    {
        return Cache::remember(self::PREFIX.'pipeline', self::CACHE_TTL, function () {
            $steps = [
                'submitted' => 'blue',
                'verified' => 'indigo',
                'approved_operator' => 'purple',
                'approved_sekdes' => 'cyan',
                'approved_kades' => 'emerald',
                'completed' => 'green',
            ];

            $counts = PengajuanSurat::selectRaw('status, COUNT(*) as total')
                ->whereIn('status', array_keys($steps))
                ->groupBy('status')
                ->pluck('total', 'status');

            $result = [];
            foreach ($steps as $status => $color) {
                $result[] = [
                    'status' => $status,
                    'label' => ApprovalHistory::STATUS_LABELS()[$status] ?? ucfirst(str_replace('_', ' ', $status)),
                    'total' => (int) ($counts[$status] ?? 0),
                    'color' => $color,
                ];
            }

            return $result;
        });
    }

    public function myApprovals(): array
    {
        $user = auth()->user();
        $role = $user?->roles()->first()?->name;

        $statusMap = [
            'Operator Pelayanan' => ['submitted', 'verified'],
            'Sekretaris Desa' => ['approved_operator'],
            'Kepala Desa' => ['approved_sekdes'],
        ];

        $statuses = $role === 'Super Admin'
            ? ['submitted', 'verified', 'approved_operator', 'approved_sekdes']
            : ($statusMap[$role] ?? []);

        $items = [];
        if (! empty($statuses)) {
            $items = PengajuanSurat::with('user')
                ->whereIn('status', $statuses)
                ->latest()
                ->take(5)
                ->get()
                ->map(fn ($s) => [
                    'id' => $s->id,
                    'user_name' => $s->user->name ?? '-',
                    'user_avatar' => $s->user->avatar_initials,
                    'jenis_surat' => str_replace('_', ' ', $s->jenis_surat),
                    'status' => $s->status,
                    'status_label' => $s->status_label,
                    'status_color' => $s->status_color,
                    'created_at' => $s->created_at->diffForHumans(),
                    'url' => route('admin.pengajuan.show', $s),
                ])->toArray();
        }

        return [
            'role' => $role,
            'items' => $items,
            'total' => count($items),
        ];
    }
}
