<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AntreanPengambilan;
use App\Models\Berita;
use App\Models\Event;
use App\Models\PengajuanSurat;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class KadesDashboardController extends Controller
{
    public function index()
    {
        $totalWarga = User::count();
        $totalSurat = PengajuanSurat::count();
        $selesai = PengajuanSurat::where('status', 'completed')->count();
        $ditolak = PengajuanSurat::where('status', 'rejected')->count();

        $menungguSaya = PengajuanSurat::with('user')
            ->where('status', 'approved_sekdes')
            ->latest()
            ->paginate(15);

        $riwayatTertandaTangan = PengajuanSurat::with('user')
            ->whereIn('status', ['completed', 'rejected'])
            ->latest()
            ->take(10)
            ->get();

        $bulanIni = now()->startOfMonth();
        $selesaiBulanIni = PengajuanSurat::where('status', 'completed')
            ->where('updated_at', '>=', $bulanIni)
            ->count();

        $chartBulanan = PengajuanSurat::select(
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

        // ── NEW DATA ──

        // Growth comparisons
        $totalSuratBulanLalu = PengajuanSurat::where('created_at', '>=', $bulanIni->copy()->subMonth())
            ->where('created_at', '<', $bulanIni)
            ->count();
        $totalSuratBulanIni = PengajuanSurat::where('created_at', '>=', $bulanIni)->count();
        $suratGrowth = $totalSuratBulanLalu > 0
            ? round((($totalSuratBulanIni - $totalSuratBulanLalu) / $totalSuratBulanLalu) * 100)
            : ($totalSuratBulanIni > 0 ? 100 : 0);

        $wargaBulanLalu = User::where('created_at', '>=', $bulanIni->copy()->subMonth())
            ->where('created_at', '<', $bulanIni)
            ->count();
        $wargaBulanIni = User::where('created_at', '>=', $bulanIni)->count();
        $wargaGrowth = $wargaBulanLalu > 0
            ? round((($wargaBulanIni - $wargaBulanLalu) / $wargaBulanLalu) * 100)
            : ($wargaBulanIni > 0 ? 100 : 0);

        // Event mendatang
        $eventMendatang = Event::withCount('peserta')
            ->where('tanggal', '>=', now()->toDateString())
            ->where('status', '!=', 'selesai')
            ->orderBy('tanggal')
            ->take(5)
            ->get();

        // Surat masuk & keluar
        $suratMasukHariIni = SuratMasuk::whereDate('created_at', now()->toDateString())->count();
        $suratMasukMingguIni = SuratMasuk::where('created_at', '>=', now()->startOfWeek())->count();
        $suratKeluarHariIni = SuratKeluar::whereDate('created_at', now()->toDateString())->count();
        $suratKeluarMingguIni = SuratKeluar::where('created_at', '>=', now()->startOfWeek())->count();
        $totalSuratMasuk = SuratMasuk::count();
        $totalSuratKeluar = SuratKeluar::count();
        $suratMasukTerbaru = SuratMasuk::with('creator')->latest()->take(3)->get();

        // Antrean pengambilan
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

        // Berita terbaru
        $beritaTerbaru = Berita::where('status', 'publish')
            ->latest()
            ->take(5)
            ->get();

        // Activity log
        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(8)
            ->get();

        // Distribusi jenis surat (12 bulan)
        $distribusiJenis = PengajuanSurat::select('jenis_surat', DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('jenis_surat')
            ->orderByDesc('total')
            ->take(6)
            ->get();

        // Pertumbuhan warga (6 bulan)
        $wargaGrowthChart = User::select(
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

        // Rata-rata waktu proses per jenis surat
        $avgProcessingTime = PengajuanSurat::select(
            'jenis_surat',
            DB::raw("AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as avg_hours"),
            DB::raw("COUNT(*) as total")
        )
            ->where('status', 'completed')
            ->where('updated_at', '>=', now()->subMonths(3))
            ->groupBy('jenis_surat')
            ->orderByDesc('total')
            ->take(6)
            ->get();

        // SLA monitoring
        $slaHours = 48;
        $slaBreached = PengajuanSurat::whereNotIn('status', ['completed', 'rejected', 'submitted'])
            ->where('created_at', '<', now()->subHours($slaHours))
            ->count();
        $inProgress = PengajuanSurat::whereNotIn('status', ['completed', 'rejected', 'submitted'])->count();

        // Chart data: 12 bulan (enhanced)
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

        // ── Pre-computed chart data (simple arrays for @json) ──
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

        return view('admin.kades.dashboard', compact(
            'totalWarga', 'totalSurat', 'selesai', 'ditolak',
            'menungguSaya', 'riwayatTertandaTangan', 'selesaiBulanIni', 'chartBulanan',
            'suratGrowth', 'wargaGrowth',
            'eventMendatang',
            'suratMasukHariIni', 'suratMasukMingguIni', 'suratKeluarHariIni', 'suratKeluarMingguIni',
            'totalSuratMasuk', 'totalSuratKeluar', 'suratMasukTerbaru',
            'antreanMenunggu', 'antreanLewat', 'antreanDiambil', 'antreanTerbaru',
            'beritaTerbaru', 'recentActivities',
            'distribusiJenis', 'wargaGrowthChart', 'avgProcessingTime',
            'slaHours', 'slaBreached', 'inProgress',
            'chartBulanan12',
            'trenLabels', 'trenSelesai', 'trenDitolak',
            'jenisLabels', 'jenisValues',
            'wargaLabels', 'wargaValues',
        ));
    }
}
