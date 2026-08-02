<?php

namespace App\Dashboard\Widgets;

use App\Dashboard\Contracts\WidgetInterface;
use App\Dashboard\Services\SystemHealthService;
use App\Models\User;

class HealthWidget implements WidgetInterface
{
    public function __construct(private readonly User $user) {}

    public function getKey(): string
    {
        return 'health';
    }

    public function getTitle(): string
    {
        return 'Kesehatan Sistem';
    }

    public function getComponent(): string
    {
        return 'components.widgets._health';
    }

    public function getPermissions(): array
    {
        return [];
    }

    public function getGroup(): string
    {
        return 'monitoring';
    }

    public function getPosition(): int
    {
        return 51;
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
        return ['systemHealth' => app(SystemHealthService::class)->check()];
    }
}
