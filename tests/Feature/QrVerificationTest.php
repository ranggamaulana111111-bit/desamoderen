<?php

namespace Tests\Feature;

use App\Models\PengajuanSurat;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QrVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
    }

    public function test_full_approval_workflow(): void
    {
        $operator = User::factory()->create();
        $operator->assignRole('Operator Pelayanan');

        $sekdes = User::factory()->create();
        $sekdes->assignRole('Sekretaris Desa');

        $kades = User::factory()->create();
        $kades->assignRole('Kepala Desa');

        $warga = User::factory()->create();
        $warga->assignRole('Warga');

        $pengajuan = PengajuanSurat::factory()->create([
            'user_id' => $warga->id,
            'submitted_by' => $warga->id,
            'status' => 'submitted',
            'current_step' => 0,
        ]);

        $this->assertTrue($operator->hasPermissionTo('letter.review'), 'Operator does not have letter.review');
        $this->assertTrue($operator->can('approve', $pengajuan), 'Operator cannot approve pengajuan');

        $this->assertNull($pengajuan->hash_verifikasi);

        $response = $this->actingAs($operator)->post(route('admin.pengajuan.approve', $pengajuan), [
            'catatan' => 'Dokumen lengkap',
        ]);

        $response->assertStatus(302); // Should redirect

        $pengajuan->refresh();
        $this->assertEquals('verified', $pengajuan->status);

        $this->actingAs($operator)->post(route('admin.pengajuan.approve', $pengajuan), [
            'catatan' => null,
        ]);

        $pengajuan->refresh();
        $this->assertEquals('approved_operator', $pengajuan->status);

        $this->actingAs($sekdes)->post(route('admin.pengajuan.approve', $pengajuan), [
            'catatan' => null,
        ]);

        $pengajuan->refresh();
        $this->assertEquals('approved_sekdes', $pengajuan->status);

        $this->actingAs($kades)->post(route('admin.pengajuan.approve', $pengajuan), [
            'catatan' => null,
        ]);

        $pengajuan->refresh();
        $this->assertEquals('approved_kades', $pengajuan->status);

        $this->actingAs($kades)->post(route('admin.pengajuan.approve', $pengajuan), [
            'catatan' => null,
        ]);

        $pengajuan->refresh();
        $this->assertEquals('completed', $pengajuan->status);
        $this->assertNotNull($pengajuan->hash_verifikasi);
        $this->assertEquals(64, strlen($pengajuan->hash_verifikasi));
    }

    public function test_rejection_workflow(): void
    {
        $operator = User::factory()->create();
        $operator->assignRole('Operator Pelayanan');

        $warga = User::factory()->create();
        $warga->assignRole('Warga');

        $pengajuan = PengajuanSurat::factory()->create([
            'user_id' => $warga->id,
            'submitted_by' => $warga->id,
            'status' => 'submitted',
            'current_step' => 0,
        ]);

        $this->actingAs($operator)->post(route('admin.pengajuan.reject', $pengajuan), [
            'catatan' => 'Dokumen tidak lengkap',
        ]);

        $pengajuan->refresh();
        $this->assertEquals('rejected', $pengajuan->status);
    }

    public function test_revision_workflow(): void
    {
        $operator = User::factory()->create();
        $operator->assignRole('Operator Pelayanan');

        $warga = User::factory()->create();
        $warga->assignRole('Warga');

        $pengajuan = PengajuanSurat::factory()->create([
            'user_id' => $warga->id,
            'submitted_by' => $warga->id,
            'status' => 'verified',
            'current_step' => 1,
        ]);

        $this->actingAs($operator)->post(route('admin.pengajuan.revision', $pengajuan), [
            'catatan' => 'Perlu perbaikan data',
        ]);

        $pengajuan->refresh();
        $this->assertEquals('revision', $pengajuan->status);
    }

    public function test_public_verification_shows_data(): void
    {
        $warga = User::factory()->create();
        $warga->assignRole('Warga');

        $hash = hash('sha256', '1_1_test_'.now()->timestamp.'_test');

        PengajuanSurat::factory()->create([
            'user_id' => $warga->id,
            'submitted_by' => $warga->id,
            'jenis_surat' => 'sktm',
            'status' => 'completed',
            'current_step' => 5,
            'nomor_surat' => '460/001/DS-KP/2026',
            'hash_verifikasi' => $hash,
            'kode_klasifikasi' => '460',
        ]);

        $response = $this->get(route('verifikasi.show', $hash));

        $response->assertStatus(200);
        $response->assertSee('460/001/DS-KP/2026');
    }

    public function test_hash_not_found_returns_404(): void
    {
        $response = $this->get(route('verifikasi.show', 'hash_tidak_ada'));

        $response->assertStatus(404);
    }
}
