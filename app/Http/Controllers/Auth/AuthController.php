<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\Captcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function showRegister()
    {
        $captcha = Captcha::question();
        $mode = 'register';

        return view('auth.index', compact('mode', 'captcha'));
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
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'captcha' => ['required', 'string'],
        ], [], [
            'captcha' => 'jawaban keamanan',
        ]);

        if (! Captcha::check($validated['captcha'])) {
            Captcha::question();

            return back()->withInput()->withErrors(['captcha' => 'Jawaban keamanan salah. Silakan coba lagi.']);
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

        return view('auth.index', compact('mode', 'captcha'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nik' => ['required', 'string', 'digits:16'],
            'password' => ['required', 'string'],
            'captcha' => ['required', 'string'],
        ], [], [
            'captcha' => 'jawaban keamanan',
        ]);

        if (! Captcha::check($credentials['captcha'])) {
            Captcha::question();

            return back()->withInput()->withErrors(['captcha' => 'Jawaban keamanan salah. Silakan coba lagi.']);
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

        return view('auth.forgot', compact('captcha'));
    }

    public function forgot(Request $request)
    {
        $validated = $request->validate([
            'nik' => ['required', 'string', 'digits:16'],
            'no_hp' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'captcha' => ['required', 'string'],
        ], [], [
            'no_hp' => 'nomor HP',
            'captcha' => 'jawaban keamanan',
        ]);

        if (! Captcha::check($validated['captcha'])) {
            Captcha::question();

            return back()->withInput()->withErrors(['captcha' => 'Jawaban keamanan salah. Silakan coba lagi.']);
        }

        $user = User::findByNik($validated['nik']);

        if (! $user) {
            Captcha::question();

            return back()->withInput()->withErrors(['nik' => 'NIK tidak terdaftar.']);
        }

        $normalizedHp = preg_replace('/[^0-9]/', '', $validated['no_hp']);
        $userHp = preg_replace('/[^0-9]/', '', (string) $user->no_hp);

        if ($normalizedHp !== $userHp) {
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
