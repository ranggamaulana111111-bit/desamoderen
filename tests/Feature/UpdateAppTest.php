<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\GitUpdateService;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class UpdateAppTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([RolePermissionSeeder::class]);
    }

    private function superAdmin(): User
    {
        return User::create([
            'name' => 'Super Admin',
            'nik' => '0000000000000000',
            'password' => bcrypt('password'),
        ])->assignRole('Super Admin');
    }

    private function operator(): User
    {
        return User::create([
            'name' => 'Operator',
            'nik' => '0000000000000001',
            'password' => bcrypt('password'),
        ])->assignRole('Operator Pelayanan');
    }

    private function mockGit(array $current = [], ?array $update = null, ?array $updateResult = null): void
    {
        $mock = Mockery::mock(GitUpdateService::class);

        $mock->shouldReceive('gitAvailable')->andReturn(true)->byDefault();
        $mock->shouldReceive('isGitRepository')->andReturn(true)->byDefault();
        $mock->shouldReceive('currentVersion')->andReturn(
            $current ?: [
                'available' => true,
                'hash' => 'abc123',
                'shortHash' => 'abc123',
                'message' => 'Initial commit',
                'date' => '2026-01-01T00:00:00+00:00',
                'branch' => 'main',
            ]
        )->byDefault();
        $mock->shouldReceive('checkForUpdates')->andReturn(
            $update ?: [
                'available' => true,
                'branch' => 'main',
                'behindCount' => 2,
                'hasUpdate' => true,
                'latestHash' => 'def456',
                'latestMessage' => 'New feature',
                'latestDate' => '2026-01-02T00:00:00+00:00',
            ]
        )->byDefault();
        $mock->shouldReceive('update')->andReturn(
            $updateResult ?: [
                'success' => true,
                'steps' => [
                    ['step' => 'git_pull', 'success' => true, 'output' => 'Updating 123..456'],
                    ['step' => 'composer', 'success' => true, 'output' => 'Installing dependencies'],
                    ['step' => 'migrate', 'success' => true, 'output' => 'Migration success'],
                ],
                'version' => [
                    'shortHash' => 'def456',
                ],
            ]
        )->byDefault();

        $this->app->instance(GitUpdateService::class, $mock);
    }

    public function test_super_admin_can_check_update_status(): void
    {
        $this->mockGit();

        $this->actingAs($this->superAdmin())
            ->getJson('/admin/pengaturan/update-status')
            ->assertOk()
            ->assertJson([
                'success' => true,
                'update' => [
                    'hasUpdate' => true,
                    'behindCount' => 2,
                ],
            ]);
    }

    public function test_non_super_admin_cannot_check_update_status(): void
    {
        $this->mockGit();

        $this->actingAs($this->operator())
            ->getJson('/admin/pengaturan/update-status')
            ->assertForbidden();
    }

    public function test_non_admin_user_cannot_check_update_status(): void
    {
        $this->mockGit();

        $user = User::create([
            'name' => 'Warga',
            'nik' => '0000000000000002',
            'password' => bcrypt('password'),
        ])->assignRole('Warga');

        $this->actingAs($user)
            ->getJson('/admin/pengaturan/update-status')
            ->assertForbidden();
    }

    public function test_super_admin_can_run_update(): void
    {
        $this->mockGit();

        $this->actingAs($this->superAdmin())
            ->postJson('/admin/pengaturan/update')
            ->assertOk()
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('activity_logs', [
            'aksi' => 'update_app',
            'tipe' => 'pengaturan',
        ]);
    }

    public function test_non_super_admin_cannot_run_update(): void
    {
        $this->mockGit();

        $this->actingAs($this->operator())
            ->postJson('/admin/pengaturan/update')
            ->assertForbidden();
    }

    public function test_update_failure_returns_success_false(): void
    {
        $this->mockGit(updateResult: [
            'success' => false,
            'steps' => [
                ['step' => 'git_pull', 'success' => true, 'output' => 'Updating'],
                ['step' => 'composer', 'success' => false, 'output' => 'Error: not found'],
            ],
            'version' => null,
        ]);

        $this->actingAs($this->superAdmin())
            ->postJson('/admin/pengaturan/update')
            ->assertOk()
            ->assertJson(['success' => false]);

        $this->assertDatabaseHas('activity_logs', [
            'aksi' => 'update_app',
            'tipe' => 'pengaturan',
        ]);
    }

    public function test_update_status_when_git_fetch_fails_returns_message(): void
    {
        $this->mockGit();
        $this->app->instance(GitUpdateService::class, Mockery::mock(GitUpdateService::class, function ($mock) {
            $mock->shouldReceive('gitAvailable')->andReturn(true);
            $mock->shouldReceive('isGitRepository')->andReturn(true);
            $mock->shouldReceive('currentVersion')->andReturn(['available' => true]);
            $mock->shouldReceive('checkForUpdates')->andThrow(new \RuntimeException('Unable to connect to origin'));
        }));

        $this->actingAs($this->superAdmin())
            ->getJson('/admin/pengaturan/update-status')
            ->assertOk()
            ->assertJson(['success' => false]);
    }

    public function test_update_status_offline_returns_no_update(): void
    {
        $this->mockGit(update: [
            'available' => false,
            'branch' => 'main',
            'behindCount' => 0,
            'hasUpdate' => false,
            'latestHash' => null,
            'latestMessage' => null,
            'latestDate' => null,
            'error' => 'Gagal menghubungi origin (git fetch).',
        ]);

        $this->actingAs($this->superAdmin())
            ->getJson('/admin/pengaturan/update-status')
            ->assertOk()
            ->assertJson(['success' => true])
            ->assertJsonPath('update.hasUpdate', false);
    }

    public function test_update_when_git_throws_returns_success_false(): void
    {
        $this->mockGit();
        $this->app->instance(GitUpdateService::class, Mockery::mock(GitUpdateService::class, function ($mock) {
            $mock->shouldReceive('gitAvailable')->andReturn(true);
            $mock->shouldReceive('isGitRepository')->andReturn(true);
            $mock->shouldReceive('update')->andThrow(new \RuntimeException('git symbolic-ref failed'));
        }));

        $this->actingAs($this->superAdmin())
            ->postJson('/admin/pengaturan/update')
            ->assertOk()
            ->assertJson(['success' => false]);
    }

    public function test_update_status_when_git_unavailable(): void
    {
        $this->mockGit();
        $this->app->instance(GitUpdateService::class, Mockery::mock(GitUpdateService::class, function ($mock) {
            $mock->shouldReceive('gitAvailable')->andReturn(false);
        }));

        $this->actingAs($this->superAdmin())
            ->getJson('/admin/pengaturan/update-status')
            ->assertOk()
            ->assertJson(['success' => false]);
    }

    public function test_update_status_when_not_git_repository(): void
    {
        $mock = Mockery::mock(GitUpdateService::class);
        $mock->shouldReceive('gitAvailable')->andReturn(true);
        $mock->shouldReceive('isGitRepository')->andReturn(false);
        $this->app->instance(GitUpdateService::class, $mock);

        $this->actingAs($this->superAdmin())
            ->getJson('/admin/pengaturan/update-status')
            ->assertOk()
            ->assertJson(['success' => false]);
    }
}
