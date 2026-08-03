<?php

namespace Tests\Feature;

use App\Models\PengajuanSurat;
use App\Models\User;
use App\Services\TelegramNotifier;
use Database\Seeders\LetterConfigSeeder;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TelegramNotifikasiTest extends TestCase
{
    use RefreshDatabase;

    private User $warga;

    private const TOKEN = '123456:TEST-TOKEN';

    private const CHAT_ID = '-1001234567890';

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        $this->seed(LetterConfigSeeder::class);

        $this->warga = User::factory()->create();
        $this->warga->assignRole('Warga');
    }

    private function configureTelegram(): void
    {
        config([
            'village.notif_telegram_token' => self::TOKEN,
            'village.notif_telegram_chat_id' => self::CHAT_ID,
        ]);
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'jenis_surat' => 'sktm',
            'lampiran' => UploadedFile::fake()->create('lampiran.pdf', 100, 'application/pdf'),
            'nama_lengkap' => 'Budi Santoso',
            'nik' => '3201010101010001',
            'tempat_lahir' => 'Bandung',
            'tgl_lahir' => '1990-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'pekerjaan' => 'Buruh',
            'alamat_lengkap' => 'Jl. Mawar No. 1',
            'penghasilan' => 1000000,
            'alasan_sktm' => 'Keperluan pembuatan KIS',
        ], $overrides);
    }

    public function test_store_pengajuan_mengirim_telegram_ketika_terkonfigurasi(): void
    {
        $this->configureTelegram();
        Http::fake();

        $response = $this->actingAs($this->warga)
            ->post(route('warga.surat.store'), $this->payload());

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.telegram.org/bot'.self::TOKEN.'/sendMessage'
                && $request['chat_id'] === self::CHAT_ID
                && str_contains($request['text'], 'Pengajuan Surat Baru')
                && str_contains($request['text'], $this->warga->name);
        });
    }

    public function test_store_tidak_mengirim_telegram_ketika_belum_terkonfigurasi(): void
    {
        Http::fake();

        $this->actingAs($this->warga)
            ->post(route('warga.surat.store'), $this->payload())
            ->assertRedirect();

        Http::assertNothingSent();
    }

    public function test_resubmit_setelah_revisi_mengirim_telegram(): void
    {
        $this->configureTelegram();
        Http::fake();

        $pengajuan = PengajuanSurat::factory()->create([
            'user_id' => $this->warga->id,
            'submitted_by' => $this->warga->id,
            'status' => 'revision',
            'current_step' => 0,
        ]);

        $this->actingAs($this->warga)
            ->patch(route('warga.surat.updateAfterRevision', $pengajuan), $this->payload())
            ->assertRedirect();

        Http::assertSent(function ($request) {
            return str_ends_with($request->url(), '/sendMessage')
                && str_contains($request['text'], 'Pengajuan Surat Baru');
        });
    }

    public function test_is_configured_mengikuti_setting(): void
    {
        $notifier = app(TelegramNotifier::class);

        $this->assertFalse($notifier->isConfigured());

        $this->configureTelegram();

        $this->assertTrue($notifier->isConfigured());
    }

    public function test_send_mengembalikan_false_ketika_response_gagal(): void
    {
        $this->configureTelegram();
        Http::fake([
            'api.telegram.org/*' => Http::response(['ok' => false, 'description' => 'bad request'], 400),
        ]);

        $this->assertFalse(app(TelegramNotifier::class)->send('test'));
    }

    public function test_send_mengembalikan_false_ketika_belum_terkonfigurasi(): void
    {
        Http::fake();

        $this->assertFalse(app(TelegramNotifier::class)->send('test'));
        Http::assertNothingSent();
    }
}
