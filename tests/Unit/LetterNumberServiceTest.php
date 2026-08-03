<?php

namespace Tests\Unit;

use App\Models\PengajuanSurat;
use App\Models\User;
use App\Services\LetterNumberService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LetterNumberServiceTest extends TestCase
{
    use RefreshDatabase;

    private function makeSurat(string $jenis = 'sktm', array $overrides = []): PengajuanSurat
    {
        $warga = User::factory()->create();

        return PengajuanSurat::factory()->create(array_merge([
            'user_id' => $warga->id,
            'submitted_by' => $warga->id,
            'jenis_surat' => $jenis,
            'nomor_surat' => null,
            'status' => 'completed',
            'current_step' => 5,
            'kode_klasifikasi' => '470',
        ], $overrides));
    }

    public function test_formats_sequence_with_prefix_suffix_and_padding(): void
    {
        config([
            'village.format_nomor_surat' => '{prefix} / {no} / {suffix} / {tahun}',
            'village.nomor_prefix' => '470',
            'village.nomor_suffix' => 'DS-KP',
            'village.nomor_padding' => 4,
            'village.nomor_reset' => 'tahunan',
        ]);

        $surat = $this->makeSurat();

        $nomor = (new LetterNumberService)->format($surat);

        $this->assertSame('470 / 0001 / DS-KP / '.now()->year, $nomor);
    }

    public function test_generate_for_persists_and_is_idempotent(): void
    {
        config([
            'village.format_nomor_surat' => '{no}',
            'village.nomor_padding' => 3,
            'village.nomor_reset' => 'tahunan',
        ]);

        $service = new LetterNumberService;
        $surat = $this->makeSurat();

        $this->assertNull($surat->nomor_surat);

        $service->generateFor($surat);

        $this->assertSame('001', $surat->fresh()->nomor_surat);
        $this->assertSame('001', $service->generateFor($surat));
    }

    public function test_sequence_increments_per_jenis_surat(): void
    {
        config([
            'village.format_nomor_surat' => '{no}',
            'village.nomor_padding' => 3,
            'village.nomor_reset' => 'tahunan',
        ]);

        $service = new LetterNumberService;

        $sktm1 = $this->makeSurat('sktm');
        $sktm2 = $this->makeSurat('sktm');
        $domisili = $this->makeSurat('domisili');

        $sktm1->update(['nomor_surat' => $service->generateFor($sktm1)]);
        $sktm2->update(['nomor_surat' => $service->generateFor($sktm2)]);

        $this->assertSame('001', $sktm1->fresh()->nomor_surat);
        $this->assertSame('002', $sktm2->fresh()->nomor_surat);

        // jenis surat berbeda memulai ulang urutannya
        $this->assertSame('001', $service->format($domisili));
    }

    public function test_sequence_resets_per_bulan(): void
    {
        config([
            'village.format_nomor_surat' => '{no}',
            'village.nomor_padding' => 3,
            'village.nomor_reset' => 'bulanan',
        ]);

        $service = new LetterNumberService;

        $jan1 = $this->makeSurat('sktm');
        $jan2 = $this->makeSurat('sktm');

        $jan1->forceFill(['nomor_surat' => '001', 'updated_at' => '2026-01-10 09:00:00'])->save();
        $jan2->forceFill(['nomor_surat' => '002', 'updated_at' => '2026-01-12 09:00:00'])->save();

        $baru = $this->makeSurat('sktm');

        $this->assertSame('001', $service->format($baru, Carbon::parse('2026-02-05')));
        $this->assertSame('003', $service->format($baru, Carbon::parse('2026-01-20')));
    }

    public function test_supports_static_placeholders(): void
    {
        config([
            'village.format_nomor_surat' => '{kode_surat} / {id} / {tahun}-{bulan}-{hari}',
        ]);

        $surat = $this->makeSurat('sktm');
        $date = Carbon::parse('2026-03-04');

        $nomor = (new LetterNumberService)->format($surat, $date);

        $this->assertSame("460 / {$surat->id} / 2026-03-04", $nomor);
    }
}
