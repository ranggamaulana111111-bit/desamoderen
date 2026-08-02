<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentVersion;
use App\Models\PengajuanSurat;
use App\Services\DocumentVersionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class DocumentVersionController extends Controller
{
    public function __construct(
        private DocumentVersionService $documentVersionService,
    ) {}

    public function index(PengajuanSurat $pengajuan)
    {
        Gate::authorize('viewAny', DocumentVersion::class);

        $pengajuan->load('user');
        $versions = $this->documentVersionService->getVersions($pengajuan);

        return view('admin.pengajuan.versions', compact('pengajuan', 'versions'));
    }

    public function show(PengajuanSurat $pengajuan, int $version)
    {
        Gate::authorize('view', DocumentVersion::class);

        $pengajuan->load('user');
        $version = $this->documentVersionService->getVersion($pengajuan, $version);

        if (! $version) {
            abort(404, 'Versi tidak ditemukan.');
        }

        return view('admin.pengajuan.version-show', compact('pengajuan', 'version'));
    }

    public function restore(Request $request, PengajuanSurat $pengajuan, int $version)
    {
        Gate::authorize('restore', DocumentVersion::class);

        $this->documentVersionService->restore($pengajuan, $version, $request->user());

        return redirect()->route('admin.pengajuan.versions.index', $pengajuan)
            ->with('success', "Data pengajuan berhasil dikembalikan ke versi v{$version}.");
    }

    public function download(PengajuanSurat $pengajuan, int $version)
    {
        Gate::authorize('view', DocumentVersion::class);

        $versionModel = $this->documentVersionService->getVersion($pengajuan, $version);

        if (! $versionModel || ! $versionModel->pdf_path || ! Storage::disk('private')->exists($versionModel->pdf_path)) {
            abort(404, 'File PDF versi ini tidak tersedia.');
        }

        $filename = "surat_{$pengajuan->jenis_surat}_v{$version}_".now()->format('Ymd').'.pdf';

        return Storage::disk('private')->download($versionModel->pdf_path, $filename);
    }

    public function diff(Request $request, PengajuanSurat $pengajuan)
    {
        Gate::authorize('view', DocumentVersion::class);

        $request->validate([
            'v1' => 'required|integer|min:1',
            'v2' => 'required|integer|min:1|different:v1',
        ]);

        $diff = $this->documentVersionService->diff($pengajuan, (int) $request->v1, (int) $request->v2);

        return view('admin.pengajuan.version-diff', compact('pengajuan', 'diff'));
    }
}
