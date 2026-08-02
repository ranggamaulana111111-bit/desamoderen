<?php

namespace App\Dashboard;

use App\Dashboard\Widgets\ApprovalWidget;
use App\Dashboard\Widgets\AuditLogWidget;
use App\Dashboard\Widgets\ChartWidget;
use App\Dashboard\Widgets\EventWidget;
use App\Dashboard\Widgets\HeaderWidget;
use App\Dashboard\Widgets\HealthWidget;
use App\Dashboard\Widgets\NotificationWidget;
use App\Dashboard\Widgets\QueueWidget;
use App\Dashboard\Widgets\QuickActionsWidget;
use App\Dashboard\Widgets\ShortcutWidget;
use App\Dashboard\Widgets\SlaWidget;
use App\Dashboard\Widgets\StatsWidget;
use App\Dashboard\Widgets\SubmissionWidget;
use App\Dashboard\Widgets\SystemInfoWidget;
use App\Dashboard\Widgets\VillageWidget;
use App\Dashboard\Widgets\WorkflowWidget;

class WidgetManager
{
    private WidgetRegistry $registry;

    private WidgetFactory $factory;

    public function __construct(
        WidgetRegistry $registry,
        WidgetFactory $factory,
    ) {
        $this->registry = $registry;
        $this->factory = $factory;
    }

    public function init(): void
    {
        $user = auth()->user();
        $this->factory->loadPositions($user->id);
        $this->registerWidgets();
    }

    private function registerWidgets(): void
    {
        $user = auth()->user();

        $this->registry->register(new HeaderWidget($user));
        $this->registry->register(new QuickActionsWidget($user));
        $this->registry->register(new ShortcutWidget($user));
        $this->registry->register(new StatsWidget($user));
        $this->registry->register(new ChartWidget($user));
        $this->registry->register(new WorkflowWidget($user));
        $this->registry->register(new ApprovalWidget($user));
        $this->registry->register(new SlaWidget($user));
        $this->registry->register(new QueueWidget($user));
        $this->registry->register(new HealthWidget($user));
        $this->registry->register(new SystemInfoWidget($user));
        $this->registry->register(new VillageWidget($user));
        $this->registry->register(new EventWidget($user));
        $this->registry->register(new SubmissionWidget($user));
        $this->registry->register(new AuditLogWidget($user));
    }

    public function registry(): WidgetRegistry
    {
        return $this->registry;
    }

    public function factory(): WidgetFactory
    {
        return $this->factory;
    }

    public function getWidgetData(string $key): ?array
    {
        $widget = $this->registry->get($key);
        if (! $widget || ! $widget->isVisible()) {
            return null;
        }

        return $widget->getData();
    }

    public function getDashboardData(): array
    {
        $this->init();

        return [
            'layout' => $this->factory->buildLayout(),
            'widgets' => $this->registry->sorted(),
            'user' => auth()->user(),
        ];
    }
}
