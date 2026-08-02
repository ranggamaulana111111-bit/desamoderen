<?php

namespace App\Dashboard\Widgets;

use App\Dashboard\Contracts\WidgetInterface;
use App\Models\User;

class QuickActionsWidget implements WidgetInterface
{
    public function __construct(private readonly User $user) {}

    public function getKey(): string
    {
        return 'quick_actions';
    }

    public function getTitle(): string
    {
        return 'Quick Actions';
    }

    public function getComponent(): string
    {
        return 'components.widgets._quick_actions';
    }

    public function getPermissions(): array
    {
        return [];
    }

    public function getGroup(): string
    {
        return 'actions';
    }

    public function getPosition(): int
    {
        return 2;
    }

    public function isVisible(): bool
    {
        return true;
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
        $can = fn ($perm) => $this->user?->can($perm) ?? false;

        return [
            'can' => [
                'letter.create' => $can('letter.create'),
                'news.manage' => $can('news.manage'),
                'event.manage' => $can('event.manage'),
                'user.create' => $can('user.create'),
                'analytics.view' => $can('analytics.view'),
                'queue.view' => $can('queue.view'),
            ],
        ];
    }
}
