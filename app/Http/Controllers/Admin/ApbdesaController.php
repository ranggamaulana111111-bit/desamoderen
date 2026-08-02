<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apbdesa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ApbdesaController extends Controller
{
    public function index(Request $request)
    {
        $query = Apbdesa::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('bidang', 'like', "%{$search}%")
                    ->orWhere('uraian', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $apbdesa = $query->latest()->paginate(15);

        $stats = [
            'total_anggaran' => (clone $query)->sum('anggaran'),
            'total_realisasi' => (clone $query)->sum('realisasi'),
            'persentase' => 0,
            'jumlah_items' => (clone $query)->count(),
        ];

        if ($stats['total_anggaran'] > 0) {
            $stats['persentase'] = round($stats['total_realisasi'] / $stats['total_anggaran'] * 100, 2);
        }

        $tahunList = Apbdesa::distinct()->pluck('tahun')->sortDesc()->values();

        return view('admin.apbdesa.index', compact('apbdesa', 'stats', 'tahunList'));
    }

    public function create()
    {
        return view('admin.apbdesa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|digits:4|integer|min:2020|max:' . (date('Y') + 2),
            'kategori' => 'required|in:Pendapatan,Belanja',
            'bidang' => 'required|string|max:255',
            'uraian' => 'required|string|max:500',
            'anggaran' => 'required|numeric|min:0',
            'realisasi' => 'nullable|numeric|min:0',
            'sumber_dana' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:Direvisi,Draft,Disetujui,Ditolak',
        ]);

        $validated['uuid'] = Str::uuid();
        $validated['created_by'] = Auth::id();

        Apbdesa::create($validated);

        return redirect()->route('admin.apbdesa.index')
            ->with('success', 'Data APBDesa berhasil ditambahkan.');
    }

    public function show(Apbdesa $apbdesa)
    {
        $apbdesa->load('creator');

        return view('admin.apbdesa.show', compact('apbdesa'));
    }

    public function edit(Apbdesa $apbdesa)
    {
        return view('admin.apbdesa.edit', compact('apbdesa'));
    }

    public function update(Request $request, Apbdesa $apbdesa)
    {
        $validated = $request->validate([
            'tahun' => 'required|digits:4|integer|min:2020|max:' . (date('Y') + 2),
            'kategori' => 'required|in:Pendapatan,Belanja',
            'bidang' => 'required|string|max:255',
            'uraian' => 'required|string|max:500',
            'anggaran' => 'required|numeric|min:0',
            'realisasi' => 'nullable|numeric|min:0',
            'sumber_dana' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:Direvisi,Draft,Disetujui,Ditolak',
        ]);

        $apbdesa->update($validated);

        return redirect()->route('admin.apbdesa.show', $apbdesa)
            ->with('success', 'Data APBDesa berhasil diperbarui.');
    }

    public function destroy(Apbdesa $apbdesa)
    {
        $apbdesa->forceDelete();

        return redirect()->route('admin.apbdesa.index')
            ->with('success', 'Data APBDesa berhasil dihapus.');
    }
}
