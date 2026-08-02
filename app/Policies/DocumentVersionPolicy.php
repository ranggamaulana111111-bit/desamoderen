<?php

namespace App\Policies;

use App\Models\User;

class DocumentVersionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('letter.version.view');
    }

    public function view(User $user): bool
    {
        return $user->can('letter.version.view');
    }

    public function restore(User $user): bool
    {
        return $user->can('letter.version.restore');
    }
}
