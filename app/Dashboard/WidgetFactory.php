<?php

namespace App\Dashboard;

use App\Models\DashboardLayout;

class WidgetFactory
{
    private WidgetRegistry $registry;

    private array $customPositions = [];

    public function __construct(WidgetRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function loadPositions(int $userId): void
    {
        $layout = DashboardLayout::where('user_id', $userId)->get();
        foreach ($layout as $item) {
            $this->customPositions[$item->widget_key] = [
                'position' => $item->position,
                'visible' => $item->visible,
                'width' => $item->width,
                'colspan' => $item->colspan,
            ];
        }
    }

    public function getPosition(string $widgetKey): int
    {
        return $this->customPositions[$widgetKey]['position']
            ?? ($this->registry->get($widgetKey)?->getPosition() ?? 999);
    }

    public function isVisible(string $widgetKey): bool
    {
        if (isset($this->customPositions[$widgetKey])) {
            return $this->customPositions[$widgetKey]['visible'];
        }

        $widget = $this->registry->get($widgetKey);

        return $widget ? $widget->isVisible() : false;
    }

    public function getWidth(string $widgetKey): string
    {
        return $this->customPositions[$widgetKey]['width'] ?? 'full';
    }

    public function getColspan(string $widgetKey): int
    {
        return $this->customPositions[$widgetKey]['colspan'] ?? 12;
    }

    public function buildLayout(): array
    {
        $widgets = $this->registry->forCurrentUser();

        $layout = [];
        foreach ($widgets as $widget) {
            $key = $widget->getKey();
            $layout[] = [
                'key' => $key,
                'title' => $widget->getTitle(),
                'component' => $widget->getComponent(),
                'group' => $widget->getGroup(),
                'position' => $this->getPosition($key),
                'width' => $this->getWidth($key),
                'colspan' => $this->getColspan($key),
                'grid_span' => $widget->gridSpan(),
                'lazy' => $widget->isLazy(),
                'data' => $widget->isLazy() ? [] : $widget->getData(),
            ];
        }

        usort($layout, fn ($a, $b) => $a['position'] <=> $b['position']);

        return $layout;
    }
}
