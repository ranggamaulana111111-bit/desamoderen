<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat;
use App\Services\PdfGenerationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class CetakSuratController extends Controller
{
    public function __construct(
        private PdfGenerationService $pdfService,
    ) {}

    public function cetak(string $id)
    {
        $surat = PengajuanSurat::with('user')->findOrFail($id);

        Gate::authorize('download', $surat);

        if ($surat->pdf_path && Storage::disk('private')->exists($surat->pdf_path)) {
            return Storage::disk('private')->download($surat->pdf_path, $this->pdfService->getFilename($surat));
        }

        if (! $surat->hash_verifikasi) {
            $surat->update([
                'hash_verifikasi' => hash('sha256', $surat->id.$surat->user_id.$surat->jenis_surat.now()->timestamp),
            ]);
            $surat->refresh();
        }

        return $this->pdfService->generateAsStream($surat);
    }

    public function cetakWarga(Request $request, string $id)
    {
        $surat = PengajuanSurat::with('user')
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        return $this->cetak((string) $surat->id);
    }
}
