<?php

namespace App\Dashboard\Widgets;

use App\Dashboard\Contracts\WidgetInterface;
use App\Models\Event;
use App\Models\User;

class EventWidget implements WidgetInterface
{
    public function __construct(private readonly User $user) {}

    public function getKey(): string
    {
        return 'events';
    }

    public function getTitle(): string
    {
        return 'Event Mendatang';
    }

    public function getComponent(): string
    {
        return 'components.widgets._events';
    }

    public function getPermissions(): array
    {
        return [];
    }

    public function getGroup(): string
    {
        return 'info';
    }

    public function getPosition(): int
    {
        return 61;
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
        return 6;
    }

    public function getData(): array
    {
        $events = Event::whereDate('tanggal', '>=', today())
            ->orderBy('tanggal')
            ->take(5)
            ->get()
            ->map(fn ($e) => [
                'id' => $e->id,
                'judul' => $e->judul,
                'tanggal' => $e->tanggal->format('d M'),
                'tanggal_full' => $e->tanggal->format('Y-m-d'),
                'tempat' => $e->tempat,
                'waktu_mulai' => $e->waktu_mulai?->format('H:i'),
            ])->toArray();

        return ['events' => $events];
    }
}
