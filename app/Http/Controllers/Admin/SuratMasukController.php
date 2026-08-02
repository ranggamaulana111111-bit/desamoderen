<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuratMasuk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SuratMasukController extends Controller
{
    public function index(Request $request)
    {
        $query = SuratMasuk::with('creator');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                    ->orWhere('pengirim', 'like', "%{$search}%")
                    ->orWhere('perihal', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $surat = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total' => SuratMasuk::count(),
            'hari_ini' => SuratMasuk::whereDate('created_at', Carbon::today())->count(),
            'minggu_ini' => SuratMasuk::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count(),
            'bulan_ini' => SuratMasuk::whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count(),
        ];

        return view('admin.surat-masuk.index', compact('surat', 'stats'));
    }

    public function create()
    {
        $nomorAgenda = $this->generateNomorAgenda();

        return view('admin.surat-masuk.create', compact('nomorAgenda'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_terima' => 'required|date',
            'tanggal_surat'  => 'required|date',
            'nomor_surat'    => 'required|string|max:255',
            'pengirim'       => 'required|string|max:255',
            'perihal'        => 'required|string|max:500',
            'jenis_surat'    => 'required|in:Masuk,Keluar,Internal',
            'sifat_surat'    => 'required|in:Biasa,Segera,Rahasia,Penting',
            'file'           => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'keterangan'     => 'nullable|string',
            'status'         => 'required|in:diterima,diproses,selesai,ditolak',
        ]);

        $validated['nomor_agenda'] = $this->generateNomorAgenda();
        $validated['created_by'] = Auth::id();

        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('surat-masuk', 'public');
        }

        SuratMasuk::create($validated);

        return redirect()->route('admin.surat-masuk.index')->with('success', 'Surat masuk berhasil ditambahkan.');
    }

    public function show(SuratMasuk $suratMasuk)
    {
        $suratMasuk->load('creator', 'disposisis');

        return view('admin.surat-masuk.show', ['surat' => $suratMasuk]);
    }

    public function edit(SuratMasuk $suratMasuk)
    {
        return view('admin.surat-masuk.edit', ['surat' => $suratMasuk]);
    }

    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $validated = $request->validate([
            'tanggal_terima' => 'required|date',
            'tanggal_surat'  => 'required|date',
            'nomor_surat'    => 'required|string|max:255',
            'pengirim'       => 'required|string|max:255',
            'perihal'        => 'required|string|max:500',
            'jenis_surat'    => 'required|in:Masuk,Keluar,Internal',
            'sifat_surat'    => 'required|in:Biasa,Segera,Rahasia,Penting',
            'file'           => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'keterangan'     => 'nullable|string',
            'status'         => 'required|in:diterima,diproses,selesai,ditolak',
        ]);

        if ($request->hasFile('file')) {
            if ($suratMasuk->file_path) {
                Storage::disk('public')->delete($suratMasuk->file_path);
            }
            $validated['file_path'] = $request->file('file')->store('surat-masuk', 'public');
        }

        $suratMasuk->update($validated);

        return redirect()->route('admin.surat-masuk.show', $suratMasuk)->with('success', 'Surat masuk berhasil diperbarui.');
    }

    public function destroy(SuratMasuk $suratMasuk)
    {
        if ($suratMasuk->file_path) {
            Storage::disk('public')->delete($suratMasuk->file_path);
        }

        $suratMasuk->delete();

        return redirect()->route('admin.surat-masuk.index')->with('success', 'Surat masuk berhasil dihapus.');
    }

    private function generateNomorAgenda(): string
    {
        $year = Carbon::now()->format('Y');
        $prefix = "SM-{$year}-";

        $lastSequence = SuratMasuk::where('nomor_agenda', 'like', "{$prefix}%")
            ->orderByRaw("CAST(SUBSTRING(nomor_agenda, " . (strlen($prefix) + 1) . ") AS UNSIGNED) DESC")
            ->value(DB::raw("SUBSTRING(nomor_agenda, " . (strlen($prefix) + 1) . ")"));

        $nextSequence = $lastSequence ? (int) $lastSequence + 1 : 1;

        return $prefix . str_pad($nextSequence, 4, '0', STR_PAD_LEFT);
    }
}
