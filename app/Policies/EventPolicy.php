<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('event.manage');
    }

    public function view(User $user, Event $event): bool
    {
        return $user->can('event.manage') || $event->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->can('event.manage');
    }

    public function update(User $user, Event $event): bool
    {
        return $user->can('event.manage');
    }

    public function delete(User $user, Event $event): bool
    {
        return $user->can('event.manage');
    }
}
