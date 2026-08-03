<?php

namespace App\Http\Controllers\Admin;

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

        $pengajuan = $query->latest()->paginate(20)->withQueryString();

        $letterConfigs = LetterConfig::active()->get();

        $stats = [
            'all' => PengajuanSurat::count(),
            'submitted' => PengajuanSurat::where('status', 'submitted')->count(),
            'verified' => PengajuanSurat::where('status', 'verified')->count(),
            'approved_operator' => PengajuanSurat::where('status', 'approved_operator')->count(),
            'approved_sekdes' => PengajuanSurat::where('status', 'approved_sekdes')->count(),
            'approved_kades' => PengajuanSurat::where('status', 'approved_kades')->count(),
            'completed' => PengajuanSurat::where('status', 'completed')->count(),
            'rejected' => PengajuanSurat::where('status', 'rejected')->count(),
        ];

        return view('admin.pengajuan.index', compact('pengajuan', 'stats', 'letterConfigs'));
    }

    public function show(PengajuanSurat $pengajuan)
    {
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

        $this->approvalService->approve($pengajuan, $user, $validated['catatan'] ?? null);

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

        $this->approvalService->reject($pengajuan, $user, $validated['catatan']);

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

        $this->approvalService->requestRevision($pengajuan, $user, $validated['catatan']);

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

    private function handleCompletion(PengajuanSurat $pengajuan): void
    {
        DB::transaction(function () use ($pengajuan) {
            if (! $pengajuan->hash_verifikasi) {
                $pengajuan->update([
                    'hash_verifikasi' => hash('sha256', $pengajuan->id.$pengajuan->user_id.$pengajuan->jenis_surat.now()->timestamp(Str::random(16))),
                ]);
            }

            if (! $pengajuan->nomor_surat) {
                $pengajuan->update([
                    'nomor_surat' => $this->letterNumberService->generateFor($pengajuan),
                ]);
            }

            if (! $pengajuan->antrean) {
                $slot = $this->alokasiSlot();

                AntreanPengambilan::create([
                    'pengajuan_id' => $pengajuan->id,
                    'nomor_antrean' => AntreanPengambilan::generateNomor(new \DateTime($slot['tanggal'])),
                    'tanggal_ambil' => $slot['tanggal'],
                    'jam_mulai' => $slot['mulai'],
                    'jam_selesai' => $slot['selesai'],
                    'kode_qr' => Str::random(32),
                ]);
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

        for ($hari = 0; $hari < 14; $hari++) {
            AntreanPengambilan::whereDate('tanggal_ambil', $tgl)
                ->lockForUpdate()
                ->get();

            $jumlahTerisi = AntreanPengambilan::whereDate('tanggal_ambil', $tgl)->count();

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

        return [
            'tanggal' => $tgl->toDateString(),
            'mulai' => $jamMulai,
            'selesai' => sprintf('%02d:%02d', (int) $hMulai + (int) ($durasiSlot / 60), (int) $mMulai + ($durasiSlot % 60)),
        ];
    }
}
