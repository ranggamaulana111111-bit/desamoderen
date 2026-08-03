<?php

namespace Tests\Feature;

use App\Models\PengajuanSurat;
use App\Models\User;
use App\Services\ApprovalService;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Tests\TestCase;

class ApprovalWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private ApprovalService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        $this->service = app(ApprovalService::class);
    }

    private function makeRoles(): array
    {
        $operator = User::factory()->create();
        $operator->assignRole('Operator Pelayanan');

        $sekdes = User::factory()->create();
        $sekdes->assignRole('Sekretaris Desa');

        $kades = User::factory()->create();
        $kades->assignRole('Kepala Desa');

        $warga = User::factory()->create();
        $warga->assignRole('Warga');

        return compact('operator', 'sekdes', 'kades', 'warga');
    }

    private function makePengajuan(User $warga): PengajuanSurat
    {
        return PengajuanSurat::factory()->create([
            'user_id' => $warga->id,
            'submitted_by' => $warga->id,
            'status' => 'submitted',
            'current_step' => 0,
        ]);
    }

    public function test_default_chain_runs_full_workflow(): void
    {
        ['operator' => $operator, 'sekdes' => $sekdes, 'kades' => $kades, 'warga' => $warga] = $this->makeRoles();
        $pengajuan = $this->makePengajuan($warga);

        $this->service->approve($pengajuan, $operator);
        $this->assertEquals('verified', $pengajuan->fresh()->status);

        $this->service->approve($pengajuan, $operator);
        $this->assertEquals('approved_operator', $pengajuan->fresh()->status);

        $this->service->approve($pengajuan, $sekdes);
        $this->assertEquals('approved_sekdes', $pengajuan->fresh()->status);

        $this->service->approve($pengajuan, $kades);
        $this->assertEquals('approved_kades', $pengajuan->fresh()->status);

        $this->service->approve($pengajuan, $kades);
        $this->assertEquals('completed', $pengajuan->fresh()->status);
        $this->assertEquals(5, $pengajuan->fresh()->current_step);
    }

    public function test_can_perform_transition_is_permission_gated(): void
    {
        ['operator' => $operator, 'warga' => $warga] = $this->makeRoles();
        $pengajuan = $this->makePengajuan($warga);

        $this->assertTrue($this->service->canPerformTransition('verified', $operator));
        $this->assertFalse($this->service->canPerformTransition('approved_kades', $operator));
        $this->assertFalse($this->service->canPerformTransition('verified', $warga));
    }

    public function test_next_status_skips_sekdes_when_disabled(): void
    {
        config(['village.workflow_sekdes' => '0']);

        $this->assertEquals('approved_kades', $this->service->getNextStatus('approved_operator'));

        $steps = $this->service->getWorkflowSteps();
        $keys = array_column($steps, 'key');
        $this->assertNotContains('approved_sekdes', $keys);
        $this->assertContains('approved_kades', $keys);
    }

    public function test_operator_step_skipped_when_disabled(): void
    {
        config(['village.workflow_operator' => '0']);

        $this->assertEquals('approved_sekdes', $this->service->getNextStatus('submitted'));

        $steps = $this->service->getWorkflowSteps();
        $keys = array_column($steps, 'key');
        $this->assertNotContains('verified', $keys);
        $this->assertNotContains('approved_operator', $keys);
    }

    public function test_submitted_cannot_be_approved_by_operator_when_operator_step_disabled(): void
    {
        config(['village.workflow_operator' => '0']);

        ['operator' => $operator, 'warga' => $warga] = $this->makeRoles();
        $pengajuan = $this->makePengajuan($warga);

        $this->expectException(InvalidArgumentException::class);

        $this->service->approve($pengajuan, $operator);
    }

    public function test_short_chain_completes_with_relative_step(): void
    {
        config(['village.workflow_operator' => '0', 'village.workflow_sekdes' => '0']);

        ['kades' => $kades, 'warga' => $warga] = $this->makeRoles();
        $pengajuan = $this->makePengajuan($warga);

        $this->service->approve($pengajuan, $kades);
        $this->assertEquals('approved_kades', $pengajuan->fresh()->status);
        $this->assertEquals(1, $pengajuan->fresh()->current_step);

        $this->service->approve($pengajuan, $kades);
        $this->assertEquals('completed', $pengajuan->fresh()->status);
        $this->assertEquals(2, $pengajuan->fresh()->current_step);
    }
}
