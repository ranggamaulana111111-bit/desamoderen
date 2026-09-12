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
use Illuminate\Support\Facades\Password as PasswordBroker;
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
            'email' => ['required', 'string', 'email', 'max:255'],
            'nik' => ['nullable', 'string', 'digits:16', Rule::unique('users', 'nik')],
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
            'email' => [Rule::unique('users', 'email')],
        ]);

        $user = User::create([
            'name' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'nik' => $validated['nik'] ?? null,
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
            'email' => ['required', 'string', 'email'],
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

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->hasRole('Lembaga')) {
                $lembaga = $user->lembaga;

                if (! $lembaga || $lembaga->status !== 'aktif') {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return back()->withErrors(['email' => 'Akun lembaga tidak aktif. Silakan hubungi admin desa.'])->onlyInput('email');
                }

                return redirect()->route('lembaga.dashboard');
            }

            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->intended(route('warga.dashboard'));
        }

        Captcha::question();

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
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
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'no_hp' => ['nullable', 'string', 'max:20'],
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

        $user = User::where('email', $credentials['email'])->first();

        if (! $user) {
            Captcha::question();

            return back()->withInput()->withErrors(['email' => 'Email tidak terdaftar.']);
        }

        if ($user->no_hp) {
            $normalizedHp = preg_replace('/[^0-9]/', '', (string) ($credentials['no_hp'] ?? ''));
            $userHp = preg_replace('/[^0-9]/', '', (string) $user->no_hp);

            if ($normalizedHp === '' || $normalizedHp !== $userHp) {
                Captcha::question();

                return back()->withInput()->withErrors(['no_hp' => 'Nomor HP tidak cocok dengan data terdaftar.']);
            }
        }

        $token = PasswordBroker::broker()->createToken($user);

        return redirect()->route('password.reset', [
            'token' => $token,
            'email' => $user->email,
        ]);
    }

    public function showReset(Request $request)
    {
        $email = $request->query('email');
        $token = $request->query('token');
        $captcha = Captcha::question();
        $captchaEnabled = $this->captchaEnabled();
        $captchaMode = $this->captchaMode();

        return view('auth.reset', compact('email', 'token', 'captcha', 'captchaEnabled', 'captchaMode'));
    }

    public function reset(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email'],
            'token' => ['required', 'string'],
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

        $user = User::where('email', $validated['email'])->first();

        if (! $user) {
            return back()->withErrors(['email' => 'Email tidak terdaftar.']);
        }

        if (! PasswordBroker::broker()->tokenExists($user, $validated['token'])) {
            return back()->withErrors(['token' => 'Tautan reset tidak valid atau sudah kedaluwarsa. Silakan ulangi dari awal.']);
        }

        $user->forceFill(['password' => Hash::make($validated['password'])])->save();

        PasswordBroker::broker()->deleteToken($user);
        Auth::logout();

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
