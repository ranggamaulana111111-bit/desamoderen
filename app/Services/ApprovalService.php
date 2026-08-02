<?php

namespace App\Services;

use App\Models\ApprovalHistory;
use App\Models\PengajuanSurat;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApprovalService
{
    public function __construct(
        private readonly DocumentVersionService $documentVersionService,
    ) {}

    private const STEP_MAP = [
        0 => 'submitted',
        1 => 'verified',
        2 => 'approved_operator',
        3 => 'approved_sekdes',
        4 => 'approved_kades',
        5 => 'completed',
    ];

    private const APPROVAL_PERMISSIONS = [
        'verified' => 'letter.review',
        'approved_operator' => 'letter.review',
        'revision' => 'letter.review',
        'approved_sekdes' => 'letter.verify',
        'approved_kades' => 'letter.final_approve',
        'completed' => 'letter.sign',
        'rejected' => ['letter.reject', 'letter.review', 'letter.verify', 'letter.final_approve'],
    ];

    public function getValidTransitions(PengajuanSurat $surat, User $user): array
    {
        if ($surat->isTerminal()) {
            return [];
        }

        $transitions = match ($surat->status) {
            'submitted' => [
                'verified' => 'Verifikasi',
                'rejected' => 'Tolak',
            ],
            'verified' => [
                'approved_operator' => 'Setujui',
                'revision' => 'Minta Perbaikan',
                'rejected' => 'Tolak',
            ],
            'revision' => [
                'submitted' => 'Kirim Ulang',
            ],
            'approved_operator' => [
                'approved_sekdes' => 'Setujui',
                'rejected' => 'Tolak',
            ],
            'approved_sekdes' => [
                'approved_kades' => 'Setujui',
                'rejected' => 'Tolak',
            ],
            'approved_kades' => [
                'completed' => 'Selesaikan',
                'rejected' => 'Tolak',
            ],
            default => [],
        };

        if ($surat->status === 'revision') {
            if ($user->id === $surat->submitted_by && $user->can('letter.create')) {
                return $transitions;
            }

            return [];
        }

        $filtered = [];
        foreach ($transitions as $targetStatus => $label) {
            if ($this->canPerformTransition($targetStatus, $user)) {
                $filtered[$targetStatus] = $label;
            }
        }

        return $filtered;
    }

    public function canPerformTransition(string $targetStatus, User $user): bool
    {
        $required = self::APPROVAL_PERMISSIONS[$targetStatus] ?? null;

        if (is_null($required)) {
            return false;
        }

        if (is_array($required)) {
            return $user->hasAnyPermission($required);
        }

        return $user->can($required);
    }

    public function transition(PengajuanSurat $surat, string $newStatus, User $user, ?string $catatan = null): void
    {
        $validTransitions = $this->getValidTransitions($surat, $user);

        if (! array_key_exists($newStatus, $validTransitions)) {
            throw new \InvalidArgumentException("Transisi dari '{$surat->status}' ke '{$newStatus}' tidak valid.");
        }

        DB::transaction(function () use ($surat, $newStatus, $user, $catatan) {
            $previousStatus = $surat->status;
            $newStep = $this->calculateNewStep($newStatus, $surat->current_step);

            $surat->update([
                'status' => $newStatus,
                'current_step' => $newStep,
                'catatan_admin' => $catatan,
            ]);

            ApprovalHistory::create([
                'pengajuan_id' => $surat->id,
                'user_id' => $user->id,
                'status' => $newStatus,
                'catatan' => $catatan,
                'step_order' => $surat->approvalHistories()->max('step_order') + 1,
            ]);

            if ($newStatus === 'revision') {
                $surat->update(['submitted_by' => $surat->user_id]);
            }

            $this->documentVersionService->createVersion(
                $surat,
                $user,
                $catatan,
                "Status berubah dari {$previousStatus} ke {$newStatus}"
            );
        });
    }

    public function reject(PengajuanSurat $surat, User $user, ?string $catatan = null): void
    {
        $this->transition($surat, 'rejected', $user, $catatan);
    }

    public function approve(PengajuanSurat $surat, User $user, ?string $catatan = null): void
    {
        if (is_null($surat->status)) {
            Log::error("ApprovalService::approve - Status is NULL for pengajuan #{$surat->id}");
            throw new \InvalidArgumentException('Status pengajuan tidak boleh kosong.');
        }

        $nextStatus = $this->getNextStatus($surat->status);

        $this->transition($surat, $nextStatus, $user, $catatan);
    }

    public function requestRevision(PengajuanSurat $surat, User $user, ?string $catatan = null): void
    {
        $this->transition($surat, 'revision', $user, $catatan);
    }

    public function getNextStatus(string $currentStatus): ?string
    {
        return match ($currentStatus) {
            'submitted' => 'verified',
            'verified' => 'approved_operator',
            'approved_operator' => 'approved_sekdes',
            'approved_sekdes' => 'approved_kades',
            'approved_kades' => 'completed',
            default => null,
        };
    }

    public function getTimeline(PengajuanSurat $surat): Collection
    {
        return $surat->approvalHistories()
            ->with('user')
            ->orderBy('step_order')
            ->get();
    }

    public function getWorkflowSteps(): array
    {
        return [
            ['key' => 'submitted', 'label' => 'Diajukan', 'step' => 0, 'permission' => null],
            ['key' => 'verified', 'label' => 'Verifikasi Operator', 'step' => 1, 'permission' => 'letter.review'],
            ['key' => 'approved_operator', 'label' => 'Disetujui Operator', 'step' => 2, 'permission' => 'letter.review'],
            ['key' => 'approved_sekdes', 'label' => 'Disetujui Sekdes', 'step' => 3, 'permission' => 'letter.verify'],
            ['key' => 'approved_kades', 'label' => 'Disetujui Kades', 'step' => 4, 'permission' => 'letter.final_approve'],
            ['key' => 'completed', 'label' => 'Selesai', 'step' => 5, 'permission' => 'letter.sign'],
        ];
    }

    public function getStepProgress(PengajuanSurat $surat): array
    {
        $steps = $this->getWorkflowSteps();
        $currentStep = $surat->current_step;
        $result = [];

        foreach ($steps as $step) {
            $status = 'pending';
            if ($step['step'] < $currentStep) {
                $status = 'completed';
            } elseif ($step['step'] === $currentStep) {
                $status = $surat->status === 'rejected' ? 'rejected' : 'active';
            }
            $result[] = array_merge($step, ['status' => $status]);
        }

        return $result;
    }

    private function calculateNewStep(string $newStatus, int $currentStep): int
    {
        return match ($newStatus) {
            'submitted' => 0,
            'verified' => 1,
            'approved_operator' => 2,
            'approved_sekdes' => 3,
            'approved_kades' => 4,
            'completed' => 5,
            'revision' => $currentStep,
            'rejected' => $currentStep,
            default => $currentStep,
        };
    }
}
