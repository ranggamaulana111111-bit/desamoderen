<?php

namespace Tests\Feature;

use App\Models\PengajuanSurat;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class AnalyticsDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        Cache::flush();
    }

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->assignRole('Operator Pelayanan');

        return $user;
    }

    private function warga(): User
    {
        $user = User::factory()->create();
        $user->assignRole('Warga');

        return $user;
    }

    public function test_index_page_merender_dengan_data(): void
    {
        $this->actingAs($this->admin())
            ->get(route('admin.analytics.index'))
            ->assertOk()
            ->assertSee('Analitik');
    }

    public function test_chart_data_mengembalikan_semua_metrik(): void
    {
        $this->actingAs($this->admin())
            ->getJson(route('admin.analytics.chart'))
            ->assertOk()
            ->assertJsonStructure([
                'overview',
                'popularTypes',
                'statusDistribution',
                'monthlyTrends',
                'avgProcessingTime',
                'userGrowth',
                'operatorPerformance',
            ]);
    }

    public function test_default_filter_menerapkan_jendela_waktu(): void
    {
        $warga = $this->warga();

        PengajuanSurat::factory()->create([
            'user_id' => $warga->id,
            'created_at' => now()->subDays(100),
        ]);
        PengajuanSurat::factory()->create([
            'user_id' => $warga->id,
            'created_at' => now()->subDays(5),
        ]);

        $json = $this->actingAs($this->admin())
            ->getJson(route('admin.analytics.chart'))
            ->json();

        $this->assertEquals(1, $json['overview']['total']);
    }

    public function test_cache_ttl_nol_melewati_cache(): void
    {
        config(['village.analytics_cache_ttl' => '0']);

        $this->actingAs($this->admin())
            ->getJson(route('admin.analytics.chart'))
            ->assertOk()
            ->assertJsonStructure(['overview', 'operatorPerformance']);
    }

    public function test_widget_aktif_mengontrol_konten_halaman(): void
    {
        config(['village.analytics_widget_aktif' => 'overview']);

        $this->actingAs($this->admin())
            ->get(route('admin.analytics.index'))
            ->assertOk()
            ->assertSee('id="ov-total"', false)
            ->assertDontSee('id="monthlyChart"', false)
            ->assertDontSee('id="statusChart"', false);
    }

    public function test_export_csv_mengunduh_laporan(): void
    {
        $this->actingAs($this->admin())
            ->get(route('admin.analytics.export'))
            ->assertOk()
            ->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }
}
