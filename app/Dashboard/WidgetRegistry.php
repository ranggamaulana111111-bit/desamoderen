<?php

namespace App\Dashboard;

use App\Dashboard\Contracts\WidgetInterface;
use Illuminate\Support\Collection;

class WidgetRegistry
{
    private Collection $widgets;

    public function __construct()
    {
        $this->widgets = collect();
    }

    public function register(WidgetInterface $widget): void
    {
        $this->widgets->put($widget->getKey(), $widget);
    }

    public function get(string $key): ?WidgetInterface
    {
        return $this->widgets->get($key);
    }

    public function all(): Collection
    {
        return $this->widgets;
    }

    public function forCurrentUser(): Collection
    {
        return $this->widgets->filter(fn (WidgetInterface $w) => $w->isVisible());
    }

    public function byGroup(string $group): Collection
    {
        return $this->forCurrentUser()->filter(fn (WidgetInterface $w) => $w->getGroup() === $group);
    }

    public function sorted(): Collection
    {
        return $this->forCurrentUser()->sortBy('getPosition')->values();
    }

    public function lazy(): Collection
    {
        return $this->forCurrentUser()->filter(fn (WidgetInterface $w) => $w->isLazy());
    }

    public function eager(): Collection
    {
        return $this->forCurrentUser()->filter(fn (WidgetInterface $w) => ! $w->isLazy());
    }
}
