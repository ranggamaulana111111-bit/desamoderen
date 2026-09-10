<?php

namespace Tests\Feature\Admin;

use App\Models\AntreanPengambilan;
use App\Models\LaporanDesa;
use App\Models\PengajuanSurat;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class LaporanControllerAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
    }

    private function makeRw(): User
    {
        $user = User::factory()->create();
        $user->assignRole('RW');

        return $user;
    }

    private function makeKades(): User
    {
        $user = User::factory()->create();
        $user->assignRole('Kepala Desa');

        return $user;
    }

    private function makeLaporan(User $user, array $overrides = []): LaporanDesa
    {
        return LaporanDesa::create(array_merge([
            'judul' => 'Laporan Kuantitatif Bulanan',
            'periode_mulai' => '2026-01-01',
            'periode_akhir' => '2026-01-31',
            'tipe_periode' => 'bulanan',
            'modul_yang_dipilih' => ['kependudukan'],
            'konten_naratif' => [['judul' => 'Pendahuluan', 'teks' => 'Narasi contoh.']],
            'status' => 'draft',
            'format_pdf' => 'surat_resmi',
            'created_by' => $user->id,
        ], $overrides));
    }

    public function test_pemilik_dapat_melihat_mengedit_dan_menghapus_laporannya_sendiri(): void
    {
        $rw = $this->makeRw();
        $laporan = $this->makeLaporan($rw);

        $this->actingAs($rw)
            ->get(route('admin.laporan.show', $laporan))
            ->assertOk();

        $this->actingAs($rw)
            ->get(route('admin.laporan.edit', $laporan))
            ->assertOk();

        $this->actingAs($rw)
            ->delete(route('admin.laporan.destroy', $laporan))
            ->assertRedirect(route('admin.laporan.index'));

        $this->assertSoftDeleted('laporan_desas', ['id' => $laporan->id]);
    }

    public function test_rt_dengan_permission_sama_tidak_bisa_melihat_laporan_orang_lain(): void
    {
        $pemilik = $this->makeRw();
        $lain = $this->makeRw();
        $laporan = $this->makeLaporan($pemilik);

        $this->actingAs($lain)
            ->get(route('admin.laporan.show', $laporan))
            ->assertForbidden();
    }

    public function test_rt_tidak_bisa_mengedit_atau_menghapus_laporan_orang_lain(): void
    {
        $pemilik = $this->makeRw();
        $lain = $this->makeRw();
        $laporan = $this->makeLaporan($pemilik);

        $this->actingAs($lain)
            ->get(route('admin.laporan.edit', $laporan))
            ->assertForbidden();

        $this->actingAs($lain)
            ->delete(route('admin.laporan.destroy', $laporan))
            ->assertForbidden();

        $this->assertDatabaseHas('laporan_desas', ['id' => $laporan->id]);
    }

    public function test_kades_dapat_melihat_tapi_tidak_mengedit_laporan_orang_lain(): void
    {
        $kades = $this->makeKades();
        $pemilik = $this->makeRw();
        $laporan = $this->makeLaporan($pemilik);

        $this->actingAs($kades)
            ->get(route('admin.laporan.show', $laporan))
            ->assertOk();

        $this->actingAs($kades)
            ->get(route('admin.laporan.edit', $laporan))
            ->assertForbidden();

        $this->actingAs($kades)
            ->delete(route('admin.laporan.destroy', $laporan))
            ->assertForbidden();

        $this->assertDatabaseHas('laporan_desas', ['id' => $laporan->id]);
    }

    public function test_halaman_antrean_publik_menyamarkan_nik_pemohon(): void
    {
        $warga = User::factory()->create(['nik' => '3171000000000001']);
        $pengajuan = PengajuanSurat::factory()->create([
            'user_id' => $warga->id,
            'submitted_by' => $warga->id,
            'status' => 'completed',
            'current_step' => 5,
            'nomor_surat' => '470/'.random_int(100, 999).'/PDS/2026',
        ]);
        $antrean = AntreanPengambilan::create([
            'pengajuan_id' => $pengajuan->id,
            'nomor_antrean' => (string) random_int(1, 999),
            'tanggal_ambil' => now()->toDateString(),
            'jam_mulai' => '09:00',
            'jam_selesai' => '10:00',
            'kode_qr' => Str::random(32),
        ]);

        $response = $this->get(route('antrean.show', $antrean->kode_qr));

        $response->assertOk();
        $response->assertDontSee($warga->nik);
        $response->assertSee('************0001');
    }
}
