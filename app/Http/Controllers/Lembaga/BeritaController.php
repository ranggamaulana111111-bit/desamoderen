<?php

namespace App\Http\Controllers\Lembaga;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Berita;
use App\Models\Lembaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $lembaga = $this->lembaga();

        $berita = Berita::where('lembaga_id', $lembaga->id)
            ->with('user')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->query('status')))
            ->latest()
            ->paginate(20);

        return view('lembaga.berita.index', compact('berita', 'lembaga'));
    }

    public function create()
    {
        $lembaga = $this->lembaga();

        return view('lembaga.berita.create', compact('lembaga'));
    }

    public function store(Request $request)
    {
        $lembaga = $this->lembaga();

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'foto' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,publish',
        ]);

        $slug = Str::slug($request->judul);
        $original = $slug;
        $counter = 1;
        while (Berita::where('slug', $slug)->exists()) {
            $slug = $original.'-'.$counter++;
        }

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('berita', 'public');
        }

        $berita = Berita::create([
            'judul' => $validated['judul'],
            'slug' => $slug,
            'konten' => $validated['konten'],
            'foto' => $fotoPath,
            'status' => $validated['status'],
            'user_id' => Auth::id(),
            'lembaga_id' => $lembaga->id,
        ]);

        ActivityLog::catat(
            'create_berita',
            "Lembaga {$lembaga->nama} ({$request->user()->name}) mengunggah berita '{$berita->judul}'",
            'berita',
            $berita->id
        );

        return redirect()->route('lembaga.berita.index')
            ->with('success', $berita->status === 'publish'
                ? 'Berita berhasil diunggah dan langsung tampil di website desa.'
                : 'Berita disimpan sebagai draf. Publikasikan kapan saja dari menu Berita Saya.');
    }

    public function show(Berita $berita)
    {
        $lembaga = $this->lembaga();
        abort_if($berita->lembaga_id !== $lembaga->id, 403, 'Berita ini bukan milik lembaga Anda.');

        $berita->load('user');

        return view('lembaga.berita.show', compact('berita', 'lembaga'));
    }

    public function edit(Berita $berita)
    {
        $lembaga = $this->lembaga();
        abort_if($berita->lembaga_id !== $lembaga->id, 403, 'Berita ini bukan milik lembaga Anda.');

        return view('lembaga.berita.edit', compact('berita', 'lembaga'));
    }

    public function update(Request $request, Berita $berita)
    {
        $lembaga = $this->lembaga();
        abort_if($berita->lembaga_id !== $lembaga->id, 403, 'Berita ini bukan milik lembaga Anda.');

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'foto' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,publish',
        ]);

        $slug = Str::slug($request->judul);
        $original = $slug;
        $counter = 1;
        while (Berita::where('slug', $slug)->where('id', '!=', $berita->id)->exists()) {
            $slug = $original.'-'.$counter++;
        }

        $data = [
            'judul' => $validated['judul'],
            'slug' => $slug,
            'konten' => $validated['konten'],
            'status' => $validated['status'],
        ];

        if ($request->hasFile('foto')) {
            if ($berita->foto) {
                Storage::disk('public')->delete($berita->foto);
            }
            $data['foto'] = $request->file('foto')->store('berita', 'public');
        }

        $berita->update($data);

        ActivityLog::catat(
            'update_berita',
            "Lembaga {$lembaga->nama} ({$request->user()->name}) mengupdate berita '{$berita->judul}'",
            'berita',
            $berita->id
        );

        return redirect()->route('lembaga.berita.index')
            ->with('success', $berita->status === 'publish'
                ? 'Berita berhasil diperbarui dan tampil di website desa.'
                : 'Berita disimpan sebagai draf.');
    }

    public function destroy(Berita $berita)
    {
        $lembaga = $this->lembaga();
        abort_if($berita->lembaga_id !== $lembaga->id, 403, 'Berita ini bukan milik lembaga Anda.');

        if ($berita->foto) {
            Storage::disk('public')->delete($berita->foto);
        }
        $judul = $berita->judul;
        $berita->delete();

        ActivityLog::catat(
            'delete_berita',
            'Lembaga '.$lembaga->nama." menghapus berita '{$judul}'",
            'berita',
            $berita->id
        );

        return redirect()->route('lembaga.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    private function lembaga(): Lembaga
    {
        $lembaga = auth()->user()->lembaga;

        abort_if(! $lembaga, 403, 'Akun ini tidak terhubung dengan lembaga mana pun.');

        return $lembaga;
    }
}
