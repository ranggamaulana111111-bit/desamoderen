<?php

namespace Tests\Feature;

use App\Models\AntreanPengambilan;
use App\Models\PengajuanSurat;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AntreanPickupTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
    }

    private function makeWarga(): User
    {
        $warga = User::factory()->create(['nik' => '3171000000000001']);
        $warga->assignRole('Warga');

        return $warga;
    }

    private function makeOperator(): User
    {
        $operator = User::factory()->create();
        $operator->assignRole('Operator Pelayanan');

        return $operator;
    }

    private function makeSekdes(): User
    {
        $sekdes = User::factory()->create();
        $sekdes->assignRole('Sekretaris Desa');

        return $sekdes;
    }

    private function makeAntrean(User $warga, array $overrides = []): AntreanPengambilan
    {
        $pengajuan = PengajuanSurat::factory()->create([
            'user_id' => $warga->id,
            'submitted_by' => $warga->id,
            'status' => 'completed',
            'current_step' => 5,
            'nomor_surat' => '470/'.random_int(100, 999).'/PDS/2026',
        ]);

        return AntreanPengambilan::create(array_merge([
            'pengajuan_id' => $pengajuan->id,
            'nomor_antrean' => AntreanPengambilan::generateNomor(now()),
            'tanggal_ambil' => now()->toDateString(),
            'jam_mulai' => '09:00',
            'jam_selesai' => '10:00',
            'kode_qr' => Str::random(32),
        ], $overrides));
    }

    public function test_pickup_page_lists_todays_queues(): void
    {
        $operator = $this->makeOperator();
        $warga = $this->makeWarga();
        $antrean = $this->makeAntrean($warga);

        $this->actingAs($operator)
            ->get(route('admin.queue.pickup'))
            ->assertOk()
            ->assertSee('Pengambilan Surat')
            ->assertSee($warga->name)
            ->assertSee(AntreanPengambilan::STATUS_MENUNGGU);
    }

    public function test_cari_by_kode_qr_returns_antrean(): void
    {
        $operator = $this->makeOperator();
        $warga = $this->makeWarga();
        $antrean = $this->makeAntrean($warga);

        $this->actingAs($operator)
            ->postJson(route('admin.queue.pickup.cari'), ['query' => $antrean->kode_qr])
            ->assertOk()
            ->assertJsonPath('antrean.id', $antrean->id)
            ->assertJsonPath('antrean.nomor_antrean', $antrean->nomor_antrean);
    }

    public function test_cari_by_full_qr_url_extracts_code(): void
    {
        $operator = $this->makeOperator();
        $warga = $this->makeWarga();
        $antrean = $this->makeAntrean($warga);

        $this->actingAs($operator)
            ->postJson(route('admin.queue.pickup.cari'), [
                'query' => 'http://localhost/antrean/'.$antrean->kode_qr,
            ])
            ->assertOk()
            ->assertJsonPath('antrean.kode_qr', $antrean->kode_qr);
    }

    public function test_cari_by_nomor_antrean_returns_antrean(): void
    {
        $operator = $this->makeOperator();
        $warga = $this->makeWarga();
        $antrean = $this->makeAntrean($warga);

        $this->actingAs($operator)
            ->postJson(route('admin.queue.pickup.cari'), ['query' => $antrean->nomor_antrean])
            ->assertOk()
            ->assertJsonPath('antrean.id', $antrean->id);
    }

    public function test_cari_with_unknown_query_fails(): void
    {
        $operator = $this->makeOperator();

        $this->actingAs($operator)
            ->postJson(route('admin.queue.pickup.cari'), ['query' => 'tidak-ada'])
            ->assertStatus(422)
            ->assertJsonValidationErrors('query');
    }

    public function test_proses_marks_antrean_as_diambil(): void
    {
        $operator = $this->makeOperator();
        $warga = $this->makeWarga();
        $antrean = $this->makeAntrean($warga);

        $this->actingAs($operator)
            ->postJson(route('admin.queue.pickup.proses', $antrean))
            ->assertOk()
            ->assertJsonPath('antrean.status', AntreanPengambilan::STATUS_DIAMBIL);

        $this->assertDatabaseHas('antrean_pengambilan', [
            'id' => $antrean->id,
            'status' => AntreanPengambilan::STATUS_DIAMBIL,
        ]);
    }

    public function test_lewat_marks_antrean_as_lewat(): void
    {
        $operator = $this->makeOperator();
        $warga = $this->makeWarga();
        $antrean = $this->makeAntrean($warga);

        $this->actingAs($operator)
            ->postJson(route('admin.queue.pickup.lewat', $antrean))
            ->assertOk()
            ->assertJsonPath('antrean.status', AntreanPengambilan::STATUS_LEWAT);

        $this->assertDatabaseHas('antrean_pengambilan', [
            'id' => $antrean->id,
            'status' => AntreanPengambilan::STATUS_LEWAT,
        ]);
    }

    public function test_proses_twice_returns_error(): void
    {
        $operator = $this->makeOperator();
        $warga = $this->makeWarga();
        $antrean = $this->makeAntrean($warga, ['status' => AntreanPengambilan::STATUS_DIAMBIL]);

        $this->actingAs($operator)
            ->postJson(route('admin.queue.pickup.proses', $antrean))
            ->assertStatus(422);
    }

    public function test_pickup_requires_queue_view_permission(): void
    {
        $warga = $this->makeWarga();

        $this->actingAs($warga)
            ->get(route('admin.queue.pickup'))
            ->assertForbidden();
    }

    public function test_proses_requires_queue_manage_permission(): void
    {
        $sekdes = $this->makeSekdes();
        $warga = $this->makeWarga();
        $antrean = $this->makeAntrean($warga);

        $this->actingAs($sekdes)
            ->postJson(route('admin.queue.pickup.proses', $antrean))
            ->assertForbidden();

        $this->assertDatabaseHas('antrean_pengambilan', [
            'id' => $antrean->id,
            'status' => AntreanPengambilan::STATUS_MENUNGGU,
        ]);
    }
}
