<?php

namespace Tests\Feature;

use App\Models\Berita;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BeritaEditTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
    }

    public function test_berita_edit_page_renders(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        $berita = Berita::create([
            'judul' => 'Berita Awal',
            'slug' => 'berita-awal',
            'konten' => 'Konten awal',
            'status' => 'draft',
            'user_id' => $admin->id,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.berita.edit', $berita));

        $response->assertOk();
        $response->assertSee('Berita Awal');
    }

    public function test_berita_update_put_works(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        $berita = Berita::create([
            'judul' => 'Berita Awal',
            'slug' => 'berita-awal',
            'konten' => 'Konten awal',
            'status' => 'draft',
            'user_id' => $admin->id,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.berita.update', $berita), [
            'judul' => 'Berita Update',
            'konten' => 'Konten baru',
            'status' => 'publish',
            'kategori' => 'Pembangunan',
        ]);

        $response->assertRedirect(route('admin.berita.index'));
        $this->assertDatabaseHas('berita', [
            'id' => $berita->id,
            'judul' => 'Berita Update',
            'status' => 'publish',
        ]);
    }
}
