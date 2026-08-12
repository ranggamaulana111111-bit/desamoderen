<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\Captcha;
use App\Support\Recaptcha;
use App\Support\Turnstile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    private function captchaEnabled(): bool
    {
        return (string) config('village.security_captcha_aktif', '1') === '1';
    }

    private function captchaMode(): string
    {
        if (! $this->captchaEnabled()) {
            return 'none';
        }

        if (app(Turnstile::class)->configured()) {
            return 'turnstile';
        }

        if (app(Recaptcha::class)->configured()) {
            return 'recaptcha';
        }

        return 'math';
    }

    private function captchaFieldRules(): array
    {
        if ($this->captchaMode() === 'turnstile') {
            return ['cf-turnstile-response' => ['required', 'string']];
        }

        if ($this->captchaMode() === 'recaptcha') {
            return ['g-recaptcha-response' => ['required', 'string']];
        }

        return ['captcha' => $this->captchaEnabled() ? ['required', 'string'] : ['nullable', 'string']];
    }

    private function passwordRules(): array
    {
        $min = (int) config('village.security_password_min_length', 8);
        $base = Password::min($min);

        if ((string) config('village.security_password_policy', '1') === '1') {
            $base = $base->letters()->numbers();
        }

        return ['required', 'string', $base, 'confirmed'];
    }

    private function checkCaptcha(Request $request): bool
    {
        if ($this->captchaMode() === 'none') {
            return true;
        }

        if ($this->captchaMode() === 'turnstile') {
            return app(Turnstile::class)->verify($request->input('cf-turnstile-response'));
        }

        if ($this->captchaMode() === 'recaptcha') {
            return app(Recaptcha::class)->verify($request->input('g-recaptcha-response'));
        }

        return Captcha::check($request->input('captcha'));
    }

    private function captchaErrorField(): string
    {
        if ($this->captchaMode() === 'turnstile') {
            return 'cf-turnstile-response';
        }

        return $this->captchaMode() === 'recaptcha' ? 'g-recaptcha-response' : 'captcha';
    }

    public function showRegister()
    {
        $captcha = Captcha::question();
        $mode = 'register';
        $captchaEnabled = $this->captchaEnabled();
        $captchaMode = $this->captchaMode();

        return view('auth.index', compact('mode', 'captcha', 'captchaEnabled', 'captchaMode'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'nik' => ['required', 'string', 'digits:16'],
            'rt' => ['nullable', 'string', 'max:3'],
            'rw' => ['nullable', 'string', 'max:3'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:15'],
            'password' => $this->passwordRules(),
            ...$this->captchaFieldRules(),
        ], [], [
            'captcha' => 'jawaban keamanan',
            'g-recaptcha-response' => 'verifikasi keamanan',
            'cf-turnstile-response' => 'verifikasi keamanan',
        ]);

        if (! $this->checkCaptcha($request)) {
            Captcha::question();

            return back()->withInput()->withErrors([$this->captchaErrorField() => 'Verifikasi keamanan gagal. Silakan coba lagi.']);
        }

        $request->validate([
            'nik' => [Rule::unique('users', 'nik')],
        ]);

        $user = User::create([
            'name' => $validated['nama_lengkap'],
            'nik' => $validated['nik'],
            'rt' => $validated['rt'] ?? null,
            'rw' => $validated['rw'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'no_hp' => $validated['no_hp'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        $wargaRole = Role::where('name', 'Warga')->first();
        if ($wargaRole) {
            $user->assignRole($wargaRole);
        }

        Auth::login($user);

        return redirect()->intended(route('warga.dashboard'));
    }

    public function showLogin()
    {
        $captcha = Captcha::question();
        $mode = 'login';
        $captchaEnabled = $this->captchaEnabled();
        $captchaMode = $this->captchaMode();

        return view('auth.index', compact('mode', 'captcha', 'captchaEnabled', 'captchaMode'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nik' => ['required', 'string', 'digits:16'],
            'password' => ['required', 'string'],
            ...$this->captchaFieldRules(),
        ], [], [
            'captcha' => 'jawaban keamanan',
            'g-recaptcha-response' => 'verifikasi keamanan',
            'cf-turnstile-response' => 'verifikasi keamanan',
        ]);

        if (! $this->checkCaptcha($request)) {
            Captcha::question();

            return back()->withInput()->withErrors([$this->captchaErrorField() => 'Verifikasi keamanan gagal. Silakan coba lagi.']);
        }

        $user = User::findByNik($credentials['nik']);

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            if ($user->hasRole('Lembaga')) {
                return redirect()->route('lembaga.dashboard');
            }

            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->intended(route('warga.dashboard'));
        }

        Captcha::question();

        return back()->withErrors([
            'nik' => 'NIK atau password salah.',
        ])->onlyInput('nik');
    }

    public function showForgot()
    {
        $captcha = Captcha::question();
        $captchaEnabled = $this->captchaEnabled();
        $captchaMode = $this->captchaMode();

        return view('auth.forgot', compact('captcha', 'captchaEnabled', 'captchaMode'));
    }

    public function forgot(Request $request)
    {
        $validated = $request->validate([
            'nik' => ['required', 'string', 'digits:16'],
            'no_hp' => ['required', 'string'],
            'password' => $this->passwordRules(),
            ...$this->captchaFieldRules(),
        ], [], [
            'no_hp' => 'nomor HP',
            'captcha' => 'jawaban keamanan',
            'g-recaptcha-response' => 'verifikasi keamanan',
            'cf-turnstile-response' => 'verifikasi keamanan',
        ]);

        if (! $this->checkCaptcha($request)) {
            Captcha::question();

            return back()->withInput()->withErrors([$this->captchaErrorField() => 'Verifikasi keamanan gagal. Silakan coba lagi.']);
        }

        $user = User::findByNik($validated['nik']);

        if (! $user) {
            Captcha::question();

            return back()->withInput()->withErrors(['nik' => 'NIK tidak terdaftar.']);
        }

        $normalizedHp = preg_replace('/[^0-9]/', '', $validated['no_hp']);
        $userHp = preg_replace('/[^0-9]/', '', (string) $user->no_hp);

        if ($userHp !== '' && $normalizedHp !== $userHp) {
            Captcha::question();

            return back()->withInput()->withErrors(['no_hp' => 'Nomor HP tidak cocok dengan data terdaftar.']);
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('login')->with('status', 'Password berhasil direset. Silakan masuk dengan password baru.');
    }

    public function refreshCaptcha()
    {
        return response()->json(Captcha::question());
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
