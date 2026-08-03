<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AntreanPengambilan;
use App\Models\ApprovalHistory;
use App\Models\Berita;
use App\Models\Event;
use App\Models\PengajuanSurat;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SekdesDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // ── Core Stats ──
        $totalWarga = User::role('Warga')->count();
        $totalSurat = PengajuanSurat::count();
        $selesai = PengajuanSurat::where('status', 'completed')->count();
        $ditolak = PengajuanSurat::where('status', 'rejected')->count();

        $bulanIni = now()->startOfMonth();
        $selesaiBulanIni = PengajuanSurat::where('status', 'completed')
            ->where('updated_at', '>=', $bulanIni)
            ->count();

        // ── Pending Verification (approved_operator) ──
        $pendingVerification = PengajuanSurat::with('user')
            ->where('status', 'approved_operator')
            ->latest()
            ->paginate(15);

        $pendingCount = PengajuanSurat::where('status', 'approved_operator')->count();

        // ── Growth Comparisons ──
        $totalSuratBulanLalu = PengajuanSurat::where('created_at', '>=', $bulanIni->copy()->subMonth())
            ->where('created_at', '<', $bulanIni)
            ->count();
        $totalSuratBulanIni = PengajuanSurat::where('created_at', '>=', $bulanIni)->count();
        $suratGrowth = $totalSuratBulanLalu > 0
            ? round((($totalSuratBulanIni - $totalSuratBulanLalu) / $totalSuratBulanLalu) * 100)
            : ($totalSuratBulanIni > 0 ? 100 : 0);

        $wargaBulanLalu = User::role('Warga')
            ->where('created_at', '>=', $bulanIni->copy()->subMonth())
            ->where('created_at', '<', $bulanIni)
            ->count();
        $wargaBulanIni = User::role('Warga')
            ->where('created_at', '>=', $bulanIni)
            ->count();
        $wargaGrowth = $wargaBulanLalu > 0
            ? round((($wargaBulanIni - $wargaBulanLalu) / $wargaBulanLalu) * 100)
            : ($wargaBulanIni > 0 ? 100 : 0);

        // ── Today Stats ──
        $todayVerified = ApprovalHistory::where('user_id', $user->id)
            ->where('status', 'approved_sekdes')
            ->whereDate('created_at', today())
            ->count();
        $todayRejected = ApprovalHistory::where('user_id', $user->id)
            ->where('status', 'rejected')
            ->whereDate('created_at', today())
            ->count();

        // ── Verification History (my approvals/rejections) ──
        $verificationHistory = ApprovalHistory::with('pengajuan.user')
            ->where('user_id', $user->id)
            ->whereIn('status', ['approved_sekdes', 'rejected'])
            ->latest()
            ->take(5)
            ->get();

        // ── Average Verification Time (hours from operator approval to my verification) ──
        $avgProcessTime = DB::selectOne("
            SELECT AVG(TIMESTAMPDIFF(HOUR, ph1.created_at, ph2.created_at)) as avg_hours
            FROM approval_histories ph1
            JOIN approval_histories ph2 ON ph1.pengajuan_id = ph2.pengajuan_id
            WHERE ph1.status = 'approved_operator'
            AND ph2.status = 'approved_sekdes'
            AND ph2.user_id = ?
            AND ph2.created_at >= ?
        ", [$user->id, now()->subMonths(3)]);

        $avgProcessHours = $avgProcessTime?->avg_hours ?? 0;

        // ── RT/RW Distribution ──
        $rtStats = User::role('Warga')
            ->select('rt', DB::raw('count(*) as total'))
            ->groupBy('rt')
            ->orderBy('rt')
            ->get();

        $rwStats = User::role('Warga')
            ->select('rw', DB::raw('count(*) as total'))
            ->groupBy('rw')
            ->orderBy('rw')
            ->get();

        // ── Operator Performance ──
        $operatorStats = User::role('Operator Pelayanan')
            ->withCount([
                'pengajuanSurat as total_reviewed' => function ($q) {
                    $q->whereNotIn('status', ['submitted', 'revision']);
                },
                'pengajuanSurat as total_approved' => function ($q) {
                    $q->where('status', 'approved_operator');
                },
                'pengajuanSurat as total_rejected' => function ($q) {
                    $q->where('status', 'rejected');
                },
            ])
            ->get()
            ->map(function ($op) {
                $op->approval_rate = $op->total_reviewed > 0
                    ? round(($op->total_approved / $op->total_reviewed) * 100)
                    : 0;

                return $op;
            });

        // ── Stuck Surat (at operator, waiting for approve) ──
        $stuckSurat = PengajuanSurat::with('user')
            ->where('status', 'verified')
            ->where('updated_at', '<', now()->subDays(3))
            ->latest()
            ->take(5)
            ->get();

        // ── Daily Quota ──
        $dailyQuotaLimit = 20;
        $dailyQuotaUsed = ApprovalHistory::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->count();

        // ── Event Mendatang ──
        $eventMendatang = Event::withCount('peserta')
            ->where('tanggal', '>=', now()->toDateString())
            ->where('status', '!=', 'selesai')
            ->orderBy('tanggal')
            ->take(5)
            ->get();

        // ── Surat Masuk & Keluar ──
        $suratMasukHariIni = SuratMasuk::whereDate('created_at', now()->toDateString())->count();
        $suratMasukMingguIni = SuratMasuk::where('created_at', '>=', now()->startOfWeek())->count();
        $suratKeluarHariIni = SuratKeluar::whereDate('created_at', now()->toDateString())->count();
        $suratKeluarMingguIni = SuratKeluar::where('created_at', '>=', now()->startOfWeek())->count();
        $totalSuratMasuk = SuratMasuk::count();
        $totalSuratKeluar = SuratKeluar::count();
        $suratMasukTerbaru = SuratMasuk::latest()->take(3)->get();

        // ── Antrean Pengambilan ──
        $antreanMenunggu = AntreanPengambilan::where('status', 'menunggu')
            ->where('tanggal_ambil', '>=', now()->toDateString())->count();
        $antreanLewat = AntreanPengambilan::where('status', 'menunggu')
            ->where('tanggal_ambil', '<', now()->toDateString())->count();
        $antreanDiambil = AntreanPengambilan::where('status', 'diambil')
            ->whereDate('updated_at', now()->toDateString())->count();
        $antreanTerbaru = AntreanPengambilan::with('pengajuan.user')
            ->where('status', 'menunggu')
            ->orderBy('tanggal_ambil')
            ->take(5)
            ->get();

        // ── Berita Terbaru ──
        $beritaTerbaru = Berita::where('status', 'publish')
            ->latest()
            ->take(5)
            ->get();

        // ── Chart Data: 12 Bulan ──
        $chartBulanan12 = PengajuanSurat::select(
            DB::raw("DATE_FORMAT(created_at, '%m') as bulan"),
            DB::raw("SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as selesai"),
            DB::raw("SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as ditolak"),
            DB::raw('count(*) as total')
        )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->mapWithKeys(fn ($item) => [
                (int) $item->bulan => [
                    'total' => $item->total,
                    'selesai' => $item->selesai,
                    'ditolak' => $item->ditolak,
                ],
            ]);

        // ── Distribusi Jenis Surat ──
        $distribusiJenis = PengajuanSurat::select('jenis_surat', DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('jenis_surat')
            ->orderByDesc('total')
            ->take(6)
            ->get();

        // ── Pertumbuhan Warga ──
        $wargaGrowthChart = User::role('Warga')
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%m') as bulan"),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->mapWithKeys(fn ($item) => [
                (int) $item->bulan => $item->total,
            ]);

        // ── SLA Monitoring ──
        $slaHours = 48;
        $slaBreached = PengajuanSurat::where('status', 'approved_operator')
            ->where('created_at', '<', now()->subHours($slaHours))
            ->count();
        $inProgress = PengajuanSurat::where('status', 'approved_operator')->count();

        // ── Pre-computed Chart Data ──
        $bulanMap = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        $trenSorted = $chartBulanan12->keys()->sort()->values();
        $trenLabels = $trenSorted->map(fn ($m) => $bulanMap[$m] ?? $m)->values()->all();
        $trenSelesai = $trenSorted->map(fn ($m) => $chartBulanan12[$m]['selesai'] ?? 0)->values()->all();
        $trenDitolak = $trenSorted->map(fn ($m) => $chartBulanan12[$m]['ditolak'] ?? 0)->values()->all();

        $jenisLabels = $distribusiJenis->pluck('jenis_surat')->map(fn ($j) => str_replace('_', ' ', ucfirst($j)))->values()->all();
        $jenisValues = $distribusiJenis->pluck('total')->values()->all();

        $wargaSorted = $wargaGrowthChart->keys()->sort()->values();
        $wargaLabels = $wargaSorted->map(fn ($m) => $bulanMap[$m] ?? $m)->values()->all();
        $wargaValues = $wargaSorted->map(fn ($m) => $wargaGrowthChart[$m] ?? 0)->values()->all();

        $rtLabels = $rtStats->pluck('rt')->map(fn ($r) => 'RT '.$r)->values()->all();
        $rtValues = $rtStats->pluck('total')->values()->all();

        $rwLabels = $rwStats->pluck('rw')->map(fn ($r) => 'RW '.$r)->values()->all();
        $rwValues = $rwStats->pluck('total')->values()->all();

        $operatorNames = $operatorStats->pluck('name')->values()->all();
        $operatorApproved = $operatorStats->pluck('total_approved')->values()->all();
        $operatorRejected = $operatorStats->pluck('total_rejected')->values()->all();

        return view('admin.sekdes.dashboard', compact(
            'totalWarga', 'totalSurat', 'selesai', 'ditolak',
            'pendingVerification', 'pendingCount',
            'selesaiBulanIni', 'totalSuratBulanIni', 'suratGrowth', 'wargaGrowth',
            'todayVerified', 'todayRejected',
            'verificationHistory', 'avgProcessHours',
            'rtStats', 'rwStats', 'operatorStats',
            'stuckSurat',
            'dailyQuotaLimit', 'dailyQuotaUsed',
            'eventMendatang',
            'suratMasukHariIni', 'suratMasukMingguIni', 'suratKeluarHariIni', 'suratKeluarMingguIni',
            'totalSuratMasuk', 'totalSuratKeluar', 'suratMasukTerbaru',
            'antreanMenunggu', 'antreanLewat', 'antreanDiambil', 'antreanTerbaru',
            'beritaTerbaru',
            'distribusiJenis', 'wargaGrowthChart',
            'slaHours', 'slaBreached', 'inProgress',
            'trenLabels', 'trenSelesai', 'trenDitolak',
            'jenisLabels', 'jenisValues',
            'wargaLabels', 'wargaValues',
            'rtLabels', 'rtValues',
            'rwLabels', 'rwValues',
            'operatorNames', 'operatorApproved', 'operatorRejected',
        ));
    }
}
