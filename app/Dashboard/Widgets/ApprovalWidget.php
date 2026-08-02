<?php

namespace App\Dashboard\Widgets;

use App\Dashboard\Contracts\WidgetInterface;
use App\Dashboard\Services\ActivityFeedService;
use App\Dashboard\Services\WorkflowMonitorService;
use App\Models\User;

class ApprovalWidget implements WidgetInterface
{
    public function __construct(private readonly User $user) {}

    public function getKey(): string
    {
        return 'approvals';
    }

    public function getTitle(): string
    {
        return 'Approval Center';
    }

    public function getComponent(): string
    {
        return 'components.widgets._approvals';
    }

    public function getPermissions(): array
    {
        return ['letter.review', 'letter.verify', 'letter.final_approve'];
    }

    public function getGroup(): string
    {
        return 'approval';
    }

    public function getPosition(): int
    {
        return 35;
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
        $wf = app(WorkflowMonitorService::class);
        $act = app(ActivityFeedService::class);

        return [
            'approvals' => $wf->myApprovals(),
            'activities' => $act->recent(),
        ];
    }
}
