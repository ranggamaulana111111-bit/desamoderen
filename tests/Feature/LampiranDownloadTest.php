<?php

namespace Tests\Feature;

use App\Models\PengajuanSurat;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LampiranDownloadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);

        Storage::fake('private');
        Storage::fake('local');
    }

    private function makePengajuan(array $lampiran): array
    {
        $warga = User::factory()->create();
        $warga->assignRole('Warga');

        $admin = User::factory()->create();
        $admin->assignRole('Operator Pelayanan');

        $pengajuan = PengajuanSurat::factory()->create([
            'user_id' => $warga->id,
            'submitted_by' => $warga->id,
            'status' => 'submitted',
            'current_step' => 0,
            'data_tambahan' => ['lampiran' => $lampiran],
        ]);

        return [$pengajuan, $admin];
    }

    public function test_lampiran_path_lama_disajikan_inline(): void
    {
        Storage::disk('local')->put('private/lampiran/sktm_lama.pdf', 'PDF-LEGACY');

        [$pengajuan, $admin] = $this->makePengajuan(['private/lampiran/sktm_lama.pdf']);

        $response = $this->actingAs($admin)->get(route('admin.pengajuan.lampiran', [$pengajuan, 0]));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
        $this->assertStringContainsString('inline', $response->headers->get('content-disposition'));
        $this->assertSame('PDF-LEGACY', $response->streamedContent());
    }

    public function test_lampiran_path_baru_disajikan_inline(): void
    {
        Storage::disk('private')->put('lampiran/sktm_baru.pdf', 'PDF-BARU');

        [$pengajuan, $admin] = $this->makePengajuan(['lampiran/sktm_baru.pdf']);

        $response = $this->actingAs($admin)->get(route('admin.pengajuan.lampiran', [$pengajuan, 0]));

        $response->assertStatus(200);
        $this->assertStringContainsString('inline', $response->headers->get('content-disposition'));
        $this->assertSame('PDF-BARU', $response->streamedContent());
    }

    public function test_gambar_disajikan_dengan_mime_yang_benar(): void
    {
        Storage::disk('private')->put('lampiran/ktp.png', 'PNG-BARU');

        [$pengajuan, $admin] = $this->makePengajuan(['lampiran/ktp.png']);

        $response = $this->actingAs($admin)->get(route('admin.pengajuan.lampiran', [$pengajuan, 0]));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'image/png');
    }

    public function test_query_download_menghasilkan_attachment(): void
    {
        Storage::disk('private')->put('lampiran/sktm_baru.pdf', 'PDF-BARU');

        [$pengajuan, $admin] = $this->makePengajuan(['lampiran/sktm_baru.pdf']);

        $response = $this->actingAs($admin)
            ->get(route('admin.pengajuan.lampiran', [$pengajuan, 0]).'?download=1');

        $response->assertStatus(200);
        $this->assertStringContainsString('attachment', $response->headers->get('content-disposition'));
    }

    public function test_file_hilang_menghasilkan_404(): void
    {
        [$pengajuan, $admin] = $this->makePengajuan(['lampiran/tidak_ada.pdf']);

        $this->actingAs($admin)
            ->get(route('admin.pengajuan.lampiran', [$pengajuan, 0]))
            ->assertStatus(404);
    }

    public function test_index_lampiran_tidak_ada_menghasilkan_404(): void
    {
        [$pengajuan, $admin] = $this->makePengajuan([]);

        $this->actingAs($admin)
            ->get(route('admin.pengajuan.lampiran', [$pengajuan, 3]))
            ->assertStatus(404);
    }
}
