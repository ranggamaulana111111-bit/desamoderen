<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Disposisi;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisposisiController extends Controller
{
    public function index(Request $request)
    {
        $query = Disposisi::with(['suratMasuk', 'tujuanUser', 'creator']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('suratMasuk', function ($q) use ($search) {
                $q->where('pengirim', 'like', "%{$search}%")
                    ->orWhere('perihal', 'like', "%{$search}%");
            });
        }

        $disposisi = $query->latest()->paginate(15)->withQueryString();

        $total = Disposisi::count();
        $hariIni = Disposisi::whereDate('created_at', today())->count();
        $deadlineLewat = Disposisi::where('deadline', '<', now())->where('status', '!=', 'Selesai')->count();
        $selesai = Disposisi::where('status', 'Selesai')->count();

        return view('admin.disposisi.index', compact('disposisi', 'total', 'hariIni', 'deadlineLewat', 'selesai'));
    }

    public function create()
    {
        $suratMasuks = SuratMasuk::latest()->get();
        $tujuanUsers = User::whereDoesntHave('roles', fn ($q) => $q->where('name', 'Warga'))->orderBy('name')->get();

        return view('admin.disposisi.create', compact('suratMasuks', 'tujuanUsers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'surat_masuk_id' => 'required|exists:surat_masuks,id',
            'tujuan_disposisi' => 'required|exists:users,id',
            'isi_disposisi' => 'required|string',
            'sifat_disposisi' => 'required|in:Biasa,Segera,Rahasia,Penting',
            'deadline' => 'required|date',
            'status' => 'required|in:Diteruskan,Diproses,Selesai',
        ]);

        $validated['created_by'] = Auth::id();

        $disposisi = Disposisi::create($validated);

        ActivityLog::catat(
            'create_disposisi',
            "{$request->user()->name} membuat disposisi '{$disposisi->suratMasuk->perihal}' kepada {$disposisi->tujuanUser->name} (sifat: {$disposisi->sifat_disposisi})",
            'disposisi',
            $disposisi->id
        );

        return redirect()->route('admin.disposisi.index')->with('success', 'Disposisi berhasil dibuat.');
    }

    public function show(Disposisi $disposisi)
    {
        $disposisi->load(['suratMasuk', 'tujuanUser', 'creator']);

        return view('admin.disposisi.show', compact('disposisi'));
    }

    public function edit(Disposisi $disposisi)
    {
        $suratMasuks = SuratMasuk::latest()->get();
        $tujuanUsers = User::whereDoesntHave('roles', fn ($q) => $q->where('name', 'Warga'))->orderBy('name')->get();

        return view('admin.disposisi.edit', compact('disposisi', 'suratMasuks', 'tujuanUsers'));
    }

    public function update(Request $request, Disposisi $disposisi)
    {
        $validated = $request->validate([
            'surat_masuk_id' => 'required|exists:surat_masuks,id',
            'tujuan_disposisi' => 'required|exists:users,id',
            'isi_disposisi' => 'required|string',
            'sifat_disposisi' => 'required|in:Biasa,Segera,Rahasia,Penting',
            'deadline' => 'required|date',
            'status' => 'required|in:Diteruskan,Diproses,Selesai',
        ]);

        $disposisi->update($validated);

        ActivityLog::catat(
            'update_disposisi',
            "{$request->user()->name} memperbarui disposisi '{$disposisi->suratMasuk->perihal}' (status: {$disposisi->status})",
            'disposisi',
            $disposisi->id
        );

        return redirect()->route('admin.disposisi.show', $disposisi)->with('success', 'Disposisi berhasil diperbarui.');
    }

    public function destroy(Request $request, Disposisi $disposisi)
    {
        $perihal = $disposisi->suratMasuk?->perihal ?? '-';

        ActivityLog::catat(
            'delete_disposisi',
            "{$request->user()->name} menghapus disposisi '{$perihal}'",
            'disposisi',
            $disposisi->id
        );

        $disposisi->delete();

        return redirect()->route('admin.disposisi.index')->with('success', 'Disposisi berhasil dihapus.');
    }
}
