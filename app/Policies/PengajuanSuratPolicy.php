<?php

namespace App\Policies;

use App\Models\PengajuanSurat;
use App\Models\User;

class PengajuanSuratPolicy
{
    public function view(User $user, PengajuanSurat $surat): bool
    {
        if ($user->id === $surat->user_id) {
            return true;
        }

        return $user->can('letter.view');
    }

    public function approve(User $user, PengajuanSurat $surat): bool
    {
        return $user->can('letter.review')
            || $user->can('letter.verify')
            || $user->can('letter.final_approve');
    }

    public function reject(User $user, PengajuanSurat $surat): bool
    {
        return $user->can('letter.reject')
            || $user->can('letter.review')
            || $user->can('letter.verify')
            || $user->can('letter.final_approve');
    }

    public function requestRevision(User $user, PengajuanSurat $surat): bool
    {
        return $user->can('letter.review');
    }

    public function download(User $user, PengajuanSurat $surat): bool
    {
        if ($user->id === $surat->user_id) {
            return true;
        }

        return $user->can('letter.download');
    }
}
