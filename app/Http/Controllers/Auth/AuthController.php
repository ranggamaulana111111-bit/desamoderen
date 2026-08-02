<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'nik' => ['required', 'string', 'digits:16'],
            'rt' => ['nullable', 'string', 'max:3'],
            'rw' => ['nullable', 'string', 'max:3'],
            'no_hp' => ['nullable', 'string', 'max:15'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $nikHash = User::hashNik($validated['nik']);

        $request->validate([
            'nik' => [Rule::unique('users', 'nik_hash')->where(fn ($q) => $q->where('nik_hash', $nikHash))],
        ]);

        $user = User::create([
            'name' => $validated['nama_lengkap'],
            'nik' => $validated['nik'],
            'rt' => $validated['rt'] ?? null,
            'rw' => $validated['rw'] ?? null,
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
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nik' => ['required', 'string', 'digits:16'],
            'password' => ['required', 'string'],
        ]);

        $user = User::findByNik($credentials['nik']);

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->intended(route('warga.dashboard'));
        }

        return back()->withErrors([
            'nik' => 'NIK atau password salah.',
        ])->onlyInput('nik');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
