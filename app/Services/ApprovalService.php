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

        $transitions = $this->buildTransitions($surat->status);

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

        $previousStatus = $surat->status;

        DB::transaction(function () use ($surat, $newStatus, $user, $catatan, $previousStatus) {
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

        $this->notifyWebhook($surat, $previousStatus, $newStatus, $user);
    }

    private function notifyWebhook(PengajuanSurat $surat, string $from, string $to, User $user): void
    {
        app(WebhookNotifier::class)->send([
            'event' => 'pengajuan.updated',
            'pengajuan_id' => $surat->id,
            'from_status' => $from,
            'to_status' => $to,
            'updated_by' => $user->name,
            'nomor' => $surat->nomor_surat,
            'jenis_surat' => $surat->jenis_surat,
            'url' => route('admin.pengajuan.show', $surat),
            'occurred_at' => now()->toIso8601String(),
        ]);
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
        $chain = $this->activeChain();
        $index = array_search($currentStatus, $chain, true);

        if ($index === false) {
            return null;
        }

        return $chain[$index + 1] ?? null;
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
        $meta = [
            'submitted' => ['label' => 'Diajukan', 'permission' => null],
            'verified' => ['label' => 'Verifikasi Operator', 'permission' => 'letter.review'],
            'approved_operator' => ['label' => 'Disetujui Operator', 'permission' => 'letter.review'],
            'approved_sekdes' => ['label' => 'Disetujui Sekdes', 'permission' => 'letter.verify'],
            'approved_kades' => ['label' => 'Disetujui Kades', 'permission' => 'letter.final_approve'],
            'completed' => ['label' => 'Selesai', 'permission' => 'letter.sign'],
        ];

        $steps = [];
        foreach ($this->activeChain() as $step => $key) {
            $current = $meta[$key] ?? [
                'label' => ucfirst(str_replace('_', ' ', $key)),
                'permission' => null,
            ];

            $steps[] = [
                'key' => $key,
                'label' => $current['label'],
                'step' => $step,
                'permission' => $current['permission'],
            ];
        }

        return $steps;
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
        $index = array_search($newStatus, $this->activeChain(), true);

        if ($index !== false) {
            return $index;
        }

        return match ($newStatus) {
            'revision', 'rejected' => $currentStep,
            default => $currentStep,
        };
    }

    private function buildTransitions(string $status): array
    {
        if ($status === 'revision') {
            return ['submitted' => 'Kirim Ulang'];
        }

        $chain = $this->activeChain();
        $index = array_search($status, $chain, true);

        if ($status === 'submitted') {
            $transitions = [];
            $next = $chain[$index + 1] ?? null;

            if ($next) {
                $transitions[$next] = $next === 'verified' ? 'Verifikasi' : 'Setujui';
            }

            $transitions['rejected'] = 'Tolak';

            return $transitions;
        }

        if ($index === false || $status === 'completed' || $status === 'rejected') {
            return [];
        }

        $transitions = [];
        $next = $chain[$index + 1] ?? null;

        if ($next) {
            $transitions[$next] = $next === 'completed' ? 'Selesaikan' : 'Setujui';
        }

        if ($status === 'verified') {
            $transitions['revision'] = 'Minta Perbaikan';
        }

        $transitions['rejected'] = 'Tolak';

        return $transitions;
    }

    private function activeChain(): array
    {
        $chain = ['submitted'];

        if ($this->workflowEnabled('workflow_operator')) {
            $chain[] = 'verified';
            $chain[] = 'approved_operator';
        }

        if ($this->workflowEnabled('workflow_sekdes')) {
            $chain[] = 'approved_sekdes';
        }

        if ($this->workflowEnabled('workflow_kades')) {
            $chain[] = 'approved_kades';
        }

        $chain[] = 'completed';

        return $chain;
    }

    private function workflowEnabled(string $key): bool
    {
        return (string) (config("village.{$key}") ?? '1') === '1';
    }
}
