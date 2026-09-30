<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PengaturanUiTest extends TestCase
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

    public function test_halaman_pengaturan_bisa_dirender(): void
    {
        $response = $this->actingAs($this->superAdmin())
            ->get('/admin/pengaturan');

        $response->assertOk();
        $response->assertSee('Pusat Kendali Desa Digital', false);
        $response->assertSee('Modul Konfigurasi', false);
        $response->assertSee('class="setting-card"', false);
        $response->assertSee('class="setnav"', false);
    }

    public function test_setiap_tab_pengaturan_bisa_dirender(): void
    {
        $admin = $this->superAdmin();
        $tabs = array_keys(app(\App\Services\SettingService::class)->getCategories());

        foreach ($tabs as $tab) {
            $response = $this->actingAs($admin)
                ->get('/admin/pengaturan?tab='.$tab);

            $response->assertOk();
        }
    }

    public function test_nav_pencarian_dan_hero_stats_ada(): void
    {
        $response = $this->actingAs($this->superAdmin())
            ->get('/admin/pengaturan');

        $response->assertOk();
        $response->assertSee('menuIndex:', false);
        $response->assertSee('Identitas Desa', false);
        $response->assertSee('Pelayanan &amp; Workflow', false);
        $response->assertSee('Sistem &amp; Infrastruktur', false);
        $response->assertSee('Warga Terdaftar', false);
        $response->assertSee('Pratinjai Surat', false);
    }

    public function test_halaman_pengaturan_menolak_warga(): void
    {
        $warga = User::create([
            'name' => 'Warga',
            'nik' => '0000000000000010',
            'password' => bcrypt('password'),
        ])->assignRole('Warga');

        $this->actingAs($warga)->get('/admin/pengaturan')->assertForbidden();
    }
}
