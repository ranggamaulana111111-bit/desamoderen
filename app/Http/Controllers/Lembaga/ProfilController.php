<?php

namespace App\Http\Controllers\Lembaga;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Lembaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function edit()
    {
        $lembaga = $this->lembaga();

        return view('lembaga.profil.edit', compact('lembaga'));
    }

    public function update(Request $request)
    {
        $lembaga = $this->lembaga();

        $validated = $request->validate([
            'ketua' => ['nullable', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:100'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = [
            'ketua' => $validated['ketua'] ?? null,
            'deskripsi' => $validated['deskripsi'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'no_hp' => $validated['no_hp'] ?? null,
            'email' => $validated['email'] ?? null,
        ];

        if ($request->hasFile('foto')) {
            if ($lembaga->foto) {
                Storage::disk('public')->delete($lembaga->foto);
            }
            $data['foto'] = $request->file('foto')->store('lembaga', 'public');
        }

        $lembaga->update($data);

        ActivityLog::catat(
            'update_lembaga_profile',
            "Lembaga {$lembaga->nama} ({$request->user()->name}) memperbarui profil lembaga",
            'lembaga',
            $lembaga->id
        );

        return redirect()->route('lembaga.profil.edit')
            ->with('success', 'Profil lembaga berhasil diperbarui.');
    }

    private function lembaga(): Lembaga
    {
        $lembaga = auth()->user()->lembaga;

        abort_if(! $lembaga, 403, 'Akun ini tidak terhubung dengan lembaga mana pun.');

        return $lembaga;
    }
}
