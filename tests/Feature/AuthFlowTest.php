<?php

namespace Tests\Feature;

use App\Models\User;
use App\Support\Captcha;
use Database\Seeders\DemoAuthSeeder;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([RolePermissionSeeder::class, DemoAuthSeeder::class]);
    }

    public function test_login_page_renders(): void
    {
        $this->get('/login')->assertStatus(200)->assertSee('Masuk');
    }

    public function test_register_page_renders(): void
    {
        $this->get('/register')->assertStatus(200)->assertSee('Daftar');
    }

    public function test_forgot_password_page_renders(): void
    {
        $this->get('/password/lupa')->assertStatus(200)->assertSee('Atur Ulang');
    }

    public function test_captcha_refresh_returns_new_question(): void
    {
        $first = $this->get('/login')->assertStatus(200);

        $response = $this->post('/captcha/refresh')->assertStatus(200);
        $json = $response->json();

        $this->assertCount(2, $json);
        $this->assertTrue(is_numeric($json[0]) && is_numeric($json[1]));
        $this->assertSame((int) $json[0] + (int) $json[1], (int) session('captcha_a') + (int) session('captcha_b'));
    }

    public function test_login_success_with_demo_account(): void
    {
        $this->get('/login');

        session(['captcha_a' => 3, 'captcha_b' => 4]);

        $this->post('/login', [
            'nik' => '3216010101010001',
            'password' => 'demo1234',
            'captcha' => '7',
        ])->assertRedirect('/warga/dashboard');

        $this->assertAuthenticated();
    }

    public function test_login_rejects_wrong_captcha(): void
    {
        $this->get('/login');

        session(['captcha_a' => 3, 'captcha_b' => 4]);

        $this->post('/login', [
            'nik' => '3216010101010001',
            'password' => 'demo1234',
            'captcha' => '99',
        ])->assertSessionHasErrors('captcha');

        $this->assertGuest();
    }

    public function test_login_rejects_wrong_credentials(): void
    {
        $this->get('/login');

        session(['captcha_a' => 3, 'captcha_b' => 4]);

        $this->post('/login', [
            'nik' => '3216010101010001',
            'password' => 'salah123',
            'captcha' => '7',
        ])->assertSessionHasErrors('nik');

        $this->assertGuest();
    }

    public function test_register_creates_warga_user(): void
    {
        $this->get('/register');

        session(['captcha_a' => 3, 'captcha_b' => 4]);

        $this->post('/register', [
            'nama_lengkap' => 'Warga Baru',
            'nik' => '3216010101010002',
            'rt' => '01',
            'rw' => '02',
            'alamat' => 'Jl. Mawar No. 2',
            'no_hp' => '081234567891',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
            'captcha' => '7',
        ])->assertRedirect('/warga/dashboard');

        $user = User::where('nik', '3216010101010002')->first();

        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('Warga'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_register_rejects_duplicate_nik(): void
    {
        $this->get('/register');

        session(['captcha_a' => 3, 'captcha_b' => 4]);

        $this->post('/register', [
            'nama_lengkap' => 'Warga Demo Lagi',
            'nik' => '3216010101010001',
            'no_hp' => '081234567892',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
            'captcha' => '7',
        ])->assertSessionHasErrors('nik');
    }

    public function test_forgot_password_resets_password(): void
    {
        $this->get('/password/lupa');

        session(['captcha_a' => 3, 'captcha_b' => 4]);

        $this->post('/password/lupa', [
            'nik' => '3216010101010001',
            'no_hp' => '081234567890',
            'password' => 'passwordbaru1',
            'password_confirmation' => 'passwordbaru1',
            'captcha' => '7',
        ])->assertRedirect('/login')->assertSessionHas('status');

        $user = User::findByNik('3216010101010001');

        $this->assertTrue(password_verify('passwordbaru1', $user->password));
    }

    public function test_forgot_password_rejects_wrong_no_hp(): void
    {
        $this->get('/password/lupa');

        session(['captcha_a' => 3, 'captcha_b' => 4]);

        $this->post('/password/lupa', [
            'nik' => '3216010101010001',
            'no_hp' => '081111111111',
            'password' => 'passwordbaru1',
            'password_confirmation' => 'passwordbaru1',
            'captcha' => '7',
        ])->assertSessionHasErrors('no_hp');
    }

    public function test_forgot_password_works_when_user_has_no_no_hp(): void
    {
        User::findByNik('3216010101010001')->update(['no_hp' => null]);

        $this->get('/password/lupa');

        session(['captcha_a' => 3, 'captcha_b' => 4]);

        $this->post('/password/lupa', [
            'nik' => '3216010101010001',
            'no_hp' => '081234567890',
            'password' => 'passwordbaru1',
            'password_confirmation' => 'passwordbaru1',
            'captcha' => '7',
        ])->assertRedirect('/login')->assertSessionHas('status');

        $this->assertTrue(password_verify('passwordbaru1', User::findByNik('3216010101010001')->password));
    }

    public function test_captcha_check_helper(): void
    {
        session(['captcha_a' => 3, 'captcha_b' => 4]);

        $this->assertTrue(Captcha::check(7));
        $this->assertFalse(Captcha::check(8));
    }
}
