<?php

namespace App\Dashboard\Widgets;

use App\Dashboard\Contracts\WidgetInterface;
use App\Dashboard\Services\QueueDashboardService;
use App\Models\User;

class QueueWidget implements WidgetInterface
{
    public function __construct(private readonly User $user) {}

    public function getKey(): string
    {
        return 'queue';
    }

    public function getTitle(): string
    {
        return 'Status Antrean';
    }

    public function getComponent(): string
    {
        return 'components.widgets._queue';
    }

    public function getPermissions(): array
    {
        return ['queue.view'];
    }

    public function getGroup(): string
    {
        return 'monitoring';
    }

    public function getPosition(): int
    {
        return 50;
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
        return 4;
    }

    public function getData(): array
    {
        return [
            'queue' => app(QueueDashboardService::class)->status(),
            'canManage' => $this->user->can('queue.manage'),
        ];
    }
}
