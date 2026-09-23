<?php

namespace App\Policies;

use App\Models\PengajuanSurat;
use App\Models\User;
use App\Services\ApprovalService;

class PengajuanSuratPolicy
{
    public function view(User $user, PengajuanSurat $surat): bool
    {
        if ($user->id === $surat->user_id) {
            return true;
        }

        if (! $user->can('letter.view')) {
            return false;
        }

        return $user->isRtRw() ? $user->inSameWilayah($surat->user) : true;
    }

    public function approve(User $user, PengajuanSurat $surat): bool
    {
        $service = app(ApprovalService::class);
        $nextStatus = $service->getNextStatus($surat->status);

        if (is_null($nextStatus)) {
            return false;
        }

        return array_key_exists($nextStatus, $service->getValidTransitions($surat, $user));
    }

    public function reject(User $user, PengajuanSurat $surat): bool
    {
        $validTransitions = app(ApprovalService::class)->getValidTransitions($surat, $user);

        return array_key_exists('rejected', $validTransitions);
    }

    public function requestRevision(User $user, PengajuanSurat $surat): bool
    {
        $validTransitions = app(ApprovalService::class)->getValidTransitions($surat, $user);

        return array_key_exists('revision', $validTransitions);
    }

    public function download(User $user, PengajuanSurat $surat): bool
    {
        if ($user->id === $surat->user_id) {
            return $surat->status === 'completed';
        }

        if (! $user->can('letter.download')) {
            return false;
        }

        if ($user->isRtRw() && ! $user->inSameWilayah($surat->user)) {
            return false;
        }

        return $surat->status === 'completed';
    }

    public function viewLampiran(User $user, PengajuanSurat $surat): bool
    {
        if ($user->id === $surat->user_id) {
            return false;
        }

        return $this->view($user, $surat);
    }
}