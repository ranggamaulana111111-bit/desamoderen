<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = SuratKeluar::with('creator');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_agenda', 'like', "%{$search}%")
                    ->orWhere('tujuan', 'like', "%{$search}%")
                    ->orWhere('perihal', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $surat = $query->latest()->paginate(15)->withQueryString();

        $total = SuratKeluar::count();
        $hariIni = SuratKeluar::whereDate('created_at', today())->count();
        $mingguIni = SuratKeluar::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $bulanIni = SuratKeluar::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)->count();

        return view('admin.surat-keluar.index', compact('surat', 'total', 'hariIni', 'mingguIni', 'bulanIni'));
    }

    public function create()
    {
        $nomorAgenda = $this->generateNomorAgenda();

        return view('admin.surat-keluar.create', compact('nomorAgenda'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_kirim' => 'required|date',
            'tujuan' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'jenis_surat' => 'required|in:Masuk,Keluar,Internal',
            'sifat_surat' => 'required|in:Biasa,Segera,Rahasia,Penting',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'status' => 'required|in:dikirim,diproses,selesai,ditolak',
        ]);

        $validated['nomor_agenda'] = $this->generateNomorAgenda();
        $validated['created_by'] = auth()->id();

        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('surat-keluar', 'public');
        }

        unset($validated['file']);

        SuratKeluar::create($validated);

        return redirect()->route('admin.surat-keluar.index')
            ->with('success', 'Surat keluar berhasil ditambahkan.');
    }

    public function show(SuratKeluar $suratKeluar)
    {
        $suratKeluar->load('creator');

        return view('admin.surat-keluar.show', ['surat' => $suratKeluar]);
    }

    public function edit(SuratKeluar $suratKeluar)
    {
        return view('admin.surat-keluar.edit', ['surat' => $suratKeluar]);
    }

    public function update(Request $request, SuratKeluar $suratKeluar)
    {
        $validated = $request->validate([
            'tanggal_kirim' => 'required|date',
            'tujuan' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'jenis_surat' => 'required|in:Masuk,Keluar,Internal',
            'sifat_surat' => 'required|in:Biasa,Segera,Rahasia,Penting',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'status' => 'required|in:dikirim,diproses,selesai,ditolak',
        ]);

        if ($request->hasFile('file')) {
            if ($suratKeluar->file_path) {
                Storage::disk('public')->delete($suratKeluar->file_path);
            }
            $validated['file_path'] = $request->file('file')->store('surat-keluar', 'public');
        }

        unset($validated['file']);

        $suratKeluar->update($validated);

        return redirect()->route('admin.surat-keluar.show', $suratKeluar)
            ->with('success', 'Surat keluar berhasil diperbarui.');
    }

    public function destroy(SuratKeluar $suratKeluar)
    {
        if ($suratKeluar->file_path) {
            Storage::disk('public')->delete($suratKeluar->file_path);
        }

        $suratKeluar->delete();

        return redirect()->route('admin.surat-keluar.index')
            ->with('success', 'Surat keluar berhasil dihapus.');
    }

    private function generateNomorAgenda(): string
    {
        $year = date('Y');
        $last = SuratKeluar::where('nomor_agenda', 'like', "SK-{$year}-%")
            ->orderByRaw("SUBSTRING_INDEX(nomor_agenda, '-', -1) DESC")
            ->first();

        if ($last) {
            $lastNum = (int) substr($last->nomor_agenda, strrpos($last->nomor_agenda, '-') + 1);
            $next = str_pad($lastNum + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $next = '001';
        }

        return "SK-{$year}-{$next}";
    }
}
