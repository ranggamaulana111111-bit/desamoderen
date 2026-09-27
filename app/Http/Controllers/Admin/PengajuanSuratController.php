<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PrivateFileHelper;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessCompletedLetter;
use App\Models\ActivityLog;
use App\Models\AntreanPengambilan;
use App\Models\LetterConfig;
use App\Models\PengajuanSurat;
use App\Services\ApprovalService;
use App\Services\LetterNumberService;
use App\Services\PdfGenerationService;
use App\Services\Surat\LetterServiceFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PengajuanSuratController extends Controller
{
    public function __construct(
        private ApprovalService $approvalService,
        private PdfGenerationService $pdfService,
        private LetterNumberService $letterNumberService,
    ) {}

    public function index(Request $request)
    {
        $user = $request->user();

        $query = PengajuanSurat::with('user', 'latestApproval');

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($jenis = $request->input('jenis')) {
            $query->where('jenis_surat', $jenis);
        }

        if ($search = $request->input('search')) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($user->isRtRw()) {
            $query->whereHas('user', function ($q) use ($user) {
                $q->where('rt', $user->rt)->where('rw', $user->rw);
            });
        }

        $pengajuan = $query->latest()->paginate(20)->withQueryString();

        $letterConfigs = LetterConfig::active()->get();

        $base = PengajuanSurat::query();
        if ($user->isRtRw()) {
            $base->whereHas('user', fn ($q) => $q->where('rt', $user->rt)->where('rw', $user->rw));
        }

        $stats = [
            'all' => (clone $base)->count(),
            'submitted' => (clone $base)->where('status', 'submitted')->count(),
            'verified' => (clone $base)->where('status', 'verified')->count(),
            'approved_operator' => (clone $base)->where('status', 'approved_operator')->count(),
            'approved_sekdes' => (clone $base)->where('status', 'approved_sekdes')->count(),
            'approved_kades' => (clone $base)->where('status', 'approved_kades')->count(),
            'completed' => (clone $base)->where('status', 'completed')->count(),
            'rejected' => (clone $base)->where('status', 'rejected')->count(),
        ];

        return view('admin.pengajuan.index', compact('pengajuan', 'stats', 'letterConfigs'));
    }

    public function show(PengajuanSurat $pengajuan)
    {
        Gate::authorize('view', $pengajuan);

        $pengajuan->load(['user', 'approvalHistories.user', 'antrean']);

        $service = LetterServiceFactory::make($pengajuan->jenis_surat);
        $validTransitions = $this->approvalService->getValidTransitions($pengajuan, auth()->user());
        $timeline = $this->approvalService->getTimeline($pengajuan);
        $stepProgress = $this->approvalService->getStepProgress($pengajuan);

        return view('admin.pengajuan.show', compact('pengajuan', 'service', 'validTransitions', 'timeline', 'stepProgress'));
    }

    public function approve(Request $request, PengajuanSurat $pengajuan)
    {
        $validated = $request->validate([
            'catatan' => 'nullable|string|max:1000',
        ]);

        $user = $request->user();

        Gate::authorize('approve', $pengajuan);

        try {
            $this->approvalService->approve($pengajuan, $user, $validated['catatan'] ?? null);
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['message' => $e->getMessage()]);
        }

        $label = str_replace('_', ' ', ucfirst($pengajuan->jenis_surat));
        ActivityLog::catat(
            'approve_pengajuan',
            "{$user->name} menyetujui pengajuan {$label} ID #{$pengajuan->id} (status: {$pengajuan->fresh()->status}).".(($validated['catatan'] ?? null) ? " Catatan: {$validated['catatan']}" : ''),
            'pengajuan',
            $pengajuan->id
        );

        if ($pengajuan->fresh()->status === 'completed') {
            $this->handleCompletion($pengajuan);
        }

        return redirect()->route('admin.pengajuan.show', $pengajuan)
            ->with('success', 'Pengajuan berhasil disetujui.');
    }

    public function reject(Request $request, PengajuanSurat $pengajuan)
    {
        $validated = $request->validate([
            'catatan' => 'required|string|max:1000',
        ]);

        $user = $request->user();

        Gate::authorize('reject', $pengajuan);

        try {
            $this->approvalService->reject($pengajuan, $user, $validated['catatan']);
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['message' => $e->getMessage()]);
        }

        $label = str_replace('_', ' ', ucfirst($pengajuan->jenis_surat));
        ActivityLog::catat(
            'reject_pengajuan',
            "{$user->name} menolak pengajuan {$label} ID #{$pengajuan->id}. Catatan: {$validated['catatan']}",
            'pengajuan',
            $pengajuan->id
        );

        return redirect()->route('admin.pengajuan.show', $pengajuan)
            ->with('success', 'Pengajuan berhasil ditolak.');
    }

    public function requestRevision(Request $request, PengajuanSurat $pengajuan)
    {
        $validated = $request->validate([
            'catatan' => 'required|string|max:1000',
        ]);

        $user = $request->user();

        Gate::authorize('requestRevision', $pengajuan);

        try {
            $this->approvalService->requestRevision($pengajuan, $user, $validated['catatan']);
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['message' => $e->getMessage()]);
        }

        $label = str_replace('_', ' ', ucfirst($pengajuan->jenis_surat));
        ActivityLog::catat(
            'revision_pengajuan',
            "{$user->name} meminta perbaikan pada pengajuan {$label} ID #{$pengajuan->id}. Catatan: {$validated['catatan']}",
            'pengajuan',
            $pengajuan->id
        );

        return redirect()->route('admin.pengajuan.show', $pengajuan)
            ->with('success', 'Permintaan perbaikan berhasil dikirim.');
    }

    public function showLampiran(Request $request, PengajuanSurat $pengajuan, int $index)
    {
        Gate::authorize('viewLampiran', $pengajuan);

        $lampiran = $pengajuan->data_tambahan['lampiran'] ?? [];

        if (! isset($lampiran[$index])) {
            abort(404, 'Lampiran tidak ditemukan.');
        }

        $located = PrivateFileHelper::locate($lampiran[$index]);

        if (! $located) {
            abort(404, 'File lampiran tidak tersedia di server.');
        }

        $filename = basename($located['path']);

        return Storage::disk($located['disk'])->response($located['path'], $filename, [
            'Content-Type' => $this->lampiranMime($filename),
            'X-Content-Type-Options' => 'nosniff',
        ], $request->boolean('download') ? 'attachment' : 'inline');
    }

    private function lampiranMime(string $filename): string
    {
        return match (strtolower(pathinfo($filename, PATHINFO_EXTENSION))) {
            'pdf' => 'application/pdf',
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            default => 'application/octet-stream',
        };
    }

    private function handleCompletion(PengajuanSurat $pengajuan): void
    {
        DB::transaction(function () use ($pengajuan) {
            $pengajuan->lockForUpdate();

            if (! $pengajuan->hash_verifikasi) {
                $pengajuan->update([
                    'hash_verifikasi' => hash('sha256', $pengajuan->id.$pengajuan->user_id.$pengajuan->jenis_surat.Str::random(40)),
                ]);
            }

            if (! $pengajuan->nomor_surat) {
                $nomor = $this->letterNumberService->generateFor($pengajuan, now());
                $pengajuan->update([
                    'nomor_surat' => $nomor,
                    'tgl_selesai' => $pengajuan->tgl_selesai ?? now()->toDateString(),
                ]);
            }

            if (! $pengajuan->antrean) {
                $slot = $this->alokasiSlot();

                $antrean = AntreanPengambilan::firstOrCreate(
                    ['pengajuan_id' => $pengajuan->id],
                    [
                        'nomor_antrean' => AntreanPengambilan::generateNomor(new \DateTime($slot['tanggal'])),
                        'tanggal_ambil' => $slot['tanggal'],
                        'jam_mulai' => $slot['mulai'],
                        'jam_selesai' => $slot['selesai'],
                        'kode_qr' => Str::random(32),
                    ]
                );
            }
        });

        ProcessCompletedLetter::dispatch($pengajuan->id);
    }

    private function alokasiSlot(): array
    {
        $jamMulai = config('village.antrean_jam_mulai', '09:00');
        $jamSelesai = config('village.antrean_jam_selesai', '12:00');
        $kuotaPerSlot = (int) config('village.antrean_kuota_per_slot', 1);
        $durasiSlot = (int) config('village.antrean_durasi_slot', 15);

        if ($durasiSlot < 1) {
            $durasiSlot = 15;
        }

        [$hMulai, $mMulai] = explode(':', $jamMulai);
        [$hSelesai, $mSelesai] = explode(':', $jamSelesai);
        $menitBuka = (int) $hMulai * 60 + (int) $mMulai;
        $menitTutup = (int) $hSelesai * 60 + (int) $mSelesai;
        $totalSlot = (int) (($menitTutup - $menitBuka) / $durasiSlot);
        $kapasitasHarian = $totalSlot * $kuotaPerSlot;

        $sekarang = now();
        $lewatJamTutup = (int) $sekarang->format('Hi') >= (int) str_replace(':', '', $jamSelesai);
        $tgl = $lewatJamTutup
            ? $sekarang->copy()->addDay()->startOfDay()
            : $sekarang->copy()->startOfDay();

        for ($hari = 0; $hari < 30; $hari++) {
            $jumlahTerisi = AntreanPengambilan::whereDate('tanggal_ambil', $tgl)
                ->lockForUpdate()
                ->count();

            if ($jumlahTerisi < $kapasitasHarian) {
                $slotIndex = intdiv($jumlahTerisi, $kuotaPerSlot);
                $menitMulai = $menitBuka + ($slotIndex * $durasiSlot);

                return [
                    'tanggal' => $tgl->toDateString(),
                    'mulai' => sprintf('%02d:%02d', intdiv($menitMulai, 60), $menitMulai % 60),
                    'selesai' => sprintf('%02d:%02d', intdiv($menitMulai + $durasiSlot, 60), ($menitMulai + $durasiSlot) % 60),
                ];
            }

            $tgl->addDay();
        }

        throw new \RuntimeException('Tidak ada slot antrean yang tersedia dalam 30 hari ke depan.');
    }
}
