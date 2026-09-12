<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Lembaga;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class LembagaController extends Controller
{
    public function index()
    {
        $lembagas = Lembaga::withCount(['users', 'berita', 'events'])
            ->latest()
            ->paginate(20);

        return view('admin.lembaga.index', compact('lembagas'));
    }

    public function create()
    {
        return view('admin.lembaga.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateLembaga($request, accountRequired: true);
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('lembaga', 'public');
        }

        $lembaga = DB::transaction(function () use ($validated, $fotoPath, $request) {
            $lembaga = Lembaga::create([
                'nama' => $validated['nama'],
                'singkatan' => $validated['singkatan'] ?? null,
                'jenis' => $validated['jenis'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'ketua' => $validated['ketua'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
                'no_hp' => $validated['no_hp'] ?? null,
                'email' => $validated['email'] ?? null,
                'foto' => $fotoPath,
                'status' => $validated['status'],
            ]);

            $user = User::create([
                'name' => $validated['nama_pengurus'],
                'email' => $validated['email_pengurus'],
                'password' => $validated['password'],
                'no_hp' => $validated['no_hp_pengurus'] ?? null,
                'lembaga_id' => $lembaga->id,
            ]);

            $lembagaRole = Role::where('name', 'Lembaga')->first();
            if ($lembagaRole) {
                $user->assignRole($lembagaRole);
            }

            ActivityLog::catat(
                'create_lembaga',
                "Admin {$request->user()->name} menambahkan lembaga '{$lembaga->nama}' beserta akun login {$user->name} ({$user->email})",
                'lembaga',
                $lembaga->id
            );

            return $lembaga;
        });

        return redirect()->route('admin.lembaga.index')
            ->with('success', 'Lembaga dan akun login berhasil dibuat.');
    }

    public function show(Lembaga $lembaga)
    {
        $lembaga->loadCount(['users', 'berita', 'events']);
        $pengurus = $lembaga->users()->whereHas('roles', fn ($q) => $q->where('name', 'Lembaga'))->first();

        return view('admin.lembaga.show', compact('lembaga', 'pengurus'));
    }

    public function edit(Lembaga $lembaga)
    {
        $pengurus = $lembaga->users()->whereHas('roles', fn ($q) => $q->where('name', 'Lembaga'))->first();

        return view('admin.lembaga.edit', compact('lembaga', 'pengurus'));
    }

    public function update(Request $request, Lembaga $lembaga)
    {
        $pengurus = $lembaga->users()->whereHas('roles', fn ($q) => $q->where('name', 'Lembaga'))->first();
        $validated = $this->validateLembaga($request, accountRequired: false, exceptUserId: $pengurus?->id);

        DB::transaction(function () use ($request, $lembaga, $pengurus, $validated) {
            $data = [
                'nama' => $validated['nama'],
                'singkatan' => $validated['singkatan'] ?? null,
                'jenis' => $validated['jenis'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'ketua' => $validated['ketua'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
                'no_hp' => $validated['no_hp'] ?? null,
                'email' => $validated['email'] ?? null,
                'status' => $validated['status'],
            ];

            if ($request->hasFile('foto')) {
                if ($lembaga->foto) {
                    Storage::disk('public')->delete($lembaga->foto);
                }
                $data['foto'] = $request->file('foto')->store('lembaga', 'public');
            }

            $lembaga->update($data);

            $this->syncPengurusAccount($lembaga, $pengurus, $validated);

            ActivityLog::catat(
                'update_lembaga',
                "Admin {$request->user()->name} mengupdate lembaga '{$lembaga->nama}'",
                'lembaga',
                $lembaga->id
            );
        });

        return redirect()->route('admin.lembaga.index')
            ->with('success', 'Data lembaga berhasil diperbarui.');
    }

    public function destroy(Lembaga $lembaga)
    {
        if ($lembaga->foto) {
            Storage::disk('public')->delete($lembaga->foto);
        }

        $nama = $lembaga->nama;
        $lembaga->delete();

        ActivityLog::catat(
            'delete_lembaga',
            'Admin '.(Auth::user()->name ?? '')." menghapus lembaga '{$nama}'",
            'lembaga',
            $lembaga->id
        );

        return redirect()->route('admin.lembaga.index')
            ->with('success', 'Lembaga berhasil dihapus.');
    }

    protected function validateLembaga(Request $request, bool $accountRequired, ?int $exceptUserId = null): array
    {
        $rules = [
            'nama' => ['required', 'string', 'max:100'],
            'singkatan' => ['nullable', 'string', 'max:50'],
            'jenis' => ['required', Rule::in(array_keys(Lembaga::jenisOptions()))],
            'deskripsi' => ['nullable', 'string'],
            'ketua' => ['nullable', 'string', 'max:100'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:100'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ];

        $passwordRule = $this->passwordRule();

        $rules['nama_pengurus'] = [$accountRequired ? 'required' : 'nullable', 'string', 'max:100'];
        $rules['email_pengurus'] = [$accountRequired ? 'required' : 'nullable', 'email', 'max:100', Rule::unique('users', 'email')->ignore($exceptUserId)];
        $rules['no_hp_pengurus'] = ['nullable', 'string', 'max:20'];
        $rules['password'] = [$accountRequired ? 'required' : 'nullable', 'string', $passwordRule];

        $messages = $this->validationMessages();

        $validated = $request->validate($rules, $messages);

        if (! $accountRequired) {
            $accountFilled = $request->filled('nama_pengurus')
                || $request->filled('email_pengurus')
                || $request->filled('password');

            if ($accountFilled) {
                $validated = array_merge($validated, $request->validate([
                    'nama_pengurus' => ['required', 'string', 'max:100'],
                    'email_pengurus' => ['required', 'email', 'max:100', Rule::unique('users', 'email')->ignore($exceptUserId)],
                    'password' => ['required', 'string', $passwordRule],
                ], $messages));
            }
        }

        return $validated;
    }

    private function validationMessages(): array
    {
        return [
            'nama.required' => 'Nama lembaga wajib diisi.',
            'nama.max' => 'Nama lembaga maksimal 100 karakter.',
            'jenis.required' => 'Jenis lembaga wajib diisi.',
            'singkatan.max' => 'Singkatan maksimal 50 karakter.',
            'ketua.max' => 'Nama ketua maksimal 100 karakter.',
            'alamat.max' => 'Alamat maksimal 255 karakter.',
            'no_hp.max' => 'No. HP maksimal 20 karakter.',
            'email.email' => 'Email lembaga tidak valid.',
            'email.max' => 'Email lembaga maksimal 100 karakter.',
            'foto.image' => 'File logo/foto harus berupa gambar.',
            'foto.max' => 'Ukuran file logo/foto maksimal 2MB.',
            'nama_pengurus.required' => 'Nama pengurus wajib diisi saat menambah akun login.',
            'nama_pengurus.max' => 'Nama pengurus maksimal 100 karakter.',
            'email_pengurus.required' => 'Email pengurus wajib diisi (dipakai untuk login).',
            'email_pengurus.email' => 'Email pengurus tidak valid.',
            'email_pengurus.unique' => 'Email pengurus sudah digunakan oleh akun lain.',
            'email_pengurus.max' => 'Email pengurus maksimal 100 karakter.',
            'no_hp_pengurus.max' => 'No. HP pengurus maksimal 20 karakter.',
            'password.required' => 'Password akun pengurus wajib diisi.',
            'password.min' => 'Password minimal :min karakter.',
            'password.letters' => 'Password harus mengandung huruf.',
            'password.numbers' => 'Password harus mengandung angka.',
        ];
    }

    private function passwordRule(): Password
    {
        $min = (int) config('village.security_password_min_length', 8);
        $base = Password::min($min);

        if ((string) config('village.security_password_policy', '1') === '1') {
            $base = $base->letters()->numbers();
        }

        return $base;
    }

    private function syncPengurusAccount(Lembaga $lembaga, ?User $pengurus, array $validated): void
    {
        $accountFilled = ! empty($validated['nama_pengurus'])
            || ! empty($validated['email_pengurus'])
            || ! empty($validated['password']);

        if ($pengurus) {
            $pengurus->update([
                'name' => $validated['nama_pengurus'] ?? $pengurus->name,
                'email' => $validated['email_pengurus'] ?? $pengurus->email,
                'no_hp' => $validated['no_hp_pengurus'] ?? $pengurus->no_hp,
            ]);

            if (! empty($validated['password'])) {
                $pengurus->password = $validated['password'];
                $pengurus->save();
            }

            return;
        }

        if (! $accountFilled) {
            return;
        }

        $user = User::create([
            'name' => $validated['nama_pengurus'],
            'email' => $validated['email_pengurus'],
            'password' => $validated['password'],
            'no_hp' => $validated['no_hp_pengurus'] ?? null,
            'lembaga_id' => $lembaga->id,
        ]);

        $lembagaRole = Role::where('name', 'Lembaga')->first();
        if ($lembagaRole) {
            $user->assignRole($lembagaRole);
        }

        ActivityLog::catat(
            'create_lembaga_pengurus',
            'Admin '.(Auth::user()->name ?? '')." menambahkan akun pengurus {$user->name} ({$user->email}) untuk lembaga '{$lembaga->nama}'",
            'lembaga',
            $lembaga->id
        );
    }
}
