<?php

namespace App\Policies;

use App\Models\Berita;
use App\Models\User;

class BeritaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('news.manage');
    }

    public function view(User $user, Berita $berita): bool
    {
        return $user->can('news.manage') || $berita->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->can('news.manage');
    }

    public function update(User $user, Berita $berita): bool
    {
        return $user->can('news.manage');
    }

    public function delete(User $user, Berita $berita): bool
    {
        return $user->can('news.manage');
    }
}
