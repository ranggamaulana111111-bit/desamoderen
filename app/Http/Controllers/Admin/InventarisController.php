<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventaris;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InventarisController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventaris::with('creator');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_inventaris', 'like', "%{$search}%")
                    ->orWhere('nama_barang', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $inventaris = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total' => Inventaris::count(),
            'total_nilai' => Inventaris::sum('nilai_perolehan'),
            'baiks' => Inventaris::where('kondisi', 'Baik')->count(),
            'rusaks' => Inventaris::whereIn('kondisi', ['Rusak Ringan', 'Rusak Berat'])->count(),
        ];

        return view('admin.inventaris.index', compact('inventaris', 'stats'));
    }

    public function create()
    {
        $kodeInventaris = $this->generateKodeInventaris();

        return view('admin.inventaris.create', compact('kodeInventaris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang'       => 'required|string|max:255',
            'kategori'          => 'required|in:Peralatan,Kendaraan,Gedung,Tanah,Furniture,Elektronik,Lainnya',
            'nomor_inventaris'  => 'nullable|string|max:255',
            'kondisi'           => 'required|in:Baik,Rusak Ringan,Rusak Berat,Perawatan',
            'jumlah'            => 'required|integer|min:1',
            'lokasi'            => 'nullable|string|max:255',
            'tahun_perolehan'   => 'nullable|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'nilai_perolehan'   => 'nullable|numeric|min:0',
            'foto'              => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'keterangan'        => 'nullable|string',
            'status'            => 'required|in:Digunakan,Tersedia,Disimpan,Dihapus',
        ]);

        $validated['kode_inventaris'] = $this->generateKodeInventaris();
        $validated['created_by'] = Auth::id();

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('inventaris', 'public');
        }

        Inventaris::create($validated);

        return redirect()->route('admin.inventaris.index')->with('success', 'Inventaris berhasil ditambahkan.');
    }

    public function show(Inventaris $inventaris)
    {
        $inventaris->load('creator');

        return view('admin.inventaris.show', compact('inventaris'));
    }

    public function edit(Inventaris $inventaris)
    {
        return view('admin.inventaris.edit', compact('inventaris'));
    }

    public function update(Request $request, Inventaris $inventaris)
    {
        $validated = $request->validate([
            'nama_barang'       => 'required|string|max:255',
            'kategori'          => 'required|in:Peralatan,Kendaraan,Gedung,Tanah,Furniture,Elektronik,Lainnya',
            'nomor_inventaris'  => 'nullable|string|max:255',
            'kondisi'           => 'required|in:Baik,Rusak Ringan,Rusak Berat,Perawatan',
            'jumlah'            => 'required|integer|min:1',
            'lokasi'            => 'nullable|string|max:255',
            'tahun_perolehan'   => 'nullable|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'nilai_perolehan'   => 'nullable|numeric|min:0',
            'foto'              => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'keterangan'        => 'nullable|string',
            'status'            => 'required|in:Digunakan,Tersedia,Disimpan,Dihapus',
        ]);

        if ($request->hasFile('foto')) {
            if ($inventaris->foto) {
                Storage::disk('public')->delete($inventaris->foto);
            }
            $validated['foto'] = $request->file('foto')->store('inventaris', 'public');
        }

        $inventaris->update($validated);

        return redirect()->route('admin.inventaris.show', $inventaris)->with('success', 'Inventaris berhasil diperbarui.');
    }

    public function destroy(Inventaris $inventaris)
    {
        if ($inventaris->foto) {
            Storage::disk('public')->delete($inventaris->foto);
        }

        $inventaris->delete();

        return redirect()->route('admin.inventaris.index')->with('success', 'Inventaris berhasil dihapus.');
    }

    private function generateKodeInventaris(): string
    {
        $year = Carbon::now()->format('Y');
        $prefix = "INV-{$year}-";

        $lastSequence = Inventaris::where('kode_inventaris', 'like', "{$prefix}%")
            ->orderByRaw("CAST(SUBSTRING(kode_inventaris, " . (strlen($prefix) + 1) . ") AS UNSIGNED) DESC")
            ->value(DB::raw("SUBSTRING(kode_inventaris, " . (strlen($prefix) + 1) . ")"));

        $nextSequence = $lastSequence ? (int) $lastSequence + 1 : 1;

        return $prefix . str_pad($nextSequence, 4, '0', STR_PAD_LEFT);
    }
}
