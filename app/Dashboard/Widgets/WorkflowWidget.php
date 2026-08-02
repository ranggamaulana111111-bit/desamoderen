<?php

namespace App\Dashboard\Widgets;

use App\Dashboard\Contracts\WidgetInterface;
use App\Dashboard\Services\WorkflowMonitorService;
use App\Models\User;

class WorkflowWidget implements WidgetInterface
{
    public function __construct(private readonly User $user) {}

    public function getKey(): string
    {
        return 'workflow';
    }

    public function getTitle(): string
    {
        return 'Workflow Pipeline';
    }

    public function getComponent(): string
    {
        return 'components.widgets._workflow';
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
        return 30;
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
        return ['pipeline' => app(WorkflowMonitorService::class)->pipeline()];
    }
}
