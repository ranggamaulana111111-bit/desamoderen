<?php

namespace App\Dashboard\Widgets;

use App\Dashboard\Contracts\WidgetInterface;
use App\Dashboard\Services\DashboardStatsService;
use App\Models\User;
use App\Services\AnalyticsService;

class ChartWidget implements WidgetInterface
{
    public function __construct(private readonly User $user) {}

    public function getKey(): string
    {
        return 'charts';
    }

    public function getTitle(): string
    {
        return 'Grafik';
    }

    public function getComponent(): string
    {
        return 'components.widgets._charts';
    }

    public function getPermissions(): array
    {
        return ['analytics.view'];
    }

    public function getGroup(): string
    {
        return 'analytics';
    }

    public function getPosition(): int
    {
        return 20;
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
        $analytics = app(AnalyticsService::class);
        $stats = app(DashboardStatsService::class);

        return [
            'trends' => $analytics->getMonthlyTrends(12),
            'letterDistribution' => $stats->letterDistribution(),
        ];
    }
}
