<?php

namespace App\Services;

use App\Models\ApprovalHistory;
use App\Models\PengajuanSurat;
use App\Models\User;
use Carbon\Carbon;

class AnalyticsService
{
    public function getOverviewStats(?Carbon $start = null, ?Carbon $end = null): array
    {
        $query = PengajuanSurat::query();
        if ($start) {
            $query->whereDate('created_at', '>=', $start);
        }
        if ($end) {
            $query->whereDate('created_at', '<=', $end);
        }

        $total = (clone $query)->count();
        $completed = (clone $query)->where('status', 'completed')->count();
        $rejected = (clone $query)->where('status', 'rejected')->count();
        $active = (clone $query)->whereIn('status', PengajuanSurat::ACTIVE_STATUSES)->count();
        $revisionCount = (clone $query)->where('status', 'revision')->count();

        $approvalRate = $total > 0 ? round(($completed / $total) * 100, 1) : 0;
        $rejectionRate = $total > 0 ? round(($rejected / $total) * 100, 1) : 0;

        return compact('total', 'completed', 'rejected', 'active', 'revisionCount', 'approvalRate', 'rejectionRate');
    }

    public function getMonthlyTrends(int $months = 12): array
    {
        $raw = PengajuanSurat::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as bulan")
            ->selectRaw('COUNT(*) as total')
            ->selectRaw("SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as selesai")
            ->selectRaw("SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as ditolak")
            ->where('created_at', '>=', now()->subMonths($months)->startOfMonth())
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->keyBy('bulan');

        $monthsCollection = collect();
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $key = $date->format('Y-m');
            $row = $raw->get($key);
            $monthsCollection->push([
                'bulan' => $key,
                'label' => $date->locale('id')->isoFormat('MMM YYYY'),
                'total' => (int) ($row->total ?? 0),
                'selesai' => (int) ($row->selesai ?? 0),
                'ditolak' => (int) ($row->ditolak ?? 0),
            ]);
        }

        return $monthsCollection->toArray();
    }

    public function getPopularLetterTypes(?Carbon $start = null, ?Carbon $end = null): array
    {
        $query = PengajuanSurat::selectRaw('jenis_surat')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw("SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as selesai")
            ->selectRaw("SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as ditolak")
            ->groupBy('jenis_surat')
            ->orderByDesc('total');

        if ($start) {
            $query->whereDate('created_at', '>=', $start);
        }
        if ($end) {
            $query->whereDate('created_at', '<=', $end);
        }

        return $query->get()->map(function ($item) {
            $item->total = (int) $item->total;
            $item->selesai = (int) $item->selesai;
            $item->ditolak = (int) $item->ditolak;
            $item->label = str_replace('_', ' ', ucfirst($item->jenis_surat));
            $item->approval_rate = $item->total > 0 ? round(($item->selesai / $item->total) * 100, 1) : 0;

            return $item;
        })->toArray();
    }

    public function getAvgProcessingTimePerType(): array
    {
        $results = PengajuanSurat::where('status', 'completed')
            ->selectRaw('jenis_surat')
            ->selectRaw('AVG(TIMESTAMPDIFF(SECOND, created_at, updated_at)) as avg_seconds')
            ->selectRaw('COUNT(*) as sample_count')
            ->groupBy('jenis_surat')
            ->get();

        $formatted = [];
        foreach ($results as $item) {
            $avgSeconds = (float) ($item->avg_seconds ?? 0);
            $formatted[] = [
                'label' => str_replace('_', ' ', ucfirst($item->jenis_surat)),
                'jenis_surat' => $item->jenis_surat,
                'avg_seconds' => $avgSeconds,
                'avg_hours' => round($avgSeconds / 3600, 1),
                'avg_days' => round($avgSeconds / 86400, 1),
                'sample_count' => (int) $item->sample_count,
            ];
        }

        return $formatted;
    }

    public function getUserGrowth(int $months = 12): array
    {
        $raw = User::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as bulan")
            ->selectRaw('COUNT(*) as total_baru')
            ->where('created_at', '>=', now()->subMonths($months)->startOfMonth())
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->keyBy('bulan');

        $cumulative = User::where('created_at', '<', now()->subMonths($months)->startOfMonth())->count();

        $monthsCollection = collect();
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $key = $date->format('Y-m');
            $baru = (int) ($raw->get($key)->total_baru ?? 0);
            $cumulative += $baru;

            $monthsCollection->push([
                'bulan' => $key,
                'label' => $date->locale('id')->isoFormat('MMM YYYY'),
                'baru' => $baru,
                'total_akumulasi' => $cumulative,
            ]);
        }

        return $monthsCollection->toArray();
    }

    public function getOperatorPerformance(): array
    {
        $histories = ApprovalHistory::selectRaw('approval_histories.user_id')
            ->selectRaw('approval_histories.status')
            ->selectRaw('COUNT(*) as total')
            ->join('users', 'approval_histories.user_id', '=', 'users.id')
            ->whereIn('approval_histories.status', [
                'verified', 'approved_operator', 'approved_sekdes',
                'approved_kades', 'completed', 'rejected', 'revision',
            ])
            ->groupBy('approval_histories.user_id', 'approval_histories.status')
            ->with('user:id,name')
            ->get()
            ->groupBy('user_id');

        return $histories->map(function ($items, $userId) {
            $user = $items->first()->user;
            $total = $items->sum('total');
            $approvals = $items->whereIn('status', [
                'verified', 'approved_operator', 'approved_sekdes', 'approved_kades', 'completed',
            ])->sum('total');
            $rejections = $items->where('status', 'rejected')->sum('total');
            $revisions = $items->where('status', 'revision')->sum('total');

            return [
                'user_id' => $userId,
                'name' => $user->name,
                'total' => $total,
                'approvals' => $approvals,
                'rejections' => $rejections,
                'revisions' => $revisions,
                'approval_rate' => $total > 0 ? round(($approvals / $total) * 100, 1) : 0,
            ];
        })->sortByDesc('total')->values()->toArray();
    }

    public function getStatusDistribution(): array
    {
        $raw = PengajuanSurat::selectRaw('status')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        $labels = ApprovalHistory::STATUS_LABELS();
        $colors = ApprovalHistory::STATUS_COLORS();

        $chartColors = [
            'submitted' => '#3b82f6',
            'verified' => '#6366f1',
            'revision' => '#eab308',
            'approved_operator' => '#a855f7',
            'approved_sekdes' => '#06b6d4',
            'approved_kades' => '#10b981',
            'completed' => '#22c55e',
            'rejected' => '#ef4444',
        ];

        $result = [];
        foreach (PengajuanSurat::STATUSES as $status) {
            $result[] = [
                'status' => $status,
                'label' => $labels[$status] ?? $status,
                'color' => $colors[$status] ?? 'bg-gray-100 text-gray-700',
                'chart_color' => $chartColors[$status] ?? '#6b7280',
                'total' => (int) ($raw->get($status)->total ?? 0),
            ];
        }

        return $result;
    }

    public function getExportData(?Carbon $start = null, ?Carbon $end = null): array
    {
        $query = PengajuanSurat::with('user', 'approvalHistories.user')
            ->orderByDesc('created_at');

        if ($start) {
            $query->whereDate('created_at', '>=', $start);
        }
        if ($end) {
            $query->whereDate('created_at', '<=', $end);
        }

        return $query->get()->map(function ($surat) {
            $latestHistory = $surat->approvalHistories->last();
            $duration = $surat->created_at->diffInSeconds($surat->updated_at);

            return [
                'ID' => $surat->id,
                'Pemohon' => $surat->user->name ?? '-',
                'NIK' => $surat->user->nik ?? '-',
                'Jenis Surat' => str_replace('_', ' ', ucfirst($surat->jenis_surat)),
                'Status' => $surat->status_label,
                'Tanggal Diajukan' => $surat->created_at->format('Y-m-d H:i'),
                'Tanggal Update' => $surat->updated_at->format('Y-m-d H:i'),
                'Durasi (jam)' => round($duration / 3600, 1),
                'Nomor Surat' => $surat->nomor_surat ?? '-',
                'Diperbarui Oleh' => $latestHistory?->user?->name ?? '-',
                'Catatan' => $surat->catatan_admin ?? '-',
            ];
        })->toArray();
    }

    public function getFilteredStats(?Carbon $start = null, ?Carbon $end = null): array
    {
        return [
            'overview' => $this->getOverviewStats($start, $end),
            'popularTypes' => $this->getPopularLetterTypes($start, $end),
            'statusDistribution' => $this->getStatusDistribution(),
            'monthlyTrends' => $this->getMonthlyTrends(),
            'avgProcessingTime' => $this->getAvgProcessingTimePerType(),
            'userGrowth' => $this->getUserGrowth(),
            'operatorPerformance' => $this->getOperatorPerformance(),
        ];
    }
}
