<?php

namespace App\Services;

use App\Models\PengajuanSurat;
use App\Services\Surat\DynamicLetterService;
use App\Services\Surat\LetterGeneratorInterface;
use App\Services\Surat\LetterServiceFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpFoundation\Response;

class PdfGenerationService
{
    public function buildViewData(PengajuanSurat $surat, LetterGeneratorInterface $service): array
    {
        $resolved = $service->generate($surat);

        $ttd = $surat->tanda_tangan_meta;
        $namaPenandatangan = $ttd['nama'] ?? config('village.nama_kades', 'Kepala Desa');
        $jabatanPenandatangan = $ttd['jabatan'] ?? config('village.jabatan_kades', 'Kepala Desa');
        $nipPenandatangan = $ttd['nip'] ?? config('village.nip_kades', '-');
        $keperluan = $ttd['keperluan'] ?? null;

        $tglCetak = now();
        $tglBerlakuSampai = $tglCetak->copy()->addMonths($service->masaBerlakuBulan());

        $verifyUrl = $surat->hash_verifikasi
            ? route('verifikasi.show', $surat->hash_verifikasi)
            : '#';

        $qrSvg = QrCode::format('svg')->size(120)->generate($verifyUrl);

        $tahun = $tglCetak->year;

        $data = $resolved['data'];
        $data['surat'] = $surat;
        $data['nomor_surat'] = $surat->nomor_surat ?? sprintf('%s / %s / DS-KP / %s', $service->kodeKlasifikasi(), $surat->id, $tahun);
        $data['tgl_cetak'] = $tglCetak->locale('id')->translatedFormat('d F Y');
        $data['tgl_berlaku_sampai'] = $tglBerlakuSampai->locale('id')->translatedFormat('d F Y');
        $data['kades'] = $namaPenandatangan;
        $data['penandatangan_nama'] = $namaPenandatangan;
        $data['penandatangan_jabatan'] = $jabatanPenandatangan;
        $data['penandatangan_nip'] = $nipPenandatangan;
        $data['keperluan'] = $keperluan;
        $data['jenis_label'] = $resolved['jenis_label'];
        $data['hash'] = $surat->hash_verifikasi;
        $data['qr_svg'] = $qrSvg;

        $stempel = config('village.stempel_desa');
        $ttdKades = config('village.ttd_kades');
        $data['stempel_desa'] = $stempel && Storage::disk('public')->exists($stempel)
            ? base64_encode(Storage::disk('public')->get($stempel))
            : null;
        $data['ttd_kades'] = $ttdKades && Storage::disk('public')->exists($ttdKades)
            ? base64_encode(Storage::disk('public')->get($ttdKades))
            : null;

        return $data;
    }

    public function renderPdf(PengajuanSurat $surat, LetterGeneratorInterface $service): \Barryvdh\DomPDF\PDF
    {
        $data = $this->buildViewData($surat, $service);
        $view = $service instanceof DynamicLetterService
            ? 'pdf.template_dynamic'
            : $this->resolveView($surat->jenis_surat);

        return Pdf::loadView($view, $data);
    }

    public function generateAndStore(PengajuanSurat $surat): string
    {
        $service = LetterServiceFactory::make($surat->jenis_surat);
        $pdf = $this->renderPdf($surat, $service);

        $tahun = now()->year;
        $filename = "surat/{$surat->jenis_surat}_{$surat->id}_{$tahun}.pdf";

        Storage::disk('private')->put($filename, $pdf->output());

        $surat->update(['pdf_path' => $filename]);

        return $filename;
    }

    public function generateAsStream(PengajuanSurat $surat): Response
    {
        $service = LetterServiceFactory::make($surat->jenis_surat);
        $pdf = $this->renderPdf($surat, $service);

        return $pdf->stream($this->getFilename($surat));
    }

    public function getFilename(PengajuanSurat $surat): string
    {
        $tahun = now()->year;
        $namaWarga = strtolower(str_replace(' ', '-', $surat->user->name));

        return "{$surat->jenis_surat}-{$namaWarga}-{$tahun}.pdf";
    }

    private function resolveView(string $jenisSurat): string
    {
        return match ($jenisSurat) {
            'sktm' => 'pdf.template_sktm',
            'ktp_sementara' => 'pdf.template_ktp_sementara',
            'akta' => 'pdf.template_akta',
            default => 'pdf.template_dynamic',
        };
    }
}
