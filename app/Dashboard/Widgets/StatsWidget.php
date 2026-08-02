<?php

namespace App\Dashboard\Widgets;

use App\Dashboard\Contracts\WidgetInterface;
use App\Dashboard\Services\DashboardStatsService;
use App\Dashboard\Services\WorkflowMonitorService;
use App\Models\PengajuanSurat;
use App\Models\User;
use App\Services\AnalyticsService;
use Illuminate\Support\Facades\Cache;

class StatsWidget implements WidgetInterface
{
    public function __construct(private readonly User $user) {}

    public function getKey(): string
    {
        return 'stats';
    }

    public function getTitle(): string
    {
        return 'Statistik & Pipeline';
    }

    public function getComponent(): string
    {
        return 'components.widgets._stats';
    }

    public function getPermissions(): array
    {
        return [];
    }

    public function getGroup(): string
    {
        return 'stats';
    }

    public function getPosition(): int
    {
        return 10;
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
        $stats = app(DashboardStatsService::class);
        $workflow = app(WorkflowMonitorService::class);
        $analytics = app(AnalyticsService::class);

        $overview = $stats->overview();
        $pipeline = $workflow->pipeline();
        $analyticsSummary = $stats->analyticsSummary();

        return [
            'stats' => $overview,
            'workflow' => $pipeline,
            'analyticsSummary' => $analyticsSummary,
            'operatorPerformance' => array_slice($analytics->getOperatorPerformance(), 0, 5),
            'topRtrw' => $this->getTopRtrw(),
        ];
    }

    private function getTopRtrw(): array
    {
        return Cache::remember('dsh_top_rtrw', 60, function () {
            $topRt = PengajuanSurat::selectRaw('users.rt, COUNT(*) as total')
                ->join('users', 'pengajuan_surats.user_id', '=', 'users.id')
                ->whereNotNull('users.rt')->where('users.rt', '!=', '')
                ->groupBy('users.rt')->orderByDesc('total')->take(5)
                ->get()->map(fn ($item) => ['label' => "RT {$item->rt}", 'total' => (int) $item->total])->toArray();

            $topRw = PengajuanSurat::selectRaw('users.rw, COUNT(*) as total')
                ->join('users', 'pengajuan_surats.user_id', '=', 'users.id')
                ->whereNotNull('users.rw')->where('users.rw', '!=', '')
                ->groupBy('users.rw')->orderByDesc('total')->take(5)
                ->get()->map(fn ($item) => ['label' => "RW {$item->rw}", 'total' => (int) $item->total])->toArray();

            return ['rt' => $topRt, 'rw' => $topRw];
        });
    }
}
