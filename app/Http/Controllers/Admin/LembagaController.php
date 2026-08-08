<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Lembaga;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
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

        return DB::transaction(function () use ($validated, $fotoPath, $request) {
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
                'nik' => $validated['nik'],
                'password' => Hash::make($validated['password']),
                'no_hp' => $validated['no_hp'] ?? null,
                'lembaga_id' => $lembaga->id,
            ]);

            $lembagaRole = Role::where('name', 'Lembaga')->first();
            if ($lembagaRole) {
                $user->assignRole($lembagaRole);
            }

            ActivityLog::catat(
                'create_lembaga',
                "Admin {$request->user()->name} menambahkan lembaga '{$lembaga->nama}' beserta akun login {$user->name}",
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

        if ($pengurus) {
            $pengurus->update([
                'name' => $validated['nama_pengurus'] ?? $pengurus->name,
                'nik' => $validated['nik'] ?? $pengurus->nik,
                'no_hp' => $validated['no_hp'] ?? $pengurus->no_hp,
            ]);

            if (! empty($validated['password'])) {
                $pengurus->update(['password' => Hash::make($validated['password'])]);
            }
        }

        ActivityLog::catat(
            'update_lembaga',
            "Admin {$request->user()->name} mengupdate lembaga '{$lembaga->nama}'",
            'lembaga',
            $lembaga->id
        );

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

        if ($accountRequired) {
            $rules['nama_pengurus'] = ['required', 'string', 'max:100'];
            $rules['password'] = ['required', 'string', 'min:6'];
        } else {
            $rules['nama_pengurus'] = ['nullable', 'string', 'max:100'];
            $rules['password'] = ['nullable', 'string', 'min:6'];
        }

        $nikRule = ['string', 'digits:16'];
        if ($accountRequired) {
            $nikRule[] = 'required';
        }
        $nikRule[] = Rule::unique('users', 'nik')->ignore($exceptUserId);
        $rules['nik'] = $nikRule;

        return $request->validate($rules);
    }
}
