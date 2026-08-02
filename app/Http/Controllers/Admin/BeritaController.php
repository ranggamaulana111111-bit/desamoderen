<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::with('user')->latest()->paginate(20);

        return view('admin.berita.index', compact('berita'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $request)
    {
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
        ]);

        ActivityLog::catat(
            'create_berita',
            "Admin {$request->user()->name} membuat berita '{$berita->judul}' ({$berita->status})",
            'berita',
            $berita->id
        );

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function show(Berita $beritum)
    {
        $beritum->load('user');

        return view('admin.berita.show', compact('beritum'));
    }

    public function edit(Berita $beritum)
    {
        return view('admin.berita.edit', compact('beritum'));
    }

    public function update(Request $request, Berita $beritum)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'foto' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,publish',
        ]);

        $slug = Str::slug($request->judul);
        $original = $slug;
        $counter = 1;
        while (Berita::where('slug', $slug)->where('id', '!=', $beritum->id)->exists()) {
            $slug = $original.'-'.$counter++;
        }

        $data = [
            'judul' => $validated['judul'],
            'slug' => $slug,
            'konten' => $validated['konten'],
            'status' => $validated['status'],
            'user_id' => Auth::id(),
        ];

        if ($request->hasFile('foto')) {
            if ($beritum->foto) {
                Storage::disk('public')->delete($beritum->foto);
            }
            $data['foto'] = $request->file('foto')->store('berita', 'public');
        }

        $beritum->update($data);

        ActivityLog::catat(
            'update_berita',
            "Admin {$request->user()->name} mengupdate berita '{$beritum->judul}'",
            'berita',
            $beritum->id
        );

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $beritum)
    {
        if ($beritum->foto) {
            Storage::disk('public')->delete($beritum->foto);
        }
        $judul = $beritum->judul;
        $beritum->delete();

        ActivityLog::catat(
            'delete_berita',
            'Admin '.(Auth::user()->name ?? '')." menghapus berita '{$judul}'",
            'berita',
            $beritum->id
        );

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}
