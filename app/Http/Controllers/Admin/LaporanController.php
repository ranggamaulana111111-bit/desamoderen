<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanDesa;
use App\Services\LaporanService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function __construct(
        private readonly LaporanService $laporanService
    ) {}

    public function index(Request $request)
    {
        $query = LaporanDesa::with('creator', 'approver')
            ->where('created_by', Auth::id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('tipe')) {
            $query->where('tipe_periode', $request->tipe);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('nomor_laporan', 'like', "%{$search}%");
            });
        }

        $laporan = $query->latest()->paginate(12);

        $stats = [
            'total' => LaporanDesa::where('created_by', Auth::id())->count(),
            'draft' => LaporanDesa::where('created_by', Auth::id())->where('status', 'draft')->count(),
            'finalisasi' => LaporanDesa::where('created_by', Auth::id())->where('status', 'finalisasi')->count(),
        ];

        return view('admin.laporan.index', compact('laporan', 'stats'));
    }

    public function create(Request $request)
    {
        $modules = LaporanService::MODULES;
        $moduleLabels = LaporanService::MODULE_LABELS;
        $moduleIcons = LaporanService::MODULE_ICONS;

        return view('admin.laporan.create', compact('modules', 'moduleLabels', 'moduleIcons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'periode_mulai' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_mulai',
            'tipe_periode' => 'required|in:bulanan,kuartal,tahunan,khusus',
            'modul_yang_dipilih' => 'required|array|min:1',
            'modul_yang_dipilih.*' => 'in:' . implode(',', LaporanService::MODULES),
            'format_pdf' => 'required|in:surat_resmi,laporan_institusional',
            'konten_naratif' => 'nullable|array',
        ]);

        $validated['created_by'] = Auth::id();

        if (!isset($validated['konten_naratif']) || empty($validated['konten_naratif'])) {
            $start = Carbon::parse($validated['periode_mulai']);
            $end = Carbon::parse($validated['periode_akhir']);
            $validated['konten_naratif'] = $this->laporanService->generateAllNarratives(
                $validated['modul_yang_dipilih'],
                $start,
                $end
            );
        }

        $laporan = LaporanDesa::create($validated);

        return redirect()->route('admin.laporan.show', $laporan)
            ->with('success', 'Laporan berhasil disimpan sebagai draf.');
    }

    public function show(LaporanDesa $laporan)
    {
        $laporan->load('creator', 'approver');

        if (empty($laporan->konten_naratif)) {
            $start = $laporan->periode_mulai;
            $end = $laporan->periode_akhir;
            $laporan->konten_naratif = $this->laporanService->generateAllNarratives(
                $laporan->modul_yang_dipilih,
                $start,
                $end
            );
            $laporan->save();
        }

        return view('admin.laporan.show', compact('laporan'));
    }

    public function edit(LaporanDesa $laporan)
    {
        abort_unless($laporan->canEdit(), 403);

        $modules = LaporanService::MODULES;
        $moduleLabels = LaporanService::MODULE_LABELS;
        $moduleIcons = LaporanService::MODULE_ICONS;

        if (empty($laporan->konten_naratif)) {
            $laporan->konten_naratif = $this->laporanService->generateAllNarratives(
                $laporan->modul_yang_dipilih,
                $laporan->periode_mulai,
                $laporan->periode_akhir
            );
        }

        return view('admin.laporan.edit', compact('laporan', 'modules', 'moduleLabels', 'moduleIcons'));
    }

    public function update(Request $request, LaporanDesa $laporan)
    {
        abort_unless($laporan->canEdit(), 403);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten_naratif' => 'required|array',
            'konten_naratif.*.judul' => 'required|string',
            'konten_naratif.*.teks' => 'required|string',
            'format_pdf' => 'required|in:surat_resmi,laporan_institusional',
        ]);

        $laporan->update($validated);

        return redirect()->route('admin.laporan.show', $laporan)
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy(LaporanDesa $laporan)
    {
        abort_unless($laporan->canEdit(), 403);

        $laporan->delete();

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }

    public function previewData(Request $request)
    {
        $validated = $request->validate([
            'modul_yang_dipilih' => 'required|array|min:1',
            'modul_yang_dipilih.*' => 'in:' . implode(',', LaporanService::MODULES),
            'periode_mulai' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_mulai',
        ]);

        $start = Carbon::parse($validated['periode_mulai']);
        $end = Carbon::parse($validated['periode_akhir']);

        $narratives = $this->laporanService->generateAllNarratives(
            $validated['modul_yang_dipilih'],
            $start,
            $end
        );

        return response()->json($narratives);
    }

    public function generatePdf(LaporanDesa $laporan)
    {
        $laporan->load('creator', 'approver');

        if (empty($laporan->konten_naratif)) {
            $laporan->konten_naratif = $this->laporanService->generateAllNarratives(
                $laporan->modul_yang_dipilih,
                $laporan->periode_mulai,
                $laporan->periode_akhir
            );
            $laporan->save();
        }

        $view = $laporan->format_pdf === 'laporan_institusional'
            ? 'pdf.laporan_institusional'
            : 'pdf.laporan_surat_resmi';

        $pdf = Pdf::loadView($view, [
            'laporan' => $laporan,
            'konten' => $laporan->konten_naratif,
        ]);

        $filename = 'laporan-desa-' . $laporan->slugifyJudul() . '-' . $laporan->periode_mulai->format('Y-m') . '.pdf';

        return $pdf->download($filename);
    }

    public function finalize(Request $request, LaporanDesa $laporan)
    {
        abort_unless($laporan->isDraft(), 403);
        abort_unless(Auth::user()->hasRole(['Kepala Desa', 'Super Admin']), 403);

        $laporan->update([
            'status' => 'finalisasi',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Laporan berhasil difinalisasi.');
    }

    public function restore(LaporanDesa $laporan)
    {
        abort_unless($laporan->isFinalized(), 403);
        abort_unless(Auth::user()->hasRole(['Kepala Desa', 'Super Admin']), 403);

        $laporan->update([
            'status' => 'draft',
            'approved_by' => null,
            'approved_at' => null,
        ]);

        return back()->with('success', 'Laporan dikembalikan ke status draf.');
    }
}
