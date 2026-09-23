<?php

namespace Tests\Feature;

use App\Dashboard\WidgetManager;
use App\Dashboard\Widgets\HeaderWidget;
use App\Models\PengajuanSurat;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotifWidgetTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
    }

    private function makeUser(string $role): User
    {
        $u = User::factory()->create();
        $u->assignRole($role);

        return $u;
    }

    private function headerNotifMessages(User $user): array
    {
        $this->actingAs($user);

        $wm = app(WidgetManager::class);
        $wm->init();
        $data = $wm->getWidgetData('header');

        $this->assertNotNull($data, 'header widget visible');

        return array_column($data['notifications'] ?? [], 'message');
    }

    public function test_super_admin_sees_three_aggregated_approval_notifications(): void
    {
        $warga = $this->makeUser('Warga');
        $super = $this->makeUser('Super Admin');

        PengajuanSurat::factory()->create(['user_id' => $warga->id, 'submitted_by' => $warga->id, 'status' => 'submitted', 'current_step' => 0]);
        PengajuanSurat::factory()->create(['user_id' => $warga->id, 'submitted_by' => $warga->id, 'status' => 'verified', 'current_step' => 1]);
        PengajuanSurat::factory()->create(['user_id' => $warga->id, 'submitted_by' => $warga->id, 'status' => 'approved_operator', 'current_step' => 2]);
        PengajuanSurat::factory()->create(['user_id' => $warga->id, 'submitted_by' => $warga->id, 'status' => 'approved_sekdes', 'current_step' => 3]);

        $messages = $this->headerNotifMessages($super);

        $this->assertCount(3, array_filter($messages, fn ($m) => str_contains($m, 'pengajuan menunggu')));
        $this->assertContains('2 pengajuan menunggu verifikasi', $messages);
        $this->assertContains('1 pengajuan menunggu verifikasi Sekretaris Desa', $messages);
        $this->assertContains('1 pengajuan menunggu tanda tangan Kepala Desa', $messages);
    }

    public function test_operator_sees_single_aggregated_notification(): void
    {
        $warga = $this->makeUser('Warga');
        $operator = $this->makeUser('Operator Pelayanan');

        PengajuanSurat::factory()->create(['user_id' => $warga->id, 'submitted_by' => $warga->id, 'status' => 'submitted', 'current_step' => 0]);
        PengajuanSurat::factory()->create(['user_id' => $warga->id, 'submitted_by' => $warga->id, 'status' => 'verified', 'current_step' => 1]);

        $messages = $this->headerNotifMessages($operator);

        $pending = array_filter($messages, fn ($m) => str_contains($m, 'pengajuan menunggu'));
        $this->assertCount(1, $pending);
        $this->assertContains('2 pengajuan menunggu verifikasi', $messages);
    }

    public function test_no_pending_means_no_approval_notification(): void
    {
        $super = $this->makeUser('Super Admin');

        $messages = $this->headerNotifMessages($super);

        $this->assertEmpty(array_filter($messages, fn ($m) => str_contains($m, 'pengajuan menunggu')));
    }

    public function test_message_count_matches_badge_count(): void
    {
        $warga = $this->makeUser('Warga');
        $super = $this->makeUser('Super Admin');

        PengajuanSurat::factory()->create(['user_id' => $warga->id, 'submitted_by' => $warga->id, 'status' => 'submitted', 'current_step' => 0]);
        PengajuanSurat::factory()->create(['user_id' => $warga->id, 'submitted_by' => $warga->id, 'status' => 'approved_sekdes', 'current_step' => 3]);

        $messages = $this->headerNotifMessages($super);
        $count = (new HeaderWidget(\Auth::user()))->getData();

        $this->assertSame(count($messages), count($count['notifications']));
    }
}
