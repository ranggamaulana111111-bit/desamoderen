<?php

namespace App\Dashboard\Widgets;

use App\Dashboard\Contracts\WidgetInterface;
use App\Dashboard\Services\DashboardStatsService;
use App\Models\User;

class SubmissionWidget implements WidgetInterface
{
    public function __construct(private readonly User $user) {}

    public function getKey(): string
    {
        return 'submissions';
    }

    public function getTitle(): string
    {
        return 'Pengajuan Terbaru';
    }

    public function getComponent(): string
    {
        return 'components.widgets._submissions';
    }

    public function getPermissions(): array
    {
        return ['letter.view'];
    }

    public function getGroup(): string
    {
        return 'content';
    }

    public function getPosition(): int
    {
        return 70;
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

        return ['latestSubmissions' => $stats->latestSubmissions()];
    }
}
